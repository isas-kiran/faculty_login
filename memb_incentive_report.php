<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Membership Incentive Report (Therapist Wise)</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
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
               
				<?php if($_SESSION['type']=='S')
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
				
				<td width="15%">
					<select name="therapist_name" id="therapist_name"  class="input_select_login"  style="width: 150px; ">
						<option value="">-Sold By-</option>
						<?php 
							$therapist="select DISTINCT memb_added_by from customer where 1 and memb_added_by!='0' and memb_added_by!='' AND memb_added_by IS NOT NULL ".$_SESSION['where']."";
							$ptr_therapist=mysql_query($therapist);
							while($data_ptr_therapist=mysql_fetch_array($ptr_therapist))
							{
								$therapist_nm="select name,admin_id from site_setting where admin_id='".$data_ptr_therapist['memb_added_by']."'";
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
							}
						?>
					</select>
				</td>
				
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
                            $pre_keyword=" and (service_name like '%".$keyword."%' || service_description like '%".$keyword."%' || service_price like '%".$keyword."%' || service_time like '%".$keyword."%' || service_code like '%".$keyword."%' || status like '%".$keyword."%')";
                        else
                            $pre_keyword="";
						
						if($_REQUEST['therapist_name']!='')
							{
								$therapist_name=" and csm.memb_added_by='".$_REQUEST['therapist_name']."'";
							}
							else
							{
								$therapist_name='';
							}
						
						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						 {
							 $frm_date=explode("/",$_REQUEST['from_date']);
							$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							
						  	$pre_from_date=" and csm.added_date >='".date('Y-m-d',strtotime($frm_dates))."'";
							
							$installment_from_date=" and added_date >='".date('Y-m-d',strtotime($frm_dates))."'";
							
							$enquiry_from_date=" and added_date >='".date('Y-m-d',strtotime($frm_dates))."'";
						 }
						else
						{
							$pre_from_date=""; 
							$enquiry_date="";
							$installment_from_date="";                           
						}
						
						if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
						{
							 $to_date=explode("/",$_REQUEST['to_date']);
							$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
							
							 $pre_to_date=" and csm.added_date<='".date('Y-m-d',strtotime($to_dates))."'";
							
							$installment_to_date=" and added_date<='".date('Y-m-d',strtotime($to_dates))."' ";
							
							$enquiery_to_date=" and added_date<='".date('Y-m-d',strtotime($to_dates))."'";
						}
						else
						{
							$pre_to_date="";
							$enquiery_to_date="";
							$installment_to_date="";
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
							$branch_keyword_p="and cs.cm_id ='".$cm_id."'";
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
                            $select_directory='order by cust_id desc';  
						$record_cat_id='';
						$record_cat_idss='';
						if($_GET['record_id'] !='')
						{
							$record_cat_id="and cust_id='".$_GET['record_id']."' ";
							$record_cat_idss="and cs.cust_id='".$_GET['record_id']."' ";
							
						}	
						$cmids="";
						if($_SESSION['where']!='')
						{
							$cmids=" and cs.cm_id='".$_SESSION['cm_id']."'";
						}
						
						
							$sql_query= "SELECT distinct(csm.cust_id) as cust_id,csm.price as price, csm.memb_added_by as memb_added_by,csm.membership_id as membership_id  FROM customer csm, membership m, site_setting ss where 1 and (csm.price like '%".$keyword."%' or csm.cust_name like '%".$keyword."%' or csm.mobile1 like '%".$keyword."%' or ss.name like '%".$keyword."%') and csm.membership_id=m.membership_id and ss.admin_id=csm.memb_added_by and  csm.membership='yes' ".$cmids." ".$pre_from_date."  ".$pre_to_date." ".$therapist_name."  ".$branch_keyword_p." ".$record_cat_idss." ".$where_service_id." ".$select_directory.""; 
						
					
					                    
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
					  <?php
					  if($_SESSION['type']=="S")
					  {
					  ?>
                        <td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
						<?php
					  } ?>
                        <td width="5%" align="center"><strong>Sr. No.</strong></td>
						<?php
						if($_SESSION['type']=="S")
						{?>
							<td width="6%" align="center"><strong>Branch</strong></td>
						<?php
						}
						?>
                        <td width="10%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=service_name".$query_string;?>" class="table_font"><strong>Customer Name</strong></a> <?php echo $img1;?></td>
                        <td width="25%" align="center"><strong>Membership Name</strong></td>
						 <td width="25%" align="center"><strong>Membership Added By</strong></td>
                     
                        <td width="8%" align="center"><strong> Cost</strong></td>
						
						 <td width="8%" align="center"><strong>Excluding GST Cost</strong></td>
                       
                     
						
                        <td width="10%" align="center"><strong>Added Date</strong></td>
						
                    
                      </tr>
                            <?php

                            while($val_querys=mysql_fetch_array($all_records))
                            {
								
								$selct_all_rec = " select * from `customer` where cust_id= '".$val_querys['cust_id']."' ";
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
                                
								 $sel_cust_name="select cust_name,mobile1 from customer where cust_id='".$val_query['cust_id']."'";
								$ptr_cust=mysql_query($sel_cust_name);
								$data_cust_name=mysql_fetch_array($ptr_cust);
                                echo '<tr '.$bgcolor.' >';
								if($_SESSION['type']=="S")
								{
                                      echo '<td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
								}
                                echo '<td align="center">'.$sr_no.'</td>';  
								if($_SESSION['type']=="S")
								{
								$sql_branch = "  select branch_name, cm_id from site_setting where cm_id='".$val_query['cm_id']."' ";
								$ptr_branch = mysql_query($sql_branch);
								$data_branch = mysql_fetch_array($ptr_branch);
								
								echo '<td align="center">'.$data_branch['branch_name'].'</td>';
								}
								$sel_cust_inv="select invoice_id from customer_service_invoice where customer_service_id='".$listed_record_id."'";   
								$ptr_cust_inv=mysql_query($sel_cust_inv); 
							    if(mysql_num_rows($ptr_cust_inv)>1)
								{
									echo '<td >'.$data_cust_name['cust_name'].'<br>'.$data_cust_name['mobile1'].
									'</td>';
								}
								else
                                {
									//if($val_query['cgst_tax'] >0)
									echo '<td >'.$data_cust_name['cust_name'].'<br>'.$data_cust_name['mobile1'].'</td>';
									//else
									//echo '<td ><a href="add_cust_services.php?record_id='.$listed_record_id.'" >'.$data_cust_name['cust_name'].'<br>'.$data_cust_name['mobile1'].'</a></td>';
								}
								
								
								//echo ">>>>>>>>>>>".$val_querys['service_id'];
								echo '<td align="center">';
								
								
								$select_service_name="select membership_name from membership where membership_id='".$val_querys['membership_id']."'";
									$ptr_service=mysql_query($select_service_name);
									$data_service_name=mysql_fetch_array($ptr_service);
									echo $data_service_name['membership_name'];
								
								echo '</td>';
								
								 $sel_th="select admin_id,name from site_setting where admin_id='".$val_querys['memb_added_by']."'";
								$ptr_th=mysql_query($sel_th);
								$therapist_name=mysql_fetch_array($ptr_th);
								echo '<td >'.$therapist_name['name'].
									'</td>';
								
								echo '<td align="center">'.$val_querys['price'].'</td>';
								$cgst=9;
								$sgst=9;
								 "</br>".$totalgst=$cgst+$sgst;
								 "</br>".$new_total_tax=(($totalgst+100)/100);
								 "</br>".$total_taxable_value = $val_querys['price'] / $new_total_tax;
								 "</br>".$total_gst =$val_querys['price'] - $total_taxable_value;
								
								
								echo '<td align="center">'.intval($total_taxable_value).'</td>';
								if($val_query['remaining_amount']==0)
								{
									$update_service="update customer_service set status='Completed' where customer_service_id='".$listed_record_id."'";
									$ptr_update=mysql_query($update_service);
								}
								
							
								$sep_s=explode(" ",$val_query['added_date']);
								$date_sep=explode("-",$sep_s[0]);
								$dates=$date_sep[2]."/".$date_sep[1]."/".$date_sep[0];
								echo '<td align="center">'.$dates.'</td>';
								
                                
								
                                echo '</tr>';
                                $tot +=$val_querys['price'];   
								$tot_gst +=$total_taxable_value;   								
                                $bgColorCounter++;
                            }    
                                ?>
  
  <tr>
  <td colspan="6">
  <b>Total</b>
  </td>
  <td>
 <b> <?php echo $tot; ?></b>
  </td>
   <td colspan="2">
 <b> <?php echo intval($tot_gst); ?></b>
  </td>
  </tr>
   <?php
   $inc_range = "select * from pr_add_service_incentive_details where staff_id='".$_REQUEST['therapist_name']."' ORDER BY s_id ASC";
$range = mysql_query($inc_range);

while($row = mysql_fetch_array($range))
{
	$range_diff=$row['s_to']-$row['s_from'];
if($tot_gst > $row['s_to'])
{
	$inc_amount=$range_diff*$row['s_percentage']/100;
}
else 
{
	if($tot_gst>$row['s_from'])
		
		{
		$amt=$tot_gst-$row['s_from'];
		}
	else
	{
		$amt=0;
	}
	$inc_amount=($amt)*$row['s_percentage']/100;
}
$tot_ser_incentive+=$inc_amount;

	
  ?>
  <tr>
  <td colspan="7">
  <b>Range - <?php echo $row['s_from']; ?> TO <?php echo $row['s_to']; ?> (<?php echo $row['s_percentage']; ?> %)</b>
  </td>
 
  <td colspan="2">
 <b> <?php echo intval($inc_amount); ?></b>
  </td>
   
  </tr>
<?php } ?>
 <tr>
  <td colspan="7">
  <b>Total Incentive</b>
  </td>
 
  <td colspan="2">
 <b> <?php echo intval($tot_ser_incentive); ?></b>
  </td>
   
  </tr>
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
