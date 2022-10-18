<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Checkout</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
    <script type="text/javascript" src="../js/common.js"></script>
     <!-- Multiselect -->
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>
    
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
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
    <script type="text/javascript">
       
    $(document).ready(function()
	{            
		$('.datepicker').datepicker({ changeMonth: true,changeYear: true,dateFormat:"dd/mm/yy", showButtonPanel: true, closeText: 'Clear'});
		$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
		}
		
//             $('input:radio[name=free_course][value=N]').click();
//             $('input:radio[name=discount_course][value=Y]').click();
//             $('input:radio[name=status][value=Inactive]').click();
	});
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
                                $sql_query= "SELECT checkout_id FROM checkout where checkout_id ='".$del_record_id."'";
                                if(mysql_num_rows($db->query($sql_query)))
                                    {                                                
                                        $delete_query="delete from checkout where checkout_id='".$del_record_id."'";
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
                        $sql_query= "SELECT checkout_id FROM checkout where checkout_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {                           
                            $delete_query="delete from checkout where checkout_id='".$del_record_id."'";
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
                        <!--<td width="15%">
                        <select name="product_center">
                        	<option value="">Select Product Center</option>
                            <option value="stock"  <?php //if($_REQUEST['product_center']=="stock") echo 'selected="selected"'; ?>>Stock</option>
                            <option value="shelf" <?php //if($_REQUEST['product_center']=="shelf") echo 'selected="selected"'; ?>>Shelf</option>
                            <option value="consumable" <?php //if($_REQUEST['product_center']=="consumable") echo 'selected="selected"'; ?>>Consumable</option>
                        </select>
                        </td>-->
                        <td width="10%"><input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>"></td>
                         <td width="10%"><input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>"></td>
                        <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                        
                        <td width="15%"><b style="font-size:14px; text-decoration:underline"><a href="manage_checkout_archive.php">Archive</a></b></td>
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
                            $pre_keyword=" and (type like '%".$keyword."%')";
                        else
                            $pre_keyword="";
						if($_REQUEST['product_center']!="")
                           $product_center="and c.type ='".trim($_REQUEST['product_center'])."'";
							
						if($_REQUEST['from_date']!="")
						{
							$sep=explode("/",$_REQUEST['from_date']);
							$from_date=$sep[2]."-".$sep[1]."-".$sep[0];
                          	$from_date=" and c.added_date >='".date('Y-m-d',strtotime($from_date))."'";
						}
						if($_REQUEST['to_date']!="")
						{
							$sep=explode("/",$_REQUEST['to_date']);
							$to_date=$sep[2]."-".$sep[1]."-".$sep[0];
                            $to_date=" and c.added_date <='".date('Y-m-d',strtotime($to_date))."'";
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

                        if($_GET['orderby']=='checkout_id' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='checkout_id'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                            $select_directory='order by checkout_id desc';
							
						if($pre_keyword=='' && ($product_center=='' && $from_date=='' && $to_date==''))
						{                      
						  "main". $sql_query= "SELECT checkout_id, cm_id, added_date, admin_id FROM checkout where 1 ".$_SESSION['where']." ".$_SESSION['user_id']." ".$pre_keyword." ".$select_directory.""; 
						}
						else
						{
							$cm_ids=='';
							$admin_ids='';
							if($_SESSION['where'] !='')
							{
								$cm_ids="and c.cm_id='".$_SESSION['cm_id']."'";
							}
							if($_SESSION['user_id'] !='')
							{
								$admin_ids="and c.admin_id='".$_SESSION['admin_id']."'";
							}
							 $sql_query="select c.checkout_id, c.cm_id, c.added_date, c.admin_id from checkout c, product p, site_setting s, checkout_product_map cpm where 1 and (cpm.type like '%".$keyword."%' or cpm.unit like '%".$keyword."%' or cpm.issue_qty like '%".$keyword."%' or p.product_name like '%".$keyword."%' or s.name like '%".$keyword."%' or s.branch_name like '%".$keyword."%') ".$product_center." ".$from_date." ".$to_date." and c.checkout_id=cpm.checkout_id and cpm.product_id=p.product_id and s.admin_id=cpm.employee_id and c.cm_id=s.cm_id ".$cm_ids." ".$admin_ids."";
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
                        <td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
                        <td width="5%" align="center"><strong>Sr. No.</strong></td>
                        <td width="10%" align="center"><strong>Product Name</strong></td>
                        <td width="10%" align="center"><strong>Type</strong></td>
                        <td width="10%" align="center"><strong>Unit</strong></td>
                        <td width="10%" align="center"><strong>Issue Qty</strong></td>
                        <td width="10%" align="center"><strong>Employee</strong></td>
                        <td width="10%" align="center"><strong>Branch</strong></td>
                        <td width="10%" align="center"><strong>Added Date</strong></td>
                        <td width="10%" class="centerAlign"><strong>Action</strong></td>
                      </tr>
                            <?php

                            while($val_query=mysql_fetch_array($all_records))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                
                                $listed_record_id=$val_query['checkout_id']; 
								
                                include "include/paging_script.php";
                                
                                echo '<tr '.$bgcolor.' >
                                      <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
                                echo '<td align="center">'.$sr_no.'</td>'; 
								
								echo '<td width="10%" style="padding-top:10px;padding-bottom:10px">';
								
								$sel_checkout_pro="select product_id from checkout_product_map where checkout_id='".$val_query['checkout_id']."' ";
                                $query_checkout_pro=mysql_query($sel_checkout_pro);
								$tot_rec=mysql_num_rows($query_checkout_pro);
								$a=1;
								while($fetch_checkout_pro=mysql_fetch_array($query_checkout_pro))
								{
									$sel_product="select product_name from product where product_id ='".$fetch_checkout_pro['product_id']."'";
									$ptr_product=mysql_query($sel_product);
									$data_product=mysql_fetch_array($ptr_product);
									
									echo $data_product['product_name'];
									
									if($a!=$tot_rec)
									 echo '<hr>';
									
									$a++;
								}
								
								echo '</td>';
								
                                echo '<td width="10%" style="padding-top:10px;padding-bottom:10px" align="center">';
								
								$sel_checkout_pro1="select type from checkout_product_map where checkout_id='".$val_query['checkout_id']."' ";
                                $query_checkout_pro1=mysql_query($sel_checkout_pro1);
								$tot_rec1=mysql_num_rows($query_checkout_pro1);
								$b=1;
								while($fetch_checkout_pro1=mysql_fetch_array($query_checkout_pro1))
								{
									
									echo $fetch_checkout_pro1['type'];
									
									if($b!=$tot_rec1)
									 echo '<hr>';
									
									$b++;
								}
								
								echo '</td>';
								
								 echo '<td width="10%" style="padding-top:10px;padding-bottom:10px" align="center">';
								
								$sel_checkout_pro2="select unit from checkout_product_map where checkout_id='".$val_query['checkout_id']."' ";
                                $query_checkout_pro2=mysql_query($sel_checkout_pro2);
								$tot_rec2=mysql_num_rows($query_checkout_pro2);
								$c=1;
								while($fetch_checkout_pro2=mysql_fetch_array($query_checkout_pro2))
								{
									
									echo $fetch_checkout_pro2['unit'];
									
									if($c!=$tot_rec2)
									 echo '<hr>';
									
									$c++;
								}
								
								echo '</td>';
								
								echo '<td width="10%" style="padding-top:10px;padding-bottom:10px" align="center">';
								
								$sel_checkout_pro3="select issue_qty from checkout_product_map where checkout_id='".$val_query['checkout_id']."' ";
                                $query_checkout_pro3=mysql_query($sel_checkout_pro3);
								$tot_rec3=mysql_num_rows($query_checkout_pro3);
								$d=1;
								while($fetch_checkout_pro3=mysql_fetch_array($query_checkout_pro3))
								{
									
									echo $fetch_checkout_pro3['issue_qty'];
									
									if($d!=$tot_rec3)
									 echo '<hr>';
									
									$d++;
								}
								
								echo '</td>';
								
								echo '<td width="10%" style="padding-top:10px;padding-bottom:10px" align="center">';
								
								$sel_checkout_pro4="select employee_id from checkout_product_map where checkout_id='".$val_query['checkout_id']."' ";
                                $query_checkout_pro4=mysql_query($sel_checkout_pro4);
								$tot_rec4=mysql_num_rows($query_checkout_pro4);
								$e=1;
								while($fetch_checkout_pro4=mysql_fetch_array($query_checkout_pro4))
								{
									$sel_name="select name from site_setting where admin_id='".$fetch_checkout_pro4['employee_id']."'";
									$ptr_name=mysql_query($sel_name);
									$data_names=mysql_fetch_array($ptr_name);
									
									echo $data_names['name'];
									
									if($e!=$tot_rec4)
									 echo '<hr>';
									
									$e++;
								}
								
								echo '</td>';
								
                                $sql_branch = "  select branch_name, cm_id from site_setting where cm_id='".$val_query['cm_id']."' ";
								$ptr_branch = mysql_query($sql_branch);
								$data_branch = mysql_fetch_array($ptr_branch);
								
								echo '<td align="center">'.$data_branch['branch_name'].'</td>';
								
								$explode_added_date=explode('-',$val_query['added_date']);
								$sep_date=$explode_added_date[2].'-'.$explode_added_date[1].'-'.$explode_added_date[0];
								
                                echo '<td align="center">'.$sep_date.'</td>';
								
                                echo '<td align="center">
                                      <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
//<a href="add_checkout.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
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
