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
                           
						  $sql_records= "SELECT* from invoice where  enroll_id ='".$record_id."'";
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
						 	$sql_records_invoice= "SELECT * FROM `invoice` WHERE `enroll_id`='".$record_id."' order by invoice_id desc ";
							 
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
<table align="center" border="0" width="786" class="left_border right_border top_border" style="border-radius:5px;">
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
		 if($_GET['action'] !='print')
		 {
		 ?>
        <a href="logsheet-generate.php?record_id=<?php echo $record_id ?>&action=print" style="text-decoration:none"><input type="button" name="print" value="Print" /></a>
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
                                        
                        	
                           <!-- <table width="990" height="84" align="center" class="table">-->
                                    <?
                                    	$select_enroll = " select enroll_id,course_id,name,added_date,installment_display_id from enrollment where enroll_id='".$record_id."' ";
									  	$ptr_enroll=mysql_query($select_enroll);
										$data_enroll = mysql_fetch_array($ptr_enroll);
										
										$select_course = " select course_id,course_name from courses where course_id='".$data_enroll['course_id']."' ";
									  	$ptr_course=mysql_query($select_course);
										$data_course = mysql_fetch_array($ptr_course);
										
										/*$select_topic_id = " select COUNT(topic_id) as total_topic from topic_map where course_id='".$data_enroll['course_id']."' ";
									  	$total_topic=mysql_fetch_object($select_topic_id);
										echo $total_topic->total_topic;*/
										
										$q = mysql_query(" select topic_id from topic_map where course_id='".$data_enroll['course_id']."' ");
										$c = mysql_num_rows($q);
										
										echo '<input type="hidden" name="total_topic" value="'.$c.'"/>';
										?>
                                        <tr><th colspan="2"><? echo strtoupper($data_course['course_name']); ?> LOGSHEET</th></tr>
                                    	<tr style="padding-left:10px">
                                        	<td width="146"><strong>Student Name :&nbsp;&nbsp;&nbsp;</strong><? echo $data_enroll['name']; ?></td>
                                           
                                            <td width="141"><strong>Course Name :&nbsp;&nbsp;&nbsp;</strong><? echo $data_course['course_name']; ?><input type="hidden" name="course_id" value="<? echo $data_course['course_id']?>" /></td>
                                        </tr>
                                        <tr>
                                        	<td><strong>Admission Date :&nbsp;&nbsp;&nbsp;</strong><? echo $data_enroll['added_date']; ?></td>
                                            <td><strong>Enrollment ID :&nbsp;&nbsp;&nbsp;</strong><? echo $data_enroll['installment_display_id']; ?></td>
                                            
                                        </tr>
                                    <!--</table>-->
                                    
</table>
                        
                        
                        </td></tr>
                                              
                                              </table>
                                           
                                            
										<table align="center" border="1px" width="786" cellpadding="0" cellspacing="1"
                                        bgcolor="#EFEFEF" style=" border:1px solid;" >
                                        
                           
								<tr align="center" class="grey_td" >
                                    <td width="6%" class="tr-header"><strong>Sr No.</strong></td>
                                    <td width="8%" class="tr-header"><strong>Day</strong></td>
                                    <td width="8%" class="tr-header"><strong>Week 1 Date</strong></td>
                                    <td width="17%" class="tr-header"><strong>Theory Topic</strong></td>
                                    <td width="8%"  class="tr-header"><strong>Total Hours</strong></td>
                                    <td width="12%" class="tr-header"><strong>Faculty Sign</strong></td>
                                    <td width="12%" class="tr-header"><strong>Student Sign</strong></td>
                                </tr><?php
									$bgColorCounter=1;
									$j=1;
                                    	
										$select_topic_id = "select selected_topic_id from logsheet where course_id='".$data_enroll['course_id']."' and enroll_id= '".$_GET['record_id']."'";
									  	$ptr_topic_id=mysql_query($select_topic_id);
										if(mysql_num_rows($ptr_topic_id))
										while($data_topic_id = mysql_fetch_array($ptr_topic_id))
										{
										
										$select_topic_name = " select topic_id,topic_name,duration from topic where topic_id='".$data_topic_id['selected_topic_id']."' ";
									  	$ptr_topic_name=mysql_query($select_topic_name);
										if(mysql_num_rows($ptr_topic_name))
										{
										$data_topic_name = mysql_fetch_array($ptr_topic_name);
										
										$sel_logsheet="select * from logsheet where enroll_id='".$record_id."' and topic_id='".$data_topic_id['selected_topic_id']."'";
										$ptr_logsheet=mysql_query($sel_logsheet);
										$data_logsheet=mysql_fetch_array($ptr_logsheet);
										
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
                                        echo '<td align="center">'.$sr_no.'</td>';
										echo "<td align='center'>".$sr_no."</td>";
										echo '<td align="center">'.$data_topic_name['addded_date'].'</td>'; 
										echo '<td align="center">'.$data_topic_name['topic_name'].'<input type="hidden" name="topic_id_'.$j.'" value="'.$data_topic_name['topic_id'].'"></td>'; 
										echo '<td align="center">'.$data_topic_name['duration'].'</td>';
										
										if($data_logsheet['faculty_sign']=='completed')
										{
										 echo '<td align="center">';
										 echo'<img src="images/active_icon.png" width="30px" height="30px"><input type="hidden" id="action11" name="action_'.$j.'" value="completed" />';
                                         echo '</td>';
										}
										else
										{
											
											 echo '<td align="center">';
											 echo '';
											 echo '</td>';
										}
										
										if($data_logsheet['student_sign']=='completed')
										{
										 echo '<td align="center">';
										 echo'<img src="images/active_icon.png" width="30px" height="30px"><input type="hidden" id="action11" name="action1_'.$j.'" value="completed" />';
                                         echo '</td>';
										}
										else
										{
											echo '<td align="center">';
											echo '';
											echo'</td>';
										}
										
                                        echo '</tr>';
										}
                                       $bgColorCounter++;
									   $j++;
									   $i--;
									   
									
                                    }
                                 	
                                    ?>
       
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
