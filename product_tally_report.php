<?php 
//Change Note - 
//Changes on 9-5-20 by kiran - change is in calculation, change calculation on Base price on the fly and avoid to direct take value from database, only taking base price and gst percentage and in Export file aldo show Orignal DB valu in Column M and difference N
include 'inc_classes.php';
include "admin_authentication.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Product Tally Report</title>
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
    <style>
	.table11 {
		border-collapse: collapse !important;
		margin: 0px !important;
		border: 1px !important;
	}
	.table11 td {
		border: solid 1px #DDDDDD !important;
		height: 30px !important;
		padding: 0px 3px !important;
	}
	</style>
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
                            <tr>
        						<td class="width5"></td>
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
                                <td width="12%" align="center"><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                                <td width="10%" align="center">
                                 <input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>">
                                </td>
                                <td width="10%" align="center">
                                <input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>">
                                </td>
                                <td width="10%" align="center">
                                <select name="pay_type" class="input_select">
                                    <option value="">--Select Payment Mode--</option>
                                    <?php
                                    $sel_payment_mode="select payment_mode,payment_mode_id from payment_mode where 1";
                                    //and (payment_mode_id=2 or payment_mode_id=4 or payment_mode_id=5)
                                    $ptr_payment_mode=mysql_query($sel_payment_mode);
                                    $selctds='';
                                    while($data_payment=mysql_fetch_array($ptr_payment_mode))
                                    {
                                        $selected='';
                                        if($data_payment['payment_mode_id'] == $_REQUEST['pay_type'])
                                        {
                                            $selected='selected="selected"';
                                            $selctds = $data_payment['payment_mode'].'-'.$data_payment['payment_mode_id'];
                                        }
                                        echo '<option '.$selected.' value="'.$data_payment['payment_mode_id'].'">'.$data_payment['payment_mode'].'</option>';
                                    }
                                    ?>
                                </select>
                                </td>
                                <td width="10%" align="center">
                                    <select name="bank_id" class="input_select">
                                        <option value="">--Select Bank--</option>
                                        <?php 
                                        $course_category="select DISTINCT(cm_id),branch_name from site_setting where type='A' ".$_SESSION['where']."";
                                        $ptr_course_cat=mysql_query($course_category);
                                        while($data_cat=mysql_fetch_array($ptr_course_cat))
                                        {
                                            echo "<optgroup label='".$data_cat['branch_name']."'>";
                                            $sel_source="SELECT * FROM bank where 1 and cm_id='".$data_cat['cm_id']."' ";
                                            $ptr_src=mysql_query($sel_source);
                                            while($data_src=mysql_fetch_array($ptr_src))
                                            {
                                                ?>
                                                <option value="<?php echo $data_src['bank_id']?>" <? if($_POST['bank_id'] == $data_src['bank_id']) echo "selected"; else if ( $data_src['bank_id'] == $_REQUEST['bank_id']) echo "selected";?> > <?php echo $data_src['bank_name'] ?> </option>
                                                <?
                                            }
                                            echo "</optgroup>";
                                        }?>
                                    </select>
                                </td>
                                <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                                <td width="10%"><input type="reset" name="reset" value="Reset" class="inputButton"/></td>
                                <td><a href="product_tally_export.php<?php echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a></td>  
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
                $pre_keyword_i =" and (i.total_price like '%".$keyword."%')";
            }                            
            else
            {
                $pre_keyword="";
                $pre_keyword_i ="";
            }
            
            if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
            {
                $frm_date=explode("/",$_REQUEST['from_date']);
                $frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
                
                $pre_from_date=" and DATE(admission_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
                $installment_from_date=" and DATE(`installment_date`) >='".date('Y-m-d',strtotime($frm_dates))."'";
                $paid_from_date=" and DATE(i.added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
                $paid_from_date_i=" and DATE(s.added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
            }
            else
            {
                $pre_from_date=""; 
                if($_REQUEST['to_date']=='')
                {
                    $paid_from_date_i=" and DATE(s.added_date) >='".date('Y-m-d',strtotime('-30 days'))."'";
                    $paid_from_date=" and DATE(i.added_date) >='".date('Y-m-d',strtotime('-30 days'))."'";
                }
                else
                {
                    $paid_from_date="";
                    $paid_from_date_i="";
                }
                $installment_from_date="";                           
            }
            if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
            {
                $to_date=explode("/",$_REQUEST['to_date']);
                $to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
                
                $pre_to_date=" and DATE(`admission_date`) <='".date('Y-m-d',strtotime($to_dates))."'";
                $installment_to_date=" and DATE(`installment_date`)<='".date('Y-m-d',strtotime($to_dates))."' ";
                $paid_to_date=" and DATE(i.added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
                $paid_to_date_i=" and DATE(s.added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
            }
            else
            {
                $pre_to_date="";
                $installment_to_date="";
                $paid_to_date=" ";
                $paid_to_date_i=" and DATE(s.added_date)<='".date('Y-m-d')."'";
                $paid_to_date=" and DATE(i.added_date)<='".date('Y-m-d')."'";
            }
            $pay_type=""; //and (i.paid_type='2' or i.paid_type='4' or i.paid_type='5')
            if($_REQUEST['pay_type'] !='')
            {
                $pay_type=" and i.paid_type='".$_REQUEST['pay_type']."'";
            }
            $bank_ids="";
            if($_REQUEST['bank_id'] !='')
            {
                $bank_ids=" and i.bank_id='".$_REQUEST['bank_id']."'";
            }
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
                    $search_cm_id=" and i.cm_id='".$data_cm_id['cm_id']."'";
                    $cm_ids=$data_cm_id['cm_id'];
                }
                else
                {
                    $search_cm_id='';
                }
            }
            else
            {
                $search_cm_id='';
                if($_SESSION['where']!='')
                {
                    $search_cm_id=" and i.cm_id='".$_SESSION['cm_id']."'";
                }
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
                $select_directory='order by DATE(e.added_date) asc';                     
            
            //$sql_query= "select i.* from sales_product i where 1 ".$search_cm_id." ".$pre_keyword_i." ".$pay_type." ".$bank_ids." ".$paid_from_date." ".$paid_to_date." ".$select_directory." "; 
            $sql_query= "select i.*, e.receipt_no from sales_product_invoice e, sales_product i where 1  and i.sales_product_id=e.sales_product_id ".$search_cm_id." ".$pre_keyword_i." ".$pay_type." ".$bank_ids." ".$paid_from_date." ".$paid_to_date." group by sales_product_id ".$select_directory." "; //
            $my_db=mysql_query($sql_query);
            $no_of_records=mysql_num_rows($my_db);
                
            if($no_of_records)
            {
                $bgColorCounter=1;
				/*$query_string='&keyword='.$keyword.'&branch_name='.$_REQUEST['branch_name'].'&from_date= '.$_REQUEST['from_date'].'&to_date= '.$_REQUEST['to_date'].'&bank_id='.$_REQUEST['bank_id'].'&pay_type='.$_REQUEST['pay_type'];
				$query_string1=$query_string.$date_query;
				$pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
				$pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
				$all_records= $pager->paginate();*/
				?>
                <form method="post"  name="frmTakeAction"  action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>">
                    <input type="hidden" name="formAction" id="formAction" value=""/>
                    <tr class="grey_td" >
                        <!--<td width="4%" align="center"><strong>Sr. No.</strong></td>
                        <td width="5%" align="center">Receipt No.</td>
                        <td  width="15%" align="center"><strong>Customer Name</strong></td>
                        <td width="35%" align="center">
                            <table width="100%">
                                <tr>
                                    <td align="center" width="40%">Product Name</td>
                                    <td align="center" width="10%">Quantity</td>
                                    <td align="center" width="15%">Price</td>
                                    <td align="center" width="10%">CGST</td>
                                    <td align="center" width="10%">SGST</td>
                                    <td align="center" width="10%">IGST</td>
                                    <td align="center" width="20%">Total</td>
                                </tr>
                            </table>
                        </td>
                        <td width="6%" align="center">Payment Type</td>
                        <td width="10%" align="center">Bank Name</td>
                        <td width="10%" align="center">Bank Details</td>
                        <td width="5%" align="center">Deposit Amount</td>
                        <td width="5%" align="center">Added Date</td>-->
                        <td width="8%" align="center">Date</td>
                        <td width="8%" align="center">Vochure No.</td>
                        <!--<td width="8%" align="center">Vochure Type</td>-->
                        <td width="8%" align="center">Sub-Vochure Type</td>
                        <td width="15%" align="center"><strong>Party</strong></td>
                        <td width="48%" align="center" colspan="6">
                            <table>
                                <tr>
                                    <td width="40%" align="center">Account</td>
                                    <td width="20%" align="center">Product</td>
                                    <td width="10%" align="center">Qty</td>
                                    <td width="10%" align="center">Rate</td>
                                    <td width="8%" align="center">Disc. Rate</td>
                                    <td width="10%" align="center">Amount</td>
                                </tr>
                            </table>
                        </td>
                        <!--<td width="12%" align="center">Cost Center</td>-->
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
                    
                    while($val_query=mysql_fetch_array($my_db))
                    {
                        $total_amnts=0;
                        $total_price=0;
                        
                        if($bgColorCounter%2==0)
                            $bgcolor='class="grey_td"';
                        else
                            $bgcolor=""; 
                            $listed_record_id=$val_query['sales_product_id'];
                        //include "include/paging_script.php";
                        echo '<tr '.$bgcolor.'>';
                        //echo '<td align="center">'.$sr_no.'</td>';
                        
                        /*$sel_branch= " select branch_name from site_setting where cm_id='".$val_query['cm_id']."'";
                        $ptr_branch= mysql_query($sel_branch);
                        $data_branch = mysql_fetch_array($ptr_branch);
                        
                        if($_SESSION['type']=="S")
                        {
                            echo '<td align="center">'.$data_branch['branch_name'].'</td>';
                        }*/
                        $sep=explode(" ",$val_query['added_date']);
                        $sep_date=explode("-",$sep[0]);
                        $date=$sep_date[2]."/".$sep_date[1]."/".$sep_date[0];
                        echo "<td align='center'>".$date."</td>";
                        
                        echo '<td align="center">'.$val_query['ext_invoice_no'].'</td>';
                        //echo '<td align="center">Sales</td>';
                        echo '<td align="center">Product</td>';
                        $cust_id='';
                        if($val_query['type']=='Customer')
                        {
                            $sql_product="select cust_name,cust_id from customer where cust_id='".$val_query['customer_id']."'";
                            $ptr_product = mysql_query($sql_product);
                            $data_product = mysql_fetch_array($ptr_product);
                            $name=$data_product['cust_name'];
                            $cust_id=$data_product['cust_id'];
                        }
                        else
                        if($val_query['type']=='Employee')
                        {
                            $sql_product="select name,admin_id from site_setting where admin_id='".$val_query['customer_id']."'";
                            $ptr_product = mysql_query($sql_product);
                            $data_product = mysql_fetch_array($ptr_product);
                            $name=$data_product['name'];
                            $cust_id=$data_product['admin_id'];
                        }
                        else
                        {
                            $sql_product="select name,enroll_id from enrollment where enroll_id='".$val_query['customer_id']."'";
                            $ptr_product=mysql_query($sql_product);
                            $data_product= mysql_fetch_array($ptr_product);
                            $name=$data_product['name'];
                            $cust_id=$data_product['enroll_id'];
                        }
                        $cust_name=$name;
                        
                        echo '<td align="center">'.$cust_name.' - '.$cust_id.'</td>';
                        echo '<td colspan="6"><table width="100%" class="table11">';
                        
                        $tot_price_gst=0;
                        $tot_disc_price_gst=0;
                        
                        $sel_prod="select SUM(i.cgst_tax) as cgst_total,SUM(i.base_prod_price * i.product_qty) as base_total,SUM(i.discounted_price * i.product_qty) as total_val,s.total_price, i.product_disc, SUM(i.discounted_price) as total_cgst_val,(i.cgst_tax_in_per + i.sgst_tax_in_per) as total_gst from sales_product_map i, sales_product s where i.sales_product_id='".$val_query['sales_product_id']."' and i.sales_product_id=s.sales_product_id and (i.cgst_tax_in_per >0 || i.sgst_tax_in_per >0) group by i.cgst_tax_in_per";
                        $ptr_prod= mysql_query($sel_prod);
                        if($tot_sale=mysql_num_rows($ptr_prod))
                        {
                            while($data_prod=mysql_fetch_array($ptr_prod))
                            {
                                $total_price=$data_prod['total_price'];
                                $tot_disc_price_gst=$data_prod['total_val'];
                                $tot_price_gst=$data_prod['total_val'];
                                $disc=0;
                                if($val_query['discount'] >0 && $val_query['discount_type']=='percentage')
                                {
                                    $tot_disc=number_format(($data_prod['total_val'] * $val_query['discount'] ) / 100,3,'.','');
                                    $tot_disc_price_gst=$data_prod['total_val'] - $tot_disc ;
                                    $disc=$val_query['discount'];
                                }
                                if(($data_prod['total_val'] <=0 || $data_prod['total_val']='') && $data_prod['product_disc']=='100')
                                {
                                    $tot_price_gst=$data_prod['base_total'];
                                    $disc=100;
                                }
                                
                                echo'<tr>';
                                echo '<td align="center" width="40%">Sales @ '.$data_prod['total_gst'].'%</td>';
                                echo '<td align="center" width="20%">Item </td>';
                                echo '<td align="center" width="10%">1</td>';				
                                echo '<td align="center" width="10%">'.number_format($tot_price_gst,3,'.','').'</td>';
                                echo '<td align="center" width="10%">'.$disc.'</td>';
                                echo "<td align='center' width='10%'>".number_format($tot_disc_price_gst,3,'.','')."</td>";
                                echo '</tr>';
                                $total_amnts =number_format($tot_disc_price_gst,3,'.','');
                            }
                        }
                        //============================= FOR IGST ============================
                        $tot_price_igst=0;
                        $tot_disc_price_igst=0;
                    
                        $sel_prod="select SUM(i.igst_tax) as cgst_total,SUM(i.base_prod_price * i.product_qty) as base_total,SUM(i.discounted_price * i.product_qty) as total_val,s.total_price, i.product_disc, SUM(i.discounted_price) as total_cgst_val,(i.igst_tax_in_per) as total_gst from sales_product_map i, sales_product s where i.sales_product_id='".$val_query['sales_product_id']."' and i.sales_product_id=s.sales_product_id and (i.igst_tax_in_per >0) group by i.igst_tax_in_per";
                        $ptr_prod= mysql_query($sel_prod);
                        if($tot_sale=mysql_num_rows($ptr_prod))
                        {
                            while($data_prod=mysql_fetch_array($ptr_prod))
                            {
                                $total_price=$data_prod['total_price'];
                                $tot_disc_price_igst=$data_prod['total_val'];
                                $tot_price_igst=$data_prod['total_val'];
                                $disc=0;
                                if($val_query['discount'] >0 && $val_query['discount_type']=='percentage')
                                {
                                    $tot_disc=number_format(($data_prod['total_val'] * $val_query['discount'] ) / 100,3,'.','');
                                    $tot_disc_price_igst=$data_prod['total_val'] - $tot_disc ;
                                    $disc=$val_query['discount'];
                                }
                                if(($data_prod['total_val'] <=0 || $data_prod['total_val']='') && $data_prod['product_disc']=='100')
                                {
                                    $tot_price_igst=$data_prod['base_total'];
                                    $disc=100;
                                }
                                
                                echo'<tr>';
                                echo '<td align="center" width="40%">Sales @ '.$data_prod['total_gst'].'%</td>';
                                echo '<td align="center" width="20%">Item </td>';
                                echo '<td align="center" width="10%">1</td>';				
                                echo '<td align="center" width="10%">'.number_format($tot_price_igst,3,'.','').'</td>';
                                echo '<td align="center" width="10%">'.$disc.'</td>';
                                echo "<td align='center' width='10%'>".number_format($tot_disc_price_igst,3,'.','')."</td>";
                                echo '</tr>';
                                $total_amnts =number_format($tot_disc_price_igst,3,'.','');
                            }
                        }
                        //============================= FOR GST Null ============================
                        $tot_price=0;
                        $tot_disc_price=0;
                        
                        $sel_prod="select SUM(i.cgst_tax) as cgst_total,SUM(i.base_prod_price * i.product_qty) as base_total,SUM(i.discounted_price * i.product_qty) as total_val,s.total_price, i.product_disc, SUM(i.discounted_price) as total_cgst_val from sales_product_map i, sales_product s where i.sales_product_id='".$val_query['sales_product_id']."' and i.sales_product_id=s.sales_product_id and (i.cgst_tax_in_per <=0 and i.sgst_tax_in_per <=0 and i.igst_tax_in_per <=0) group by i.igst_tax_in_per";
                        $ptr_prod= mysql_query($sel_prod);
                        if($tot_sale=mysql_num_rows($ptr_prod))
                        {
                            while($data_prod=mysql_fetch_array($ptr_prod))
                            {
                                $total_price=$data_prod['total_price'];
                                $tot_disc_price=$data_prod['total_val'];
                                $tot_price=$data_prod['total_val'];
                                $disc=0;
                                if($val_query['discount'] >0 && $val_query['discount_type']=='percentage')
                                {
                                    $tot_disc=number_format(($data_prod['total_val'] * $val_query['discount'] ) / 100,3,'.','');
                                    $tot_disc_price=$data_prod['total_val'] - $tot_disc ;
                                    $disc=$val_query['discount'];
                                }
                                if(($data_prod['total_val'] <=0 || $data_prod['total_val']='') && $data_prod['product_disc']=='100')
                                {
                                    $tot_price=$data_prod['base_total'];
                                    $disc=100;
                                }
                                
                                echo'<tr>';
                                echo '<td align="center" width="40%">Sales @ 0%</td>';
                                echo '<td align="center" width="20%">Item </td>';
                                echo '<td align="center" width="10%">1</td>';				
                                echo '<td align="center" width="10%">'.number_format($tot_price,3,'.','').'</td>';
                                echo '<td align="center" width="10%">'.$disc.'</td>';
                                echo "<td align='center' width='10%'>".number_format($tot_disc_price,3,'.','')."</td>";
                                echo '</tr>';
                                $total_amnts =number_format($tot_disc_price,3,'.','');
                            }
                        }
                        
                        
                        /*echo "<br/>".$sel_prod="select SUM(i.discounted_price * i.product_qty) as total_val, s.total_price from sales_product_map i, sales_product s where 1 and i.sales_product_id='".$val_query['sales_product_id']."' and i.sales_product_id=s.sales_product_id and i.sales_product_price > 0 and s.total_price > 0 group by i.sales_product_id";
                        $ptr_prod= mysql_query($sel_prod);
                        if($tot_sale=mysql_num_rows($ptr_prod))
                        {
                            while($data_prod=mysql_fetch_array($ptr_prod))
                            {
                                $total_price=$data_prod['total_price'];
                                $tot_disc_price=$data_prod['total_val'];
                                $disc=0;
                                if($val_query['discount'] >0)
                                {
                                    $tot_disc=round(($data_prod['total_val'] * $val_query['discount'] ) / 100,2);
                                    $tot_disc_price=$data_prod['total_val'] - $tot_disc ;
                                    $disc=$val_query['discount'];
                                }
                                
                                echo'<tr>';
                                echo '<td align="center" width="40%">Product Sales</td>';
                                echo '<td align="center" width="20%">Item </td>';
                                echo '<td align="center" width="10%">1</td>';				
                                echo '<td align="center" width="10%">'.round($data_prod['total_val'],2).'</td>';
                                echo '<td align="center" width="10%">'.$disc.'</td>';
                                echo "<td align='center' width='10%'>".round($tot_disc_price,2)."</td>";
                                echo '</tr>';
                                $total_amnts =round($tot_disc_price,2);
                            }
                        }*/
                        
                        //echo "<td align='center'>".$val_query['total_paid_gst']."</td>";
                        /*$sel_inst_amnt="select payment_mode from payment_mode where 1 and payment_mode_id='".$val_query['paid_type']."' ";
                        $ptr_ins_amnt=mysql_query($sel_inst_amnt);
                        $data_inst_amnt=mysql_fetch_array($ptr_ins_amnt);*/
                        //echo "<td align='center'><strong>".$data_inst_amnt['payment_mode']."</strong></td>";
                        
                        //echo '</tr>';
                        //===========================CGST========================================
                        $tot_cgst=0;
                        $sel_cgst_prod="select SUM(i.cgst_tax) as cgst_total,SUM(i.base_prod_price) as base_total,i.product_disc, SUM(i.discounted_price) as total_cgst_val,i.cgst_tax_in_per from sales_product_map i, sales_product s where i.sales_product_id='".$val_query['sales_product_id']."' and i.sales_product_id=s.sales_product_id and i.sales_product_price>0 and s.total_price > 0 group by i.cgst_tax_in_per";
                        $ptr_cgst_prod= mysql_query($sel_cgst_prod);
                        if($tot_cgst_num=mysql_num_rows($ptr_cgst_prod))
                        {
                            while($data_cgst=mysql_fetch_array($ptr_cgst_prod))
                            {
                                if($data_cgst['cgst_tax_in_per']>0)
                                {
                                    echo'<tr>';
                                    echo '<td align="center" width="40%">Output CGST '.$data_cgst['cgst_tax_in_per'].'%</td>';
                                    echo '<td align="center" width="20%"></td>';
                                    echo '<td align="center" width="10%"></td>';				
                                    echo '<td align="center" width="10%"></td>';
                                    echo '<td align="center" width="10%"></td>';
                                    $tot_cgst=($tot_price_gst*$data_cgst['cgst_tax_in_per']/100);
                                    echo "<td align='center' width='10%'>".number_format($tot_cgst,3,'.','')."</td>";
                                    echo '</tr>';
                                    $total_amnts +=number_format($tot_cgst,3,'.','');
                                }
                            }
                        }
                        //=======================================SGST====================================
                        $tot_sgst=0;
                        $sel_sgst_prod="select SUM(i.sgst_tax) as sgst_total,SUM(i.base_prod_price) as base_total,i.product_disc, SUM(i.discounted_price) as total_sgst_val,i.sgst_tax_in_per from sales_product_map i, sales_product s where i.sales_product_id='".$val_query['sales_product_id']."' and i.sales_product_id=s.sales_product_id and i.sales_product_price>0 and s.total_price > 0 group by i.sgst_tax_in_per";
                        $ptr_sgst_prod= mysql_query($sel_sgst_prod);
                        if($tot_sgst_num=mysql_num_rows($ptr_sgst_prod))
                        {
                            while($data_sgst=mysql_fetch_array($ptr_sgst_prod))
                            {
                                if($data_sgst['sgst_tax_in_per']>0)
                                {
                                    echo'<tr>';
                                    echo '<td align="center" width="40%">Output SGST '.$data_sgst['sgst_tax_in_per'].'%</td>';
                                    echo '<td align="center" width="20%"></td>';
                                    echo '<td align="center" width="10%"></td>';				
                                    echo '<td align="center" width="10%"></td>';
                                    echo '<td align="center" width="10%"></td>';
                                    $tot_sgst=($tot_price_gst*$data_sgst['sgst_tax_in_per']/100);
                                    echo "<td align='center' width='10%'>".number_format($tot_sgst,3,'.','')."</td>";
                                    echo '</tr>';
                                    $total_amnts +=number_format($tot_sgst,3,'.','');
                                }
                            }
                        }
                        //====================================IGST========================================
                        $tot_igst=0;
                        $sel_igst_prod="select SUM(i.igst_tax) as igst_total,SUM(i.base_prod_price) as base_total,i.product_disc, SUM(i.discounted_price) as total_igst_val,i.igst_tax_in_per from sales_product_map i, sales_product s where i.sales_product_id='".$val_query['sales_product_id']."' and i.sales_product_id=s.sales_product_id and i.sales_product_price>0 and s.total_price > 0 group by i.igst_tax_in_per";
                        $ptr_igst_prod= mysql_query($sel_igst_prod);
                        if($tot_igst_num=mysql_num_rows($ptr_igst_prod))
                        {
                            while($data_igst=mysql_fetch_array($ptr_igst_prod))
                            {
                                if($data_igst['igst_tax_in_per']>0)
                                {
                                    echo'<tr>';
                                    echo '<td align="center" width="40%">Output IGST '.$data_igst['igst_tax_in_per'].' %</td>';
                                    echo '<td align="center" width="20%"></td>';
                                    echo '<td align="center" width="10%"></td>';				
                                    echo '<td align="center" width="10%"></td>';
                                    echo '<td align="center" width="10%"></td>';
                                    $tot_igst=($tot_price_igst*$data_igst['igst_tax_in_per']/100);
                                    echo "<td align='center' width='10%'>".number_format($tot_igst,3,'.','')."</td>";
                                    echo '</tr>';
                                    $total_amnts +=number_format($tot_igst,3,'.','');
                                }
                            }
                        }
                        //==============================================================================
                        echo'<tr>';
                        echo '<td align="center" width="40%"><strong>Total</strong></td>';
                        echo '<td align="center" width="20%"></td>';
                        echo '<td align="center" width="10%"></td>';				
                        echo '<td align="center" width="10%"></td>';
                        echo '<td align="center" width="10%"></td>';
                        $total_actual= number_format($tot_disc_price_gst+$tot_disc_price_igst+$tot_cgst+$tot_sgst+$tot_igst,3,'.','');
                        //$tots_price=number_format($total_price,3,'.','');
                        
                        echo "<td align='center' width='10%'>".number_format($total_actual,3,'.','')."</td>";
                        echo '</tr>';
                        echo '</table></td>';
                        //$tot_num_gst=number_format($tot_cgst+$tot_sgst+$tot_igst,3,'.','');
                        
                        /*echo '<td align="center">';
                        echo '<table width="100%">';
                        $sel_prod="select sales_product_id,product_id,discounted_price, sales_product_price,product_qty, cgst_tax, sgst_tax,igst_tax from sales_product_map where sales_product_id='".$val_query['sales_product_id']."'";
                        $ptr_prod= mysql_query($sel_prod);
                        while($product=mysql_fetch_array($ptr_prod))
                        {
                            echo '<tr>';
                            $sel_p="select product_name from product where product_id='".$product['product_id']."'";
                            $ptr_p=mysql_query($sel_p);
                            $data_p= mysql_fetch_array($ptr_p);	
                            echo'<td align="center" width="40%">'.$data_p['product_name'].'</td>';
                            echo'<td align="center" width="10%">'.$product['product_qty'].'</td>';
                            echo'<td align="center" width="15%">'.$product['discounted_price'].'</td>';
                            echo'<td align="center" width="15%">'.$product['cgst_tax'].'</td>';
                            echo'<td align="center" width="15%">'.$product['sgst_tax'].'</td>';
                            echo'<td align="center" width="15%">'.$product['igst_tax'].'</td>';
                            echo'<td align="center" width="20%">'.$product['sales_product_price'].'</td>';
                            echo '</tr>';
                        }
                        echo '</table></td>';
                        $sel_inst_amnt="select payment_mode from payment_mode where payment_mode_id='".$val_query['paid_type']."' ";
                        $ptr_ins_amnt=mysql_query($sel_inst_amnt);
                        $data_inst_amnt=mysql_fetch_array($ptr_ins_amnt);
                                
                        echo "<td align='center'>".$data_inst_amnt['payment_mode']."</td>";*/
                        
                        $sel_bnk="select bank_name,account_no from bank where 1 and bank_id='".$val_query['bank_id']."' ";
                        $ptr_bnk=mysql_query($sel_bnk);
                        $data_bank=mysql_fetch_array($ptr_bnk);
                        
						//===cost center======
                        /*echo "<td align='center'>";
                        if($val_query['paid_type']!=1)
                        {
                            echo "Acc. No.- ".$data_bank['account_no'];
                            //echo "Bank Name- ".$data_bank['bank_name']."<br/>Acc. No.- ".$data_bank['account_no'];
                        }
                        echo "</td>";*/
                        
                        /*echo "<td align='center'> ";
                        if($val_query['bank_ref_no'] !='')
                            echo "Ref No.- ".$val_query['bank_ref_no']."<br/>";
                            
                        if($val_query['cheque_detail'] !='')
                            echo "Chaque No.- ".$val_query['cheque_detail']."<br/>";
                        
                        if($val_query['chaque_date'] !='')
                            echo "Chaque Date.- ".$val_query['chaque_date']."<br/>";
                            
                        if($val_query['credit_card_no'] !='')
                            echo "Credit Card No.- ".$val_query['credit_card_no']."<br/>";
                        
                        echo "</td>";
                        
                        echo "<td align='center'>".$val_query['payable_amount']."</td>";*/
                        
                        //$totals_tds +=intval($val_query['payable_amount']);
                        
                        echo '</tr>';
                        $no++;
                        $bgColorCounter++;
                    }
                    ?>
					<tr class="grey_td">
                        <td colspan="16">
                            <table cellspacing="0" cellpadding="0" width="100%"  style="border:1 px solid #CCC; border-collapse:collapse">
                                <tr class="grey_td">
                                    <td width="70%" align="center" colspan="3"><strong>Total</strong></td>				
                                    <td width="30%" align="center"><span style='color:red'><strong><?php echo number_format($totals_tds,3,'.',''); ?></strong></span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
    				<!--<tr class="head_td">
                        <td colspan="16">
                            <table cellspacing="0" cellpadding="0" width="100%">
                                <tr>
                                    <?php
									/*if($no_of_records>10)
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
									echo '<td width="75%" align="right">'.$pager->renderFullNav().'</td>'; */
                                     ?>
                                </tr>
                            </table>
                        </td>
                    </tr>-->
  				</form>
  				<?php 
			} 
      		else
        		echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No records found related to your search criteria, please try again</div><br></td></tr>';?>
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