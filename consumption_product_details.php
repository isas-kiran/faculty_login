<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Consumption Details</title>
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
    <td class="top_mid" valign="bottom"><?php include "include/report_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
    
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
        
<table cellspacing="0" cellpadding="0" class="table" width="98%">
    
    
  <tr class="head_td">
    <td colspan="8">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
               
                <!--<td class="rightAlign" > 
                    <table border="0" cellspacing="0" cellpadding="0" align="right">
              <tr>
              <td></td>
              <td class="width5"></td>
                <td><input type="text" value="<?php //if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
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
                            $pre_keyword=" and (pcategory_name like '%".$keyword."%')";
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

                        if($_GET['orderby']=='pcategory_name' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='pcategory_name'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        
                                                 
						$sql_query= "select DISTINCT(e.employee_id) from consumption_map e, site_setting s where 1 and e.employee_id=s.admin_id and e.employee_id='".$_GET['employee_id']."' and e.product_id='".$_GET['product_id']." '".$_SESSION['where']." order by s.name asc"; 
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
                        <td width="5%" align="center"><strong>Sr. No.</strong></td>
                        <td width="20%" align="center"><strong>Employee Name</strong></td>
                        <td width="70%" align="center"><strong>Product Details</strong></td>                     
                      </tr>
                            <?php
                            while($val_query=mysql_fetch_array($all_records))
                            {
								$sel_name="select name from site_setting where admin_id='".$val_query['employee_id']."'";
								$ptr_name=mysql_query($sel_name);
								if(mysql_num_rows($ptr_name))
								{
									$data_names=mysql_fetch_array($ptr_name);
									
									if($bgColorCounter%2==0)
										$bgcolor='class="grey_td"';
									else
										$bgcolor="";                
									$listed_record_id=$val_query['employee_id']; 
									include "include/paging_script.php";
									echo '<tr '.$bgcolor.' >';
									echo '<td align="center" width="8%">'.$sr_no.'</td>';  
									echo '<td align="center" width="20%" style="font-size:14px">'.$data_names['name'].'</td>';
									echo '<td  colspan="2" width="70%">';
									
										/*echo'<td width="10%" style="padding-top:10px;padding-bottom:10px" align="center">';
										"<br/>". $select_product_ids="select DISTINCT(product_id) from consumption where employee_id='".$val_query['employee_id']."' ";
										$query_product_ids=mysql_query($select_product_ids);
										$count_prod_ids=mysql_num_rows($query_product_ids);
										$a=1;
										while($fetch_prod_ids=mysql_fetch_array($query_product_ids))
										{
											$sel_product="select product_name from product where product_id ='".$fetch_prod_ids['product_id']."'";
											$ptr_product=mysql_query($sel_product);
											$data_product=mysql_fetch_array($ptr_product);
											echo $data_product['product_name'];
											
											if($a!=$count_prod_ids)
											 echo '<hr>';
											$a++;
										}
										echo '</td>';*/
										
										//echo '<td width="10%" style="padding-top:10px;padding-bottom:10px" align="center">';
										"<br/>".$select_product_ids="select DISTINCT(product_id) from consumption_map where employee_id='".$_GET['employee_id']."' and product_id='".$_GET['product_id']."' ";
										$query_product_ids=mysql_query($select_product_ids);
										$count_prod_ids=mysql_num_rows($query_product_ids);
										$a=1;
										while($fetch_prod_ids=mysql_fetch_array($query_product_ids))
										{
											echo '<table width="100%"><tr>';
											$sel_product="select product_name from product where product_id ='".$fetch_prod_ids['product_id']."'";
											$ptr_product=mysql_query($sel_product);
											$data_product=mysql_fetch_array($ptr_product);
											echo'<td width="30%" style="padding-top:10px;padding-bottom:10px;font-size:14px" align="center">';
											echo $data_product['product_name'];
											echo'<td>';
											"<br/>". $sel_prod_id="select product_id,quantity,unit,consume_qty,consume_unit,description,added_date from consumption_map where product_id='".$fetch_prod_ids['product_id']."' ";
											$qry_pro_ids=mysql_query($sel_prod_id);
											if($total_prod_ids=mysql_num_rows($qry_pro_ids))
											{
												echo'<td width="70%"><table width="100%" class="table" style=" border: 1px solid black; border-collapse: collapse;margin-left:0px;margin-right:0px" border="1" >';
												echo'<tr style="border:1px solid black;"><td style="border:1px solid black;" align="center">Sr.no.</td><td style="border:1px solid black;" align="center">Consume Qty</td><td style="border:1px solid black;" align="center">Consume Unit</td><td style="border:1px solid black;" align="center">Remaining Qty</td><td style="border:1px solid black;" align="center">Remaining Unit</td><td style="border:1px solid black;" align="center">Description</td><td style="border:1px solid black;" align="center">Date</td></tr>';
												$b=1;
												while($data_prod_ids=mysql_fetch_array($qry_pro_ids))
												{
													echo'<tr style="border:1px solid black;">';
													echo'<td style="border:1px solid black;" align="center">'.$b.'</td>';
													echo'<td style="border:1px solid black;" align="center">'.$data_prod_ids['consume_qty'].'<br/>';
													echo'<td style="border:1px solid black;" align="center">'.$data_prod_ids['consume_unit'].'<br/>';
													echo'<td style="border:1px solid black;" align="center">'.$data_prod_ids['quantity'].'<br/>';
													echo'<td style="border:1px solid black;" align="center">'.$data_prod_ids['unit'].'<br/>';
													echo'<td style="border:1px solid black;" align="center">'.$data_prod_ids['description'].'<br/>';
													echo'<td style="border:1px solid black;" align="center">'.$data_prod_ids['added_date'].'<br/>';
													
													echo'</tr>';
													
													$b++;
												}
												echo'</table></td>';
											}
											echo '</tr></table>';	
											if($a!=$count_prod_ids)
											 echo '<hr>';
											$a++;
											
										}
										//echo '</td>';	
									echo '</td>';
									echo '</tr>';
																	
									$bgColorCounter++;
								}
                            }    
                                ?>
  
  
  <tr class="head_td">
    <td colspan="8">
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
