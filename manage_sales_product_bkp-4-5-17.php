<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Sales Product</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
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
    <td class="top_mid" valign="bottom"><?php include "include/product_category_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
    <?php       if($_POST['formAction'])
                    {
                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $del_record_id=$_POST['chkRecords'][$r];
                                $sql_query= "SELECT sales_product_id FROM sales_product where sales_product_id ='".$del_record_id."'";
                                if(mysql_num_rows($db->query($sql_query)))
                                    {                                                
                                        $delete_query="delete from sales_product where sales_product_id='".$del_record_id."'";
                                        $db->query($delete_query); 
										
										$delete_query1="delete from sales_product_map where sales_product_id='".$del_record_id."'";
                                        $db->query($delete_query1);   
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
                        $sql_query= "SELECT sales_product_id FROM sales_product where sales_product_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {                           
                            $delete_query="delete from sales_product where sales_product_id='".$del_record_id."'";
                            $db->query($delete_query); 
							
							$delete_query1="delete from sales_product_map where sales_product_id='".$del_record_id."'";
                            $db->query($delete_query1); 
							
							    
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
    <td colspan="14">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                <td width="20%">
                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                <option value="">-Operation-</option>
                                <option value="delete">Delete</option>
<!--                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>-->
                        </select></td>
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
                            $pre_keyword=" and (amount like '%".$keyword."%' || price like '%".$keyword."%' || discount like '%".$keyword."%' || tax like '%".$keyword."%' || total_cost like '%".$keyword."%' || payment_mode like '%".$keyword."%' )";
                        else
                            $pre_keyword="";

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

                        if($_GET['orderby']=='sales_product_id' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='sales_product_id'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                        	$select_directory='order by sales_product_id desc';  
						
						if($pre_keyword=='')
						{                  
                          	$sql_query= "SELECT * FROM sales_product where 1 ".$_SESSION['where']." ".$_SESSION['user_id']." ".$pre_keyword." ".$select_directory.""; 
						}
						else
						{
							$cm_ids=='';
							$admin_ids='';
							if($_SESSION['where'] !='')
							{
								$cm_ids="and sp.cm_id='".$_SESSION['cm_id']."'";
							}
							if($_SESSION['user_id'] !='')
							{
								$admin_ids="and sp.admin_id='".$_SESSION['admin_id']."'";
							}
							
							$sql_query= "SELECT distinct(sp.sales_product_id) as sales_product_id FROM sales_product sp, site_setting s, customer c, payment_mode pm where 1  and (sp.total_price like '%".$keyword."%' or sp.discount like '%".$keyword."%' or sp.product_price like '%".$keyword."%' or sp.tot_price_withou_tax like '%".$keyword."%' or sp.payable_amount like '%".$keyword."%' or sp.remaining_amount like '%".$keyword."%' or s.branch_name like '%".$keyword."%' or c.cust_name like '%".$keyword."%' or pm.payment_mode like '%".$keyword."%' ) and sp.payment_mode_id=pm.payment_mode_id and sp.cm_id=s.cm_id and sp.customer_id=c.cust_id and sp.payment_mode_id=pm.payment_mode_id ".$cm_ids." ".$admin_ids.""; 
						}
                       
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
                     <tr class="grey_td" >
                        <td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
                        <td width="5%" align="center"><strong>Sr. No.</strong></td>
                        <td width="10%" align="center"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=vendor".$query_string;?>" class="table_font"><strong>Branch</strong></a> <?php echo $img1;?></td>
                        
                        <td width="10%" align="center"><strong>Customer Name</strong></td>
                        
                        <td width="15%" align="center"><strong>Product</strong></td>
                        
                        <td width="15%" align="center"><strong>Total Product Price</strong></td>
                        
                        <td width="15%" align="center"><strong>Discount</strong></td>
                       
                        <td width="15%" align="center"><strong>Total Discounted Price</strong></td>
                        
                        <td width="15%" align="center"><strong> Total Paid Amount</strong></td>
                        
                        <td width="15%" align="center"><strong>Remaining Amount</strong></td>
                         
                        <td width="15%" align="center"><strong>Payment Mode</strong></td>
                        
                        <td width="6%" align="center"><strong>View Payment</strong></td>
                       
                         <td width="10%" align="center"><strong>Added Date</strong></td>
                        <td width="10%" class="centerAlign"><strong>Action</strong></td>
                      </tr>
                      
                      <style>
								hr.style4 { 
									  border: 0; 
									  height: 1px; 
									  background-image: -webkit-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
									  background-image: -moz-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
									  background-image: -ms-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
									  background-image: -o-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0); 
									}
					</style> 
                            <?php

                            while($val_querys=mysql_fetch_array($all_records))
                            {
								
								$selct_all_rec = " select * from `sales_product` where sales_product_id= '".$val_querys['sales_product_id']."' ";
								$ptr_all = mysql_query( $selct_all_rec);
								$val_query= mysql_fetch_array($ptr_all);
								
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                
                                $listed_record_id=$val_query['sales_product_id']; 
                               
                                include "include/paging_script.php";
                                
                                echo '<tr '.$bgcolor.' >
                                      <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
                                echo '<td align="center">'.$sr_no.'</td>'; 
								      
							    $sql_branch = " select branch_name, cm_id from site_setting where cm_id='".$val_query['cm_id']."' ";
								$ptr_branch = mysql_query($sql_branch);
								$data_branch = mysql_fetch_array($ptr_branch);
									  
                                echo '<td align="center">'.$data_branch['branch_name'].'</td>';
								
								$sql_product = " select cust_name, cust_id from customer where cust_id='".$val_query['customer_id']."' ";
								$ptr_product = mysql_query($sql_product);
								$data_product = mysql_fetch_array($ptr_product);
								
								echo '<td align="center">'.$data_product['cust_name'].'</td>';
								
								echo '<td align="center">';
								
								$sel_product="select sales_product_id,product_id,product_qty from sales_product_map where sales_product_id ='".$val_query['sales_product_id']."'";
								$ptr_product=mysql_query($sel_product);
								$k=1;
								$count=mysql_num_rows($ptr_product);
								while($data_product=mysql_fetch_array($ptr_product))
								{
									$select_service_name="select product_name,price from product where product_id='".$data_product['product_id']."'";
									$ptr_service=mysql_query($select_service_name);
									$data_service_name=mysql_fetch_array($ptr_service);
									echo $data_service_name['product_name']."(Price - ".$data_service_name['price'].")(Qty - ".$data_product['product_qty'].")<br />";
									
									if($k !=$count)
									{
										echo '<hr class="style4">';
									}
									
									$k++;
								}
								
								echo '</td>';
								
								echo '<td align="center">'.$val_query['product_price'].'</td>';
								
								echo '<td align="center">'.$val_query['discount'].'</td>';
								
								echo '<td align="center">'.$val_query['total_price'].'</td>';
								
								$tot_paid_amount="SELECT SUM( payable_amount ) as payable_amount FROM `sales_product_invoice` WHERE sales_product_id=".$listed_record_id."";
								$query_sum=mysql_query($tot_paid_amount);
								$fetch_sum=mysql_fetch_array($query_sum);
								
								echo '<td align="center">'.$fetch_sum['payable_amount'].'</td>';
								
								echo '<td align="center">'.$val_query['remaining_amount'].'</td>';
								
								$sql_payment_mode = " select payment_mode, payment_mode_id from payment_mode where payment_mode_id='".$val_query['payment_mode_id']."' ";
								$ptr_payment_mode = mysql_query($sql_payment_mode);
								$data_payment = mysql_fetch_array($ptr_payment_mode);
								
								
								echo '<td align="center">'.$data_payment['payment_mode'].'</td>';
								
								echo '<td><center><a href="sales_prod_payment_details.php?record_id='.$listed_record_id.'">
						<img src="images/view_bill.jpg" border="0" width="30px" height="30px" title="View Payment"></a></center></td>';
								
                                echo '<td align="center">'.$val_query['added_date'].'</td>';
								echo '<td align="center">';
								
                                //echo '<a href="sales_product.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;';
								echo '<a href="" onClick="window.open(\'invoice_sales_product.php?record_id='.$listed_record_id.'\', \'win1\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900,height=600,directories=no,location=no\'); return false;" ><img src="images/invoice.png" title="View Invoice" class="example-fade"/></a>&nbsp;&nbsp;';
								
                                      echo '<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';

                                echo '</td>';
                                echo '</tr>';
                                                                
                                $bgColorCounter++;
                            }    
                                ?>
  
  
  <tr class="head_td">
    <td colspan="14">
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
