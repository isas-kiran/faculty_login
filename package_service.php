<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Package Services</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='150'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
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
    
    <script>
	function service_status(values,ids)
	{
		var data1="status="+values+"&customer_id="+ids;	
		//alert(data1);
			$.ajax({
				url: "get_status.php", type: "post", data: data1, cache: false,
				success: function (html)
				{
					if(html=="success")
					{
						alert("Status changed successfully");
					}
				}
				});
		
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
                                $sql_query= "SELECT customer_service_id FROM customer_service where customer_service_id ='".$del_record_id."'";
                                if(mysql_num_rows($db->query($sql_query)))
								{                                                
									$delete_query="delete from customer_service where customer_service_id='".$del_record_id."'";
									$db->query($delete_query);   
									
									$delete_query1="delete from customer_service_map where customer_service_id='".$del_record_id."'";
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
                        $sql_query= "SELECT customer_service_id FROM customer_service where customer_service_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {                           
                            $delete_query="delete from customer_service where customer_service_id='".$del_record_id."'";
                            $db->query($delete_query);
							
							$delete_query1="delete from customer_service_map where customer_service_id='".$del_record_id."'";
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
    <td colspan="15">
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
                            $pre_keyword=" and (service_name like '%".$keyword."%' || service_description like '%".$keyword."%' || service_price like '%".$keyword."%' || service_time like '%".$keyword."%' || service_code like '%".$keyword."%' || status like '%".$keyword."%')";
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

                        if($_GET['orderby']=='service_name' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='service_name'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                            $select_directory='  order by customer_service_id desc';  
							
							if($pre_keyword=='')
								{                     
									    $sql_query= "SELECT  * FROM customer_service where  packagess_deal_id !='' or packagess_deal_id !=0 ".$_SESSION['where']." ".$pre_keyword." ".$select_directory.""; 
								 
								 
								  /* $sql_query="SELECT 
 customer_service_id, 
 MAX(added_date) AS most_recent_signin
FROM customer_service
GROUP BY packagess_deal_id"; */
//echo  $sql_query="SELECT customer_service_id FROM `customer_service` WHERE added_date=(SELECT MAX(added_date) FROM `customer_service`)";



 /*  $sql_query="SELECT * 
FROM customer_service
WHERE added_date
IN (
SELECT MAX( added_date ) 
FROM customer_service
WHERE packagess_deal_id !=  '0'
GROUP BY packagess_deal_id
)
 ".$pre_keyword." ".$select_directory.""; */
								}
								else
								
								{
									  $sql_query= "SELECT distinct(cs.customer_service_id) as customer_service_id FROM customer_service cs, customer c, servies s, customer_service_map csm where 1  and (cs.service_price like '%".$keyword."%' or cs.discount_price like '%".$keyword."%' or cs.service_tax like '%".$keyword."%' or cs.total_cost like '%".$keyword."%' or c.cust_name like '%".$keyword."%' or c.mobile1 like '%".$keyword."%' or s.service_name like '%".$keyword."%' or s.service_price like '%".$keyword."%') and cs.customer_id=c.cust_id and cs.customer_service_id=csm.customer_service_id  and csm.service_id=s.service_id ".$_SESSION['where']." ".$select_directory." "; 
								}
                       //echo $sql_query;
                        $no_of_records=mysql_num_rows($db->query($sql_query));
						//$fetch=mysql_query($sql_query);
						//$no_of_records=mysql_num_rows($fetch);
						
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
                        <td width="10%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=service_name".$query_string;?>" class="table_font"><strong>Customer Name</strong></a> <?php echo $img1;?></td>
						<td width="10%" align="center"><strong>Package Name</strong></td>
                        <td width="10%" align="center"><strong>Services</strong></td>
                        <td width="10%" align="center"><strong>Quantity</strong></td>
                         <td width="10%" align="center"><strong>Redum. Services</strong></td>
                          <td width="10%"><strong>Remaining Services</strong></td>
                        <!--<td width="10%"><strong>Total Service Price</strong></td>
                        <td width="10%" align="center"><strong>Discount Price</strong></td>
                        <td width="10%" align="center"><strong>Service Tax Cost</strong></td>
                        <td width="10%" align="center"><strong>Total Cost</strong></td>
                        <td width="15%" align="center"><strong> Total Paid Amount</strong></td>
                        
                        <td width="15%" align="center"><strong>Remaining Amount</strong></td>
                        <td width="10%" align="center"><strong>Status</strong></td>
                        <td width="10%" align="center"><strong>Job Card</strong></td>
                        <td width="6%" align="center"><strong>View Payment</strong></td>-->
                        <td width="10%" align="center"><strong>Added Date</strong></td>
                        <!--<td width="10%" class="centerAlign"><strong>Action</strong></td>-->
                      </tr>
                            <?php
							
                            while($val_querys=mysql_fetch_array($all_records))
                            {
								
								
								
								
								 $selct_all_rec = " select * from `customer_service` where customer_service_id= '".$val_querys['customer_service_id']."' ";
								$ptr_all = mysql_query( $selct_all_rec);
								$val_query= mysql_fetch_array($ptr_all);
								
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                
                                $listed_record_id=$val_query['customer_service_id']; 
                                
                                $position=120; // Define how many character you want to display.                                
                                $post = substr(strip_tags($val_query['service_description']), 0, $position);
                                
                                include "include/paging_script.php";
                                
								 $sel_cust_name="select cust_name,mobile1 from customer where cust_id='".$val_query['customer_id']."'";
								$ptr_cust=mysql_query($sel_cust_name);
								$data_cust_name=mysql_fetch_array($ptr_cust);
                                echo '<tr '.$bgcolor.' >
                                      <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
                                echo '<td align="center">'.$sr_no.'</td>';   
								$sel_cust_inv="select invoice_id from customer_service_invoice where customer_service_id='".$listed_record_id."'";   
								$ptr_cust_inv=mysql_query($sel_cust_inv); 
							    if(mysql_num_rows($ptr_cust_inv)>1)
								{
									echo '<td >'.$data_cust_name['cust_name'].'<br>'.$data_cust_name['mobile1'].
									'</td>';
								}
								else
                                {
									echo '<td ><a href="add_cust_services.php?record_id='.$listed_record_id.'" >'.$data_cust_name['cust_name'].'<br>'.$data_cust_name['mobile1'].'</a></td>';
								}
								echo '<td align="center">';
								$sel_cust_services="select package_name from package where package_id ='".$val_querys['packagess_deal_id']."'";
								$ptr_sel_service=mysql_query($sel_cust_services);
								while($data_service=mysql_fetch_array($ptr_sel_service))
								{
									echo $data_service['package_name'];
								}
								echo '</td>';
								
								
								echo '<td align="center">';
								$sel_cust_services="select service_id,quantity from package_service_map where package_id ='".$val_querys['packagess_deal_id']."'";
								$ptr_sel_service=mysql_query($sel_cust_services);
								while($data_service=mysql_fetch_array($ptr_sel_service))
								{
									$select_service_name="select service_name,service_price from servies where service_id='".$data_service['service_id']."'";
									$ptr_service=mysql_query($select_service_name);
									$data_service_name=mysql_fetch_array($ptr_service);
									$pck_qty=$data_service['quantity'];
									echo $data_service_name['service_name']."(Price - ".$data_service_name['service_price'].")(QTY - ".$data_service['quantity'].")<br />";
									
								}
								echo '</td>';
								echo '<td align="center">';
								  $select_id="SELECT package_id,quantity FROM sales_package_voucher_memb WHERE  package_id='".$val_querys['packagess_deal_id']."' and category='Package'";
								  $query=mysql_query($select_id);
								 while($fetch=mysql_fetch_array($query))
								{ 
								$total_qty=$fetch['quantity'];
								 echo $fetch['quantity'];
								
								}
								echo '</td>';
								echo '</td>';
							 	echo '<td align="center">';
								/*
								  $select_id="SELECT package_id,quantity,service_id FROM package_service_map WHERE  package_id='".$val_querys['packagess_deal_id']."'";
								  $query=mysql_query($select_id);
								 while($fetch=mysql_fetch_array($query))
								{ 
								
								    $select_id="SELECT package_id,quantity,service_id FROM sales_customer_service_voucher_map WHERE package_id='".$fetch['package_id']."' ";
								  $query=mysql_query($select_id);
								   while($fetch_qty=mysql_fetch_array($query))
								   {
									   
									  $select_service_name="select service_name,service_price,service_id from servies where service_id='".$fetch_qty['service_id']."'";
									$ptr_service=mysql_query($select_service_name);
									$data_service_name=mysql_fetch_array($ptr_service);
									
									
									 $qty=$fetch['quantity']-$fetch_qty['quantity'];
									
								echo $data_service_name['service_name']."(Price - ".$data_service_name['service_price'].")(QTY - ".$qty.")<br />";
								                 
								   }
								} */
								
								
								
							
								      $select_id="SELECT service_id FROM customer_service_map WHERE customer_service_id='".$val_querys['customer_service_id']."' ";
								  $query=mysql_query($select_id);
								   while($fetch_qty=mysql_fetch_array($query))
								   {
									   
									    $select_service_name="select service_name,service_price,service_id from package_service_map where service_id='".$fetch_qty['service_id']."' and package_id='".$val_querys['packagess_deal_id']."' ";
									$ptr_service=mysql_query($select_service_name);
									
									
									
									$select_service_name="select service_name,service_price,service_id from servies where service_id='".$fetch_qty['service_id']."'";
									$ptr_service=mysql_query($select_service_name);
									$data_service_name=mysql_fetch_array($ptr_service);
									$fetch=mysql_num_rows($ptr_service);
									 $qnty="$fetch";
									
									 $qty=$fetch['quantity']-$fetch_qty['quantity'];
									
						echo $data_service_name['service_name']."(Price - ".$data_service_name['service_price'].")(QTY - $fetch)<br />";
								                 
									
								}
								//echo "<hr>";
								
								echo '</td>';
					
								echo '<td align="center">';
								/* 
								   $select_id="SELECT package_id,quantity FROM sales_package_voucher_memb WHERE  package_id='".$val_querys['packagess_deal_id']."'";
								  $query=mysql_query($select_id);
								 while($fetch=mysql_fetch_array($query))
								{ 
								
								     $select_id1="SELECT package_id,quantity,service_id FROM package_service_map WHERE package_id='".$fetch['package_id']."' ";
								  $query=mysql_query($select_id1);
								  while($fetch_qty=mysql_fetch_array($query))
								  
									   {
									     "<br>". $select_service_name="select package_id,id from sales_package_voucher_memb where cust_id='".$val_querys['customer_id']."' and category='Package' order by id desc LIMIT 1";
									  
									$ptr_service=mysql_query($select_service_name);
									while($data_service_name2=mysql_fetch_array($ptr_service))
									
									   {
										      
										 $select_service_name="select service_name,service_price,service_id from servies where service_id='".$fetch_qty['service_id']."'";
									$ptr_service=mysql_query($select_service_name);
									while($data_service_name=mysql_fetch_array($ptr_service))
										{
										
									 "<br>".$select_service_name1="select package_id,service_id,quantity from sales_customer_service_voucher_map where id='".$data_service_name2['id']."' and package_id='".$data_service_name2['package_id']."'";
									$ptr_service1=mysql_query($select_service_name1);
									    
										 $data_service_name1=mysql_fetch_array($ptr_service1);
										 
									$total=(($fetch['quantity']*$fetch_qty['quantity'])-($fetch_qty['quantity']-$data_service_name1['quantity']));
									
									echo $data_service_name['service_name']."(Price - ".$data_service_name['service_price'].")(QTY - ".$total.")<br />";
										 
										}
										 
									  }
									      
								  }
								} */
								
								 $select_id="SELECT package_id,quantity,service_id FROM sales_customer_service_voucher_map WHERE package_id='".$val_querys['packagess_deal_id']."' ";
								  $query=mysql_query($select_id);
								   while($fetch_qty=mysql_fetch_array($query))
								   {   
													 $select_service_name1="select service_name,service_price,service_id from servies where service_id='".$fetch_qty['service_id']."'";
													$ptr_service=mysql_query($select_service_name1);
													$data_service_name=mysql_fetch_array($ptr_service);
													
													
									  /* $select_id="SELECT package_id,quantity FROM sales_package_voucher_memb WHERE  package_id='".$val_querys['packagess_deal_id']."' and category='Package'";
								  $query=mysql_query($select_id);
										$fetch=mysql_fetch_array($query);
										
										$total_qty=$fetch['quantity']; */
										 
										 
									
						echo $data_service_name['service_name']."(Price - ".$data_service_name['service_price'].")(QTY - ".$fetch_qty['quantity'].")<br />";
										
									}
								
								echo '</td>';
						
								
								echo '<td align="center">'.$val_query['added_date'].'</td>';
								
                                echo '</tr>';
                                                                
                                $bgColorCounter++;
								
                            }
						
                                ?>
  
  
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
