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
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='137'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}

?>
	 <script type="text/javascript" src="../js/common.js"></script>
     <!-- Multiselect -->
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>
    <link rel="stylesheet" href="js/chosen.css" />	
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
	<script type="text/javascript">
    $(document).ready(function()
	{            
		$('.datepicker').datepicker({ changeMonth: true,changeYear: true,dateFormat:"dd/mm/yy", showButtonPanel: true, closeText: 'Clear'});
		$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
		}
	   	$("#branch_name").chosen({allow_single_deselect:true});	
		//$('input:radio[name=free_course][value=N]').click();
		//$('input:radio[name=discount_course][value=Y]').click();
		//$('input:radio[name=status][value=Inactive]').click();
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
		function validationToConvert(type)
        {
            if(confirm("Are you sure, you want to Convert selected record(s) in Inventory ?"))
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
<?php
$sep_url_string='';
$sep_url= explode("?",$_SERVER['REQUEST_URI']);
if($sep_url[1] !='')
{
$sep_url_string="?".$sep_url[1];
}
?>   
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
									"<br/>".$sel_prod_id="select product_id,product_qty from sales_product_map where sales_product_id='".$del_record_id."'";
									$ptr_prod_id=mysql_query($sel_prod_id);
									while($data_prod=mysql_fetch_array($ptr_prod_id))
									{
										"<br/>".$update_prod="update product set quantity=quantity+".$data_prod['product_qty']." where product_id='".$data_prod['product_id']."' ";
										$pre_prod=mysql_query($update_prod);
									}
									
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_sales_product','Delete','sale product','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);
						
									$delete_query_sale="delete from sales_product where sales_product_id='".$del_record_id."'";
									$db->query($delete_query_sale); 
									
									$delete_query_inv="delete from sales_product_invoice where sales_product_id='".$del_record_id."'";
									$db->query($delete_query_inv); 
									
									$delete_query_map="delete from sales_product_map where sales_product_id='".$del_record_id."'";
									$db->query($delete_query_map);   
									
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
							
							"<br/>".$sel_prod_id="select product_id,product_qty from sales_product_map where sales_product_id='".$del_record_id."'";
							$ptr_prod_id=mysql_query($sel_prod_id);
							while($data_prod=mysql_fetch_array($ptr_prod_id))
							{
								"<br/>".$update_prod="update product set quantity=quantity+".$data_prod['product_qty']." where product_id='".$data_prod['product_id']."' ";
								$pre_prod=mysql_query($update_prod);
							}  
							
							"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_sales_product','Delete','sale product','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert);
										
                            $delete_query_sale="delete from sales_product where sales_product_id='".$del_record_id."'";
                            $db->query($delete_query_sale); 
							
							$delete_query_inv="delete from sales_product_invoice where sales_product_id='".$del_record_id."'";
							$db->query($delete_query_inv); 
									
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
                
                <td width="20%">
					<select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
							<option value="">-Operation-</option>
							<option value="delete">Delete</option>
<!--                                <option value="Active">Active</option>
							<option value="Inactive">Inactive</option>-->
					</select>
				</td>
				<?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
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
				<td width="10%"><input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>"></td>
				<td width="10%"><input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>"></td>
				<td width="15%"><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
				<td width="40%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
				<td><a href="sale_export.php<?php echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a></td>  
                <!--<td class="rightAlign" > 
                    <table border="0" cellspacing="0" cellpadding="0" align="right">
              <tr>
              <td></td>
              <td class="width5"></td>
                
                <td class="width2"></td>
                <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
              </tr>
                    </table>	
                </td>-->
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
                            $pre_keyword=" and (sales_product_id like '%".$keyword."%' || total_price like '%".$keyword."%' || payable_amount like '%".$keyword."%' || remaining_amount like '%".$keyword."%' || product_price like '%".$keyword."%' )";
							 $pre_keyword_sp=" and (c.cust_name like '%".$keyword."%' or p.product_name like '%".$keyword."%' or sp.sales_product_id like '%".$keyword."%' or sp.total_price like '%".$keyword."%' or sp.payable_amount like '%".$keyword."%' or sp.remaining_amount like '%".$keyword."%' or sp.product_price like '%".$keyword."%' )";
						}
					    else
						{
                            $pre_keyword="";
							$pre_keyword_sp="";
						}
						
						$search_cm_id='';
						if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
						{
							if($_REQUEST['branch_name']!='')
							{
								$branch_name=$_REQUEST['branch_name'];
								$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_cm_id=mysql_query($select_cm_id);
								$data_cm_id=mysql_fetch_array($ptr_cm_id);
								$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
								$search_cm_id_s=" and sp.cm_id='".$data_cm_id['cm_id']."'";
								
							}
							else
							{
								$search_cm_id='';
								$search_cm_id_s='';
							}
						}
						$from_date='';
						$to_date='';
						$from_date_sp='';
						$to_date_sp='';
						if($_REQUEST['from_date']!="")
						{
							$sep=explode("/",$_REQUEST['from_date']);
							$from_dates=$sep[2]."-".$sep[1]."-".$sep[0];
							$from_date=" and DATE(added_date) >='".$from_dates."'";
                          	$from_date_sp=" and DATE(sp.added_date) >='".$from_dates."'";
						}
						if($_REQUEST['to_date']!="")
						{
							$sep=explode("/",$_REQUEST['to_date']);
							$to_dates=$sep[2]."-".$sep[1]."-".$sep[0];
                            $to_date=" and DATE(added_date) <='".$to_dates."'";
							$to_date_sp=" and DATE(sp.added_date) <='".$to_dates."'";
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

                        if($_GET['orderby']=='sales_product_id' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='sales_product_id'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                        	$select_directory='order by sales_product_id desc';  
						if($_GET['record_id'] !='')
						{
							$record_cat_id="and sales_product_id='".$_GET['record_id']."' ";
						}
						if($pre_keyword=='')
						{                  
                          	$sql_query= "SELECT * FROM sales_product where 1 ".$record_cat_id." ".$_SESSION['where']."  ".$search_cm_id." ".$from_date." ".$to_date." ".$pre_keyword." ".$select_directory.""; //".$_SESSION['user_id']." on 13/6/18
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
							
							$sql_query= "SELECT distinct(sp.sales_product_id) as sales_product_id FROM sales_product sp, customer c,product p ,sales_product_map sm where 1 and sp.customer_id=c.cust_id and sm.sales_product_id=sp.sales_product_id and sm.product_id=p.product_id ".$cm_ids."  ".$from_date_sp." ".$to_date_sp." ".$search_cm_id_s." ".$pre_keyword_sp." order by sp.sales_product_id desc "; //".$admin_ids." on 13/6/18
							//(sp.total_price like '%".$keyword."%' or sp.discount like '%".$keyword."%' or sp.product_price like '%".$keyword."%' or sp.tot_price_withou_tax like '%".$keyword."%' or sp.payable_amount like '%".$keyword."%' or sp.remaining_amount like '%".$keyword."%' or s.branch_name like '%".$keyword."%' or pm.payment_mode like '%".$keyword."%') and (sp.payment_mode_id=pm.payment_mode_id and sp.cm_id=s.cm_id and sp.payment_mode_id=pm.payment_mode_id  ) , payment_mode pm, site_setting s,
						}
                       
                        $no_of_records=mysql_num_rows($db->query($sql_query));
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword.'&branch_name='.$_REQUEST['branch_name'].'&from_date='.$_REQUEST['from_date'].'&to_date='.$_REQUEST['to_date'];
                            $query_string1=$query_string.$date_query;
                            // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
					<form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                    <input type="hidden" name="formAction" id="formAction" value=""/>
                    <tr class="grey_td" >
					 	<?php
						if( $_SESSION['type'] =='S' || $edit_access=='yes')
						{	
						?>
                        	<td width="1%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
						<? 
						}
						?>
                        <td width="1%" align="center"><strong>Sr. No.</strong></td>
                        <td width="4%" align="center"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=vendor".$query_string;?>" class="table_font"><strong>Branch</strong></a> <?php echo $img1;?></td>
                        
                        <td width="6%" align="center"><strong>Customer Name</strong></td>
                        
                        <td width="15%" align="center"><strong>Product</strong></td>
                        
                        <td width="2%" align="center"><strong>Total Product Price</strong></td>
                        
                        <td width="1%" align="center"><strong>Discount</strong></td>
                       
                        <td width="3%" align="center"><strong>Total Discounted Price</strong></td>
                        
                        <td width="3%" align="center"><strong> Total Paid Amount</strong></td>
                        
                        <td width="3%" align="center"><strong>Remaining Amount</strong></td>
                         
                        <td width="2%" align="center"><strong>Payment Mode</strong></td>
                        
                        <td width="2%" align="center"><strong>View Payment</strong></td>
                      
                        <td width="2%" align="center"><strong>Added Date</strong></td>
						    	
                        <td width="3%" class="centerAlign"><strong>Action</strong></td>
						 
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
                                if($_SESSION['type'] =='S' || $edit_access=='yes')
								{
                                	echo '<tr '.$bgcolor.' >
                                	<td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
								}
                                echo '<td align="center">'.$sr_no.'</td>'; 
								      
							    $sql_branch = " select branch_name, cm_id from site_setting where cm_id='".$val_query['cm_id']."' ";
								$ptr_branch = mysql_query($sql_branch);
								$data_branch = mysql_fetch_array($ptr_branch);
									  
                                echo '<td align="center">'.$data_branch['branch_name'].'</td>';
								if($val_query['type']=='Customer')
								{
									$sql_product = " select cust_name, cust_id from customer where cust_id='".$val_query['customer_id']."' ";
									$ptr_product = mysql_query($sql_product);
									$data_product = mysql_fetch_array($ptr_product);
									$name=$data_product['cust_name'];
								}
								else
								if($val_query['type']=='Employee')
								{
									$sql_product = " select name, admin_id from site_setting where admin_id='".$val_query['customer_id']."' ";
									$ptr_product = mysql_query($sql_product);
									$data_product = mysql_fetch_array($ptr_product);
									$name=$data_product['name'];
								}
								else
								{
									$sql_product = " select name from enrollment where enroll_id='".$val_query['customer_id']."' ";
									$ptr_product = mysql_query($sql_product);
									$data_product = mysql_fetch_array($ptr_product);
									$name=$data_product['name'];
								}
								$cust_name=$name;
								if($keyword)
								{
									$cust_name= str_ireplace($keyword, '<span style="color: blue; font-size:12px"><strong>'.$keyword.'</strong></span>', $name);
								}
								echo '<td align="center">'.$cust_name.'</td>';	
															
								echo '<td align="center">';
								$sel_product="select sales_product_id,product_id,product_qty from sales_product_map where sales_product_id ='".$val_query['sales_product_id']."'";
								$ptr_product=mysql_query($sel_product);
								$k=1;
								$count=mysql_num_rows($ptr_product);
								while($data_product=mysql_fetch_array($ptr_product))
								{
									$select_service_name="select product_name,price,admin_id from product where product_id='".$data_product['product_id']."'";
									$ptr_service=mysql_query($select_service_name);
									$data_service_name=mysql_fetch_array($ptr_service);
									$owner_name='';
									if($_SESSION['type'] =='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
									{
										$sel_emp="select name from site_setting where admin_id='".$data_service_name['admin_id']."'";
										$ptr_admin_id=mysql_query($sel_emp);
										$data_name=mysql_fetch_array($ptr_admin_id);
										$owner_name= "(".$data_name['name'].")";
									}
									$prod_name=$data_service_name['product_name'];
									if($keyword)
									{
										$prod_name= str_ireplace($keyword, '<span style="color: blue; font-size:12px"><strong>'.$keyword.'</strong></span>', $prod_name);
									}
									echo $prod_name."(Price - ".$data_service_name['price'].")(Qty - ".$data_product['product_qty'].") &nbsp;&nbsp;&nbsp;".$owner_name."<br />";
									
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
								//if( $_SESSION['type'] =='S')
								//{
								echo '<td><center><a href="sales_prod_payment_details.php?record_id='.$listed_record_id.'">
								<img src="images/view_bill.jpg" border="0" width="30px" height="30px" title="View Payment"></a></center></td>';
								//}
                                echo '<td align="center">'.$val_query['added_date'].'</td>';
								echo '<td align="center">';								
								//echo '<a target="_blank" href="pcmc.php?id='.$listed_record_id.'">Convert</a>';
								//echo '<a onclick="return validationToConvert(\''.$_SERVER['PHP_SELF'].'\');" href="pcmc.php?id='.$listed_record_id.'">Convert</a>&nbsp;&nbsp;';
								if($_SESSION['type'] =='S' || $edit_access=='yes')
								{
									echo '<a href="sales_product_edit.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp';
								}
								echo '<a href="" onClick="window.open(\'invoice_sales_product.php?record_id='.$listed_record_id.'\', \'win1\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900,height=600,directories=no,location=no\'); return false;" ><img src="images/invoice.png" title="View Invoice" class="example-fade"/></a>&nbsp;&nbsp;';
								if( $_SESSION['type'] =='S' || $edit_access=='yes')
								{
                                	echo '<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
								}
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
