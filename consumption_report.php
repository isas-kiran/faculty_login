<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Consumption Report</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='176'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
    <script type="text/javascript" src="../js/common.js"></script>
	<link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
     <script type="text/javascript">
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
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
		
		function show_product(value)
		{
			admin_id= value;
			var cat_data="action=show_produts_by_employee&admin_id="+admin_id;
			$.ajax({
			url: "show_checkout_product.php",type:"post", data: cat_data,cache: false,
			success: function(retbank)
			{
				//alert(retbank);
				document.getElementById("product_id").innerHTML=retbank;
				//document.getElementById("create_floor").innerHTML='';
				//document.getElementById("res1").value=retbank;
			}
			
			});
			
			//document.getElementById("product_id").disabled = false;
			
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
				<td width="15%">
					<select name="employee_id" id="employee_id"  class="input_select_login"  style="width: 150px;" onchange="show_product(this.value)">
						<option value="">Select Employee</option>
						<?php
						$sel_emp="select name,admin_id from site_setting where 1 ".$_SESSION['where']."";
						$ptr_emp=mysql_query($sel_emp);
						while($data_emp=mysql_fetch_array($ptr_emp))
						{
							$selected='';
							if($data_emp['admin_id'] == $row_expense['admin_id'])
							{
								$selected='selected="selected"';
							}
							echo '<option '.$selected.' value="'.$data_emp['admin_id'].'">'.$data_emp['name'].'</option>';
						}
						
						?>
					</select>
				</td>
				<td width="15%">
					<select name="product_id" id="product_id"  class="input_select_login"  style="width: 150px; ">
						<option value="">-Select Product-</option>
						<?php
							$sel_tel = "select admin_id,product_id,product_name from product where 1 ".$_SESSION['where']." ".$_SESSION['user_id']."";	 
							$query_tel = mysql_query($sel_tel);
							while($data=mysql_fetch_array($query_tel))
							{
								$name='';
								if($_SESSION['type'] =='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
								{
									$sel_emp="select name from site_setting where admin_id='".$data['admin_id']."'";
									$ptr_admin_id=mysql_query($sel_emp);
									$data_name=mysql_fetch_array($ptr_admin_id);
									$name= "(".$data_name['name'].")";
								}
								echo '<option value="'.$data['product_id'].'">'.addslashes($data['product_name']).'&nbsp; &nbsp;&nbsp;&nbsp;'.$name.'</option>';
							}
							 ?>
					</select>
				</td>
				<td width="10%" align="center">
				<input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>">
				</td>
				<td width="10%" align="center">
				<input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>">
				</td>
				<td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                
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
						
						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						{
							$frm_date=explode("/",$_REQUEST['from_date']);
							$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							$from_date=" and DATE(e.added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							
						}
						else
						{
							$from_date=""; 
						}
						
						if($_REQUEST['to_date']  && $_REQUEST['to_date']!=="0000-00-00" && $_REQUEST['to_date']!="From Date")
						{
							$to_date=explode("/",$_REQUEST['to_date']);
							$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
							$to_date=" and DATE(e.added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
						}
						else
						{
							$to_date="";
						}
						
						if($_REQUEST['employee_id'])
						{
							$emp_id=$_REQUEST['employee_id'];
							$employee_id=" and e.employee_id ='".$emp_id."'";
						}
						else
						{
							$employee_id=""; 
						}
						if($_REQUEST['product_id'])
						{
							$product_id=$_REQUEST['product_id'];
							$product_ids=" and e.product_id ='".$product_id."'";
							$product_ids11=" and product_id ='".$product_id."'";
						}
						else
						{
							$product_ids=""; 
							$product_ids11="";
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
								$search_cm_id=" and e.cm_id='".$data_cm_id['cm_id']."'";
								
							}
							else
							{
								$search_cm_id='';
							}
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

                        if($_GET['orderby']=='pcategory_name' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='pcategory_name'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
						$where_cm='';
						if($_SESSION['where']!='')
						{
							$where_cm=" and e.cm_id='".$_SERVER['cm_id']."'";
						}                  
                            $sql_query= "select DISTINCT(e.employee_id) from consumption e, site_setting s where 1 and e.employee_id=s.admin_id ".$where_cm." ".$from_date." ".$to_date." ".$search_cm_id." ".$employee_id." ".$product_ids."  order by s.name asc"; 
                       		//echo $sql_query;
                        	$no_of_records=mysql_num_rows($db->query($sql_query));
                        	if($no_of_records)
                        	{
                            	$bgColorCounter=1;
                            	//$_SESSION['show_records'] = 10;
                            	$query_string='&keyword='.$keyword.'&from_date='.$_REQUEST['from_date'].'&to_date='.$_REQUEST['to_date'].'&branch_name='.$_REQUEST['branch_name'];
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
										"<br/>".$select_product_ids="select DISTINCT(product_id) from consumption where employee_id='".$val_query['employee_id']."' ".$product_ids11." ";
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
											"<br/>". $sel_prod_id="select product_id,quantity,unit,description,added_date from consumption where product_id='".$fetch_prod_ids['product_id']."' ";
											$qry_pro_ids=mysql_query($sel_prod_id);
											if($total_prod_ids=mysql_num_rows($qry_pro_ids))
											{
												echo'<td width="70%"><table width="100%" class="table" style=" border: 1px solid black; border-collapse: collapse;margin-left:0px;margin-right:0px" border="1" >';
												echo'<tr style="border:1px solid black;"><td style="border:1px solid black;" align="center" width="10%">Sr.no.</td><td style="border:1px solid black;" align="center" width="20%">Remaining Quantity</td><td style="border:1px solid black;" align="center" width="15%">Unit</td><td style="border:1px solid black;" align="center" width="25%">Description</td><td style="border:1px solid black;" align="center" width="15%">Date</td><td style="border:1px solid black;" align="center" width="15%">Details</td></tr>';
												$b=1;
												while($data_prod_ids=mysql_fetch_array($qry_pro_ids))
												{
													echo'<tr style="border:1px solid black;">';
													echo'<td style="border:1px solid black;" align="center">'.$b.'</td>';
													echo'<td style="border:1px solid black;" align="center">'.$data_prod_ids['quantity'].'<br/>';
													echo'<td style="border:1px solid black;" align="center">'.$data_prod_ids['unit'].'<br/>';
													echo'<td style="border:1px solid black;" align="center">'.$data_prod_ids['description'].'<br/>';
													echo'<td style="border:1px solid black;" align="center">'.$data_prod_ids['added_date'].'<br/>';
													echo'<td style="border:1px solid black;" align="center"><a href="consumption_product_details.php?employee_id='.$listed_record_id.'&product_id='.$data_prod_ids['product_id'].'" target="_blank">Show Details</a><br/>';
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
