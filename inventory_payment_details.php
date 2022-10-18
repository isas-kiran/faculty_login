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
<title>Inventory Payment Details</title>
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
<?php include "include/header.php";?>
<div id="info">
<?php include "include/menuLeft.php"; ?>
<!--left end-->
<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/product_category_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
                         
                      <?php
                       
						$sql_records= "SELECT * FROM inventory_invoice where inventory_id=".$record_id." ";
						$query_records=mysql_query($sql_records);
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
                                        <td height="2" align="right"><?php echo $pager->renderFullNav();?></td>
                                       </tr>
                                       </table>
                                      </td></tr>
                                    
                                    <tr>
                                      <td valign="top" colspan="2">
                                    <table width="990" height="84" align="center">
                                    <?php
									
										$sel_inventory="select vendor_id, inventory_id, price, discount, discount_price, total_cost, amount1, payable_amount, remaining_amount from inventory where inventory_id='".$record_id."'";
										$quer_inventory=mysql_query($sel_inventory);
										$fetch_query_inventory=mysql_fetch_array($quer_inventory);
									
                                        $select_vendor = " select name, vendor_id from vendor where vendor_id='".$fetch_query_inventory['vendor_id']."' ";
									  	$ptr_vendor=mysql_query($select_vendor);
										$data_vendor = mysql_fetch_array($ptr_vendor);
										
									?>
                                    	<tr style="padding-left:10px">
                                        	<td width="20"><strong>Vendor Name :</strong></td><td width="330"><?php echo $data_vendor['name']; ?></td>
                                            
                                        </tr>
                                        
                                    </table>
                                    
                                    </td></tr>
                                    
                                    <tr><td valign="top" colspan="2">
                                       <table width="98%" align="center"  cellpadding="0" cellspacing="1"  class="table" style="width: 97%;">
								<tr align="center" class="grey_td" >
                                    <td width="5%" class="tr-header"><strong>Sr.</strong></td>
                                    <td width="11%" class="tr-header"><strong>Invoice No.</strong></td>
                                    <td width="11%" class="tr-header"><strong>Total Product Price</strong></td>
                                    <td width="11%" class="tr-header"><strong>Discount</strong></td>
                                    <td width="11%"  class="tr-header"><strong>Total Discounted Price</strong></td>
                                    <td width="11%"  class="tr-header"><strong>Final Amount</strong></td>
                                    <td width="11%"  class="tr-header"><strong>Total paid Amount</strong></td>
                                    <td width="11%" class="tr-header"><strong> Deposit Amount </strong></td>
                                    <td width="11%" class="tr-header"><strong> Remaining Amount </strong></td>
                                    <td width="11%" class="tr-header"><strong> Date </strong></td>
                                    <td width="9%" class="tr-header"><strong>Status</strong></td>
                                    <td width="9%" class="tr-header"><strong>View</strong></td>
                                    <td width="12%" class="tr-header"><strong>Print</strong></td>
                                </tr><?php
								    $total_paid='';
                                    while($val_record=mysql_fetch_array($all_records))
                                    {
										if($bgColorCounter%2==0)
                                    		$bgcolor='class="grey_td"';
                                		else
                                    		$bgcolor=""; 
										 $enroll_id=$val_record['enroll_id'];
										 $paid_totas=0;
                                        
                                        include "include/paging_script.php";
										
                                        echo '<tr class="'.$bgclass.'">';
                                        echo '<td align="center">'.$sr_no.'</td>';
										echo "<td align='center'>".$val_record['invoice_id']."</td>";
									    echo '<td align="center">'.$fetch_query_inventory['price'].'</td>'; 
									    echo '<td align="center">'.$fetch_query_inventory['discount'].'</td>';
									    echo '<td align="center">'.$fetch_query_inventory['total_cost'].'</td>';
										echo '<td align="center">'.$fetch_query_inventory['amount1'].'</td>';
										
										$tot_paid_amount="SELECT SUM( payable_amount ) as payable_amount FROM `inventory_invoice` WHERE inventory_id=".$record_id."";
										$query_sum=mysql_query($tot_paid_amount);
										$fetch_sum=mysql_fetch_array($query_sum);
										
										$total_paid +=$val_record['payable_amount'];
										
										echo '<td align="center">'.$total_paid.'</td>';
								        echo '<td align="center">'.$val_record['payable_amount'].'</td>';
								        echo '<td align="center">'.$val_record['remaining_amount'].'</td>';
								
									    echo '<td align="center">';
										echo date("d-m-Y",strtotime($val_record['added_date']));
										echo'</td>';
										 echo '<td align="center">';
										echo $val_record['status'];
										echo'</td>';
                                        echo "<td align='center'>
										<img src='images/view.jpeg' title='View Invoice' border='0' 
										onclick=\"window.open('invoice_generate_inventory.php?record_id=".$val_record['invoice_id']."','View Invoice','scrollbars=yes','resizable=yes','width=900,height=600')\" style='cursor:pointer' >
										</td>";
										echo "<td align='center'><img src='images/print1.jpeg'
								onclick=\"window.open('invoice_generate_inventory.php?record_id=".$val_record['invoice_id']."&action=print','View Invoice','width=750,height=700')\"style='cursor:pointer'title='Print Invoice' border='0'></td>";
										
                                        echo '</tr>';
										$bgColorCounter++;
									}
                                  
                                    ?>
                                        </table>
                                        <table align="right">
                                        <tr>
                                        <?php
                                        if($fetch_query_inventory['remaining_amount'] !=0)
										{
											
											echo '<td>';
											echo'<a href="add_inventory_payment.php?record_id='.$record_id.'"><strong><font size="+1">Add Payment</font></strong></a>'; 
											echo '</td>';
											echo '<td>';
											echo  '<a href="add_inventory_payment.php?record_id='.$record_id.'">
											<img src="images/add1-.png" border="0" title="Add Payment"></a>';
											echo '</td>';
										}
								?>
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