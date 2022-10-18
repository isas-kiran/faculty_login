<?php include 'inc_classes.php';?>
<!--ENROLLMENT INCOMMING GST REPORT WITH NO GST NO OF STUDENT-->
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>GST Summury Report</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
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
    <td class="top_mid" valign="bottom"><?php include "include/financial_report_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
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
    <td colspan="10">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
    <?php
	if($_REQUEST['from_date'] =='')
	{
		?>
		
		<?php
	}
	?>
              <tr>
                <?php if($_SESSION['type']=='S')
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
                <!--<td width="20%">
                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                <option value="">-Operation-</option>
                                <option value="delete">Delete</option>
                        </select></td>-->
						
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
						{                            
							$pre_keyword =" and (name like '%".$keyword."%' )";
							$pre_keyword_i =" and (e.name like '%".$keyword."%' )";
						}                            
                        else
						{
                            $pre_keyword="";
							$pre_keyword_i ="";
						}
						if($_REQUEST['gst_student']!="")
							$gst_keyword =trim($_REQUEST['gst_student']);
						
						$search_cm_id='';
						$cm_ids=$_SESSION['cm_id'];
						if($_SESSION['type']=="S")
						{
							if($_REQUEST['branch_name']!='')
							{
								$branch_name=$_REQUEST['branch_name'];
								$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_cm_id=mysql_query($select_cm_id);
								$data_cm_id=mysql_fetch_array($ptr_cm_id);
								$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
								$sales_search_cm_id=" and sp.cm_id='".$data_cm_id['cm_id']."'";
								$prod_search_cm_id=" and ip.cm_id='".$data_cm_id['cm_id']."'";
								$exp_search_cm_id=" and e.cm_id='".$data_cm_id['cm_id']."'";
								$cm_ids=$data_cm_id['cm_id'];
							}
							else
							{
								$search_cm_id='';
								$sales_search_cm_id='';
								$prod_search_cm_id='';
								$exp_search_cm_id='';
							}
						}
						if($gst_keyword)
						{
							if($gst_keyword=="with_gst")
							{
								$where_gst =" and e.cust_gst_no !=''";
								$where_gst_i =" and e.cust_gst_no !=''";
							}
							else if($gst_keyword=="without_gst")
							{
								$where_gst =" and e.cust_gst_no=''";
								$where_gst_i =" and e.cust_gst_no=''";
							}                            
							else
							{
								$where_gst="";
								$where_gst_i ="";
							}
						}                            
                        else
						{
                            $where_gst="";
							$where_gst_i ="";
						}
						
						$from_date="";
						$to_date="";
						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						{
							$frm_date=explode("/",$_REQUEST['from_date']);
							$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							
							$from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$sales_from_date=" and DATE(sp.added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$prod_from_date=" and DATE(ip.added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$exp_from_date=" and DATE(e.added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
						}
						if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
						{
							$to_dates=explode("/",$_REQUEST['to_date']);
							$to_date1=$to_dates[2]."-".$to_dates[1]."-".$to_dates[0];
							
							$to_date=" and DATE(added_date)<='".$to_date1."'";
							$sales_to_date=" and DATE(sp.added_date)<='".$to_date1."'";
							$prod_to_date=" and DATE(ip.added_date)<='".$to_date1."'";
							$exp_to_date=" and DATE(e.added_date)<='".$to_date1."'";
						}
						if($_REQUEST['inq'])
						{
							$inquiry=$_REQUEST['inq'];
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
                        if($_GET['orderby']=='name' )
                            $img1 = $img;
                        if($_GET['order'] !='' && ($_GET['orderby']=='firstname'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
							$select_directory='order by i.invoice_id desc';                     
							$where_cm='';
							if($_SESSION['where']!='')
							{
								$where_cm=" and i.cm_id='".$_SESSION['cm_id']."'";
							}
							$branch_id='';
                       		 
                       		
						
								?>

   

				<form method="post"  name="frmTakeAction"  action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>">
                     <input type="hidden" name="formAction" id="formAction" value=""/>
                      <tr class="grey_td">
                        <td width="12%" align="center"><strong>Enrollment Incoming GST</strong></td>
                        <td width="15%" align="center"><strong>Product Incoming GST</strong></td>
                        <td width="15%" align="center"><strong>Service Incoming GST</strong></td>
						<td width="15%" align="center"><strong>Purchase Outgoing GST</strong></td>
						<td width="15%" align="center"><strong>Expense Outgoing GST</strong></td>
						
                      </tr>

                            <?php
							$total_paid=0;
							$total_gst_new=0;
							$monthly_expected=0;
							$total_down_cgst=0;
							$total_down_sgst=0;
							$total_down=0;
							$total_ins_cgst=0;
							$total_ins_sgst=0;
							$total_ins=0;
							$no=1;
							// ------------ For Enrollment --------------
                           "<br/>".$sel_inst_amnt="select SUM(cgst_tax) as cgst_total from invoice where 1 and amount>0 and type='down_payment'  and (cgst_tax_in_per >0 or sgst_tax_in_per >0) ".$search_cm_id." ".$from_date." ".$to_date."";
						  $ptr_name=mysql_query($sel_inst_amnt);
                          $data_name=mysql_fetch_array($ptr_name);
						  $total_down_cgst=$data_name['cgst_total'];
							
						"<br/>".$sel_inst_amnt1="select SUM(sgst_tax) as sgst_total from invoice where 1 and amount>0 and type='down_payment' and (cgst_tax_in_per >0 or sgst_tax_in_per >0) ".$search_cm_id." ".$from_date." ".$to_date."";
						  $ptr_name1=mysql_query($sel_inst_amnt1);
                          $data_name1=mysql_fetch_array($ptr_name1);
						  $total_down_sgst=$data_name1['sgst_total'];							
								
						  $total_down=$total_down_cgst+$total_down_sgst;	
							
						  "<br/>".$sel_inst_amnt2="select SUM(cgst_tax) as cgst_per_total from invoice where 1 and amount>0 and (type='' or type!='down_payment' or type is NULL) and (cgst_tax_in_per >0 or sgst_tax_in_per >0) ".$search_cm_id." ".$from_date." ".$to_date."";
						  $ptr_name2=mysql_query($sel_inst_amnt2);
                          $data_name2=mysql_fetch_array($ptr_name2);
						  $total_ins_cgst=$data_name2['cgst_per_total'];
							
						 "<br/>".$sel_inst_amnt3="select SUM(sgst_tax) as sgst_per_total from invoice where 1 and amount>0 and (type='' or type!='down_payment' or type is NULL) and (cgst_tax_in_per >0 or sgst_tax_in_per >0) ".$search_cm_id." ".$from_date." ".$to_date."";
						  $ptr_name3=mysql_query($sel_inst_amnt3);
                          $data_name3=mysql_fetch_array($ptr_name3);
						  $total_ins_sgst=$data_name3['sgst_per_total'];	
						  
						  $sel_total_cf="select SUM(cf_gst_amnt) as cf_gst_amnt from invoice where 1 and cf_gst_amnt>0 ".$search_cm_id." ".$from_date." ".$to_date."";
						  $ptr_cf=mysql_query($sel_total_cf);
                          $data_cf=mysql_fetch_array($ptr_cf);
						  $total_cf_gst=$data_cf['cf_gst_amnt'];						
								
						  $total_ins=$total_ins_cgst+$total_ins_sgst;
							
							// -------------- For product  --------------
							
							
							
						 "<br/>".$sel_inst_amnt4="select SUM(s.sgst_tax) as product_sgst_total,sp.added_date from sales_product_map s,sales_product sp where 1 and s.sales_product_id=sp.sales_product_id and (s.cgst_tax_in_per >0 or s.sgst_tax_in_per >0) and (sp.show_gst is NULL or sp.show_gst!='no') and sp.payable_amount>0 ".$sales_search_cm_id." ".$sales_from_date." ".$sales_to_date."";
						  $ptr_name4=mysql_query($sel_inst_amnt4);
                          $data_name4=mysql_fetch_array($ptr_name4);
						  $product_sgst_total=$data_name4['product_sgst_total'];	
						  
						  "<br/>".$sel_inst_amnt5="select SUM(s.cgst_tax) as product_cgst_total,sp.added_date from sales_product_map s,sales_product sp where 1 and s.sales_product_id=sp.sales_product_id and (cgst_tax_in_per >0 or sgst_tax_in_per >0) and (sp.show_gst is NULL or sp.show_gst!='no') and sp.payable_amount>0 ".$sales_search_cm_id." ".$sales_from_date." ".$sales_to_date."";
						  $ptr_name5=mysql_query($sel_inst_amnt5);
                          $data_name5=mysql_fetch_array($ptr_name5);
						  $product_cgst_total=$data_name5['product_cgst_total'];	
						  
						  // -------------- For Services  --------------
						  
						  "<br/>".$sel_inst_amnt6="select SUM(sgst_tax) as service_sgst_total from customer_service_invoice where 1 and (sgst_tax_in_percent >0) and (sgst_tax >0) ".$search_cm_id." ".$from_date." ".$to_date."";
						  $ptr_name6=mysql_query($sel_inst_amnt6);
                          $data_name6=mysql_fetch_array($ptr_name6);
						  $service_sgst_total=$data_name6['service_sgst_total'];	
						  
						  "<br/>".$sel_inst_amnt7="select SUM(cgst_tax) as service_cgst_total from customer_service_invoice where 1 and (cgst_tax_in_percent >0) and (cgst_tax >0) ".$search_cm_id." ".$from_date." ".$to_date."";
						  $ptr_name7=mysql_query($sel_inst_amnt7);
                          $data_name7=mysql_fetch_array($ptr_name7);
						  $service_cgst_total=$data_name7['service_cgst_total'];
						  
						  // -------------- For Purchase  --------------
							
							 "<br/>".$sel_inst_amnt8="select SUM(i.sgst_tax) as purchase_sgst_total,ip.added_date from inventory_product_map i,inventory_invoice ip where 1 and i.inventory_id=ip.inventory_id and (i.cgst_tax_in_per >0 or i.sgst_tax_in_per >0) ".$prod_search_cm_id." ".$prod_from_date." ".$prod_to_date."";
						  $ptr_name8=mysql_query($sel_inst_amnt8);
                          $data_name8=mysql_fetch_array($ptr_name8);
						  $purchase_sgst_total=$data_name8['purchase_sgst_total'];	
						  
						  "<br/>".$sel_inst_amnt9="select SUM(i.cgst_tax) as purchase_cgst_total,ip.added_date from inventory_product_map i,inventory_invoice ip where 1 and i.inventory_id=ip.inventory_id and (i.cgst_tax_in_per >0 or i.sgst_tax_in_per >0) ".$prod_search_cm_id." ".$prod_from_date." ".$prod_to_date."";
						  $ptr_name9=mysql_query($sel_inst_amnt9);
                          $data_name9=mysql_fetch_array($ptr_name9);
						  $purchase_cgst_total=$data_name9['purchase_cgst_total'];	
						  
						  // -------------- For Expense  --------------
							
							 "<br/>".$sel_inst_amnt4="select SUM(em.sgst_tax) as expense_sgst_total,e.added_date from expense_map em,expense e where 1 and (em.cgst_tax_in_per >0 or em.sgst_tax_in_per >0) and e.expense_id=em.expense_id ".$exp_search_cm_id." ".$exp_from_date." ".$exp_to_date."";
						  $ptr_name4=mysql_query($sel_inst_amnt4);
                          $data_name4=mysql_fetch_array($ptr_name4);
						  $expense_sgst_total=$data_name4['expense_sgst_total'];	
						  
						  "<br/>".$sel_inst_amnt5="select SUM(em.cgst_tax) as expense_cgst_total,e.added_date from expense_map em,expense e where 1 and (em.cgst_tax_in_per >0 or em.sgst_tax_in_per >0) and e.expense_id=em.expense_id ".$exp_search_cm_id." ".$exp_from_date." ".$exp_to_date."";
						  $ptr_name5=mysql_query($sel_inst_amnt5);
                          $data_name5=mysql_fetch_array($ptr_name5);
						  $expense_cgst_total=$data_name5['expense_cgst_total'];
						  
                                ?>

                                <tr class="grey_td">

    <td>
    	<table cellspacing="0" cellpadding="0" width="100%"  style="border:1 px solid #CCC; border-collapse:collapse">
        	<tr class="grey_td">
                <td width="31%" colspan="3" align="center">
                <span style='color:blue'><strong>Down Payment</strong></span><br/>CGST- <?php echo $total_down_cgst; ?><br/>SGST- <?php echo $total_down_sgst; ?><br/><span style='color:blue'><strong>Total- <?php echo $total_down; ?></strong></span></br>
				<span style='color:orange'><strong>Installments</strong></span><br/>CGST- <?php echo $total_ins_cgst; ?><br/>SGST- <?php echo $total_ins_sgst; ?><br/><span style='color:orange'><strong>Total- <?php echo $total_ins; ?></strong></span></br>
                <span style='color:violet'><strong>CF Amount</strong></span><br/><span style='color:violet'><strong>Total- <?php echo $total_cf_gst; ?></strong></span></br>
				<span style='color:red'><strong>Total</strong></span><br/>CGST- <?php echo $total_down_cgst+$total_ins_cgst; ?><br/>SGST- <?php echo $total_down_sgst+$total_ins_sgst; ?><br/><span style='color:red'><strong>Total- <?php echo $total_down+$total_ins+$total_cf_gst; ?></strong></span></td>
				<td width="15%"></td>
            </tr>
    	</table>
    </td>
<td>
    	<table cellspacing="0" cellpadding="0" width="100%"  style="border:1 px solid #CCC; border-collapse:collapse">
        	<tr class="grey_td">
                <td width="31%" colspan="3" align="center">
				<span style='color:blue'><strong>CGST- <?php echo $product_sgst_total; ?></strong></span></br>
				<span style='color:blue'><strong>SGST- <?php echo $product_cgst_total; ?></strong></span></br>
				<span style='color:red'><strong>Total- </strong></span><span style='color:red'><strong><?php echo $product_sgst_total+$product_cgst_total; ?></strong></span></td>
				<td width="15%"></td>
            </tr>
    	</table>
    </td>
	
	<td>
    	<table cellspacing="0" cellpadding="0" width="100%"  style="border:1 px solid #CCC; border-collapse:collapse">
        	<tr class="grey_td">
                <td width="31%" colspan="3" align="center">
				<span style='color:blue'><strong>CGST- <?php echo ($service_sgst_total); ?></strong></span></br>
				<span style='color:blue'><strong>SGST- <?php echo ($service_cgst_total); ?></strong></span></br>
				<span style='color:red'><strong>Total- </strong></span><span style='color:red'><strong><?php echo ($service_sgst_total+$service_cgst_total); ?></strong></span></td>
				<td width="15%"></td>
            </tr>
    	</table>
    </td>
	
	<td>
    	<table cellspacing="0" cellpadding="0" width="100%"  style="border:1 px solid #CCC; border-collapse:collapse">
        	<tr class="grey_td">
                <td width="31%" colspan="3" align="center">
				<span style='color:blue'><strong>CGST- <?php echo $purchase_sgst_total; ?></strong></span></br>
				<span style='color:blue'><strong>SGST- <?php echo $purchase_cgst_total; ?></strong></span></br>
				<span style='color:red'><strong>Total- </strong></span><span style='color:red'><strong><?php echo $purchase_sgst_total+$purchase_cgst_total; ?></strong></span></td>
				<td width="15%"></td>
            </tr>
    	</table>
    </td>
	
	<td>
    	<table cellspacing="0" cellpadding="0" width="100%"  style="border:1 px solid #CCC; border-collapse:collapse">
        	<tr class="grey_td">
                <td width="31%" colspan="3" align="center">
				<span style='color:blue'><strong>CGST- <?php echo $expense_sgst_total; ?></strong></span></br>
				<span style='color:blue'><strong>SGST- <?php echo $expense_cgst_total; ?></strong></span></br>
				<span style='color:red'><strong>Total- </strong></span><span style='color:red'><strong><?php echo $expense_sgst_total+$expense_cgst_total; ?></strong></span></td>
				<td width="15%"></td>
            </tr>
    	</table>
    </td>
	
    </tr>
    <tr class="head_td">
    <td colspan="3">
	<center><strong> Total =
       <?php
          echo $incoming=$total_down+$total_ins+$total_cf_gst+$product_sgst_total+$product_cgst_total+$service_sgst_total+$service_cgst_total;
		 ?>
       </strong></center>
    </td>
 <td colspan="3">
 <center><strong> Total =
    <?php
			echo $outgoing=$purchase_sgst_total+$purchase_cgst_total+$expense_sgst_total+$expense_cgst_total;
					
			     ?>
      </strong></center>
    </td>
    </tr>
<tr class="head_td">
    <td colspan="15">
	<center><strong> Total =
       <?php
          echo $incoming-$outgoing;
		 ?>
       </strong></center>
    </td>
 
    </tr>
  

  

  </form>

 

      

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

