<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Profit And Loss Report</title>
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
                <td class="top_mid" valign="bottom"><?php include "include/financial_report_menu.php";?></td>
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
    						<td colspan="12">
								<form method="get" name="search">
                               		<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
              							<tr>
                							<td class="width5"></td>
                								<?php 
												if($_SESSION['type']=='S')
                                            	{
                                   					?>
						 							<td width="15%">
														<select name="branch_name" id="branch_name"  class="input_select_login"  style="width: 150px; ">
															<option value="">-Branch Name-</option>
																<?php 
																$sel_branch="select branch_id,branch_name from branch";
																$ptr_sel=mysql_query($sel_branch);
																while($data_branch=mysql_fetch_array($ptr_sel))
																{
																	$sel='';
																	if($data_branch['branch_name']==$_GET['branch_name'])
																	{
																		$sel='selected="selected"';
																	}
																	echo '<option '.$sel.' value="'.$data_branch['branch_name'].'" > '.$data_branch['branch_name'].'</option>';
																}
																?>
														</select>
													</td>
													<?php
												}
												?>
                        						<td width="10%" align="center">
                        							<select name="bank_id" class="input_select">
                        							<option value="">--Select Bank--</option>
                            						<?php 
													$course_category = " select DISTINCT(cm_id),branch_name from site_setting where type='A' ".$_SESSION['where']."";
													$ptr_course_cat = mysql_query($course_category);
													while($data_cat = mysql_fetch_array($ptr_course_cat))
													{
														echo "<optgroup label='".$data_cat['branch_name']."'>";
														$sel_source="SELECT * FROM bank where 1 and cm_id='".$data_cat['cm_id']."' ";
														$ptr_src=mysql_query($sel_source);
														while($data_src=mysql_fetch_array($ptr_src))
														{
															?>
															<option value="<?php echo $data_src['bank_id']?>" <?php if($_POST['bank_id'] == $data_src['bank_id']) echo "selected"; else if ( $data_src['bank_id'] == $_REQUEST['bank_id']) echo "selected";?> > <?php echo $data_src['bank_name'] ?> </option>
															<?php
														}
														echo "</optgroup>";
													}?>
                        							</select>
                        						</td>
                        						<td width="10%" align="center">
                         							<input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>">
                        						</td>
                        						<td width="10%" align="center">
                        							<input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>">
                        						</td>
                        						<td width="10%" align="center">
                        							<select name="pay_type" class="input_select">
                        							<option value="">--Select Payment Mode--</option>
                            						<?php
													$sel_payment_mode="select payment_mode,payment_mode_id from payment_mode where 1 ";
													$ptr_payment_mode=mysql_query($sel_payment_mode);
													$selctds='';
													while($data_payment=mysql_fetch_array($ptr_payment_mode))
													{
														$selected='';
														if($data_payment['payment_mode_id'] == $_REQUEST['pay_type'])
														{
															$selected='selected="selected"';
															$selctds = $data_payment['payment_mode'].'-'.$data_payment['payment_mode_id'];
														}
														echo '<option '.$selected.' value="'.$data_payment['payment_mode_id'].'">'.$data_payment['payment_mode'].'</option>';
						
													}
													?>
                        							</select>
                        						</td>
                                            	<td width="12%" align="center"><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                                            	<td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                                            	<td width="10%"><input type="reset" name="reset" value="Reset" class="inputButton"/></td>
                                            	<!--<td><a href="bank_summury_export.php<?php //echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a></td> --> 
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
                                $pre_keyword_i =" and (e.name like '%".$keyword."%' )";
                            }                            
                            else
                            {
                                $pre_keyword="";
                                $pre_keyword_i ="";
                            }
                            if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
                            {
                                $frm_date=explode("/",$_REQUEST['from_date']);
                                $frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
                                
                                $pre_from_date=" and DATE(admission_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
                                $installment_from_date=" and DATE(`installment_date`) >='".date('Y-m-d',strtotime($frm_dates))."'";
                                $paid_from_date=" and DATE(i.added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
                                $paid_from_date_i=" and DATE(s.added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
                            }
                            else
                            {
                                $pre_from_date=""; 
                                if($_REQUEST['to_date']=='')
                                {
                                    $paid_from_date=" and DATE(i.added_date) >='".date('Y-m-d',strtotime('-30 days'))."'";
                                    $paid_from_date_i=" and DATE(s.added_date) >='".date('Y-m-d',strtotime('-30 days'))."'";
                                    $frm_dates=date('Y-m-d',strtotime('-30 days'));
                                }
                                else
                                {
                                    $paid_from_date="";
                                    $paid_from_date_i="";
                                    $frm_dates='';
                                }
                                $installment_from_date="";                           
                            }
                            if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
                            {
                                $to_date=explode("/",$_REQUEST['to_date']);
                                $to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
                                
                                $pre_to_date=" and DATE(`admission_date`) <='".date('Y-m-d',strtotime($to_dates))."'";
                                $installment_to_date=" and DATE(`installment_date`) <='".date('Y-m-d',strtotime($to_dates))."' ";
                                $paid_to_date=" and DATE(i.added_date) <='".date('Y-m-d',strtotime($to_dates))."'";
                                $paid_to_date_i=" and DATE(s.added_date) <='".date('Y-m-d',strtotime($to_dates))."'";
                            }
                            else
                            {
                                $pre_to_date="";
                                $installment_to_date="";
                                $paid_to_date=" and DATE(i.added_date) <='".date('Y-m-d')."'";
                                $paid_to_date_i=" and DATE(s.added_date) <='".date('Y-m-d')."'";
                                $to_dates=date('Y-m-d');
                            }
                            $paid_type=''; //and (i.paid_type='2' or i.paid_type='4' or i.paid_type='5')
							$paymode_type_prod="";
							$paymode_type='';
							$paymode_type_exp="";
							$paid_type_serv="";
							$paymode_type_inv='';
							$paid_type_inv="";
                            if($_REQUEST['pay_type'] !='')
                            {
                                $paid_type=" and paid_type='".$_REQUEST['pay_type']."'";
								$paymode_type_prod= " and sp.payment_mode_id='".$_REQUEST['pay_type']."'";
								$paymode_type=" and payment_mode_id='".$_REQUEST['pay_type']."'";
								$paymode_type_exp=" and e.payment_mode_id='".$_REQUEST['pay_type']."'";
								$paid_type_serv=" and i.paid_type='".$_REQUEST['pay_type']."'";
								$paid_type_inv=" and i.paid_type='".$_REQUEST['pay_type']."'";
								$paymode_type_inv=" and e.payment_mode_id='".$_REQUEST['pay_type']."'";
                            }
                            
                            $bank_ids="";
							$bank_ids_prod="";
                            $banks_id="";
                            $banks_id_rec="";
							$banks_id_serv="";
							$banks_id_inv="";
							$banks_id_exp="";
							$b_id='';
                            if($_REQUEST['bank_id'] !='')
                            {
                                $bank_ids=" and bank_name='".$_REQUEST['bank_id']."'";
                                $banks_id=" and bank_id='".$_REQUEST['bank_id']."'";
								$banks_id_serv=" and i.bank_id='".$_REQUEST['bank_id']."'";
								$banks_id_inv=" and i.bank_id='".$_REQUEST['bank_id']."'";
								$banks_id_exp=" and e.bank_id='".$_REQUEST['bank_id']."'";
								$bank_ids_prod=" and sp.bank_id='".$_REQUEST['bank_id']."'";
                                $banks_id_rec=" and from_bank_name='".$_REQUEST['bank_id']."' ";
                                $b_id=$_REQUEST['bank_id'];
                            }
                            else
                            {
                                //$bank_ids=" and bank_name='16'";
                                //$banks_id=" and bank_id='16'";
                                //$banks_id_rec=" and from_bank_name='16' ";
                                //$b_id='16';
                            }
                            $search_cm_id='';
							$search_cm_id_prod='';
							$search_cm_id_serv="";
							$search_cm_id_inv="";
							$search_cm_id_exp="";
                            $cm_ids=$_SESSION['cm_id'];
                            if($_SESSION['type']=="S")
                            {
                                if($_REQUEST['branch_name']!='')
                                {
                                    $branch_name=$_REQUEST['branch_name'];
                                    $select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
                                    $ptr_cm_id=mysql_query($select_cm_id);
                                    $data_cm_id=mysql_fetch_array($ptr_cm_id);
                                    $search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
									$search_cm_id_prod=" and sp.cm_id='".$data_cm_id['cm_id']."'";
									$search_cm_id_serv=" and i.cm_id='".$data_cm_id['cm_id']."'";
									$search_cm_id_inv=" and i.cm_id='".$data_cm_id['cm_id']."'";
									$search_cm_id_exp=" and e.cm_id='".$data_cm_id['cm_id']."'";
                                    $cm_ids=$data_cm_id['cm_id'];
                                }
                                else
                                {
                                    $search_cm_id=" and cm_id='2'";
									$search_cm_id_prod=" and sp.cm_id='2'";
									$search_cm_id_serv=" and i.cm_id='2'";
									$search_cm_id_inv=" and i.cm_id='2'";
									$search_cm_id_exp=" and e.cm_id='2'";
                                    $cm_ids='2';
                                }
                            }
                            else
                            {
                                $search_cm_id='';
								$search_cm_id_serv="";
								$search_cm_id_inv="";
								$search_cm_id_prod="";
                                if($_SESSION['where']!='')
                                {
                                    $search_cm_id=" and cm_id='".$_SESSION['cm_id']."'";
									$search_cm_id_prod=" and sp.cm_id='".$_SESSION['cm_id']."'";
									$search_cm_id_serv=" and i.cm_id='".$_SESSION['cm_id']."'";
									$search_cm_id_inv=" and i.cm_id='".$_SESSION['cm_id']."'";
									$search_cm_id_exp=" and e.cm_id='".$_SESSION['cm_id']."'";
                                }
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
                                $select_directory=' order by DATE(i.added_date) desc';       
                            
                            $date1=date_create($frm_dates);
                            $date2=date_create($to_dates);
                            $diff=date_diff($date1,$date2);
                            $data_difs=$diff->format("%a");
                            //$data_difs;
                            if($diff)
                            {
								if($b_id!='')
								{
                                	$sel_bank="select bank_name from bank where bank_id='".$b_id."'";
                                	$ptr_bank=mysql_query($sel_bank);
                                	$data_bank_name=mysql_fetch_array($ptr_bank);
								}
								?>
                                <form method="post"  name="frmTakeAction"  action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>">
                                <input type="hidden" name="formAction" id="formAction" value=""/>
                                <!--<tr class="grey_td" >
                                    <td width="10%" rowspan="1" align="center">Sr No</td>
                                    <td width="30%" rowspan="1" align="center">Bank Name</td>
                                    <td width="30%" rowspan="4" align="center">Incomming</td>
                                    <td width="39%" rowspan="2" align="center">Outgoing</td>
                                </tr>-->
                                <tr>
                                    <td colspan="3" style="font-size:12px"><strong>Bank Name- <?php echo $data_bank_name['bank_name']; ?></strong></td>
                                    <td colspan="3" style="font-size:12px"><strong>From Date- <?php echo $frm_dates; ?></strong></td>
                                    <td colspan="4" style="font-size:12px"><strong>To Date- <?php echo $to_dates; ?></strong></td>
                                </tr>
                                <tr class="grey_td" style="background-color:#FBFD9F">
                                    <td width="4%" rowspan="2" align="center" style="font-size:12px;color:brown"><strong>Sr. No</strong></td>
                                    <td width="7%" rowspan="2" align="center" style="font-size:12px;color:brown"><strong>Added Date</strong></td>
                                    <td width="38%" colspan="3" align="center" style="font-size:12px; color:green"><strong>Incomming</strong></td>
                                    <td width="30%" colspan="2" align="center" style="font-size:12px; color:red"><strong>Outgoing</strong></td>
                                    <td width="10%" rowspan="2" align="center" style="font-size:12px;color:green"><strong>Total Incomming</strong></td>
                                    <td width="10%" rowspan="2" align="center" style="font-size:12px;color:red"><strong>Total Outgoing</strong></td>
                                </tr>
                                <tr class="grey_td" style="background-color:#FBFD9F">
                                    <td width="15%" align="center" style="font-size:12px;color:green"><strong>Enrollment</strong></td>
                                    <!--<td width="10%" align="center" style="font-size:12px;color:green"><strong>Receipt</strong></td>-->
                                    <td width="12%" align="center" style="font-size:12px;color:green"><strong>Sale Prod.</strong></td>
                                    <td width="12%" align="center" style="font-size:12px;color:green"><strong>Service</strong></td> 
                                    <!--<td width="10%" align="center" style="font-size:12px;color:green"><strong>Cash Deposited</strong></td> -->
                                    <td width="12%" align="center" style="font-size:12px;color:red"><strong>Expense</strong></td>
                                    <td width="12%" align="center" style="font-size:12px;color:red"><strong>Purchase</strong></td>
                                    <!--<td width="10%" align="center" style="font-size:12px;color:red"><strong>Cash Withdrawl</strong></td> -->
                                </tr>
                                <?php
                                for($i=0;$i<$data_difs;$i++)
                                {
                                    if($bgColorCounter%2==0)
                                        $bgcolor='class="grey_td"';
                                    else
                                        $bgcolor=""; 
                                        
                                    $dates=date('d/m/Y', strtotime($frm_dates. ' + '.$i.' days'));
                                    $newdates=date('Y-m-d', strtotime($frm_dates. ' + '.$i.' days'));
                                    $sr_nos=$i+1;
                                    $tot_pur='';
                                    $tot_exp='';
                                    $tot_ser='';
                                    $tot_prod='';
                                    $tot_rec='';
                                    $tot_inv='';
                                    $tot_with='';
                                    $tot_depo='';
                                    echo '<tr '.$bgcolor.'>';
                                    echo '<td align="center" style="color:brown">'.$sr_nos.'</td>';
                                    echo '<td align="center" style="color:brown">'.$dates.'</td>';
                                    //========================Enrollment==========================
									
                                    echo '<td align="left">';
                                    $sel_inv="select amount,enroll_id,paid_type,cgst_tax,sgst_tax from invoice where DATE(added_date)='".$newdates."' and amount>0 and (cgst_tax_in_per >0 or sgst_tax_in_per >0) ".$paid_type." ".$bank_ids." ".$search_cm_id." ";
                                    $ptr_inv=mysql_query($sel_inv);
                                    while($data_inv=mysql_fetch_array($ptr_inv))
                                    {
										$total_ded_value=0;
                                        $sel_name="select name from enrollment where enroll_id='".$data_inv['enroll_id']."'";
                                        $ptr_name=mysql_query($sel_name);
                                        $data_names=mysql_fetch_array($ptr_name);
										
										$sql_pay="select payment_mode from payment_mode where payment_mode_id='".$data_inv['paid_type']."'";
										$ptr_pay=mysql_query($sql_pay);
										$pay_type=mysql_fetch_array($ptr_pay);
                                        
										$tot_gst=intval($data_inv['cgst_tax']+$data_inv['sgst_tax']);
										
										if($data_inv['paid_type']=='4')
										{
											$cc_deduction=(($tot_gst*1.4)/100);
											$total_ded_value = $total_ded_value + $cc_deduction;
											//$after_cc_deduction = $after_cc_deduction + $total_ded_value;
										}
										$tot_stud_gst = $tot_gst - $total_ded_value;
										
										
                                        echo "<span style='color:blue'><strong>".$tot_stud_gst."</span></strong> (<span style='color:orange'>".$data_names['name']."</span> - <span style='color:brown'>".$pay_type['payment_mode']." </span>)"."<br/>";
                                        $tot_inv +=$tot_stud_gst;
                                    }
                                    if($tot_inv >0)
                                        echo "<hr/><br/><span style='color:green'><strong>Total- ".$tot_inv."</strong></span>";
                                    $total_enroll +=$tot_inv;
                                    echo'</td>';
                                    //============================================================
                                    //========================Recipt==============================
                                    /*echo '<td align="left">';
                                    $sel_rec="select amount,payment_mode_id from receipt where 1 and (cash_transfer_mode ='' or cash_transfer_mode is NULL) and DATE(added_date)='".$newdates."' and amount>0 ".$paymode_type." ".$banks_id." ".$search_cm_id."";
                                    $ptr_rec=mysql_query($sel_rec);
                                    while($data_rec=mysql_fetch_array($ptr_rec))
                                    {
										$sql_pay="select payment_mode from payment_mode where payment_mode_id='".$data_rec['payment_mode_id']."'";
										$ptr_pay=mysql_query($sql_pay);
										$pay_type=mysql_fetch_array($ptr_pay);
										
                                        echo "<span style='color:blue'>".$data_rec['amount']."</span> <span style='color:brown'>(".$pay_type['payment_mode'].")</span><br/>";
                                        $tot_rec +=$data_rec['amount'];
                                    }
                                    if($tot_rec >0)
                                        echo "<hr/><br/><span style='color:green'><strong>Total- ".$tot_rec."</strong></span>";
                                    $total_receipt +=$tot_rec;
                                    echo'</td>';*/
                                    //===============================================================
                                    //========================Sales Product==========================
                                    echo '<td align="center">';
                                    //$sel_sp="select payable_amount,paid_type from sales_product_invoice where DATE(added_date)='".$newdates."' and payable_amount>0 ".$paid_type." ".$banks_id." ".$search_cm_id."";
									$sel_sp="select s.sgst_tax,s.cgst_tax,s.igst_tax,sp.added_date,sp.payment_mode_id,s.discounted_price,s.cgst_tax_in_per,s.sgst_tax_in_per,s.igst_tax_in_per,s.product_qty from sales_product_map s,sales_product sp where 1 and s.sales_product_id=sp.sales_product_id and (s.cgst_tax_in_per >0 or s.sgst_tax_in_per >0) and (sp.show_gst is NULL or sp.show_gst!='no') and sp.payable_amount>0 and DATE(sp.added_date)='".$newdates."' ".$paymode_type_prod." ".$banks_id_prod." ".$search_cm_id_prod." ";
                                    $ptr_sp=mysql_query($sel_sp);
                                    while($data_sp=mysql_fetch_array($ptr_sp))
                                    {
										$total_ded_value =0;
										$sql_pay="select payment_mode from payment_mode where payment_mode_id='".$data_sp['payment_mode_id']."'";
										$ptr_pay=mysql_query($sql_pay);
										$pay_type=mysql_fetch_array($ptr_pay);
										$taxdata='';
										if($data_sp['cgst_tax'] >0 && $data_sp['sgst_tax'] > 0)
										{
											$tot_sale_gst=intval(round($data_sp['cgst_tax']+$data_sp['sgst_tax']));
											$taxdata='/ '.$data_sp['cgst_tax_in_per'].'% + '.$data_sp['sgst_tax_in_per'].'%';
										}
										else if($data_sp['igst_tax'] >0)
										{
											$tot_sale_gst=intval(round($data_sp['igst_tax']));
											$taxdata='/ '.$data_sp['igst_tax_in_per'].'% ';
										}
										if($data_inv['paid_type']=='4')
										{
											$cc_deduction=(($tot_sale_gst*1.4)/100);
											$total_ded_value = $total_ded_value + $cc_deduction;
											//$after_cc_deduction = $after_cc_deduction + $total_ded_value;
										}
										$prod_qty='';
										if($data_inv['product_qty'] >1)
										{
											$prod_qty=' * '.$data_inv['product_qty'].'';
										}
										$tot_prod_sale_gst= $tot_sale_gst-$total_ded_value;
                                        echo "<span style='color:blue'>".$tot_sale_gst."</span> - ".$data_sp['discounted_price']." ".$prod_qty." ".$taxdata." <span style='color:brown'>(".$pay_type['payment_mode'].")</span><br/>";
                                        $tot_prod +=$tot_prod_sale_gst;
                                    }
                                    if($tot_prod>0)
                                        echo "<hr/><br/><span style='color:green'><strong>Total- ".$tot_prod."</strong></span>";
                                    $total_prod +=$tot_prod;
                                    echo'</td>';
                                    //===============================================================
                                    
                                    //========================Service================================
                                   	echo '<td align="center">';
                                   	$sel_ser="select i.paid_type,i.cgst_tax,i.sgst_tax,c.apply_gst from customer_service_invoice i, customer_service c where i.customer_service_id=c.customer_service_id and c.apply_gst!='no' and (i.cgst_tax_in_per >0 or i.sgst_tax_in_per >0) and DATE(i.added_date)='".$newdates."' and i.payable_amount>0 ".$paid_type_serv." ".$banks_id_serv." ".$search_cm_id_serv.""; 
                                    $ptr_ser=mysql_query($sel_ser);
                                    while($data_ser=mysql_fetch_array($ptr_ser))
                                    {
										$sql_pay="select payment_mode from payment_mode where payment_mode_id='".$data_ser['paid_type']."'";
										$ptr_pay=mysql_query($sql_pay);
										$pay_type=mysql_fetch_array($ptr_pay);
										
										$tot_service_gst=intval($data_ser['cgst_tax']+$data_ser['sgst_tax']);
										if($data_inv['paid_type']=='4')
										{
											$cc_deduction=(($tot_service_gst*1.4)/100);
											$total_ded_value = $total_ded_value + $cc_deduction;
											//$after_cc_deduction = $after_cc_deduction + $total_ded_value;
										}
										$tot_serv_gst= $tot_service_gst-$total_ded_value;
                                        echo "<span style='color:blue'>".$tot_serv_gst."</span> <span style='color:brown'>(".$pay_type['payment_mode'].")</span><br/>";
                                        $tot_ser +=$tot_serv_gst;
                                    }
                                    if($tot_ser>0)
                                        echo "<hr/><br/><span style='color:green'><strong>Total- ".$tot_ser."</strong></span>";
                                    $total_serv +=$tot_ser;
                                    echo'</td>';
                                    //============================================================
                                    //========================Cash deposited==============================
                                    /*echo '<td align="left">';
                                    $sel_dep1="select amount,bank_id,payment_mode_id from receipt where 1 ".$banks_id." and category='cash_transfer' and cash_transfer_mode='outword' and DATE(added_date)='".$newdates."' ".$search_cm_id." ";
                                    $ptr_dep1=mysql_query($sel_dep1);
                                    if(mysql_num_rows($ptr_dep1))
                                    {
                                        while($data_inward=mysql_fetch_array($ptr_dep1))
                                        {
											$sql_pay="select payment_mode from payment_mode where payment_mode_id='".$data_inward['payment_mode_id']."'";
											$ptr_pay=mysql_query($sql_pay);
											$pay_type=mysql_fetch_array($ptr_pay);	
											
											$sql_bank="select bank_name from bank where bank_id='".$data_inward['bank_id']."'";
											$ptr_bank=mysql_query($sql_bank);
											$pay_bank=mysql_fetch_array($ptr_bank);		
											
                                            echo "<span style='color:blue'>".$data_inward['amount']."</span> <span style='color:brown'>(".$pay_type['payment_mode']." - ".$pay_bank['bank_name'].") </span><br/>";
                                            $tot_depo +=$data_inward['total_amt'];
                                        }
                                    }*/
                                    /*$sel_bank_out="select amount,bank_id,payment_mode_id from receipt where 1 ".$banks_id." and category='cash_transfer' and cash_transfer_mode='bank_to_bank' and DATE(added_date)='".$newdates."' ".$search_cm_id." ";
                                    $ptr_bank_out=mysql_query($sel_bank_out);
                                    if(mysql_num_rows($ptr_bank_out))
                                    {
                                        while($data_outward_bank=mysql_fetch_array($ptr_bank_out))
                                        {					
											$sql_pay="select payment_mode from payment_mode where payment_mode_id='".$data_outward_bank['payment_mode_id']."'";
											$ptr_pay=mysql_query($sql_pay);
											$pay_type=mysql_fetch_array($ptr_pay);	
											
											$sql_bank="select bank_name from bank where bank_id='".$data_outward_bank['bank_id']."'";
											$ptr_bank=mysql_query($sql_bank);
											$pay_bank=mysql_fetch_array($ptr_bank);		
																
                                            echo "<span style='color:blue'>".$data_outward_bank['amount']."</span> <span style='color:brown'>(".$pay_type['payment_mode']." - ".$pay_bank['bank_name'].") </span><br/>";
                                            $tot_depo +=$data_outward_bank['total_amt'];
                                        }
                                    }
                                    
                                    if($tot_depo >0)
                                        echo "<hr/><br/><span style='color:green'><strong>Total- ".$tot_depo."</strong></span>";
                                    $total_dep_bank +=$tot_depo;
                                    echo'</td>';*/
                                    //===============================================================
                                    //========================Expemse ==========================
                                    echo '<td align="left">';
                                    $sel_exp="select e.payment_mode_id,e.bank_id,em.gst_claim,e.added_Date,em.cgst_tax,em.sgst_tax,em.sales_product_price,em.expense_id from expense e, expense_map em where DATE(e.added_Date)='".$newdates."' and e.total_price>0 and amount>0 and (em.cgst_tax_in_per >0 or em.sgst_tax_in_per >0 or em.igst_tax_in_per >0) and e.expense_id=em.expense_id and e.gst_claim='yes' ".$paymode_type_exp." ".$banks_id_exp." ".$search_cm_id_exp."";
                                    $ptr_exp=mysql_query($sel_exp);
                                    while($data_exp=mysql_fetch_array($ptr_exp))
                                    {
										$sql_pay="select payment_mode from payment_mode where payment_mode_id='".$data_exp['payment_mode_id']."'";
										$ptr_pay=mysql_query($sql_pay);
										$pay_type=mysql_fetch_array($ptr_pay);
										$tot_exp_amnt=($data_exp['cgst_tax']+$data_exp['sgst_tax']+$data_exp['igst_tax']);
										
										$sel_vend="select vendor_id from expense where expense_id='".$data_exp['expense_id']."'";
										$ptr_vend=mysql_query($sel_vend);
										$data_vend=mysql_fetch_array($ptr_vend);
										
										$sel_v_name="select name from vendor where vendor_id='".$data_vend['vendor_id']."'";
										$ptr_v_name=mysql_query($sel_v_name);
										$data_v_name=mysql_fetch_array($ptr_v_name);
										
                                        echo "<span style='color:blue'>".$tot_exp_amnt."</span> - (".$data_exp['sales_product_price'].") <span style='color:brown'>(".$pay_type['payment_mode'].") - (".$data_v_name['name'].")</span><br/>";
										
                                        $tot_exp +=$tot_exp_amnt;
                                    }
                                    if($tot_exp>0)
                                        echo "<hr/><br/><span style='color:red'><strong>Total- ".$tot_exp."</strong></span>";
                                    $total_expe +=$tot_exp;
                                    echo'</td>';
                                    //============================================================
                                    //========================Purchse==========================
                                    echo '<td align="center">';
                                   // $sel_pur="select i.payable_amount,i.paid_type,i.invoice_id,im.cgst_tax,im.sgst_tax,im.discounted_price,im.cgst_tax_in_per,im.sgst_tax_in_per,im.sin_product_qty,i.inventory_id from inventory_invoice i, inventory_product_map im where i. inventory_id=im.inventory_id and DATE(i.added_date)='".$newdates."' and i.payable_amount>0 and (im.cgst_tax_in_per >0 or im.sgst_tax_in_per >0) ".$paid_type_inv." ".$banks_id_inv." ".$search_cm_id_inv."";
									$sel_pur="select i.amount1,i.payment_mode_id,i.inventory_id,im.cgst_tax,im.sgst_tax,im.discounted_price,im.cgst_tax_in_per,im.sgst_tax_in_per,im.sin_product_qty from inventory i, inventory_product_map im where i.inventory_id=im.inventory_id and DATE(i.added_date)='".$newdates."' and (im.cgst_tax_in_per >0 or im.sgst_tax_in_per >0 or im.igst_tax_in_per >0) ".$paymode_type_inv." ".$banks_id_inv." ".$search_cm_id_inv."";
                                    $ptr_pur=mysql_query($sel_pur);
                                    while($data_pur=mysql_fetch_array($ptr_pur))
                                    {
										$sql_pay="select payment_mode from payment_mode where payment_mode_id='".$data_pur['payment_mode_id']."'";
										$ptr_pay=mysql_query($sql_pay);
										$pay_type=mysql_fetch_array($ptr_pay);
										$tot_gst_inv=($data_pur['cgst_tax']+$data_pur['sgst_tax']+$data_pur['igst_tax']);
										$qty='';
										if($data_pur['sin_product_qty'] >1)
										{
											$qty=' * '.$data_pur['sin_product_qty'].'';
										}
										$sel_vend="select vendor_id from inventory where inventory_id='".$data_pur['inventory_id']."'";
										$ptr_vend=mysql_query($sel_vend);
										$data_vend=mysql_fetch_array($ptr_vend);
										
										$sel_v_name="select name from vendor where vendor_id='".$data_vend['vendor_id']."'";
										$ptr_v_name=mysql_query($sel_v_name);
										$data_v_name=mysql_fetch_array($ptr_v_name);
										
                                        echo "<span style='color:blue'>".$tot_gst_inv."</span> - (".$data_pur['amount1'].") / ".$data_pur['cgst_tax_in_per']."% + ".$data_pur['sgst_tax_in_per']."% <span style='color:brown'>(".$pay_type['payment_mode'].")</span> - (".$data_v_name['name'].")<br/>";
                                        $tot_pur +=$tot_gst_inv;
                                    }
                                    if($tot_pur>0)
                                        echo "<hr/><br/><span style='color:red'><strong>Total- ".$tot_pur."</strong></span>";
                                    $total_purchase +=$tot_pur;
                                    echo'</td>';
                                    //============================================================
                                    //========================Cash Withdrawl==============================
                                    /*echo '<td align="center">';
                                    $sel_bank_out="select SUM(amount) as total_amt from receipt where ".$banks_id." and category='cash_transfer' and cash_transfer_mode='inword'  and DATE(added_date)='".$newdates."' ".$search_cm_id." ";
                                    $ptr_bank_out=mysql_query($sel_bank_out);
                                    if(mysql_num_rows($ptr_bank_out))
                                    {
                                        while($data_outward_bank=mysql_fetch_array($ptr_bank_out))
                                        {
                                            echo $data_outward_bank['total_amt']."<br/>";
                                            $tot_with +=$data_outward_bank['total_amt'];
                                        }
                                    }
                                    $sel_with="select SUM(amount) as total_amt from receipt where ".$banks_id_rec." and category='cash_transfer' and cash_transfer_mode='bank_to_bank'  and DATE(added_date)='".$newdates."' ".$search_cm_id." ";
                                    $ptr_bank_with=mysql_query($sel_with);
                                    if(mysql_num_rows($ptr_bank_with))
                                    {
                                        while($data_with_bank=mysql_fetch_array($ptr_bank_with))
                                        {
                                            echo "<span style='color:blue'>".$data_with_bank['total_amt']."</span><br/>";
                                            $tot_with +=$data_with_bank['total_amt'];
                                        }
                                    }
                                    if($tot_with >0)
                                        echo "<hr/><br/><span style='color:red'><strong>Total- ".$tot_with."</span></strong>";
                                    $total_with_bank +=$tot_with;
                                    echo'</td>';*/
                                    //===============================================================
                                    $total_credit=$tot_inv+$tot_rec+$tot_prod+$tot_ser+$total_dep_bank;
                                    $total_debit=$tot_exp+$tot_pur+$total_with_bank;
                                    
                                    $total_deposite +=$total_credit;
                                    $total_withdrawl +=$total_debit;
                                    echo '<td align="center" style="color:green">'.$total_credit.'</td>';
                                    echo '<td align="center" style="color:red">'.$total_debit.'</td>';
                                    echo '</tr>';
                                }
                                
                                ?>
                            	<tr class="grey_td">
                        	        <td align="center" colspan="2"><strong>Total</strong></td>
                    	            <td align="center" colspan="1"><strong><?php echo $total_enroll; ?></strong></td>
                	                <!--<td align="center" colspan="1"><strong><?php //echo $total_receipt; ?></strong></td>-->
            	                    <td align="center" colspan="1"><strong><?php echo $total_prod; ?></strong></td>
        	                        <td align="center" colspan="1"><strong><?php echo $total_serv; ?></strong></td>
     	                           <!--<td align="center" colspan="1"><strong><?php //echo $total_dep_bank; ?></strong></td>-->
	                                <td align="center" colspan="1"><strong><?php echo $total_expe; ?></strong></td>
                            		<td align="center" colspan="1"><strong><?php echo $total_purchase; ?></strong></td>
                            		<!--<td align="center" colspan="1"><strong><?php //echo $total_with_bank; ?></strong></td>-->
                            		<td align="center" colspan="1"><strong><?php echo $total_deposite; ?></strong></td>
                            		<td align="center" colspan="1"><strong><?php echo $total_withdrawl; ?></strong></td>
                            		<!--<td colspan="15">
                               			<table cellspacing="0" cellpadding="0" width="100%"  style="border:1 px solid #CCC; border-collapse:collapse">
                                    		<tr class="grey_td">
                                    
                                        		<td width="70%" align="center" colspan="3"><strong>Total</strong></td>
                                        
                                        		<td width="30%" align="center"><span style='color:red'><strong><?php //echo $totals_tds; ?></strong></span></td>
                                    		</tr>
                                		</table>
                            		</td>-->    						
                            	</tr>
                                <tr class="grey_td">
                        	        <td align="right" colspan="8"><strong>Total Difference</strong></td>
                            		<td align="center" colspan="2"><strong><?php echo $total_difference=intval($total_deposite-$total_withdrawl); ?></strong></td>
                            			
                            	</tr>
    							<tr class="head_td">
    								<td colspan="15">
     									<table cellspacing="0" cellpadding="0" width="100%">
                                    		<tr>
                                        	<?php
                                            	if($no_of_records>10)
                                            	{
                                                	echo '<td width="3%" align="left">Show</td>
                                                	<td width="20%" align="left"><select class="input_select_login" name="show_records" onchange="redirect(this.value)">';
                                                	$show_records=array(0=>'10',1=>'20','50','100');
                                                	for($s=0;$s<count($show_records);$s++)
                                                	{
                                                	    if($_SESSION['show_records']==$show_records[$s])
                                                	        echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                	    else
                                                	        echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                	}
                                                echo'</td></select>';
                                            	}
                                            	echo '<td width="75%" align="right">'.$pager->renderFullNav().'</td>'; 
                                        	?>
                                    		</tr>
        								</table>
                            		</td>
                            	</tr>
							</form>
                        	<?php 
						} 
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
