<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Inventory</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='135'";
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
    <!--------------------Auocomplete search------------------------ -->
   <!-- <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />-->
    <!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>  -->  
    <script type="text/javascript">
    $(document).ready(function()
    { 
       $("#vendor_id").chosen({allow_single_deselect:true});
	   $("#branch_name").chosen({allow_single_deselect:true});
    });
    </script>
    <!-------------------------------------------- -->
	<script type="text/javascript">
    $(document).ready(function()
	{            
		$('.datepicker').datepicker({ changeMonth: true,changeYear: true,dateFormat:"dd/mm/yy", showButtonPanel: true, closeText: 'Clear'});
		$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
		}
		
		// $('input:radio[name=free_course][value=N]').click();
		// $('input:radio[name=discount_course][value=Y]').click();
		// $('input:radio[name=status][value=Inactive]').click();
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
	
	function get_vendor(branch_name)
	{
		var bank_data="branch_name="+branch_name;
		$.ajax({
		url: "get_vendor.php",type:"post", data: bank_data,cache: false,
		success: function(retbank)
		{
			//alert(retbank);
			document.getElementById("show_vendor").innerHTML=retbank;
			$("#vendor_id").chosen({allow_single_deselect:true});
		}
		});
	}
	function invoice_approve(ids)
	{
		var inv_data="action=set_inv_status&inv_id="+ids;
		$.ajax({
		url: "set_status.php",type:"post", data: inv_data,cache: false,
		success: function(retbank)
		{
			alert(retbank);
			//document.getElementById("show_vendor").innerHTML=retbank;
			//$("#vendor_id").chosen({allow_single_deselect:true});
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
    <?php       
	if($_POST['formAction'])
	{
		if($_POST['formAction']=="delete")
		{
			for($r=0;$r<count($_POST['chkRecords']);$r++)
			{
				$del_record_id=$_POST['chkRecords'][$r];
				$sql_query= "SELECT quotation_id FROM product_quotation where quotation_id ='".$del_record_id."'";
				if(mysql_num_rows($db->query($sql_query)))
				{
					$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_quotation','Delete','quotation delete','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert);
					
					/*$sel_inv="select * from product_quotation_map where quotation_id='".$del_record_id."'";
					$ptr_inv=mysql_query($sel_inv);
					while($data_inv=mysql_fetch_array($ptr_inv))
					{
						$qty=$data_inv['sin_product_qty'];
						$product_id=$data_inv['product_id'];
				
						$sel_qty="select quantity from product where `product_id`='".$product_id."'";
						$ptr_qty=mysql_query($sel_qty);
						$data_qty=mysql_fetch_array($ptr_qty);
						$total=intval($data_qty['quantity']-$qty);
						
						$sql_query="UPDATE `product` SET `quantity`='".$total."' WHERE `product_id`='".$product_id."'";
						$query=mysql_query($sql_query);
					}*/
						
					$delete_query="delete from product_quotation where quotation_id='".$del_record_id."'";
					$db->query($delete_query);   
					
					$delete_query1="delete from product_quotation_map where quotation_id='".$del_record_id."'";
					$db->query($delete_query1); 
					 
					//$delete_query2="delete from inventory_tax_map where quotation_id='".$del_record_id."'";
					//$db->query($delete_query2);
					 
					$delete_query3="delete from product_quotation_invoice where quotation_id='".$del_record_id."'";
					$db->query($delete_query3);
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
		$sql_query= "SELECT quotation_id FROM product_quotation where quotation_id='".$del_record_id."'";
		if(mysql_num_rows($db->query($sql_query)))
		{  
			$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_quotation','Delete','purchase delete','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
			$query=mysql_query($insert);
			/*	
			$sel_inv="select * from product_quotation_map where quotation_id='".$del_record_id."'";
			$ptr_inv=mysql_query($sel_inv);
			while($data_inv=mysql_fetch_array($ptr_inv))
			{
				$qty=$data_inv['sin_product_qty'];
				$product_id=$data_inv['product_id'];
					
				$sel_qty="select quantity from product where `product_id`='".$product_id."'";
				$ptr_qty=mysql_query($sel_qty);
				$data_qty=mysql_fetch_array($ptr_qty);
				$total=intval($data_qty['quantity']-$qty);
					
				$sql_query="UPDATE `product` SET `quantity`='".$total."' WHERE `product_id`='".$product_id."'";
				$query=mysql_query($sql_query);
			}*/
				
			$delete_query="delete from product_quotation where quotation_id='".$del_record_id."'";
			$db->query($delete_query); 
				
			$delete_query1="delete from product_quotation_map where quotation_id='".$del_record_id."'";
			$db->query($delete_query1);
				
			//$delete_query2="delete from inventory_tax_map where quotation_id='".$del_record_id."'";
			//$db->query($delete_query2);
				
			$delete_query3="delete from product_quotation_invoice where quotation_id='".$del_record_id."'";
			$db->query($delete_query3);
			?>
			<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record deleted successfully</p></center>
            </div>
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
    				<td colspan="16">
        				<form method="get" name="search">
							<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              					<tr>
                                    <td width="20%">
                                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                            <option value="">-Operation-</option>
                                            <option value="delete">Delete</option>
                                            <!--<option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>-->
                                        </select>
                                    </td>
									<?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
                                    {
										?>
										<td width="15%">
											<select name="branch_name" id="branch_name"  class="input_select_login" onchange="get_vendor(this.value)" style="width: 150px; ">
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
                                    <td width="15%" id="show_vendor">
                                        <select name="vendor_id" id="vendor_id"  class="input_select_login"  style="width: 150px;">
                                            <option value="">-Select Vendor-</option>
                                            <?php 
                                                $sel_vendor="select vendor_id,name from vendor where 1 ".$_SESSION['where']." and name!=''";
                                                $ptr_vendor=mysql_query($sel_vendor);
                                                while($data_vendor=mysql_fetch_array($ptr_vendor))
                                                {
                                                    $sel='';
                                                    if($data_vendor['vendor_id']==$_REQUEST['vendor_id'])
                                                    {
                                                        $sel='selected="selected"';
                                                    }
                                                    echo '<option '.$sel.' value="'.$data_vendor['vendor_id'].'" > '.$data_vendor['name'].'</option>';
                                                }		
                                            ?>
                                        </select>
                                    </td>
                                    <td width="10%"><input type="text" name="from_date" class="input_text datepicker" placeholder="From Date"  id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>"></td>
                                    <td width="10%"><input type="text" name="to_date" class="input_text datepicker" placeholder="To Date"  id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>"></td>
                                    
                                    <td width="10%"><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="auto search_box" title="Keyword" /></td>
                                    <td width="40%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                                    <td><a href="purchase_export.php<?php echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a></td>  
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
					$pre_keyword=" and (amount like '%".$keyword."%' || price like '%".$keyword."%' || discount like '%".$keyword."%' || tax like '%".$keyword."%' || total_cost like '%".$keyword."%' || payment_mode like '%".$keyword."%' || payable_amount like '%".$keyword."%' || remaining_amount like '%".$keyword."%')";
					
				}
				else
				{
					$pre_keyword="";
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
						$search_cm_id_s=" and i.cm_id='".$data_cm_id['cm_id']."'";
						
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
					$from_date_i=" and DATE(i.added_date) >='".$from_dates."'";
				}
				if($_REQUEST['to_date']!="")
				{
					$sep=explode("/",$_REQUEST['to_date']);
					$to_dates=$sep[2]."-".$sep[1]."-".$sep[0];
					$to_date=" and DATE(added_date) <='".$to_dates."'";
					$to_date_i=" and DATE(i.added_date) <='".$to_dates."'";
				}
				$where_vendor='';
				$where_vendor_i='';
				if($_REQUEST['vendor_id'])
				{
					$vendor_id=$_REQUEST['vendor_id'];
					$where_vendor=" and vendor_id='".$vendor_id."'";
					$where_vendor_i=" and i.vendor_id='".$vendor_id."'";
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

				if($_GET['orderby']=='quotation_id' )
					$img1 = $img;

				if($_GET['order'] !='' && ($_GET['orderby']=='quotation_id'))
				{
					$select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
					$date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
				}
				else
					$select_directory='order by quotation_id desc';  
				if($_GET['record_id'] !='')
				{
					$record_cat_id="and quotation_id='".$_GET['record_id']."' ";
				}	
				if($pre_keyword=='')
				{                    
				  $sql_query= "SELECT * FROM  product_quotation where 1 ".$record_cat_id." ".$_SESSION['where']." ".$where_vendor." ".$search_cm_id." ".$from_date." ".$to_date." ".$pre_keyword." ".$select_directory."";//".$_SESSION['user_id']." 25-12-17
				}
				else
				{
					$cm_ids=='';
					$admin_ids='';
					if($_SESSION['where'] !='')
					{
						$cm_ids=" and i.cm_id='".$_SESSION['cm_id']."'";
					}
					if($_SESSION['user_id'] !='')
					{
						$admin_ids=" and i.admin_id='".$_SESSION['admin_id']."'";
					}
				   $sql_query= "SELECT distinct(i.quotation_id) as quotation_id FROM  product_quotation i, vendor v, product_quotation_map im, product p where 1  and (v.name like '%".$keyword."%' or p.product_name like '%".$keyword."%') and i.vendor_id=v.vendor_id and im.quotation_id=i.quotation_id and im.product_id=p.product_id".$cm_ids." ".$where_vendor_i." ".$from_date_i." ".$to_date_i." ".$search_cm_id_s." order by i.quotation_id desc"; //".$admin_ids."  25-12-17
				}
				$no_of_records=mysql_num_rows($db->query($sql_query));
				if($no_of_records)
				{
					$bgColorCounter=1;
					//$_SESSION['show_records'] = 10;
					$query_string='&keyword='.$keyword.'&from_date='.$_REQUEST['from_date'].'&to_date='.$_REQUEST['to_date'].'&vendor_id='.$_REQUEST['vendor_id'];
					$query_string1=$query_string.$date_query;
					//$pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
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
							<td width="2%" align="center">
                            <input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')">
                            </td>
							<?php
						}
						?>
						<td width="3%" align="center"><strong>Sr. No.</strong></td>
                        <td width="7%" align="center"><strong>Branch</strong></td>
						<td width="10%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=vendor".$query_string;?>"class="table_font"><strong>Vender</strong></a><?php echo $img1;?></td>
						<td width="20%" align="center"><strong>Products</strong></td>
						<td width="5%" align="center"><strong>MRP</strong></td>
						<td width="5%" align="center"><strong>Discount</strong></td>
						<td width="5%" align="center"><strong>Total Cost</strong></td>
						<!--<td width="5%" align="center"><strong>Amount</strong></td>
						<td width="5%" align="center"><strong>Total Paid Amount</strong></td>
						<td width="5%" align="center"><strong>Remaining Amount</strong></td>-->
						
						<!--<td width="5%" align="center"><strong>Payment Mode</strong></td>					    	
						<td width="5%" align="center"><strong>View Payment</strong></td>-->
												
						<td width="8%" align="center"><strong>Owned By</strong></td>
                        <td width="8%" align="center"><strong>Send to Order</strong></td>
						<?php
						if($_SESSION['type']=='AC' || $_SESSION['type']=='S' || $_SESSION['type']=='Z')
						{
							?>
							<td width="5%" align="center"><strong>Invoice Approve</strong></td>
							<?php
						}
						?>
						<td width="8%" align="center"><strong>Added Date</strong></td>
						<td width="5%" class="centerAlign"><strong>Action</strong></td> 
					</tr>
					<style>
                        hr.style4 
                        { 
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
                        $sql_inventoery="select * from product_quotation where quotation_id='".$val_querys['quotation_id']."' ";
                        $ptr_inventory=mysql_query($sql_inventoery);
                        $val_query=mysql_fetch_array($ptr_inventory);
                        
                        if($bgColorCounter%2==0)
                            $bgcolor='class="grey_td"';
                        else
                            $bgcolor="";                
                        
                        $listed_record_id=$val_query['quotation_id']; 
                       
                        include "include/paging_script.php";
                          
                        if($_SESSION['type'] =='S' || $edit_access=='yes')
                        {	
                            echo '<tr '.$bgcolor.' >
                            <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
                        }
                        echo '<td align="center">'.$sr_no.'</td>'; 
                        $sql_branch="select branch_name, cm_id from site_setting where cm_id='".$val_query['cm_id']."' ";
                        $ptr_branch=mysql_query($sql_branch);
                        $data_branch=mysql_fetch_array($ptr_branch);
                        echo '<td align="center">'.$data_branch['branch_name'].'</td>';
						
                        $sql_vendor="select name, vendor_id from vendor where vendor_id='".$val_query['vendor_id']."' ";
                        $ptr_vendor=mysql_query($sql_vendor);
                        $data_vendor=mysql_fetch_array($ptr_vendor);
                        echo '<td >'.$data_vendor['name'].'</td>';
						
                        echo '<td align="center">';
                        $sel_product="select quotation_id,product_id,sin_product_qty from product_quotation_map where quotation_id ='".$val_query['quotation_id']."'";
                        $ptr_product=mysql_query($sel_product);
                        $k=1;
                        $count=mysql_num_rows($ptr_product);
                        while($data_product=mysql_fetch_array($ptr_product))
                        {
                            $select_service_name="select product_name,price,admin_id from product where product_id='".$data_product['product_id']."'";
                            $ptr_service=mysql_query($select_service_name);
                            $data_service_name=mysql_fetch_array($ptr_service);
                            
                            $name='';
                            if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
                            {
                                $sel_emp="select name from site_setting where admin_id='".$data_service_name['admin_id']."'";
                                $ptr_admin_id=mysql_query($sel_emp);
                                $data_name=mysql_fetch_array($ptr_admin_id);
                                $name= "(".$data_name['name'].")";
                            }
                            $prod_name=$data_service_name['product_name'];
                            if($keyword)
                            {
                                $prod_name= str_ireplace($keyword,'<span style="color: blue; font-size:12px"><strong>'.$keyword.'</strong></span>', $prod_name);
                            }
                            echo $prod_name."&nbsp;&nbsp;&nbsp;".$name."<br />";
                            
                            if($k !=$count)
                            {
                                echo '<hr class="style4">';
                            }
                            $k++;
                        }
                        
                        echo '</td>';
                        echo '<td align="center">'.$val_query['price'].'</td>';
                        echo '<td align="center">'.$val_query['discount'].'</td>';						
                        echo '<td align="center">'.$val_query['total_cost'].'</td>';
                        //echo '<td align="center">'.$val_query['amount1'].'</td>';
                    
                        /*$tot_paid_amount="SELECT SUM( payable_amount ) as payable_amount FROM `product_quotation_invoice` WHERE quotation_id=".$listed_record_id."";
                        $query_sum=mysql_query($tot_paid_amount);
                        $fetch_sum=mysql_fetch_array($query_sum);
                        echo '<td align="center">'.$fetch_sum['payable_amount'].'</td>';
                        echo '<td align="center">'.$val_query['remaining_amount'].'</td>';*/
                                                
                        $sql_payment_mode="select payment_mode, payment_mode_id from payment_mode where payment_mode_id='".$val_query['payment_mode_id']."' ";
                        $ptr_payment_mode=mysql_query($sql_payment_mode);
                        $data_payment=mysql_fetch_array($ptr_payment_mode);
                                                
                        //echo '<td align="center">'.$data_payment['payment_mode'].'</td>';
                        //if( $_SESSION['type'] =='S')
                        //	{	
                        
                        //echo '<td><center><a href="quoation_payment_details.php?record_id='.$listed_record_id.'">
                        //<img src="images/view_bill.jpg" border="0" width="30px" height="30px" title="View Payment"></a></center></td>';
                        //	}
                        $sel_emp="select name from site_setting where admin_id='".$val_query['admin_id']."'";
                        $ptr_admin_id=mysql_query($sel_emp);
                        $data_name=mysql_fetch_array($ptr_admin_id);
                        
                        $name= $data_name['name'];
                        echo '<td align="center">'.$name.'</td>';
						echo '<td align="center">Send to Order</td>';
                        if($_SESSION['type']=='AC' || $_SESSION['type']=='S' || $_SESSION['type']=='Z')
                        {
                            if($val_query['invoice_status'] !='' && file_exists("vendor_invoice/".$val_query['ref_invoice']))
                            {
                            	echo '<td width="5%" align="center"><strong><a href="vendor_invoice/'.$val_query['ref_invoice'].'" download><img src="images/download.png" width="20" height="20" ></a><br/><button name="approve" onclick="invoice_approve('.$listed_record_id.')" style="margin-top:5px">Approve</button></strong></td>';
                            }
                            else
                            {
                                echo '<td></td>';
                            }
                        }
                        echo '<td align="center">'.$val_query['added_date'].'</td>';				
                        echo '<td align="center">';
                        if($_SESSION['type'] =='S' || $edit_access=='yes')
                        {
                            echo '<a href="add_quotation.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp';
                        }
                        echo '&nbsp;&nbsp; <a href="" onClick="window.open(\'invoice_quotation.php?record_id='.$listed_record_id.'\', \'win1\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900,height=600,directories=no,location=no\'); return false;"><img src="images/invoice.png" title="View Invoice" class="example-fade"/></a>';
                        if($_SESSION['type'] =='S' || $edit_access=='yes')
                        {
                            echo' &nbsp;&nbsp; <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
                        }
                        echo '</td>';
                        echo '</tr>';                      
                        $bgColorCounter++;
                    }    
                    ?>
  
  
	<tr class="head_td">
		<td colspan="16">
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