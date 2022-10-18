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
                                $sql_query= "SELECT product_id FROM product where product_id ='".$del_record_id."'";
                                if(mysql_num_rows($db->query($sql_query)))
                                    {                                                
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
                     }
                    if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
                    {
                        $del_record_id=$_REQUEST['record_id'];
                        $sql_query= "SELECT product_id FROM product where product_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {                           
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
							$select_directory='order by product_name asc';  
						if($pre_keyword=='') 
						{                   
							$sql_query= "SELECT * FROM product where 1 ".$_SESSION['where']." ".$_SESSION['user_id']."  ".$select_directory.""; 
						}
						else
						{
							$cm_ids=='';
							$admin_ids='';
							if($_SESSION['where'] !='')
							{
								$cm_ids="and p.cm_id='".$_SESSION['cm_id']."'";
							}
							if($_SESSION['user_id'] !='')
							{
								$admin_ids="and p.admin_id='".$_SESSION['admin_id']."'";
							}
							/*echo $sql_query="select p.* from product p, product_category pc, subcategory sub, vendor v where 1  and (p.product_name like '%".$keyword."%' or p.product_code like '%".$keyword."%' or p.description like '%".$keyword."%' or p.size like '%".$keyword."%' or p.commission like '%".$keyword."%' or p.price like '%".$keyword."%' or pc.pcategory_name like '%".$keyword."%' or sub.sub_name like '%".$keyword."%' or v.name like '%".$keyword."%') and p.pcategory_id=pc.pcategory_id and p.sub_id=sub.sub_id and p.vender=v.vendor_id ";*/
							
							 $sql_query= "SELECT p.product_name, p.product_code, p.description, p.size, p.commission, p.price, p.pcategory_id, p.sub_id, p.product_id,p.quantity,p.added_date FROM product p, product_category pc, product_subcategory sub where 1  and (p.product_name like '%".$keyword."%' or p.product_code like '%".$keyword."%' or p.description like '%".$keyword."%' or p.size like '%".$keyword."%' or p.commission like '%".$keyword."%' or p.price like '%".$keyword."%' or pc.pcategory_name like '%".$keyword."%' or sub.sub_name like '%".$keyword."%' ) and p.pcategory_id=pc.pcategory_id and p.sub_id=sub.sub_id ".$cm_ids." ".$admin_ids." ".$select_directory.""; 
						}
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
                      <tr class="grey_td" >
                        <td width="3%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
                        <td width="3%" align="center"><strong>Sr. No.</strong></td>
                        <td width="7%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=product_name".$query_string;?>" class="table_font"><strong>Product Name</strong></a> <?php echo $img1;?></td>
                        <td width="7%" align="center"><strong>Product Code</strong></td>
                        <td width="8%" align="center"><strong>Product Category</strong></td>
                        <td width="9%" align="center"><strong>Sub Category</strong></td>
                        <td width="4%" align="center"><strong>Qty</strong></td>
                        <td width="10%" align="center"><strong>Description</strong></td>
                        <td width="6%" align="center"><strong>Size</strong></td>
                        <td width="11%" align="center"><strong>Commission</strong></td>
                         <td width="7%" align="center"><strong>Non Tax Value</strong></td>
                        <td width="10%" align="center"><strong>Vender</strong></td>
                         <td width="9%" align="center"><strong>Added Date</strong></td>
                        <td width="6%" class="centerAlign"><strong>Action</strong></td>
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
								
								echo '<td align="center">';
								
								$select_ext_produ="select product_id from inventory_product_map where product_id='".$listed_record_id."'";
								$qquery_produ=mysql_query($select_ext_produ);
								if(!mysql_num_rows($qquery_produ))
								{
								
                                  echo '<input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'">';
								}
								
								echo '</td>';
								
                                echo '<td align="center">'.$sr_no.'</td>'; 
								      
                                echo '<td >'.$val_query['product_name'].'</td>';
								
								echo '<td align="center">'.$val_query['product_code'].'</td>';
								
								$select_prod_cat="select pcategory_name,pcategory_id from product_category where pcategory_id='".$val_query['pcategory_id']."'";
								$query_cat=mysql_query($select_prod_cat);
								$fetch_cat=mysql_fetch_array($query_cat);
								
								echo '<td align="center">'.$fetch_cat['pcategory_name'].'</td>';
								
								$select_prod_subcat="select sub_name,sub_id from product_subcategory where sub_id='".$val_query['sub_id']."'";
								$query_subcat=mysql_query($select_prod_subcat);
								$fetch_subcat=mysql_fetch_array($query_subcat);
								
								echo '<td align="center">'.$fetch_subcat['sub_name'].'</td>';
								
								echo '<td align="center">'.$val_query['quantity'].'</td>';
								
                                echo '<td >'.$post.'</td>';
								
								echo '<td align="center">'.$val_query['size']."  ".$val_query['unit'].'</td>';
								
								echo '<td align="center">'.$val_query['commission'].'</td>';
								
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
                                echo '<td align="center">'.$val_query['added_date'].'</td>';
                                echo '<td align="center">';
								$select_ext_produ="select product_id from inventory_product_map where product_id='".$listed_record_id."'";
								$qquery_produ=mysql_query($select_ext_produ);
								//if(!mysql_num_rows($qquery_produ))
								//{
								
								echo '<a href="add_product_edit.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
                                      <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
								//}

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
