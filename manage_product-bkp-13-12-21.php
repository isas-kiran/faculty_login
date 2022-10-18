<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Product</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='131'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}

?>
<link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
<link rel="stylesheet" href="js/chosen.css" />
<script src="js/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
var pageName = "manage_product";
$(document).ready(function()
{   <?php
	if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' ) {?>
	$("#branch_name").chosen({allow_single_deselect:true});
	<?php
	}
	?>
	$("#stockiest").chosen({allow_single_deselect:true});
	$("#status_type").chosen({allow_single_deselect:true});
	$("#customer_id").chosen({allow_single_deselect:true});
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
	else if(action=="change_owner")
	{
		$( ".new_custom_course" ).dialog({
			width: '500',
			height:'150'
		});
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
function select_stockiest(branch_name)
{
	var data1="action=stockiest&branch_name="+branch_name;	
	//alert(data1);
	$.ajax({
	url: "get_stockiest.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		if(html !='')
		{
			//alert(html);
			document.getElementById("stockiest_id").innerHTML=html;
			$("#stockiest").chosen({allow_single_deselect:true});
		}
	}
	});
	
	
	var id='Vendor';
	var branch_name= branch_name;
	var data1="action=show_data&action_page=sales_product&id="+id+'&branch_name='+branch_name;
	$.ajax({
	url: "ajax_customer_type_data.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		$('#show_type').html(html);
		// document.getElementById('show_type').value=html;
		//$("#realtxt").chosen({allow_single_deselect:true});
		$("#customer_id").chosen({allow_single_deselect:true});
		
	}
	});
	
	
}
function set_status(values,ids)
{
	var data1="action=set_prod_status&status="+values+"&prod_id="+ids;	
	//alert(data1);
	$.ajax({
		url: "get_assigned.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
		}
	});
}
function set_brand(values,ids)
{
	var data1="action=set_prod_brand&status="+values+"&prod_id="+ids;	
	//alert(data1);
	$.ajax({
		url: "get_assigned.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
		}
	});
}

function change_qty(id,values)
{
	var data1="action=set_quantity&id="+id+"&values="+values;	
	//alert(data1);
	$.ajax({
		url: "set_quantity.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
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
                                $sql_query= "SELECT product_id,product_name FROM product where product_id ='".$del_record_id."'";
                                $ptr_query=mysql_query($sql_query);
								if(mysql_num_rows($ptr_query))
								{    
									$cust_data=mysql_fetch_array($ptr_query);  
									
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_product_category','Delete','".$cust_data['product_name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);                                                   
									$delete_query="delete from product where product_id='".$del_record_id."'";
									$db->query($delete_query);  
									
									$delete_query1="delete from product_image where product_id='".$del_record_id."'";
									$db->query($delete_query1);  
									
									$delete_query12="delete from product_vendor_map where product_id='".$del_record_id."'";
									$db->query($delete_query12);                                                                                       
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
						  else if($_POST['formAction']=="change_owner")
							{
								if($_POST['councillior_admin_id']!="")
								{
									$total_count=count($_POST['chkRecords']);
									for($r=0;$r<count($_POST['chkRecords']);$r++)
									{
										$sel_product_id=$_POST['chkRecords'][$r];
										$vendor_id=$_POST['councillior_admin_id'];
										$sql_query= "SELECT map_id FROM product_vendor_map where product_id ='".$sel_product_id."' and vendor_id='".$vendor_id."' ";
										$my_query=mysql_query($sql_query);
										if(!mysql_num_rows($my_query))
										{                 
											$update_query="insert into product_vendor_map (`product_id`,`vendor_id`) values ('".$sel_product_id."','".$vendor_id."')";
											$query=mysql_query($update_query);    
										}
									 }
									 ?>
									<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record(s) owner transfer successfully</p></center></div>
									<script type="text/javascript">
									// $("#statusChangesDiv").dialog();
										$(document).ready(function() {
											$( "#statusChangesDiv" ).dialog({
													modal: true,
													buttons: {
																Ok: function() { $( this ).dialog( "close" );}
															 }
											});
										});
										setTimeout('document.location.href="manage_product.php";',2000);
									</script>
									<?php 
								}
								else
								{
									?>
									<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Error : Councillor Not Selected</p></center></div>
									<?php
								}
							}
						  
                    }
					
                    if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
                    {
                        $del_record_id=$_REQUEST['record_id'];
                        $sql_query= "SELECT product_id,product_name FROM product where product_id='".$del_record_id."'";
                        $ptr_query=mysql_query($sql_query);
						if(mysql_num_rows($ptr_query))
						{    
							$cust_data=mysql_fetch_array($ptr_query);  
							
							"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_product_category','Delete','".$cust_data['product_name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert);                          
                            $delete_query="delete from product where product_id='".$del_record_id."'";
                            $db->query($delete_query);
							
							 $delete_query1="delete from product_image where product_id='".$del_record_id."'";
                            $db->query($delete_query1); 
							
							 $delete_query12="delete from product_vendor_map where product_id='".$del_record_id."'";
                            $db->query($delete_query12);        
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
    
<?php
$sep_url_string='';
$sep_url= explode("?",$_SERVER['REQUEST_URI']);
if($sep_url[1] !='')
{
$sep_url_string="?".$sep_url[1];
}
?>   
  <tr class="head_td">
    <td colspan="21">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                <td width="20%">
                <?php
				if( $_SESSION['type'] =='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
				{	
					?>
                    <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                        <option value="">-Operation-</option>
                        <option value="delete">Delete</option>
                        <option value="change_owner">Change Vendor</option>
                        <!--<option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>-->
                    </select>
                	</td>
                	<?php
				}
				?>
				<?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
				{
				?>
                <td width="15%">
                    <select name="branch_name" id="branch_name" onchange="select_stockiest(this.value)" class="input_select_login"  style="width: 150px; ">
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
                <? } ?>
				<td id="stockiest_id" width="16%">
				<?php
				if($_REQUEST['branch_name'] !='' || $_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'   )
				{
					if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
					{
						$branch_name=$_REQUEST['branch_name'];
					}
					else
						$branch_name=$_SESSION['branch_name'];
					echo'<select name="stockiest" id="stockiest" class="input_select_login"  style="width: 150px; ">
							<option value="">-Select Stockiest-</option>';
					$sel_stockiest="select * from site_setting where branch_name='".$branch_name."' and type='ST' and system_status='Enabled'";
					$ptr_stockiest=mysql_query($sel_stockiest);
					while($data_stockist=mysql_fetch_array($ptr_stockiest))
					{
						$sel='';
						if($data_stockist['admin_id']==$_GET['stockiest'])
						{
							$sel='selected="selected"';
						}
						echo '<option '.$sel.' value="'.$data_stockist['admin_id'].'" > '.$data_stockist['name'].'</option>';
					}
					echo '</select>';
				}
				else
				{
					echo'<select name="stockiest" id="stockiest" class="input_select_login"  style="width: 150px; ">
					<option value="">-Select Stockiest-</option>';
					$sel_stockiest="select * from site_setting where 1 and type='ST' and system_status='Enabled' ".$_SESSION['where']." ";
					$ptr_stockiest=mysql_query($sel_stockiest);
					while($data_stockist=mysql_fetch_array($ptr_stockiest))
					{
						$sel='';
						if($data_stockist['admin_id']==$_GET['stockiest'])
						{
							$sel='selected="selected"';
						}
						echo '<option '.$sel.' value="'.$data_stockist['admin_id'].'" > '.$data_stockist['name'].'</option>';
					}
					echo '</select>';
				}
				?>
				</td>
                <td width="15%">
					<div id="show_type">
                        <table style="width:100%;">
                            <tr>
                                <td width="70%" id="sel_cust" class="customized_select_box">
                                <select name="customer_id" id="customer_id" style="width:200px;" onChange="show_mobile_no(this.value,'<?php echo $_POST['id']; ?>')" >
                                <option value="">Select Vendor</option> 
                                <?php  
                                $sql_cust = "select contact,vendor_id,name from vendor where 1 ".$user_cm." and cm_id!='' order by vendor_id asc";
                                $ptr_cust = mysql_query($sql_cust);
                                while($data_cust = mysql_fetch_array($ptr_cust))
                                { 
									$selecteds="";
                                    if($data_cust['vendor_id']==$_REQUEST['customer_id'])
                                    {
                                        $selecteds='selected="selected"';
                                    }
                                    echo "<option value='".$data_cust['vendor_id']."' ".$selecteds.">".$data_cust['name']."</option>";
                                }
                                ?>
                                </select>
                                <td width="10%"><input type="hidden" name="mail" id="mail" value=""  /></td>
                            </tr>
                        </table>
					</div>
				</td>
                <td width="12%">
                    <select name="status_type" id="status_type" class="input_select_login"  style="width: 150px;">
                    <option value="">-Select Status-</option>
						<option value="Active" <?php if($_REQUEST['status_type']=='Active') echo 'selected="selected"'; else if($_REQUEST['status_type']=='') echo 'selected="selected"'; ?> >Active</option>
                        <option value="Inactive" <?php if($_REQUEST['status_type']=='Inactive') echo 'selected="selected"';?>>Inactive</option>
                    </select>
                </td>
                <!--<td width="15%">
					<select name="vendor_id" id="vendor_id"  class="input_select_login"  style="width: 150px; ">
						<option value="">-Select Vendor-</option>
						<?php 
							/*$sel_vendor="select vendor_id,name from vendor where 1 ".$_SESSION['where']." and name!=''";
							$ptr_vendor=mysql_query($sel_vendor);
							while($data_vendor=mysql_fetch_array($ptr_vendor))
							{
								$sel='';
								if($data_vendor['vendor_id']==$_REQUEST['vendor_id'])
								{
									$sel='selected="selected"';
								}
								echo '<option '.$sel.' value="'.$data_vendor['vendor_id'].'" > '.$data_vendor['name'].'</option>';
							}	*/	
						?>
					</select>
				</td>-->
				<td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>               
				<td> <a href="product_export.php<?php echo $sep_url_string; ?>"><img src="images/excel.png" height="20px" width="20px"/></a></td>  
                <td class="rightAlign" > 
                <table border="0" cellspacing="0" cellpadding="0" align="right">
              <tr>
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
                            $pre_keyword=" and (product_name like '%".$keyword."%' || product_code like '%".$keyword."%' || description like '%".$keyword."%' || amount like '%".$keyword."%' || commission like '%".$keyword."%' || price like '%".$keyword."%' || vender like '%".$keyword."%' || type like '%".$keyword."%')";
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
						if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
						{
							if($_REQUEST['branch_name']!='')
							{
								$branch_name=$_REQUEST['branch_name'];
								$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_cm_id=mysql_query($select_cm_id);
								$data_cm_id=mysql_fetch_array($ptr_cm_id);
								$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
								$search_cm_id_S=" and p.cm_id='".$data_cm_id['cm_id']."'";
							}
							else
							{
								$branch_name='';
								$search_cm_id_S='';
							}
							if($_REQUEST['stockiest'] !='')
							{
								$st_admin_id=$_REQUEST['stockiest'];
								$search_admin_id=" and admin_id='".$st_admin_id."'";
								$search_admin_id_S=" and p.admin_id='".$st_admin_id."'";
							}
							else
							{
								$st_admin_id='';
								$search_admin_id_S='';
							}
						}
						else
						{
							$search_cm_id_S='';
							$search_admin_id_S='';
						}

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

                        if($_GET['orderby']=='product_name' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='product_name'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
							$select_directory='order by product_id desc';  
										
						$record_cat_id='';
						if($_GET['record_id'] !='')
						{
							$record_cat_id="and product_id='".$_GET['record_id']."' ";
						}
						$where_vend_id='';
						if($_REQUEST['customer_id'])
						{
							$where_vend_id=" and p.vender='".$_REQUEST['customer_id']."'";
						}
						/*$vendor_ids='';
						if($_GET['vendor_id'] !='')
						{
							$vendor_ids=" and pvm.vendor_id='".$_GET['vendor_id']."' ";
						}*/
						
						$user_id=$_SESSION['user_id'];
						if($_SESSION['type']=="A")
						{
							$user_id='';
						} 
						/*if($pre_keyword=='') 
						{         
							
							$sql_query= "SELECT * FROM product where 1 ".$record_cat_id." ".$_SESSION['where']."  ".$search_cm_id." ".$search_admin_id." ".$select_directory.""; //".$user_id." on 13/6/18
						}
						else
						{*/
							$cm_ids=='';
							$admin_ids='';
							
							$user_id=$_SESSION['user_id'];
							if($_SESSION['type']=="A")
							{
								$user_id='';
							} 
							
							if($_SESSION['where'] !='')
							{
								$cm_ids="and p.cm_id='".$_SESSION['cm_id']."'";
							}
							if($user_id !='')
							{
								$admin_ids="and p.admin_id='".$_SESSION['admin_id']."'";
							}
							
							$status_type="and p.status='Active'";
							if($_REQUEST['status_type'])
							{
								
								$status_type="and (p.status='".$_REQUEST['status_type']."'";
								if($_REQUEST['status_type']=='Inactive')
								{
									$status_type .=" or p.status is NULL )";
								}
								else
									$status_type .=")";
							}
							
							/*echo $sql_query="select p.* from product p, product_category pc, subcategory sub, vendor v where 1  and (p.product_name like '%".$keyword."%' or p.product_code like '%".$keyword."%' or p.description like '%".$keyword."%' or p.size like '%".$keyword."%' or p.commission like '%".$keyword."%' or p.price like '%".$keyword."%' or pc.pcategory_name like '%".$keyword."%' or sub.sub_name like '%".$keyword."%' or v.name like '%".$keyword."%') and p.pcategory_id=pc.pcategory_id and p.sub_id=sub.sub_id and p.vender=v.vendor_id ";*/
							
							$sql_query= "SELECT p.product_name, p.product_code,p.status, p.description, p.size,p.unit, p.commission, p.price, p.pcategory_id, p.sub_id, p.product_id,p.quantity,p.quantity_in_shelf,p.quantity_in_consumable,p.added_date,p.admin_id,p.hsn_code,p.brand FROM product p, product_category pc, product_subcategory sub where 1  and (p.product_name like '%".$keyword."%' or p.product_code like '%".$keyword."%' or p.description like '%".$keyword."%' or p.size like '%".$keyword."%' or p.commission like '%".$keyword."%' or p.price like '%".$keyword."%' or pc.pcategory_name like '%".$keyword."%' or sub.sub_name like '%".$keyword."%' ) ".$status_type." and p.pcategory_id=pc.pcategory_id and p.sub_id=sub.sub_id ".$cm_ids."  ".$search_cm_id_S." ".$search_admin_id_S." ".$where_vend_id." ".$select_directory.""; //".$admin_ids."
						//}
                       //echo $sql_query;
                        $no_of_records=mysql_num_rows($db->query($sql_query));
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword.'&branch_name='.$_REQUEST['branch_name'].'&stockiest='.$_REQUEST['stockiest'].'&vendor_id='.$_REQUEST['vendor_id']."&status_type=".$_REQUEST['status_type'];
                            $query_string1=$query_string.$date_query;
                           // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
    				<form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                     <input type="hidden" name="formAction" id="formAction" value=""/>
                     <input type="hidden" name="councillior_admin_id" id="councillior_admin_id" value=""  />
                      <tr class="grey_td" >
					   
                        <td width="3%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
                        <td width="3%" align="center"><strong>Sr. No.</strong></td>
                        <td width="20%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=product_name".$query_string;?>" class="table_font"><strong>Product Name</strong></a> <?php echo $img1;?></td>
                        <td width="7%" align="center"><strong>Product Code</strong></td>
						<!--<td width="5%" align="center"><strong>HSN Code</strong></td>-->
                        <td width="8%" align="center"><strong>Product Category</strong></td>
                        <td width="9%" align="center"><strong>Sub Category</strong></td>
                        <td width="4%" align="center"><strong>Qty</strong></td>
                        <td width="3%" align="center"><strong>Qty(Shelf)</strong></td>
                        <td width="3%" align="center"><strong>Qty(Cons.)</strong></td>
                        <!--<td width="10%" align="center"><strong>Description</strong></td>-->
                        <td width="6%" align="center"><strong>Size</strong></td>
                        <!--<td width="5%" align="center"><strong>Commission</strong></td>-->
                        <td width="5%" align="center"><strong>Non Tax Value</strong></td>
                        <td width="10%" align="center"><strong>Vender</strong></td>
                        <?php
						//if($_SESSION['type']=='S' || $_SESSION['type']=='ST')
						//{
							?>
							<td width="6%" align="center"><strong>Status</strong></td>
							<?php
						//}
						
						//if($_SESSION['type'] =='S')
						//{
						?>
                        <td width="6%" align="center"><strong>Brand</strong></td>
                        <td width="10%" align="center"><strong>Owner</strong></td>
                        <?php 
						//}
						?>
                         <td width="9%" align="center"><strong>Added Date</strong></td>
						   <?php
						//if( $_SESSION['type'] =='S' || $_SESSION['type'] =='ST')
						//{	
						?>
                        <td width="6%" class="centerAlign"><strong>Action</strong></td>
						<?php
						//}
						?>
                      </tr>
                            <?php

                            while($val_query=mysql_fetch_array($all_records))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                
                                $listed_record_id=$val_query['product_id']; 
                                
                                $position=120; // Define how many character you want to display.                                
                                $post = substr(strip_tags($val_query['description']), 0, $position);
                                
                                include "include/paging_script.php";
								echo '<tr '.$bgcolor.' >';								
									
                                if($_SESSION['type'] =='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
						       	{	
									
									$select_ext_produ="select product_id from inventory_product_map where product_id='".$listed_record_id."'";
									$qquery_produ=mysql_query($select_ext_produ);
									if(!mysql_num_rows($qquery_produ))
									{
                                  		
									}
									
							   	}
								echo '<td align="center">';
									echo '<input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'">';
								echo '</td>';
                                echo '<td align="center">'.$sr_no.'</td>'; 
                                echo '<td >'.$val_query['product_name'].'</td>';							
								echo '<td align="center">'.$val_query['product_code'].'</td>';
								//echo '<td align="center">'.$val_query['hsn_code'].'</td>';
								$select_prod_cat="select pcategory_name,pcategory_id from product_category where pcategory_id='".$val_query['pcategory_id']."'";
								$query_cat=mysql_query($select_prod_cat);
								$fetch_cat=mysql_fetch_array($query_cat);
								
								echo '<td align="center">'.$fetch_cat['pcategory_name'].'</td>';
								
								$select_prod_subcat="select sub_name,sub_id from product_subcategory where sub_id='".$val_query['sub_id']."'";
								$query_subcat=mysql_query($select_prod_subcat);
								$fetch_subcat=mysql_fetch_array($query_subcat);
								
								echo '<td align="center">'.$fetch_subcat['sub_name'].'</td>';
								
								echo '<td align="center">';
								if($_SESSION['type']=='S' )
								{
									echo'<input type="text" name="stock_quantity" value="'.$val_query['quantity'].'" style="width:40px" onblur="change_qty('.$listed_record_id.',this.value)" >';
								}
								else
									echo $val_query['quantity'];
								echo'</td>';
								
								echo '<td align="center">'.$val_query['quantity_in_shelf'].'</td>';
								
								echo '<td align="center">'.$val_query['quantity_in_consumable'].'</td>';
								
                                //echo '<td >'.$post.'</td>';
								
								echo '<td align="center">'.$val_query['size']."  ".$val_query['unit'].'</td>';
								
								//echo '<td align="center">'.$val_query['commission'].'</td>';
								
								echo '<td align="center">'.$val_query['price'].'</td>';
								
								echo '<td align="center">';
								$select_vendor_map="select product_id,vendor_id from product_vendor_map where product_id='".$val_query['product_id']."' ";
								$query_vendor_map=mysql_query($select_vendor_map);
								$v=1;
								while($fetch_vendor_map=mysql_fetch_array($query_vendor_map))
								{
									$sql_vendor = " select name, vendor_id from vendor where vendor_id='".$fetch_vendor_map['vendor_id']."' ";
									$ptr_vendor = mysql_query($sql_vendor);
									$data_vendor = mysql_fetch_array($ptr_vendor);
									echo ''.$data_vendor['name'].'<br/>';
									$v++;
								}
								echo '</td>';
								//if($_SESSION['type']=='S' || $_SESSION['type']=='ST')
								//{
								echo '<td align="center">';
								echo '<select name="prod_status" id="prod_status" class="input_select" style="width:100px;" onChange="set_status(this.value,'.$val_query['product_id'].')">
								<option value="">Select</option>';
								$act_selecteds = '';
								$inact_selecteds='';
								if($val_query['status']=='Active')
									$act_selecteds = 'selected="selected"';
								else if	($val_query['status']=='Inactive')
									$inact_selecteds = 'selected="selected"';
									
								echo "<option value='Active' ".$act_selecteds." >Active</option>";
								echo "<option value='Inactive' ".$inact_selecteds." >Inactive</option>";
								echo'</select>';
								echo '</td>';
								
								echo '<td align="center">';
								echo '<select name="prod_brand" id="prod_brand" class="input_select" style="width:100px;" onChange="set_brand(this.value,'.$val_query['product_id'].')">
								<option value="">Select Brand</option>';
								$sel_brand="select * from product_brand";
								$ptr_sel=mysql_query($sel_brand);
								while($data_brand=mysql_fetch_array($ptr_sel))	
								{
									$sel='';
									if($val_query['brand']==$data_brand['brand_id'])
									{
										$sel="selected='selected'";
									}
									
									echo "<option value='".$data_brand['brand_id']."' ".$sel.">".$data_brand['brand_name']."</option>";
								}
								echo'</select>';
								echo '</td>';
								//}
								$name='';
								//if($_SESSION['type'] =='S')
								//{
									$sel_emp="select name from site_setting where admin_id='".$val_query['admin_id']."'";
									$ptr_admin_id=mysql_query($sel_emp);
									if(mysql_num_rows($ptr_admin_id))
									{
										$data_name=mysql_fetch_array($ptr_admin_id);
										$name= "".$data_name['name']."";
									}
									echo '<td align="center">'.$name.'</td>';
								//}
								
								//echo '<td align="center">'.$data_name['name'].'</td>';
								
								
                                echo '<td align="center">'.$val_query['added_date'].'</td>';
								
                                echo '<td align="center">';
								$select_ext_produ="select product_id from inventory_product_map where product_id='".$listed_record_id."'";
								$qquery_produ=mysql_query($select_ext_produ);
								//if(!mysql_num_rows($qquery_produ))
								//{
								//if( $_SESSION['type'] =='S' || $_SESSION['type'] =='ST')
						       	///{
									echo '<a href="add_product_edit.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;';
								//}
								if( $_SESSION['type'] =='S' || $edit_access=='yes')
						       	{
                                     echo'<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
								}
								//}

                                echo '</td>';
							   
                                echo '</tr>';
                                                                
                                $bgColorCounter++;
                            }    
                                ?>
  
  
  <tr class="head_td">
    <td colspan="20">
       <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <?php
                      if($no_of_records>10)
						{
							echo '<td width="3%" align="left">Show</td>
							<td width="20%" align="left"><select class="input_select_login" name="show_records" onchange="redirect(this.value)">';
							$show_records=array(0=>'10',1=>'20','50','100','200','300');
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
    <td>
    
    <script type="text/javascript">
                $(function()    
                {
    	            $(".custom_cuorse_submit").click(function(){
                    var councillior_id = $("#councillior_id").val();
                               
                    if(councillior_id == "" || councillior_id == undefined)
                    {
        	            alert("Select Councillor name.");
                        return false;
                    }
					else
					{
						$("#councillior_admin_id").val(councillior_id);
						$('.new_custom_course').dialog( 'close');
						setTimeout(document.frmTakeAction.submit(),3000)
					}
                    /*if(mobile1 == "" || mobile1 == undefined)
                    {
            	        alert("Enter Mobile no.");
                        return false;
                    }
                    if(email == "" || email == undefined)
                    {
                	    alert("Eneter Email ID.");
                        return false;
                    }*/
                    /*var data1 = 'action=custome_councillior_submit&councillior_id='+councillior_id
                    $.ajax({
                    	url: "ajax.php", type: "post", data: data1, cache: false,
                        success: function (html)
                        {
                        	if(html.trim() =='mobile')
                            {
                            	alert("Mobile no. or Email already Exist");
                                return false;
                            }
                            else if(html.trim() =='cust_id')
                            {
                            	alert("Customer Name already Exist");
                                return false;
                            }
                            else if (html.trim() =='blank')
                            {
                            	alert("Please enter Mobile number");
                                return false;
                            }
                            else
                            {
                            	$(".customized_select_box").html(html);
                               
                                $('.new_custom_course').dialog( 'close');
                                $("#customer_id").chosen({allow_single_deselect:true});
                               
                            }
                        }
                        });*/
                    });
             });
            </script>
            <div class="new_custom_course" style="display: none;">
                <form method="post" id="jqueryForm" name="discount" enctype="multipart/form-data">
                    <table border="0" cellspacing="15" cellpadding="0" width="100%">
                        <tr>
                            <td colspan="3" class="orange_font">* Mandatory Fields</td>
                        </tr>
                        <tr>
                            <td width="20%">Select Vendor<span class="orange_font">*</span></td>
                            <td width="40%">
                            <select name="councillior_id" id="councillior_id">
                            <option value="">Select Vendor Name</option>
                            <?php
							$sle_name="select * from vendor where 1 ".$_SESSION['where']." order by vendor_id asc"; 
							$ptr_name=mysql_query($sle_name);
							while($data_name=mysql_fetch_array($ptr_name))
							{
								$sel_cm="select branch_name from site_setting where cm_id='".$data_name['cm_id']."'";
								$ptr_cm=mysql_query($sel_cm);
								$data_cm_id=mysql_fetch_array($ptr_cm);
								echo '<option value="'.$data_name['vendor_id'].'">'.$data_name['name'].' - ( '.$data_cm_id['branch_name'].' )</option>';
							}
							?>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="button" class="inputButton custom_cuorse_submit" value="Submit" name="submit"/>&nbsp;
                                <input type="reset" class="inputButton" value="Close" onClick="$('.new_custom_course').dialog( 'close');"/>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
    
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
