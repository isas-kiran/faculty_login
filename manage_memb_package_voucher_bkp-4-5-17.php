<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage sales voucher/Package/Membership</title>
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
    <td class="top_mid" valign="bottom"><?php include "include/services_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
    <?php       if($_POST['formAction'])
                    {
                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $del_record_id=$_POST['chkRecords'][$r];
                                $sql_query= "SELECT id FROM sales_package_voucher_memb where id ='".$del_record_id."'";
								$ptr_query11=mysql_query($sql_query); 
                                if(mysql_num_rows($ptr_query11))
								{                                                
									$delete_query="delete from sales_package_voucher_memb where id='".$del_record_id."'";
									$ptr_query21=mysql_query($delete_query); 
									
									$delete_tax="delete from voucher_tax_map where sales_voucher_id='".$del_record_id."'";
									$ptr_query33=mysql_query($delete_tax); 
									
									$delete_code="delete from voucher_customer_code_map where sales_id='".$del_record_id."'";
									$ptr_query44=mysql_query($delete_code); 
									
									$delete_service="delete from sales_customer_service_voucher_map where id='".$del_record_id."'";
									$ptr_query55=mysql_query($delete_service);                                                                                         
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
											setTimeout('document.location.href="manage_memb_package_voucher.php";',1000);
                                    </script>
                            <?php                            
                                }
                     }
                    if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
                    {
                        $del_record_id=$_REQUEST['record_id'];
                        $sql_query= "SELECT id FROM sales_package_voucher_memb where id='".$del_record_id."'";
						$ptr_query=mysql_query($sql_query);
                        if(mysql_num_rows($ptr_query))
                        {       
						                  
                            $delete_query="delete from sales_package_voucher_memb where id='".$del_record_id."'";
                           	$ptr_query=mysql_query($delete_query); 
							
							 "<br/>".$delete_tax="delete from voucher_tax_map where sales_voucher_id='".$del_record_id."'";
							$ptr_query1=mysql_query($delete_tax); 
							
							 "<br/>".$delete_code="delete from voucher_customer_code_map where sales_id='".$del_record_id."'";
							$ptr_query2=mysql_query($delete_code); 
							
							 "<br/>".$delete_service="delete from sales_customer_service_voucher_map where id='".$del_record_id."'";
							$ptr_query3=mysql_query($delete_service); 
                            ?>
                            <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record deleted successfully</p></center></div>
                            <script type="text/javascript">
                                $("#statusChangesDiv").dialog();
                                $(document).ready(function() {
                                    $( "#statusChangesDiv" ).dialog({
                                        modal: true,
                                        buttons: {
                                                    Ok: function() { $( this ).dialog( "close" ); }
                                                 }
                                        });
                                    });
									
									setTimeout('document.location.href="manage_memb_package_voucher.php";',1000);
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
						$cust_name='';
						$sel_cust_name="select cust_id from customer where cust_name like '%".$keyword."%' "; 
						$ptr_cust_name=mysql_query($sel_cust_name);     
						if(mysql_num_rows($ptr_cust_name)) 
						{
							while($data_cust_name=mysql_fetch_array($ptr_cust_name))
							{
								$cust_name .="|| cust_id = '".$data_cust_name['cust_id']."'";
							}
						} 
						
						$package_name='';
						$sel_package_id="select package_id from package where package_name like '%".$keyword."%' "; 
						$ptr_package_id=mysql_query($sel_package_id);     
						if(mysql_num_rows($ptr_package_id)) 
						{
							while($data_package_id=mysql_fetch_array($ptr_package_id))
							{
								$package_name .="|| package_id = '".$data_package_id['package_id']."'";
							}
						} 
						
						$mebership='';
						$sel_mebership="select membership_id from membership where membership_name like '%".$keyword."%' "; 
						$ptr_mebership=mysql_query($sel_mebership);     
						if(mysql_num_rows($ptr_mebership)) 
						{
							while($data_mebership=mysql_fetch_array($ptr_mebership))
							{
								$mebership .="|| membership_id = '".$data_mebership['membership_id']."'";
							}
						} 
						$voucher='';
						$sel_voucher="select voucher_id from voucher where deal_name like '".$keyword."' "; 
						$ptr_voucher=mysql_query($sel_voucher);     
						if(mysql_num_rows($ptr_voucher)) 
						{
							while($data_voucher=mysql_fetch_array($ptr_voucher))
							{
								$voucher .="|| voucher_id = '".$data_voucher['membership_id']."'";
							}
						} 
                        if($keyword)
                            $pre_keyword=" and (category like '%".$keyword."%' ".$cust_name." ".$package_name." ".$mebership." ".$voucher." || amount='%".$keyword."%')";//|| mobile1 like '%".$keyword."%' || mobile2 like '%".$keyword."%' || email like '%".$keyword."%' || address like '%".$keyword."%' || membership like '%".$keyword."%'
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

                        if($_GET['orderby']=='id' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='id'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                            $select_directory='order by id desc';                      
                            $sql_query= "SELECT * FROM sales_package_voucher_memb where 1 ".$_SESSION['where']."  ".$pre_keyword." ".$select_directory.""; 
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
                        <td width="10%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=cust_name".$query_string;?>" class="table_font"><strong>Customer Name</strong></a> <?php echo $img1;?></td>
                        <td width="8%" align="center"><strong>Category name</strong></td>
                        <td width="8%" align="center"><strong>Name</strong></td>
                        <td width="8%" align="center"><strong>Start date</strong></td>
                        <td width="8%" align="center"><strong>End Date</strong></td>
                       
                        <td width="5%" align="center"><strong>Amount</strong></td>
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
                                $listed_record_id=$val_query['id']; 
                                include "include/paging_script.php";
                                
								$cust_name="select cust_name from customer where cust_id='".$val_query['cust_id']."'";
								$ptr_cust=mysql_query($cust_name);
								$data_cust=mysql_fetch_array($ptr_cust);
								
                                echo '<tr '.$bgcolor.' >
                                      <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
                                echo '<td align="center">'.$sr_no.'</td>';
                                echo '<td ><a href="sale_memb_package_voucher.php?record_id='.$listed_record_id.'" >'.$data_cust['cust_name'].'</a></td>';
								echo '<td align="center">'.$val_query['category'].'</td>';
								$name=='';
								if($val_query['category']=='Membership')
								{
									$sl_memb="select membership_name from membership where membership_id='".$val_query['membership_id']."'";
									$ptr_memb=mysql_query($sl_memb);
									$data_memb=mysql_fetch_array($ptr_memb);
									$name=$data_memb['membership_name'];
								}
								else if($val_query['category']=='Package')
								{
									$sl_package="select package_name from package where package_id='".$val_query['package_id']."'";
									$ptr_package=mysql_query($sl_package);
									$data_package=mysql_fetch_array($ptr_package);
									$name=$data_package['package_name'];
								}else if($val_query['category']=="Voucher")
								{
									$sl_voucher="select deal_name from voucher where voucher_id='".$val_query['voucher_id']."'";
									$ptr_voucher=mysql_query($sl_voucher);
									$data_voucher=mysql_fetch_array($ptr_voucher);
									$name=$data_voucher['deal_name'];
								}
								
								echo '<td align="center">'.$name.'</td>';
								$start_date=explode('-',$val_query['start_date']);
							    $start_dates=$start_date[2].'/'.$start_date[1].'/'.$start_date[0];
								echo '<td align="center">'.$start_dates.'</td>';
								
								$end_date=explode('-',$val_query['end_date']);
							    $end_dates=$end_date[2].'/'.$end_date[1].'/'.$end_date[0];
                                echo '<td align="center">'.$end_dates.'</td>';
								
							
								echo '<td align="center">'.$val_query['amount'].'</td>';
								
								
                                echo '<td align="center">'.$val_query['added_date'].'</td>';
								
                                echo '<td align="center"><a href="sale_memb_package_voucher.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
                                      <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';

                                echo '</td>';
                                echo '</tr>';
                                                                
                                $bgColorCounter++;
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
