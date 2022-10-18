<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Customer Service Report</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; 
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];

?>
    <script type="text/javascript" src="../js/common.js"></script>
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
    <?php       if($_POST['formAction'])
                    {
                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $del_record_id=$_POST['chkRecords'][$r];
                                $sql_query= "SELECT cust_id FROM customer where cust_id ='".$del_record_id."'";
                                if(mysql_num_rows($db->query($sql_query)))
                                    {                                                
                                        $delete_query="delete from customer where cust_id='".$del_record_id."'";
                                        $db->query($delete_query);                                                                                        
                                    }
                             }
                             ?>
                                    <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record(s) deleted successfully</p></center></div>
                                    <script type="text/javascript">
                                       // $("#statusChangesDiv").dialog();
                                        $(document).ready(function() {
                                            $( "#statusChangesDiv" ).dialog({
                                                modal: true,
                                                buttons: {
                                                            Ok: function() { $( this ).dialog( "close" ); }
                                                         }
                                                });
                                            });
                                    </script>
                            <?php                            
                                }
                     }
                    if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
                    {
                        $del_record_id=$_REQUEST['record_id'];
                        $sql_query= "SELECT cust_id FROM customer where cust_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {                           
                            $delete_query="delete from customer where cust_id='".$del_record_id."'";
                            $db->query($delete_query);      
                            ?>
                            <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record deleted successfully</p></center></div>
                            <script type="text/javascript">
                               // $("#statusChangesDiv").dialog();
                                $(document).ready(function() {
                                    $( "#statusChangesDiv" ).dialog({
                                        modal: true,
                                        buttons: {
                                                    Ok: function() { $( this ).dialog( "close" ); }
                                                 }
                                        });
                                    });
                            </script>
                            <?php
                        }
                    }
                    ?>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
        
<table cellspacing="0" cellpadding="0" class="table" width="95%">
  <tr class="head_td">
    <td colspan="12">
        <form method="get" name="search">
		<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
            <tr>
                <td class="width5"></td>
                <td width="20%">
					<select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
							<option value="">-Operation-</option>
							<option value="delete">Delete</option>
					</select>
				</td>
				<?php if($_SESSION['type']=='S')
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
				<input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>">
				</td>
				<td width="10%" align="center">
				<input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>">
				</td>
				<td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                <td class="rightAlign" > 
					<table border="0" cellspacing="0" cellpadding="0" align="right">
						<tr>
						<td></td>
						<td class="width5"></td>
						<td><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
						<td class="width2"></td>
						<td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
						</tr>
                    </table>	
                </td>
            </tr>
        </table>
        </form>	
    </td>
  </tr>
<?php
                        if($_REQUEST['keyword']!="Keyword")
                            $keyword=trim($_REQUEST['keyword']);
                        if($keyword)
                            $pre_keyword=" and (cust_name like '%".$keyword."%' || mobile1 like '%".$keyword."%' || mobile2 like '%".$keyword."%' || email like '%".$keyword."%' || address like '%".$keyword."%' || membership like '%".$keyword."%')";
                        else
                            $pre_keyword="";
						
						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date") // on 3-2-2018
						{
							$frm_date=explode("/",$_REQUEST['from_date']);
							$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							
							$paid_from_date=" and DATE(`added_date`) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$paid_from_date_s=" and DATE(s.added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$paid_from_date_p=" and DATE(p.added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
						}
						else
						{
							$pre_from_date=""; 
							if($_REQUEST['to_date']=='')
							{
								$paid_from_date=" and DATE(`added_date`) >='".date('Y-m-d',strtotime('-30 days'))."'";
								$paid_from_date_s=" and DATE(s.added_date) >='".date('Y-m-d',strtotime('-30 days'))."'";
								$paid_from_date_p=" and DATE(p.added_date) >='".date('Y-m-d',strtotime('-30 days'))."'";
							}
							else
							{
								$paid_from_date="";
								$paid_from_date_s="";
								$paid_from_date_p="";
							}
							$installment_from_date="";                           
						}
						
						if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
						{
							$to_date=explode("/",$_REQUEST['to_date']);
							$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
							
							$paid_to_date=" and DATE(`added_date`)<='".date('Y-m-d',strtotime($to_dates))."'";
							$paid_to_date_s=" and DATE(s.added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
							$paid_to_date_p=" and DATE(p.added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
						}
						else
						{
							//$pre_to_date="";
							$installment_to_date="";
							$paid_to_date=" and DATE(`added_date`)<='".date('Y-m-d')."'";
							$paid_to_date_s=" and DATE(s.added_date)<='".date('Y-m-d')."'";
							$paid_to_date_p=" and DATE(s.added_date)<='".date('Y-m-d')."'";
							
						}
						
						
						$search_cm_id='';
						$cm_ids=$_SESSION['cm_id'];
						if($_SESSION['type']=="S")
						{
							if($_REQUEST['branch_name']!='')
							{
								$branch_name=$_REQUEST['branch_name'];
								$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_cm_id=mysql_query($select_cm_id);
								$data_cm_id=mysql_fetch_array($ptr_cm_id);
								$search_cm_id_s=" and s.cm_id='".$data_cm_id['cm_id']."'";
								$search_cm_id_p=" and p.cm_id='".$data_cm_id['cm_id']."'";
								$cm_ids=$data_cm_id['cm_id'];
							}
							else
							{
								$search_cm_id_s='';
								$search_cm_id_p='';
								
							}
						}
						else
						{
							$where_cmc='';
							$where_cms='';
							$where_cmp='';
							if($_SESSION['where']!='')
							{
								$where_cmc="and c.cm_id=".$_SESSION['cm_id']."";
								$where_cms="and s.cm_id=".$_SESSION['cm_id']."";
								$where_cmp="and p.cm_id=".$_SESSION['cm_id']."";
							}
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

                        if($_GET['orderby']=='cust_name' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='cust_name'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
						
						$select_directory='order by cust_id desc';                      
						"<br/>".$sql_query= "SELECT DISTINCT(c.cust_id) as cust_id FROM customer c,customer_service s, sales_product p where 1 and ( c.cust_id=s.customer_id or c.cust_id=p.customer_id) ".$where_cmc." ".$where_cms." ".$where_cmp." ".$paid_from_date_s." ".$paid_from_date_p." ".$paid_to_date_s." ".$paid_to_date_p." ".$search_cm_id_s." ".$search_cm_id_p." ".$pre_keyword." ".$select_directory.""; 
                       //echo $sql_query;
                        $no_of_records=mysql_num_rows($db->query($sql_query));
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword;
                            $query_string1=$query_string.$date_query;
                           // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
    <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                     <input type="hidden" name="formAction" id="formAction" value=""/>
                     <!--<tr>
                     <td colspan="10">
                     	<table width="990" height="84" align="center">
							<?
                        	/*$select_enroll = " select * from customer where cusstomer_id='".$record_id."' ";
                            $ptr_enroll=mysql_query($select_enroll);
                            $data_enroll = mysql_fetch_array($ptr_enroll);*/
                           /* $select_course = " select course_name from courses where course_id='".$data_enroll['course_id']."' ";
                            $ptr_course=mysql_query($select_course);
                            $data_course = mysql_fetch_array($ptr_course);*/
                            ?>
                            <tr style="padding-left:10px">
                                <td width="146"><strong>customer Name :</strong></td><td width="143"><? //echo $data_enroll['name']; ?></td>
                                <td width="145"><strong>MObile No :</strong></td><td width="226"><? //echo $data_course['course_name']; ?></td>
                                <td width="141"><strong>Email ID :</strong></td><td width="161"><? //echo $data_enroll['net_fees']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Admission Date :</strong></td><td><? //echo $data_enroll['added_date']; ?></td>
                                <td><strong>Enrollment ID :</strong></td><td><? //echo $data_enroll['installment_display_id']; ?></td>
                                <td width="141"><strong>Down Payment :</strong></td><td width="161"><? //echo $data_enroll['down_payment']; ?></td>
                            </tr>
                        </table>
                     </td>
                     </tr>-->
                      <tr class="grey_td" >
                        <td width="4%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
                        <td width="6%" align="center"><strong>Sr. No.</strong></td>
                        <td width="14%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=cust_name".$query_string;?>" class="table_font"><strong>Customer Name</strong></a> <?php echo $img1;?></td>
                        <!--<td width="7%" align="center"><strong>Mobile 1</strong></td>-->
                        <td width="38%" align="center"><strong>Services</strong></td>
                        <td width="38%" align="center"><strong>Products</strong></td>
                      </tr>
                            <?php
                            while($val_query=mysql_fetch_array($all_records))
                            {
								/*$sel_cust="select s.customer_id,p.customer_id from customer_service s, sales_product p where s.customer_id='".$val_query['cust_id']."' or p.customer_id='".$val_query['cust_id']."' ";
								$ptr_cust=mysql_query($sel_cust);
								if(mysql_num_rows($ptr_cust))
								{*/
									if($bgColorCounter%2==0)
										$bgcolor='class="grey_td"';
									else
										$bgcolor="";                
									$listed_record_id=$val_query['cust_id']; 
									include "include/paging_script.php";
									echo '<tr '.$bgcolor.' >
										  <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
									echo '<td align="center">'.$sr_no.'</td>';
									$sele_cust_name="select cust_name from customer where cust_id='".$listed_record_id."'";
									$ptr_cust_name=mysql_query($sele_cust_name);
									$data_cust_name=mysql_fetch_array($ptr_cust_name);
									
									echo '<td align="center"><a href="add_customer.php?record_id='.$listed_record_id.'" >'.$data_cust_name['cust_name'].'</a></td>';
									/*echo '<td align="center">'.$val_query['mobile1'].'</td>';*/
									echo'<td><table width="100%" class="table" style=" border: 1px solid black; border-collapse: collapse;margin-left:0px;margin-right:0px" border="1" >';
									$sel_services="select customer_service_id,total_cost,payable_amount,remaining_amount,payment_mode_id,chaque_no,bank_id,chaque_date,added_date from customer_service where customer_id='".$listed_record_id."' ".$paid_from_date_s." ".$paid_to_date_s." ";
									$ptr_services=mysql_query($sel_services);
									if(mysql_num_rows($ptr_services))
									{
										$i=1;
										echo'<tr style="border:1px solid black;"><td style="border:1px solid black;" align="center">Sr.no.</td><td style="border:1px solid black;" align="center">Services</td><td style="border:1px solid black;" align="center">Total Cost</td><td style="border:1px solid black;" align="center">Total Paid</td><td style="border:1px solid black;" align="center">Remaining</td><td style="border:1px solid black;" align="center">Paymrnt Detail</td><td style="border:1px solid black;" align="center">Date</td></tr>';
										while($data_service=mysql_fetch_array($ptr_services))
										{
											echo'<tr style="border:1px solid black;">';
											echo'<td style="border:1px solid black;" align="center">'.$i.'</td>';
											$sel_servicess='select service_id from customer_service_map where customer_service_id="'.$data_service['customer_service_id'].'"';
											$ptr_servicess=mysql_query($sel_servicess);
											$total_serv=mysql_num_rows($ptr_servicess);
											echo'<td style="border:1px solid black;" align="center"> ';
											$k=1;
											while($data_servicess=mysql_fetch_array($ptr_servicess))
											{
												$sel_ser="select service_name from servies where service_id='".$data_servicess['service_id']."'";
												$ptr_ser=mysql_query($sel_ser);
												$data_ser=mysql_fetch_array($ptr_ser);
												echo $data_ser['service_name']."<br>";
												if($k != $total_serv)
													echo "<hr>";
												$k++;
											}
											echo'</td>';
											echo'<td style="border:1px solid black;" align="center">'.$data_service['total_cost'].'</td>';
											echo'<td style="border:1px solid black;" align="center">'.$data_service['payable_amount'].'</td>';
											echo'<td style="border:1px solid black;" align="center">'.$data_service['remaining_amount'].'<br/>';
											if($data_service['remaining_amount'] !='')
											{
												echo '<span style="font-weight:600; font-style:italic;text-decoration:underline"><a href="cust_serv_payment_details.php?record_id='.$data_service['customer_service_id'].'" >pay now</a></span>';
											}
											echo'</td>';
											
											$sel_pay_mode="select payment_mode from payment_mode where payment_mode_id='".$data_service['payment_mode_id']."'";
											$ptr_sel_mode=mysql_query($sel_pay_mode);
											$fetch_pay_mode=mysql_fetch_array($ptr_sel_mode);
											
											echo'<td style="border:1px solid black;" align="center">Payment Type:<span style="font-weight:600; font-style:italic">'.$fetch_pay_mode['payment_mode'].'</span> <br/>';
											if($fetch_pay_mode['payment_mode']=='cheque')
											{
												$sel_bank_name="select bank_name,bank_id from bank where bank_id='".$data_service['bank_id']."'";
												$quer_bank=mysql_query($sel_bank_name);
												$fetch_qeur=mysql_fetch_array($quer_bank);
												?>
                                                <table width="100%">
												<tr>
													<td width="190">Bank Name: </td>
													<td width="196"><?php echo $fetch_qeur['bank_name']; ?> </td>
													
												</tr>
												<tr>
													<td width="190">Cheque No: </td>
													<td width="196"><?php echo  $data_service['chaque_no']; ?> </td>
												</tr>
												<tr>
													<?php
                                                    $explode_checq_date=explode('-',$data_service['chaque_date']);
                                                    $sep_cheque=$explode_checq_date[2].'-'.$explode_checq_date[1].'-'.$explode_checq_date[0];
                                                    ?>
                                                    <td width="190">Cheque Date: </td>
                                                    <td width="196"><?php echo $sep_cheque; ?> </td>
										  		</tr>
                                                </table>
												<?php			  
								  		 	}
											else if($fetch_pay_mode['payment_mode']=='Credit Card')
											{
												$sel_bank_name="select bank_name,bank_id from bank where bank_id='".$data_service['bank_id']."'";
												$quer_bank=mysql_query($sel_bank_name);
												$fetch_qeur=mysql_fetch_array($quer_bank);
												?>
												<table width="100%">
                                                <tr>
													<td width="190">ISAS Bank Name: </td>
													<td width="196"><?php echo $fetch_qeur['bank_name']; ?> </td>
												</tr>
												<tr>
													<td width="190">Credit Card No.: </td>
													<td width="196"><?php echo $data_service['credit_card_no']; ?> </td>
												</tr>
                                                </table>
                                                <?php
											}
											else if($fetch_pay_mode['payment_mode']=='voucher')
											{
												
												?>
                                                <table >
                                                <?php
												$vou_name="select * from customer_service_redeam_vouchers where customer_service_id='".$data_service['customer_service_id']."' ";
												$ptr_cust_id=mysql_query($vou_name);
												while($data_codes=mysql_fetch_array($ptr_cust_id))
												{
													$sel_vou="select deal_name,voucher_id from voucher where voucher_id='".$data_codes['voucher_id']."' ";
													$ptr_vou_name=mysql_query($sel_vou);
													$data_vou_name=mysql_fetch_array($ptr_vou_name);
													?>
                                                    
                                                    <tr>
														<td width="190">Voucher name: </td>
														<td width="196"><?php echo $data_vou_name['deal_name']; ?> </td>
													</tr>
                                                    <?php
													
													$sel_vou1="select voucher_code from voucher_code_map where voucher_code_id='".$data_codes['voucher_code_id']."' ";
													$ptr_vou1_name=mysql_query($sel_vou1);
													$data_vou_name1=mysql_fetch_array($ptr_vou1_name);
													?>
                                                    <tr>
														<td width="190">Voucher Code: </td>
														<td width="196"><?php echo $data_vou_name1['voucher_code']; ?> </td>
													</tr>
                                                    
                                                    <?php
													
												}
												?>
												</table>
                                                
                                                <?php
											}
											
											
											echo '</td>';
											echo'<td style="border:1px solid black;" align="center">'.$data_service['added_date'].'<br/>';
											
											echo'</tr>';
											$i++;
										}
									}
										echo'</table></td>';
									
									/*echo '<td align="center"><a href="add_customer_membership.php?record_id='.$listed_record_id.'" ><img src="images/add.png" title="Add Membership" class="example-fade"/></a></td>';*/
									echo'<td><table width="100%" class="table" style=" border: 1px solid black; border-collapse: collapse;margin-left:0px;margin-right:0px" border="1" >';
									$sel_products="select sales_product_id,total_price,payable_amount,remaining_amount,payment_mode_id,added_date from sales_product where customer_id='".$listed_record_id."' ".$paid_from_date_s." ".$paid_to_date_s."";
									$ptr_products=mysql_query($sel_products);
									$i=1;
									if(mysql_num_rows($ptr_products))
									{
										echo'<tr style="border:1px solid black;"><td style="border:1px solid black;" align="center">Sr.no.</td><td style="border:1px solid black;" align="center">Products</td><td style="border:1px solid black;" align="center">Total Cost</td><td style="border:1px solid black;" align="center">Total Paid</td><td style="border:1px solid black;" align="center">Remaining</td><td style="border:1px solid black;" align="center">Paymrnt Detail</td><td style="border:1px solid black;" align="center">Date</td></tr>';
										while($data_products=mysql_fetch_array($ptr_products))
										{
											echo'<tr style="border:1px solid black;">';
											echo'<td style="border:1px solid black;" align="center">'.$i.'</td>';
											$sel_servicess='select product_id from sales_product_map where sales_product_id="'.$data_products['sales_product_id'].'"';
											$ptr_servicess=mysql_query($sel_servicess);
											$total_serv=mysql_num_rows($ptr_servicess);
											echo'<td style="border:1px solid black;" align="center"> ';
											$t=1;
											while($data_servicess=mysql_fetch_array($ptr_servicess))
											{
												$sel_ser="select product_name from product where product_id='".$data_servicess['product_id']."'";
												$ptr_ser=mysql_query($sel_ser);
												$data_ser=mysql_fetch_array($ptr_ser);
												echo $data_ser['product_name']."<br>";
												if($t != $total_serv)
													echo "<hr>";
												$t++;
											}
											echo'</td>';
											echo'<td style="border:1px solid black;" align="center">'.$data_products['total_price'].'</td>';
											echo'<td style="border:1px solid black;" align="center">'.$data_products['payable_amount'].'</td>';
											echo'<td style="border:1px solid black;" align="center">'.$data_products['remaining_amount'].'<br/>';
											if($data_products['remaining_amount'] !='')
											{
												echo '<span style="font-weight:600; font-style:italic;text-decoration:underline"><a href="sales_prod_payment_details.php?record_id='.$data_products['sales_product_id'].'" >pay now</a></span>';
											}
											echo '</td>';
											
											$sel_pay_mode="select payment_mode from payment_mode where payment_mode_id='".$data_products['payment_mode_id']."'";
											$ptr_sel_mode=mysql_query($sel_pay_mode);
											$fetch_pay_mode=mysql_fetch_array($ptr_sel_mode);
											
											echo'<td style="border:1px solid black;" align="center">Payment Type:<span style="font-weight:600; font-style:italic">'.$fetch_pay_mode['payment_mode'].'</span> <br/>';
											if($fetch_pay_mode['payment_mode']=='cheque')
											{
												$sel_bank_name="select bank_name,bank_id from bank where bank_id='".$data_products['bank_id']."'";
												$quer_bank=mysql_query($sel_bank_name);
												$fetch_qeur=mysql_fetch_array($quer_bank);
												?>
                                                <table width="100%">
												<tr>
													<td width="190">Bank Name: </td>
													<td width="196"><?php echo $fetch_qeur['bank_name']; ?> </td>
													
												</tr>
												<tr>
													<td width="190">Cheque No: </td>
													<td width="196"><?php echo  $data_products['chaque_no']; ?> </td>
												</tr>
												<tr>
													<?php
                                                    $explode_checq_date=explode('-',$data_products['chaque_date']);
                                                    $sep_cheque=$explode_checq_date[2].'-'.$explode_checq_date[1].'-'.$explode_checq_date[0];
                                                    ?>
                                                    <td width="190">Cheque Date: </td>
                                                    <td width="196"><?php echo $sep_cheque; ?> </td>
										  		</tr>
                                                </table>
												<?php			  
								  		 	}
											else if($fetch_pay_mode['payment_mode']=='Credit Card')
											{
												$sel_bank_name="select bank_name,bank_id from bank where bank_id='".$data_products['bank_id']."'";
												$quer_bank=mysql_query($sel_bank_name);
												$fetch_qeur=mysql_fetch_array($quer_bank);
												?>
												<table width="100%">
                                                <tr>
													<td width="190">ISAS Bank Name: </td>
													<td width="196"><?php echo $fetch_qeur['bank_name']; ?> </td>
												</tr>
												<tr>
													<td width="190">Credit Card No.: </td>
													<td width="196"><?php echo $data_products['credit_card_no']; ?> </td>
												</tr>
                                                </table>
                                                <?php
											}
											else if($fetch_pay_mode['payment_mode']=='voucher')
											{
												
												?>
												<table width="100%">
                                                <tr>
													<td width="190">Voucher :</td>
													<td width="196"><?php echo $fetch_qeur['bank_name']; ?> </td>
												</tr>
                                                <?php
												$vou_name="select * from customer_service_redeam_vouchers where customer_service_id='".$id."' ";
												$ptr_cust_id=mysql_query($vou_name);
												while($data_codes=mysql_fetch_array($ptr_cust_id))
												{
													$sel_vou="select deal_name,voucher_id from voucher where voucher_id='".$data_codes['voucher_id']."' ";
													$ptr_vou_name=mysql_query($sel_vou);
													$data_vou_name=mysql_fetch_array($ptr_vou_name);
													?>
                                                    <tr>
														<td width="190">Voucher name</td>
														<td width="196"><?php echo $data_vou_name['deal_name']; ?> </td>
													</tr>
                                                    <?php
													
													$sel_vou1="select voucher_code from voucher_code_map where voucher_code_id='".$data_codes['voucher_code_id']."' ";
													$ptr_vou1_name=mysql_query($sel_vou1);
													$data_vou_name1=mysql_fetch_array($ptr_vou_name1);
													?>
                                                    <tr>
														<td width="190">Voucher Code</td>
														<td width="196"><?php echo $data_vou_name1['voucher_code']; ?> </td>
													</tr>
                                                    <?php
													
												}
												?>
												
                                                </table>
                                                <?php
											}
											
											
											echo '</td>';
											echo'<td style="border:1px solid black;" align="center">'.$data_products['added_date'].'<br/>';
											echo'</tr>';
											$i++;
										}
										
									}
									echo'</table></td>';
									
									/*echo '<td align="center"><a href="customer_service_report.php?record_id='.$listed_record_id.'" ><img src="images/add.png" title="Report" class="example-fade"/></a></td>';*/
								   
								   /* echo '<td align="center"><a href="add_customer.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
								   <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
									echo '</td>';*/
									echo '</tr>';
								
									$bgColorCounter++;
								//}
                            }    
                           ?>
  <tr class="head_td">
    <td colspan="12">
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
    </tr></form>
      <?php } 
      else
        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No Page found related to your search criteria, please try again</div><br></td></tr>';?>
</table>

	</td>
    <td class="mid_right" ></td>
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
