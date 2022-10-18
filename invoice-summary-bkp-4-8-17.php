<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Invoice Summery</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>
    </head>
<body>
<script>
/*function send1()
{
		var student_name =document.getElementById('student_name').value;
		var course_name =document.getElementById('course_name').value;
		var total_fees =document.getElementById('total_fees').value;
		var admission_date =document.getElementById('admission_date').value;
		var enrollment_id =document.getElementById('enrollment_id').value;
		var down_payment =document.getElementById('down_payment').value;
		var sr_no =document.getElementById('sr_no').value;
		var invoice_id =document.getElementById('invoice_id').value;
		var amount =document.getElementById('amount').value;
		var balance_amt =document.getElementById('balance_amt').value;
		var status =document.getElementById('status').value;
		var added_date =document.getElementById('added_date').value;
		var status1 =document.getElementById('status1').value;
		data1='action=invoice_summary&student_name='+student_name+'&course_name='+course_name+'&total_fees='+total_fees+'&admission_date='+admission_date+'&enrollment_id='+enrollment_id+'&down_payment='+down_payment+'&sr_no='+sr_no+'&invoice_id='+invoice_id+'&amount='+amount+'&balance_amt='+balance_amt+'&status='+status+'&added_date='+added_date+'&status1='+status1;
		$.ajax({
		url:'http://www.htdpt.in/tracking/send_email.php',type:"post",data:data1,cache:false,
		  success: function(response) {
     		return response;
  			}
        });
return true;
}*/
</script>
<?php include "include/header.php";?>
<div id="info">
<?php include "include/menuLeft.php"; ?>
<!--left end-->
<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/student_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
                                <form method="get" name="jqueryForm" id="jqueryForm">
                                <table align="center" border="0" width="75%"> 
                                <tr>
                                <!--<td width="30%" > <input type="text" name="bill_id" class="input defaultText" id="bill_id" title="Bill Number" value="<?php// if($_REQUEST['enroll_id']!="Bill Number") echo $_REQUEST['enroll_id'];?>"> </td>-->
                                 <!--<td width="10%" > <select name="customer_id">
                                 <option value="">Select Student</option>
                                 <?php
								 /*$select_customers = " select enroll_id as user_id ,name from enrollment order by name asc  ";
								 $ptr_customer = mysql_query($select_customers);
								 while($data_customer = mysql_fetch_array($ptr_customer))
								 {	$selecteds='';
									 if($record_id==$data_customer['user_id'])
									 $selecteds = '  selected="selected" ';
									echo "<option value='".$data_customer['user_id']."' $selecteds >".$data_customer['name']."</option>";	 
								 }*/
								 ?>
                                 </select>
                                  </td>-->
                                 
                                    
                                    <!--<td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                                    <td width="20%"></td>-->
                                </tr>
                                </table>
                                </form>
                         
                      <?php
                       if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
                      {
                  $pre_from_date=" and date_format(added_date,'%Y-%m-%d')>='".date('Y-m-d',strtotime($_REQUEST['from_date']))."'";
                                    /*$sql_previos_total= "SELECT sum(amount) as credits FROM dd_user_payement where status='Active' and user_id='".$_SESSION['user_id']."' and debit_credit='Credit' and added_date<'".$_REQUEST['from_date']." 00:00:00'";
                                    $row_previos_total=$db->fetch_array($db->query($sql_previos_total));

                                    $sql_previos_total1= "SELECT sum(amount) as debits FROM dd_user_payement where status='Active' and user_id='".$_SESSION['user_id']."' and debit_credit='Debit' and added_date<'".$_REQUEST['from_date']." 00:00:00'";
                                    $row_previos_total1=$db->fetch_array($db->query($sql_previos_total1));
                                    $balance=$row_previos_total['credits']-$row_previos_total1['debits'];*/
                                }
                                else
                                {
                                    $balance=0;
                                    $pre_from_date="";                            
                                }
                               
									
                                $sql_records= "SELECT * FROM invoice 
								where enroll_id=".$record_id." ".$pre_transcation_id." ".$pre_from_date." ".$pre_to_date." ".$pre_status."  
								order by invoice_id desc";
                                $no_of_records=mysql_num_rows($db->query($sql_records));
                                if($no_of_records)
                                {
                           
                                    $bgColorCounter=1;
                                    if(!$_SESSION['showRecords'])
                                        $_SESSION['showRecords']=10;

                                    $query_string.="&show_records=".$showRecord;
                                    $pager = new PS_Pagination($sql_records,$_SESSION['show_records'],10,$query_string);
                                    $all_records= $pager->paginate();?>
                                    <form method="post" name="frmTakeAction">
                                    <table cellpadding="0" cellspacing="0" width="100%" border="0">
                                    <tr><td valign="middle" align="right">
                                            <table width="100%" cellpadding="0" callspacing="0" border="0">
                                                <tr>
                                                    <?php
                                                    if($no_of_records>10)
                                                    {
                                                        echo '<td width="3%" align="left">Show</td>
                                                        <td width="12%" align="left"><select class="inputSelect" name="show_records" onchange="redirect(this.value)">';

                                                        for($s=0;$s<count($show_records);$s++)
                                                        {
                                                            if($_SESSION['show_records']==$show_records[$s])
                                                                echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                            else
                                                                echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                        }
                                                        echo'</td></select>';
                                                    }
                                                    ?>
                                                   <!-- <td width="70%" align="right"><a href="javascript:void(0);" onClick="window.open('csvcompany_manage.php','win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=800,height=600,directories=no,location=no'); return false;" ><img src="images/csv.png" border="0"/></a>
    
    <img src='images/view.jpeg' title='View Invoice' border='0' 
	onclick="window.open('invoice-generate-company.php')" style='cursor:pointer' > 
    <img src='images/print1.jpeg'
								onclick="window.open('invoice-generate-company.php?action=print','View Invoice')" style='cursor:pointer'title='Print Invoice' border='0'>
                                            </td>-->
                                                    <td height="2" align="right"><?php echo $pager->renderFullNav();?></td>
                                                </tr>
                                            </table>
                                        </td></tr>
                                    <tr><td height="10"></td></tr>
                                    <tr>
                                      <td valign="top" colspan="2">
                                    <table width="990" height="84" align="center">
                                    <?php
                                    	$select_enroll = " select course_id,name,total_fees,added_date,installment_display_id,down_payment from enrollment where enroll_id='".$record_id."' ";
									  	$ptr_enroll=mysql_query($select_enroll);
										$data_enroll = mysql_fetch_array($ptr_enroll);
										
										$select_course = " select course_name from courses where course_id='".$data_enroll['course_id']."' ";
									  	$ptr_course=mysql_query($select_course);
										$data_course = mysql_fetch_array($ptr_course);
										
										?>
                                    	<tr style="padding-left:10px">
                                        	<td width="146"><strong>Student Name :</strong></td><td width="143"><input type="hidden" id="student_name" value="<? echo $data_enroll['name']; ?>"><? echo $data_enroll['name']; ?></td>
                                            <td width="145"><strong>Course Name :</strong></td><td width="226"><input type="hidden" id="course_name" value="<? echo $data_course['course_name']; ?>"><? echo $data_course['course_name']; ?></td>
                                            <td width="141"><strong>Total Fees :</strong></td><td width="161"><input type="hidden" id="total_fees" value="<? echo $data_enroll['total_fees']; ?>"><? echo $data_enroll['total_fees']; ?></td>
                                        </tr>
                                        <tr>
                                        	<td><strong>Admission Date :</strong></td><td><input type="hidden" id="admission_date" value="<? echo $data_enroll['added_date']; ?>" ><? echo $data_enroll['added_date']; ?></td>
                                            <td><strong>Enrollment ID :</strong></td><td><input type="hidden" id="enrollment_id" value="<? echo $data_enroll['installment_display_id']; ?>"><? echo $data_enroll['installment_display_id']; ?></td>
                                            <td width="141"><strong>Down Payment :</strong></td><td width="161"><input type="hidden" id="down_payment" value="<? echo $data_enroll['down_payment']; ?>"><? echo $data_enroll['down_payment']; ?></td>
                                        </tr>
                                    </table>
                                    
                                    </td></tr>
                                    
                                    <tr><td valign="top" colspan="2">
                                       <table width="98%" align="center"  cellpadding="0" cellspacing="1"  class="table" style="width: 97%;">
								<tr align="center" class="grey_td" ><td width="7%" class="tr-header"><strong>Sr.</strong></td><td width="11%" class="tr-header"><strong>Invoice No.</strong></td><!--<td class="tr-header"><strong>Customer Name</strong></td>
                                <td class="tr-header"><strong>Total</strong></td><td  class="tr-header"><strong>Discount</strong></td><td class="tr-header"><strong>Down Pay.</strong></td>--><td width="12%" class="tr-header"><strong>Inst. Paid</strong></td><td width="15%" class="tr-header"><strong>Balance Amount</strong></td><td width="20%"  class="tr-header"><strong>Installment</strong></td><td width="8%" class="tr-header"><strong> Date </strong></td><td width="6%" class="tr-header"><strong> Status </strong></td><td width="9%" class="tr-header"><strong>View</strong></td><td width="12%" class="tr-header"><strong>Print</strong></td></tr><?php
                                    while($val_record=mysql_fetch_array($all_records))
                                    {
										if($bgColorCounter%2==0)
                                    		$bgcolor='class="grey_td"';
                                		else
                                    		$bgcolor=""; 
										 $enroll_id=$val_record['enroll_id'];
										 $paid_totas=0;
                                        /*if($bgColorCounter%2==0)
                                            $bgclass="tr-sub_white1";
                                        else
                                            $bgclass="tr-sub1";*/
                                        include "include/paging_script.php";
                                        echo '<tr class="'.$bgclass.'">';
                                        echo '<td align="center"><input type="hidden" id="sr_no" value="'.$sr_no.'">'.$sr_no.'</td>';
										echo '<td align="center"><input type="hidden" id="invoice_id" value="'.$val_record['invoice_id'].'">'.$val_record['invoice_id'].'</td>';
										$name ='';
										$email_id = '';
										$phone_no ='';
					
									  	$select_firstname = " select * from enrollment where enroll_id='".$val_record['enroll_id']."' ";
									  	$ptr_query=mysql_query($select_firstname);
										$data_select = mysql_fetch_array($ptr_query);
										
										
										//echo '<td align="center" style="padding-left:5px;"><b>'.$data_select['name'].'</b><br />'.$data_select['mail'].'<br />'.$data_select['phone_no'].' </td>';
                                        //echo '<td align="center">'.$data_select['course_fees'].'</td>';
                                        //echo '<td align="center">';
                                        	
                                         // echo $data_select['discount'];
                                        //echo '</td>'; 
									    $paid=$data_select['paid'];
										/*$selectpaid="select sum(installment_amount) as amount_paid  from installment_history 
										where enroll_id=".$val_record['enroll_id']." "; 
										$ptr_selectpaid=mysql_query($selectpaid);
										if(mysql_num_rows($ptr_selectpaid))
										 {
										while($val_selectedpaid=mysql_fetch_array($ptr_selectpaid))
										{*/
									    $totsss=$data_select['course_fees']-$data_select['discount'];
										$bal_totas=$totsss-$data_select['paid']; 
										/*}
										}*/
										//echo '<td align="center">'.$data_select['down_payment'].'</td>'; 
									   echo '<td align="center"><input type="hidden" id="amount" value="'.$val_record['amount'].'">'.$val_record['amount'].'</td>'; 
									   echo '<td align="center"><input type="hidden" id="balance_amt" value="'.$val_record['balance_amt'].'">'.$val_record['balance_amt'].'</td>';
									   echo '<td align="center">';
								$select_installments = " SELECT * FROM `installment` where enroll_id ='$record_id' and invoice_id = '".$val_record['invoice_id']."' and course_id='".$data_select['course_id']."'  ";
								$ptr_installment = mysql_query($select_installments);
								if(mysql_num_rows($ptr_installment))
								{
									while($data_installment = mysql_fetch_array($ptr_installment))
									{
										 $col_paid ='<font color="#006600">';
										if($data_installment['status'] =='not paid')
										$col_paid ='<font color="#FF3333">';
									 echo $data_installment['installment_amount'].'/- '.$data_installment['installment_date'].' : '.$col_paid.$data_installment['status']."</font><br>";	
									}
								}
								else
								{
									echo 'Paid';
								}
								
								echo '</td>';
									    echo '<td align="center"><input type="hidden" id="added_date" value="'.$val_record['added_date'].'">';
										echo date("d-m-Y",strtotime($val_record['added_date']));
										echo'</td>';
										 echo '<td align="center"><input type="hidden" id="status1" value="'.$val_record['status'].'">';
										echo $val_record['status'];
										echo'</td>';
                                        echo "<td align='center'>";
										if($data_select['service_tax'] >0)
										{
											echo '<a href="" onClick="window.open(\'invoice-generate.php?record_id='.$val_record['invoice_id'].'\', \'win1\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900,height=600,directories=no,location=no\'); return false;" ><img src="images/invoice.png" title="View Invoice" class="example-fade"/></a>&nbsp;&nbsp;';
										}
										else if($data_select['cgst_tax'] >0)
										{
											echo '<a href="" onClick="window.open(\'invoice-generate_gst.php?record_id='.$val_record['invoice_id'].'\', \'win1\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900,height=600,directories=no,location=no\'); return false;" ><img src="images/gst1.png" width="21" height="21" title="View GST Invoice" class="example-fade"/></a>&nbsp;&nbsp;';
										}	
										
										
										/*echo "<img src='images/view.jpeg' title='View Invoice' border='0' onclick=\"window.open('invoice-generate.php?record_id=".$val_record['invoice_id']."','View Invoice','scrollbars=yes','resizable=yes','width=900,height=600')\" style='cursor:pointer'>";*/
										
										echo "</td>";
										echo "<td align='center'><img src='images/print1.jpeg'
								onclick=\"window.open('invoice-generate.php?record_id=".$val_record['invoice_id']."&action=print','View Invoice','width=750,height=700')\"style='cursor:pointer'title='Print Invoice' border='0'></td>";
										
                                        echo '</tr>';
                                       $bgColorCounter++;
                                    }
                                  
                                    ?>
                                    <!--<script>
									$(document).ready(function(){
											return send1();
										
									});
									</script>-->
                                        </table>
                                        <table align="right">
                                        <tr>
                                        <?php
                                        if($data_select['balance_amt'] !=0)
										{
											
											echo '<td>';
											echo'<a href="add_payment_to_do.php?record_id='.$enroll_id.'"><strong><font size="+1">Add Payment</font></strong></a>'; 
											echo '</td>';
											echo '<td>';
											echo  '<a href="add_payment_to_do.php?record_id='.$enroll_id.'">
											<img src="images/add1-.png" border="0" title="Add Payment"></a>';
											echo '</td>';
											
										}
								?>
                                		</tr>
										 <tr>
                                        <?php
                                        if($data_select['balance_amt'] !=0)
										{
											
											echo '<td>';
											echo'<a href="add_payment_to_do_gst.php?record_id='.$enroll_id.'"><strong><font size="+1">Add Payment in GST </font></strong></a>'; 
											echo '</td>';
											echo '<td>';
											echo  '<a href="add_payment_to_do_gst.php?record_id='.$enroll_id.'">
											<img src="images/add1-.png" border="0" title="Add Payment GST"></a>';
											echo '</td>';
											
											
										}
								?>
                                	</tr>
                                    <tr>
                                    <td><font size="+1">(For old Payment Recovery)</font></td>
                                    </tr>
                                		</table>
                                    </td></tr>
                                    <tr><td height="10"></td></tr>
                                    <tr><td valign="middle" align="right">
                                            <table width="100%" cellpadding="0" callspacing="0" border="0">
                                                <tr>
                                                    <?php
                                                    if($no_of_records>10)
                                                    {
                                                        echo '<td width="3%" align="left">Show</td>
                                                        <td width="12%" align="left"><select class="inputSelect" name="show_records" onchange="redirect(this.value)">';

                                                        for($s=0;$s<count($show_records);$s++)
                                                        {
                                                            if($_SESSION['show_records']==$show_records[$s])
                                                                echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                            else
                                                                echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                        }
                                                        echo'</td></select>';
                                                    }
                                                    ?>
													
                                                    <td align="right"><?php echo $pager->renderFullNav();?></td>
                                                </tr>
                                            </table>
                                        </td></tr>
                                    </table>
                                    </form><?php
                                }
                                else if($_GET['search'])
                                    echo'<center><br><div id="alert" style="width:80%">Records not found related to your search criteria, please try again to get more results</div><br></center>';
                                else
                                    echo'<center><br><div id="alert" style="width:30%">No Payment history here</div><br></center>';
                            ?>
                            
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
                    <noscript>
                            Warning! JavaScript must be enabled for proper operation of the Administrator backend.				</noscript>
                 <div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>