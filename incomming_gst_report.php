<?php include 'inc_classes.php';?>

<?php include "admin_authentication.php";?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Outstanding Report</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />

<?php include "include/headHeader.php";?>

<?php include "include/functions.php"; ?>

<?php include "include/ps_pagination.php"; ?>

    <script type="text/javascript" src="../js/common.js"></script>

    

    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>

    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>

    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>

    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>

    

     <script type="text/javascript">

       

    $(document).ready(function()

        {            

            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});

            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)

            {

                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;

            }

            

        });

		</script>

        

    <script type="text/javascript">

         function submitAction(action)

        {

            var chks = document.getElementsByName('chkRecords[]');

            var hasChecked = false;

            for (var i = 0; i < chks.length; i++)

            {

                if (chks[i].checked)

                {

                    hasChecked = true;

                    break;

                }

            }

            if (hasChecked == false)

            {

                alert("Please select at least one record to do operation");

                $('#selAction').val('');

                return false;

            }



            document.getElementById('formAction').value=action;

            if(action=="delete")

            {

                if(confirm("Are you sure, you want to delete selected record(s)?"))

                    document.frmTakeAction.submit();

                else

                {

                    $('#selAction').val('');

                    return false;

                }

            }

            else

                document.frmTakeAction.submit();

        }

        function redirect1(value,value1)

        {           

            //alert(value);

           // alert(value1);

            window.location.href=value+value1;

        }



        function validationToDelete(type)

        {

            if(confirm("Are you sure, you want to delete selected record(s)?"))

                return true;

            else

                return false;

        }

    </script>

</head>



<body>

<?php include "include/header.php"; ?>

<!--info start-->

<div id="info">

<!--left start-->

<?php include "include/menuLeft.php"; ?>

<!--left end-->



<!--right start-->

<div id="right_info">

<table border="0" cellspacing="0" cellpadding="0" width="100%">

  <tr>

    <td class="top_left"></td>

    <td class="top_mid" valign="bottom"><?php include "include/report_menu.php";?></td>

    <td class="top_right"></td>

  </tr>

   

  <tr>

    <td class="mid_left"></td>

    <td class="mid_mid" align="center">

        

<table cellspacing="0" cellpadding="0" class="table" width="95%">

    
<?php
$sep_url_string='';
$sep_url= explode("?",$_SERVER['REQUEST_URI']);
if($sep_url[1] !='')
{
$sep_url_string="?".$sep_url[1];
}
?>   
    

  <tr class="head_td">

    <td colspan="10">

        <form method="get" name="search">

	<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">

              <tr>
                <td class="width5"></td>
                <!--<td width="20%">
                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                <option value="">-Operation-</option>
                                <option value="delete">Delete</option>
                        </select></td>-->
						<td width="12%" align="center"><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                        <td width="10%" align="center">
                         <input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>">
                         </td>
                         <td width="10%" align="center">
                         <input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>">
                         </td>
                                <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                                <td> <a href="outstand_export.php<?php echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a></td>  
                

            </tr>
            

        </table>

        </form>	

    </td>

  </tr>

    

     <?php
	 					if($_REQUEST['keyword']!="Keyword")
                            $keyword=trim($_REQUEST['keyword']);
							
                        if($keyword)
						{                            
							$pre_keyword =" and (name like '%".$keyword."%' )";
						}                            
                        else
                            $pre_keyword="";

						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						{
							$frm_date=explode("/",$_REQUEST['from_date']);
							$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							
							$pre_from_date=" and DATE(admission_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$installment_from_date=" and DATE(`installment_date`) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$paid_from_date=" and DATE(`added_date`) >='".date('Y-m-d',strtotime($frm_dates))."'";
						}
						else
						{
							$pre_from_date=""; 
							$paid_from_date="";
							$installment_from_date="";                           
						}
						if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
						{
							$to_date=explode("/",$_REQUEST['to_date']);
							$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
							
							$pre_to_date=" and DATE(`admission_date`) <='".date('Y-m-d',strtotime($to_dates))."'";
							$installment_to_date=" and DATE(`installment_date`)<='".date('Y-m-d',strtotime($to_dates))."' ";
							$paid_to_date=" and DATE(`added_date`)<='".date('Y-m-d',strtotime($to_dates))."'";
						}
						else
						{
							$pre_to_date="";
							$installment_to_date="";
							$paid_to_date="";
						}
						if($_REQUEST['inq'])
						{
							$inquiry=$_REQUEST['inq'];
						}
						
                        if($_REQUEST['page'])
                            $page=$_REQUEST['page'];
                        else
                            $page=0;
                        if($_REQUEST['show_records'])
                            $show=$_REQUEST['show'];
                        else
                            $show=0;
                        if($_GET['order']=='asc')
                        {
                            $order='desc';
                            $img = "<img src='images/sort_up.png' border='0'>";
                        }
                        else if($_GET['order']=='desc')
                        {
                            $order='asc';
                            $img = "<img src='images/sort_down.png' border='0'>";
                        }
                        else
                            $order='desc';
                        if($_GET['orderby']=='name' )
                            $img1 = $img;
                        if($_GET['order'] !='' && ($_GET['orderby']=='firstname'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
							$branch_id='';
                       		$select_directory='order by `enroll_id` desc';                      
                       		$sql_query= "SELECT * FROM `enrollment` WHERE 1 and ref_id='0' ".$_SESSION['where']." ".$pre_keyword." ".$select_directory."  "; 
							$db=mysql_query($sql_query);
							$no_of_records=mysql_num_rows($db);
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword.'&from_date='.$_REQUEST['from_date'].'&to_date='.$_REQUEST['to_date'];
                            $query_string1=$query_string.$date_query;
                           // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>

   

    <form method="post"  name="frmTakeAction"  action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>">
                     <input type="hidden" name="formAction" id="formAction" value=""/>
                      <tr class="grey_td" >
                        <td width="4%" align="center"><strong>Sr. No.</strong></td>
                        <td width="12%" align="center"><strong>Student Name</strong></td>
                        <td width="15%" align="center"><strong>Course Name</strong></td>
                        
                        <td width="15%" align="center"><strong>New and Installment	</strong></td>
						<td width="15%" align="center"><strong>GST in %</strong></td>
						<td width="15%" align="center"><strong>GST Value</strong></td>
                        <!--<td width="10%" align="center"><strong>Monthly Expected</strong></td>
                       
                        <td width="14%" align="center"><strong>Installments</strong></td>-->
                       
                      </tr>

                      

                            <?php

							$total_paid=0;
							$total_gst_new=0;
							$monthly_expected=0;
                            while($val_query=mysql_fetch_array($all_records))
                            {
								if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
								else
                                    $bgcolor=""; 
									$listed_record_id=$val_query['enroll_id'];
								/*$total_source='';	       
								if($inquiry)
								{
									"<br>".$sel_inq_source="select count(enquiry_source) as total_inq_src from inquiry where enquiry_source =".$inquiry." ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiery_to_date."   ";
								}
								else
								{
									// echo "hello";
									"<br>".$sel_inq_source="select count(enquiry_source) as total_inq_src from inquiry where enquiry_source =".$val_query['source_id']." ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiery_to_date."   ";
								}
								$ptr_inq_source=mysql_query($sel_inq_source);
								$total_inq_source=mysql_fetch_array($ptr_inq_source);
								"<br>".$sel_enroll_src="select count(source) as total_enroll_src from enrollment where source =".$val_query['source_id']." ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiery_to_date." ";
								$ptr_enroll_src=mysql_query($sel_enroll_src);
								$total_enroll_src=mysql_fetch_array($ptr_enroll_src);
								$total_src=$total_inq_source['total_inq_src'] + $total_enroll_src['total_enroll_src'];*/
								
                                include "include/paging_script.php";
                                echo '<tr '.$bgcolor.'>';
								echo '<td align="center">'.$sr_no.'</td>';
								echo '<td align="center">'.$val_query['name'].'</td>';
                                
								$sel_total_course="select enroll_id,course_id,down_payment,discount,discount,net_fees,admission_date,cgst_tax_in_percent,cgst_tax,sgst_tax_in_percent,sgst_tax from enrollment where 1 and ref_id='".$val_query['enroll_id']."' || enroll_id='".$val_query['enroll_id']."'";
								$ptr_ref=mysql_query($sel_total_course);
								$totals_courses=mysql_num_rows($ptr_ref);
								$totals_cntt=mysql_num_rows($ptr_ref);
                                echo '<td ><b>';
								while($data_total=mysql_fetch_array($ptr_ref))
								{
									$select_course = "select course_name from courses where course_id = '".$data_total['course_id']."'  ";
									$query=mysql_query($select_course);
									$val_course= mysql_fetch_array($query);
									
									echo '<b>'.$val_course['course_name'].'</b><br><img src="images/indian-rupee-16.ico">'.$data_total['net_fees'].'/-<br/>Down Payment- '.$data_total['down_payment'].'<br> Discount- '.$data_total['discount'].'<br/>Date: '.$data_total['admission_date'].'';
									
									/*if($data_total['cgst_tax_in_percent'] > 0)
									{
										echo '<br/>CGST ('.$data_total['cgst_tax_in_percent'].'%)- '.$data_total['cgst_tax'].'/-';
										$total_gst_new +=$data_total['cgst_tax'];
									}
									if($data_total['sgst_tax_in_percent'] > 0)
									{
										echo '<br/>SGST ('.$data_total['sgst_tax_in_percent'].'%)- '.$data_total['sgst_tax'].'/-';
										$total_gst_new +=$data_total['sgst_tax'];
									}
									if($data_total['sgst_tax_in_percent'] > 0 || $data_total['cgst_tax_in_percent'] > 0)
									{
										echo '<br/>Total- '.intval($data_total['sgst_tax']+$data_total['cgst_tax']).'/-';
									}*/
									if($totals_courses = $totals_courses-1 )
									echo '<hr />';
								}
								echo '</td>';
								
								
								
								$sel_inst_amnt="select enroll_id,paid,course_id,down_payment,admission_date,invoice_no from enrollment where 1  and  ref_id='".$val_query['enroll_id']."' || enroll_id='".$val_query['enroll_id']."'";
								$ptr_ins_amnt=mysql_query($sel_inst_amnt);
								if($total_inst=mysql_num_rows($ptr_ins_amnt))
								{
									$amount=0;
									echo '<td>';
									while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
									{
										echo "<strong >Down Payment</strong><br/>";
										echo $data_inst_amnt['down_payment'].'/- '.$data_inst_amnt['admission_date']."<br>";
										
										"<br />".$select_installments = " SELECT * FROM invoice where enroll_id ='".$data_inst_amnt['enroll_id']."' and course_id='".$data_inst_amnt['course_id']."' and invoice_id !='".$data_inst_amnt['invoice_no']."' ";
										$ptr_installment = mysql_query($select_installments);
										if(mysql_num_rows($ptr_installment))
										{
											echo "<br/><strong >Installment</strong></br>";
											$amount=0;
											while($data_installment = mysql_fetch_array($ptr_installment))
											{
												if($data_installment['amount'] >0)
												{
													$sel_paymode="select payment_mode from payment_mode where payment_mode_id='".$data_installment['paid_type']."'";
													$ptr_paymode=mysql_query($sel_paymode);
													$data_paymode=mysql_fetch_array($ptr_paymode);
													
													$amount +=$data_installment[amount];
													$col_paid ='<font color="#006600">';
													$dt=strtotime($data_installment[added_date]);
													$datess=date("Y-m-d", $dt);
													echo $data_installment['amount'].'/- '.$datess.' : '.$data_paymode['payment_mode']."<br>";
													$total_paid=$total_paid+$data_installment['amount'];
												}
											}
										}
										echo "<br/><strong></strong>";
										if($total_inst = $total_inst-1 )
										echo '<hr />';
									}
									echo '</td>';
								}
								else
								{
									echo '<td align="center">--</td>';
								}
								
								/*$sel_inst_amnt="select enroll_id,paid,course_id from enrollment where 1 and  ref_id='".$val_query['enroll_id']."' || enroll_id='".$val_query['enroll_id']."'";
								$ptr_ins_amnt=mysql_query($sel_inst_amnt);
								if($total_inst=mysql_num_rows($ptr_ins_amnt))
								{
									$amount1=0;
									echo '<td>';
									while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
									{
										"<br />".$select_installments = " SELECT * FROM invoice where enroll_id ='".$data_inst_amnt['enroll_id']."' and course_id='".$data_inst_amnt['course_id']."' ".$paid_from_date." ".$paid_to_date." ";
										$ptr_installment = mysql_query($select_installments);
										if(mysql_num_rows($ptr_installment))
										{
											$amount1=0;
											while($data_installment = mysql_fetch_array($ptr_installment))
											{
												if($data_installment[amount] >0)
												{
													$sel_paymode="select payment_mode from payment_mode where payment_mode_id='".$data_installment['paid_type']."'";
													$ptr_paymode=mysql_query($sel_paymode);
													$data_paymode=mysql_fetch_array($ptr_paymode);
													
													$amount1 +=$data_installment[amount];
													$col_paid ='<font color="#006600">';
													$dt1=strtotime($data_installment[added_date]);
													$datess1=date("Y-m-d", $dt1);
													echo $data_installment[amount].'/- '.$datess1.' : '.$data_paymode['payment_mode']."</font><br>";
													$total_paid1=$total_paid1+$data_installment['amount'];
												}
											}
										}
										echo "<strong>Total Paid- ".$amount1."<strong><br/>";
										if($total_inst = $total_inst-1 )
									echo '<hr />';
									}
										echo '</td>';
								}
								else
								{
									echo '<td align="center">--</td>';
								}*/
								
								$sel_inst_amnt="select enroll_id,paid,course_id,down_payment,admission_date,invoice_no,cgst_tax_in_percent,cgst_tax,sgst_tax_in_percent,sgst_tax from enrollment where 1  and  ref_id='".$val_query['enroll_id']."' || enroll_id='".$val_query['enroll_id']."'";
								$ptr_ins_amnt=mysql_query($sel_inst_amnt);
								if($total_inst=mysql_num_rows($ptr_ins_amnt))
								{
									
									echo '<td>';
									while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
									{
										if($data_inst_amnt['cgst_tax_in_percent'] > 0 || $data_inst_amnt['sgst_tax_in_percent'] > 0)
										{
											echo "<strong >Down Payment GST</strong>";
											if($data_inst_amnt['cgst_tax_in_percent'] > 0)
											{
												echo '<br/>CGST ('.$data_inst_amnt['cgst_tax_in_percent'].'%)';
											}
											if($data_inst_amnt['sgst_tax_in_percent'] > 0)
											{
												echo ' + SGST ('.$data_inst_amnt['sgst_tax_in_percent'].'%)';
											}
											echo '</br>';
											//echo $data_inst_amnt['down_payment'].'/- '.$data_inst_amnt['admissio n_date']."<br>";
										}
										"<br />".$select_installments = " SELECT * FROM invoice where enroll_id ='".$data_inst_amnt['enroll_id']."' and course_id='".$data_inst_amnt['course_id']."' and invoice_id !='".$data_inst_amnt['invoice_no']."' and amount > 0 ";
										$ptr_installment = mysql_query($select_installments);
										if(mysql_num_rows($ptr_installment))
										{
											echo "<br/><strong >Installment GST</strong>";
											$amount=0;
											while($data_installment = mysql_fetch_array($ptr_installment))
											{
												
												if($data_installment['cgst_tax_in_per'] >0 || $data_installment['sgst_tax_in_per'] >0)
												{
													//$sel_paymode="select payment_mode from payment_mode where payment_mode_id='".$data_installment['paid_type']."'";
													//$ptr_paymode=mysql_query($sel_paymode);
													//$data_paymode=mysql_fetch_array($ptr_paymode);
													
													///$amount +=$data_installment[amount];
													//$col_paid ='<font color="#006600">';
													//$dt=strtotime($data_installment[added_date]);
													//$datess=date("Y-m-d", $dt);
													
													if($data_installment['cgst_tax_in_per'] > 0)
													{
														echo '<br/>CGST ('.$data_installment['cgst_tax_in_per'].'%)';
													}
													if($data_installment['sgst_tax_in_per'] > 0)
													{
														echo ' + SGST ('.$data_installment['sgst_tax_in_per'].'%)';
													}
													//echo $data_installment['amount'].'/- '.$datess.' : '.$data_paymode['payment_mode']."<br>";
													//$total_paid=$total_paid+$data_installment['amount'];
												}
											}
										}
										echo "<br/><strong><strong>";
										if($total_inst = $total_inst-1 )
										echo '<hr />';
									}
									echo '</td>';
								}
								else
								{
									echo '<td align="center">--</td>';
								}
								$gst_amount=0;
								$down_total=0;
								$sel_inst_amnt="select enroll_id,paid,course_id,down_payment,admission_date,invoice_no,cgst_tax_in_percent,cgst_tax,sgst_tax_in_percent,sgst_tax from enrollment where 1  and  ref_id='".$val_query['enroll_id']."' || enroll_id='".$val_query['enroll_id']."'";
								$ptr_ins_amnt=mysql_query($sel_inst_amnt);
								if($total_inst=mysql_num_rows($ptr_ins_amnt))
								{
									
									echo '<td>';
									while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
									{
										$gst_amount=0;
										echo "<br/><strong >Down Payment GST</strong></br>";
										if($data_inst_amnt['cgst_tax'] > 0 || $data_inst_amnt['sgst_tax'] > 0)
										{
											$down_cgst=0;
											$down_sgst=0;
											
											if($data_inst_amnt['cgst_tax'] > 0)
											{
												echo $down_cgst=intval($data_inst_amnt['cgst_tax']);
											}
											if($data_inst_amnt['sgst_tax'] > 0)
											{
												echo ' + ';
												echo $down_sgst=intval($data_inst_amnt['sgst_tax']);
											}
											echo ' = <strong>';
											echo $down_total=intval($down_cgst + $down_sgst);
											echo'</strong>';
											echo '</br>';
											//echo $data_inst_amnt['down_payment'].'/- '.$data_inst_amnt['admissio n_date']."<br>";
										}
										$inst_total=0;
										"<br />".$select_installments = " SELECT * FROM invoice where enroll_id ='".$data_inst_amnt['enroll_id']."' and course_id='".$data_inst_amnt['course_id']."' and invoice_id !='".$data_inst_amnt['invoice_no']."' and amount > 0 ";
										$ptr_installment = mysql_query($select_installments);
										if(mysql_num_rows($ptr_installment))
										{
											echo "<br/><strong >Installment GST</strong></br>";
											while($data_installment = mysql_fetch_array($ptr_installment))
											{
												if($data_installment['cgst_tax'] >0 || $data_installment['sgst_tax'] >0)
												{
													$inst_cgst=0;
													$inst_sgst=0;
													if($data_installment['cgst_tax'] > 0)
													{
														echo $inst_cgst=$data_installment['cgst_tax'];
													}
													if($data_installment['sgst_tax'] > 0)
													{
														echo ' + ';
														echo $inst_sgst=$data_installment['sgst_tax'];
													}
													
													echo ' = <strong>';
													echo $inst_total=intval($inst_cgst + $inst_sgst);
													echo'</strong>';
													//echo $data_installment['amount'].'/- '.$datess.' : '.$data_paymode['payment_mode']."<br>";
													//$total_paid=$total_paid+$data_installment['amount'];
												}
											}
										}
										$gst_amount=intval($down_total+$inst_total);
										$total_gst +=$gst_amount;
										echo "<br/><br/><strong>Total GST- ".$gst_amount."<strong><br/>";
										if($total_inst = $total_inst-1 )
										echo '<hr />';
									}
									echo '</td>';
								}
								else
								{
									echo '<td align="center">--</td>';
								}
								
								   
								/*$sel_inst_amnt="select course_id,enroll_id,balance_amt from enrollment where 1 and ref_id='".$val_query['enroll_id']."' || enroll_id='".$val_query['enroll_id']."'";
								$ptr_ins_amnt=mysql_query($sel_inst_amnt);
								if($total_inst=mysql_num_rows($ptr_ins_amnt))
								{
									
									echo '<td>';
									while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
									{
										$expected=0;
										"<br />".$select_installments = " SELECT * FROM installment where enroll_id ='".$data_inst_amnt['enroll_id']."' and course_id='".$data_inst_amnt['course_id']."' ".$installment_from_date." ".$installment_to_date." ";
										$ptr_installment = mysql_query($select_installments);
										if(mysql_num_rows($ptr_installment))
										{
											$expected=0;
											while($data_installment = mysql_fetch_array($ptr_installment))
											{
											 	$expected = $expected + $data_installment['installment_amount'];	
												$monthly_expected= $monthly_expected + $data_installment['installment_amount'];
											}
										}
										echo "<strong>".$expected."<strong>";
										if($total_inst = $total_inst-1 )
										echo '<hr />';
									}
									
									echo '</td>';
								}
								else
								{
									echo '<td align="center">--</td>';
								}
								   
								   
								   
								$sel_inst_amnt="select course_id,enroll_id,balance_amt from enrollment where 1 and ref_id='".$val_query['enroll_id']."' || enroll_id='".$val_query['enroll_id']."'";
								$ptr_ins_amnt=mysql_query($sel_inst_amnt);
								if($total_inst=mysql_num_rows($ptr_ins_amnt))
								{
									echo '<td>';
									while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
									{
										
										"<br />".$select_installments = " SELECT * FROM installment where enroll_id ='".$data_inst_amnt['enroll_id']."' and course_id='".$data_inst_amnt['course_id']."' ".$installment_from_date." ".$installment_to_date." ";
										$ptr_installment = mysql_query($select_installments);
										if(mysql_num_rows($ptr_installment))
										{
											while($data_installment = mysql_fetch_array($ptr_installment))
											{
												$col_paid ='<font color="#006600">';
												if($data_installment[status] =='not paid')
												$col_paid ='<font color="#FF3333">';
												if($data_installment['installment_date'] < date("Y-m-d"))
												$past_rec='<img src="images/overdue.gif" />';
												else
												$past_rec='';
											 	echo $data_installment[installment_amount].'/- '.$data_installment[installment_date].' : '.$col_paid.$data_installment[status].$past_rec."</font><br>";	
											}
										}
										echo "<strong>Total Remaining- ".$data_inst_amnt['balance_amt']."<strong><br/>";
										if($total_inst = $total_inst-1 )
									echo '<hr />';
									}
										echo '</td>';
								}
								else
								{
									echo '<td align="center">--</td>';
								}
                               */
                                echo '</tr>';

								$bgColorCounter++;

                                                                

							}

                                ?>

                                <tr class="grey_td">

    <td colspan="15">
    	<table cellspacing="0" cellpadding="0" width="95%"  style="border:1 px solid #CCC; border-collapse:collapse">
        	<tr class="grey_td">
            	<td width="4%"></td>
                <td width="12%"></td>
                <td width="15%" align="center"></td>
				<td width="15%" align="center"></td>
                <td width="15%" align="center"><strong>Total</strong></td>
				<td width="15%" align="center"><?php echo $total_gst; ?></td>
                <td width="15%" align="center"></td>
            </tr>
    	</table>
    </td>

    </tr>
    <tr class="head_td">
    <td colspan="15">
     <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <?php
                    if($no_of_records>10)
					{
						/*echo '<td width="3%" align="left">Show</td>
						<td width="20%" align="left"><select class="input_select_login" name="show_records" onchange="redirect(this.value)">';
						$show_records=array(0=>'10',1=>'20','50','100');
						for($s=0;$s<count($show_records);$s++)
						{
							if($_SESSION['show_records']==$show_records[$s])
								echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
							else
								echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
						}
						echo'</td></select>';*/
					}
					echo '<td width="75%" align="right">'.$pager->renderFullNav().'</td>';
                 ?>
            </tr>

        </table>

 
    </td>

    </tr>

  

  

  </form>

  <?php } 

	  

      else

        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No records found related to your search criteria, please try again</div><br></td></tr>';?>

      

</table>



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

<!--footer start-->

<div id="footer">

<?php include "include/footer.php"; ?>

</div>

<!--footer end-->

</body>

</html>

