<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Incentive Report</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='258'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
    <script type="text/javascript" src="../js/common.js"></script>
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
    <td class="top_mid" valign="bottom"><?php include "include/payroll_menu.php";?></td>
    <td class="top_right"></td>
  </tr>


  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
        
<table cellspacing="0" cellpadding="0" class="table" width="95%">
    
    
  <tr class="head_td">
    <td colspan="17">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
               
				<?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
				{
				?>
                 <td width="15%">
                    <select name="branch_name" id="branch_name" class="input_select_login"  style="width: 150px; ">
                                <option value="">-Branch Name-</option>
                                <?php 
									$sel_branch="select branch_id,branch_name from branch";
									$ptr_sel=mysql_query($sel_branch);
									while($data_branch=mysql_fetch_array($ptr_sel))
									{
										$sel='';
										if($_REQUEST['branch_name'] == $data_branch['branch_name'])
										{
											$sel='selected="selected"';
										}
										echo '<option '.$sel.' value="'.$data_branch['branch_name'].'" > '.$data_branch['branch_name'].'</option>';
									}
								?>
                        </select>
                </td>
				
				<!-- <td width="15%">
					<select name="therapist_name" id="therapist_name"  class="input_select_login"  style="width: 150px; ">
						<option value="">-Therapist Name-</option>
						<?php 
						/*	$therapist="select DISTINCT admin_id from customer_service_map where 1 and admin_id!='0' and admin_id!='' AND admin_id IS NOT NULL ".$_SESSION['where']."";
							$ptr_therapist=mysql_query($therapist);
							while($data_ptr_therapist=mysql_fetch_array($ptr_therapist))
							{
								$therapist_nm="select name,admin_id from site_setting where admin_id='".$data_ptr_therapist['admin_id']."'";
							$ptr_therapist_nm=mysql_query($therapist_nm);
							$nm=mysql_fetch_array($ptr_therapist_nm);
								$sel='';
								if($nm['admin_id']==$_REQUEST['therapist_name'])
								{
									$sel='selected="selected"';
								}
								else
								{
									$sel='';
								}
								echo '<option '.$sel.' value="'.$nm['admin_id'].'" > '.$nm['name'].'</option>';
							} */
						?>
					</select>
				</td> -->
				
				 <td width="10%">
                         <input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>">
                         </td>
                         
                         <td width="10%">
                         <input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>">
                         </td>
				
				<td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                <? } ?>
				
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
						else
							$keyword='';
                        if($keyword)
                            $pre_keyword=" and (name like '%".$keyword."%')";
                        else
                            $pre_keyword="";
						
						if($_REQUEST['therapist_name']!='')
							{
								$therapist_name=" and admin_id='".$_REQUEST['therapist_name']."'";
							}
							else
							{
								$therapist_name='';
							}
						
						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						 {
							 $frm_date=explode("/",$_REQUEST['from_date']);
							$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							
						  	$pre_from_date=" and cs.added_date >='".date('Y-m-d',strtotime($frm_dates))."'";
							
							$pre_from_date1=" and sp.added_date >='".date('Y-m-d',strtotime($frm_dates))."'";
							
							$pre_from_date_cust=" and added_date >='".date('Y-m-d',strtotime($frm_dates))."'";
							
							$enquiry_from_date=" and added_date >='".date('Y-m-d',strtotime($frm_dates))."'";
						 }
						else
						{
							$pre_from_date=""; 
							$pre_from_date1="";
							$pre_from_date_cust="";                           
						}
						
						if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
						{
							 $to_date=explode("/",$_REQUEST['to_date']);
							$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
							
							 $pre_to_date=" and cs.added_date<='".date('Y-m-d',strtotime($to_dates))."'";
							 
							 $pre_to_date1=" and sp.added_date<='".date('Y-m-d',strtotime($to_dates))."'";
							
							$pre_to_date_cust=" and added_date<='".date('Y-m-d',strtotime($to_dates))."' ";
							
							$enquiery_to_date=" and added_date<='".date('Y-m-d',strtotime($to_dates))."'";
						}
						else
						{
							$pre_to_date="";
							$pre_to_date1="";
							$pre_to_date_cust="";
						}
						

                        if($_REQUEST['page'])
                            $page=$_REQUEST['page'];
                        else
                            $page=0;
                        
                        if($_REQUEST['show_records'])
                            $show=$_REQUEST['show'];
                        else
                            $show=0;
						
						if($_REQUEST['branch_name'])
						{
							$sel_branch="select cm_id from site_setting where branch_name='".$_REQUEST['branch_name']."' and type='A'";
							$ptr_branch=mysql_query($sel_branch);
							$data_branch=mysql_fetch_array($ptr_branch);
							$cm_id=$data_branch['cm_id'];
							
							$branch_keyword="  and cm_id ='".$cm_id."'";
							$branch_keyword_p="and cm_id ='".$cm_id."'";
						}
						else {
							$branch_keyword="";
							$branch_keyword_p="";
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

                        if($_GET['orderby']=='service_name' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='service_name'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                            $select_directory='order by admin_id desc';  
						$record_cat_id='';
						$record_cat_idss='';
						if($_GET['record_id'] !='')
						{
							$record_cat_id="and admin_id='".$_GET['record_id']."' ";
							$record_cat_idss="and admin_id='".$_GET['record_id']."' ";
							
						}	
						$cmids="";
						if($_SESSION['where']!='')
						{
							$cmids=" and cs.cm_id='".$_SESSION['cm_id']."'";
						}
						
						
							$sql_query= "SELECT * FROM site_setting where 1 ".$cmids." ".$therapist_name."  ".$branch_keyword_p." ".$record_cat_idss." ".$pre_keyword." ".$select_directory." "; 
						
					
					                    
						//	$sql_query= "SELECT * FROM customer_service_map where 1 ".$record_cat_id." ".$where_serv_id." ".$_SESSION['where']." ".$branch_keyword." ".$pre_from_date."  ".$pre_to_date." ".$therapist_name." ".$pre_keyword." ".$select_directory.""; 
							
							
						
						
                       //echo $sql_query;
                        $no_of_records=mysql_num_rows($db->query($sql_query));
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword.'&branch_name='.$_REQUEST['branch_name'].'&therapist_name='.$_REQUEST['therapist_name'].'&from_date='.$_REQUEST['from_date'].'&to_date='.$_REQUEST['to_date'];
                            $query_string1=$query_string.$date_query;
                           // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
    <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                     <input type="hidden" name="formAction" id="formAction" value=""/>
                      <tr class="grey_td" >
					    <td width="2%" align="center" rowspan="2"><strong>Sr. No.</strong></td>
						<?php
						if($_SESSION['type']=="S")
						{?>
							<td width="2%" align="center" rowspan="2"><strong>Branch</strong></td>
						<?php
						}
						?>
                        <td width="10%" rowspan="2"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=service_name".$query_string;?>" class="table_font"><strong>Staff Name</strong></a> <?php echo $img1;?></td>
                        <td width="10%" align="center" colspan="2"><strong>Service Incentive</strong>
						
						</td>
						 <td width="8%" align="center" rowspan="2"><strong>Product Incentive</strong></td>
                     
                        <td width="8%" align="center" rowspan="2"><strong>Membership</strong></td>
						
						 <td width="8%" align="center" rowspan="2"><strong>Including GST Cost</strong></td>
                       
							<td width="8%" align="center" rowspan="2"><strong>Excluding GST Cost</strong></td>
							
							<td width="46%" align="center" colspan="6"><strong>Incentive Applied</strong>
							
							</td>
						
						<td width="8%" align="center" rowspan="2"><strong>Total</strong></td>
                     
                      </tr>
					  
					  <tr class="grey_td" >
					  
                      
						<td align="center" ><strong>Booked</strong></td>
						<td align="center"><strong>Excuted</strong></td>
						
							
							
							<td align="center" colspan="2"><strong>Slab 1</strong></td>
							<td align="center" colspan="2"><strong>Slab 2</strong></td>
							<td align="center" colspan="2"><strong>Slab 3</strong></td>
						
                     
                      </tr>
                            <?php

                            while($val_querys=mysql_fetch_array($all_records))
                            {
							
								
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                
                               
                                
                                $position=120; // Define how many character you want to display.                                
                                $post = substr(strip_tags($val_query['service_description']), 0, $position);
                                
                                include "include/paging_script.php";
                                
							
                                echo '<tr '.$bgcolor.' >';
								
                                echo '<td align="center">'.$sr_no.'</td>';  
								if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
								{
								$sql_branch = "  select branch_name, cm_id from site_setting where cm_id='".$val_querys['cm_id']."' ";
								$ptr_branch = mysql_query($sql_branch);
								$data_branch = mysql_fetch_array($ptr_branch);
								
								echo '<td align="center">'.$data_branch['branch_name'].'</td>';
								}
								
									echo '<td >'.$val_querys['name'].
									'</td>';
								
							 
								  $select_service_name= "SELECT sum(csm.total_price) as s_amt FROM customer_service_map csm, customer_service cs where 1 and csm.customer_service_id=cs.customer_service_id and csm.admin_id=".$val_querys['admin_id']." ".$pre_from_date."  ".$pre_to_date." "; 
								 $ptr_ser = mysql_query($select_service_name);
								$s_total = mysql_fetch_array($ptr_ser);
								$e_tot= $s_total['s_amt']; 
								
								$select_service_book= "SELECT sum(total_cost) as b_amt FROM customer_service where 1 and staff_id=".$val_querys['admin_id']." ".$pre_from_date_cust."  ".$pre_to_date_cust." "; 
								 $ptr_ser_book = mysql_query($select_service_book);
								$b_total = mysql_fetch_array($ptr_ser_book);
								$b_tot= $b_total['b_amt']; 
								echo '<td width="5%" align="center">'.intval($b_tot).'</td>
								<td width="5%" align="center">'.intval($e_tot).'</td>';
								
								$select_product_book= "SELECT sum(spm.sales_product_price) as p_amt FROM sales_product_map spm, sales_product sp where 1 and spm.sales_product_id=sp.sales_product_id and spm.staff_id=".$val_querys['admin_id']." ".$pre_from_date1."  ".$pre_to_date1." "; 
								 $ptr_prod_book = mysql_query($select_product_book);
								$p_total = mysql_fetch_array($ptr_prod_book);
								$p_tot= $p_total['p_amt']; 
								echo '<td align="center">'.intval($p_tot).'</td>';
								
								$select_memb_book= "SELECT sum(price) as m_amt FROM customer where 1 and membership='yes' and memb_added_by=".$val_querys['admin_id']." ".$pre_from_date_cust."  ".$pre_to_date_cust." "; 
								 $ptr_memb_book = mysql_query($select_memb_book);
								$m_total = mysql_fetch_array($ptr_memb_book);
								$m_tot= $m_total['m_amt']; 
								echo '<td align="center">'.intval($m_tot).'</td>';
								
								echo '<td align="center">'.$total=intval($m_tot)+intval($p_tot)+intval($b_tot)+intval($e_tot).'</td>';
								$cgst=9;
								$sgst=9;
								 "</br>".$totalgst=$cgst+$sgst;
								 "</br>".$new_total_tax=(($totalgst+100)/100);
								 "</br>".$total_taxable_value = $total / $new_total_tax;
								 "</br>".$total_gst =$total - $total_taxable_value;
								
								
								echo '<td align="center">'.intval($total_taxable_value).'</td>';
	$inc_range = "select * from pr_add_service_incentive_details where staff_id='".$val_querys['admin_id']."' ORDER BY s_id ASC";
$range = mysql_query($inc_range);
$nos=mysql_num_rows($range);
$i=1;
$diff='';
$grand_tot='';
if($nos!='')
{
	
while($row = mysql_fetch_array($range))
{
	echo '<td width="5%"><table><tr>';	
	echo '<td width="5%" align="center"><strong>'.$row['s_from'].' TO '.$row['s_to'].'</strong></td>';	

	echo '</tr></table></td>';		
	
	echo '<td width="5%"><table><tr>';			

	$range_diff=$row['s_to']-$row['s_from'];
if($total_taxable_value > $row['s_to'])
{
	if($i==3 && $total_taxable_value > $row['s_to'])
	{
	$at=$total_taxable_value-$diff;
	$inc_amount=$at*$row['s_percentage']/100;	
	}
	else
	{
	$inc_amount=$range_diff*$row['s_percentage']/100;
	}
}
else 
{
	if($total_taxable_value>$row['s_from'])
		
		{
		$amt=$total_taxable_value-$row['s_from'];
		}
	else
	{
		$amt=0;
	}
	$inc_amount=($amt)*$row['s_percentage']/100;
}
$tot_ser_incentive+=$inc_amount;

echo '<td width="5%" align="center">'.number_format((float)$inc_amount, 2, '.', '').'</td>';

  
 
								
	echo '</tr></table></td>';
	$grand_tot +=$inc_amount;
	$diff +=$range_diff;
	$i++;						
	} 	
}
else{
	echo '<td width="5%"><table><tr>';	
echo '<td width="5%" align="center">0</td>';
	
	echo '</tr></table></td>';	

	echo '<td width="5%"><table><tr>';	
echo '<td width="5%" align="center">0</td>';
	
	echo '</tr></table></td>';	

	echo '<td width="5%"><table><tr>';	
echo '<td width="5%" align="center">0</td>';
	
	echo '</tr></table></td>';	

echo '<td width="5%"><table><tr>';	
echo '<td width="5%" align="center">0</td>';
	
	echo '</tr></table></td>';	

	echo '<td width="5%"><table><tr>';	
echo '<td width="5%" align="center">0</td>';
	
	echo '</tr></table></td>';	

	echo '<td width="5%"><table><tr>';	
echo '<td width="5%" align="center">0</td>';
	
	echo '</tr></table></td>';			
}	
 
   echo '<td align="center">'.number_format((float)$grand_tot, 2, '.', '').'</td>';                             
								
                                echo '</tr>';
                               $bgColorCounter++;
                            }    
                                ?>
  
 
  
 
  <tr class="head_td">
    <td colspan="17">
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
