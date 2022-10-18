<?php include 'inc_classes.php';?>
<!--ENROLLMENT INCOMMING GST REPORT WITH NO GST NO OF STUDENT-->
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CapEx report</title>
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
    <td colspan="12">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
    <?php
	if($_REQUEST['from_date'] =='')
	{
		?>
		Default Records show from <?php echo date('d/m/Y',strtotime('-30 days')) ?> to <?php echo date('d/m/Y') ?>
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
                        
						<?php
                        echo '<td>Select Month</td><td>';
                        $monthArray = range(1, 12);
                        echo '<select id="month" name="month">';?>
                        <option value="">Select Month</option>
                        <?php
                        foreach ($monthArray as $month) 
                        {
                            // padding the month with extra zero
                            $monthPadding = str_pad($month, 2, "0", STR_PAD_LEFT);
                            // you can use whatever year you want
                            // you can use 'M' or 'F' as per your month formatting preference
                            $fdate = date("F", strtotime("2018-$monthPadding-01"));
                            ?><option <?php if($month==$row_record['month']) { echo "selected"; } else { echo '';}?> value="<?php echo $monthPadding; ?>"><?php echo $fdate; ?></option>
                            <?php 
                        }
                        ?>
                        </select>
                        <?php
                        echo "</td>";
                        ?> 
                        
						<td width="12%" align="center"><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                        <td width="10%" align="center">
                         <input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>">
                         </td>
                        <td width="10%" align="center">
                        <input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>">
                        </td>
                        <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                        <td><a href="expense_tds_export.php<?php echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a></td>  
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
						
						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						{
							$frm_date=explode("/",$_REQUEST['from_date']);
							$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							
							$pre_from_date=" and DATE(admission_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$installment_from_date=" and DATE(`installment_date`) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$paid_from_date=" and DATE(`added_date`) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$exp_from_date=" and DATE(e.added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$paid_from_date_i=" and DATE(ip.added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
						}
						else
						{
							$pre_from_date=""; 
							if($_REQUEST['to_date']=='')
							{
								$paid_from_date=" and DATE(`added_date`) >='".date('Y-m-d',strtotime('-30 days'))."'";
								$paid_from_date_i=" and DATE(ip.added_date) >='".date('Y-m-d',strtotime('-30 days'))."'";
								$exp_from_date=" and DATE(e.added_date) >='".date('Y-m-d',strtotime('-30 days'))."'";
							}
							else
							{
								$paid_from_date="";
								$paid_from_date_i="";
								$exp_from_date="";
							}
							$installment_from_date="";                           
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
								$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
								$cm_ids=$data_cm_id['cm_id'];
								$branch="  and branch_name='".$branch_name."'";
							}
							else
							{
								$search_cm_id='';
								$branch='';
							}
						}
						if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
						{
							$to_date=explode("/",$_REQUEST['to_date']);
							$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
							
							$pre_to_date=" and DATE(`admission_date`) <='".date('Y-m-d',strtotime($to_dates))."'";
							$installment_to_date=" and DATE(`installment_date`)<='".date('Y-m-d',strtotime($to_dates))."' ";
							$paid_to_date=" and DATE(`added_date`)<='".date('Y-m-d',strtotime($to_dates))."'";
							$exp_to_date=" and DATE(`e.added_date`)<='".date('Y-m-d',strtotime($to_dates))."'";
							$paid_to_date_i=" and DATE(ip.added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
						}
						else
						{
							$pre_to_date="";
							$installment_to_date="";
							$paid_to_date=" and DATE(`added_date`)<='".date('Y-m-d')."'";
							$paid_to_date_i=" and DATE(ip.added_date)<='".date('Y-m-d')."'";
							$exp_to_date=" and DATE(e.added_date)<='".date('Y-m-d')."'";
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
							$select_directory='order by s.tds_id desc';                     
							$where_cm='';
							if($_SESSION['where']!='')
							{
								$where_cm=" and cm_id='".$_SESSION['cm_id']."'";
							}
							
                       		echo $sql_query= "SELECT * FROM branch WHERE 1 ".$where_cm." ".$branch." "; 
							$my_db=mysql_query($sql_query);
							$no_of_records=mysql_num_rows($my_db);
							
							if($no_of_records)
							{
								$bgColorCounter=1;
								//$_SESSION['show_records'] = 10;
								$query_string='&keyword='.$keyword.'&from_date='.$_REQUEST['from_date'].'&to_date='.$_REQUEST['to_date'].'&gst_student='.$gst_keyword.'&branch_name='.$_REQUEST['branch_name'];
								$query_string1=$query_string.$date_query;
							   // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
								$pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
								$all_records= $pager->paginate();
								?>

   

				<form method="post"  name="frmTakeAction"  action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>">
                     <input type="hidden" name="formAction" id="formAction" value=""/>
                      <tr class="grey_td" >
                        <td width="4%" align="center"><strong>Sr. No.</strong></td>
                        <td width="10%" align="center"><strong>Branch Name</strong></td>
						<td width="10%" align="center">CapEx Invest</td>
                        <td width="12%" align="center">OpEx (with tax)</td>
						<td width="12%" align="center">RBT</td>
						<td width="12%" align="center">Tax Payble</td>
						<td width="10%" align="center">Revenue</td>
						<td width="12%" align="center">Profit</td>
                        <td width="12%" align="center">Result</td>
                        <!--<td width="10%" align="center"><strong>Monthly Expected</strong></td>
                        <td width="14%" align="center"><strong>Installments</strong></td>-->
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
							$total_expense='';
							$total_opeex='';
							$rbt='';
							$tax_payble='';
							$revenue='';
							$profit='';
							$total='';
                            while($val_query=mysql_fetch_array($all_records))
                            {
								if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
								else
                                    $bgcolor=""; 
									$listed_record_id=$val_query['inventory_id'];
                                include "include/paging_script.php";
                                echo '<tr '.$bgcolor.'>';
                                
								
								echo '<td align="center">'.$sr_no.'</td>';
								echo '<td align="center">'.$val_query['branch_name'].'</td>';
								echo "<td align='center'>".$val_query['capex_invest']."</td>";
								
								$select_cm="select cm_id from site_setting where branch_name='".$val_query['branch_name']."'";
								$ptr_cm=mysql_query($select_cm);
								$data_cm=mysql_fetch_array($ptr_cm);
								//---------------------------------------------------------------
								echo "<br/>".$sel_inst_amnt="select SUM(total_price) as amount from expense where 1 and cm_id='".$data_cm['cm_id']."' ".$paid_from_date." ".$paid_to_date." ";
								$ptr_ins_amnt=mysql_query($sel_inst_amnt);
								$data_exp_amnt=mysql_fetch_array($ptr_ins_amnt);
								
								echo "<br/>".$sel_inv_amnt="select SUM(payable_amount) as amount from inventory where 1 and cm_id='".$data_cm['cm_id']."' ".$paid_from_date." ".$paid_to_date." ";
								$ptr_inv_amnt=mysql_query($sel_inv_amnt);
								$data_inv_amnt=mysql_fetch_array($ptr_inv_amnt);
								
								//---------------------------------------------------------------
								echo "<br/>".$sel_course_amnt="select SUM(amount) as amount from invoice where 1 and cm_id='".$data_cm['cm_id']."' ".$paid_from_date." ".$paid_to_date." ";
								$ptr_course_amnt=mysql_query($sel_course_amnt);
								$data_course_amnt=mysql_fetch_array($ptr_course_amnt);
								
								echo "<br/>".$sel_serv_amnt="select SUM(payable_amount) as amount from customer_service where 1 and cm_id='".$data_cm['cm_id']."' ".$paid_from_date." ".$paid_to_date." ";
								$ptr_serv_amnt=mysql_query($sel_serv_amnt);
								$data_serv_amnt=mysql_fetch_array($ptr_serv_amnt);
								
								echo "<br/>".$sel_prod_amnt="select SUM(payable_amount) as amount from sales_product_invoice where 1 and cm_id='".$data_cm['cm_id']."' ".$paid_from_date." ".$paid_to_date." ";
								$ptr_prod_amnt=mysql_query($sel_prod_amnt);
								$data_prod_amnt=mysql_fetch_array($ptr_prod_amnt);
								//---------------------------------------------------------------------
								 // -------------- For Purchase  -----------------------
								$purchase_sgst_total='';
								echo "<br/>".$sel_inst_amnt8="select SUM(i.sgst_tax) as purchase_sgst_total,ip.added_date from inventory_product_map i,inventory_invoice ip where 1 and i.inventory_id=ip.inventory_id and (i.cgst_tax_in_per >0 or i.sgst_tax_in_per >0) and cm_id='".$data_cm['cm_id']."' ".$paid_from_date_i." ".$paid_to_date_i."";
								$ptr_name8=mysql_query($sel_inst_amnt8);
								$data_name8=mysql_fetch_array($ptr_name8);
								$purchase_sgst_total=$data_name8['purchase_sgst_total'];	
								 
								$purchase_cgst_total='';
								echo "<br/>".$sel_inst_amnt9="select SUM(i.cgst_tax) as purchase_cgst_total,ip.added_date from inventory_product_map i,inventory_invoice ip where 1 and i.inventory_id=ip.inventory_id and (i.cgst_tax_in_per >0 or i.sgst_tax_in_per >0) and cm_id='".$data_cm['cm_id']."' ".$paid_from_date_i." ".$paid_to_date_i."";
								$ptr_name9=mysql_query($sel_inst_amnt9);
								$data_name9=mysql_fetch_array($ptr_name9);
								$purchase_cgst_total=$data_name9['purchase_cgst_total'];	
								 
								$total_purchase=$purchase_cgst_total+$purchase_sgst_total;
								// -------------- For Expense  ---------------------------
								$expense_sgst_total='';
								echo "<br/>".$sel_inst_amnt4="select SUM(em.sgst_tax) as expense_sgst_total,e.added_date from expense_map em,expense e where 1 and (em.cgst_tax_in_per >0 or em.sgst_tax_in_per >0) and e.expense_id=em.expense_id and cm_id='".$data_cm['cm_id']."' ".$exp_from_date." ".$exp_to_date."";
								$ptr_name4=mysql_query($sel_inst_amnt4);
								$data_name4=mysql_fetch_array($ptr_name4);
								$expense_sgst_total=$data_name4['expense_sgst_total'];	
								  
								$expense_cgst_total='';
								echo "<br/>".$sel_inst_amnt5="select SUM(em.cgst_tax) as expense_cgst_total,e.added_date from expense_map em,expense e where 1 and (em.cgst_tax_in_per >0 or em.sgst_tax_in_per >0) and e.expense_id=em.expense_id ".$exp_search_cm_id." ".$exp_from_date." ".$exp_to_date."";
								$ptr_name5=mysql_query($sel_inst_amnt5);
								$data_name5=mysql_fetch_array($ptr_name5);
								$expense_cgst_total=$data_name5['expense_cgst_total'];
								
								$total_expense=$expense_cgst_total+$expense_sgst_total;
								//-----------------------------------------------------------
								$total_opeex=$data_exp_amnt['amount']+$data_inv_amnt['amount'];
								$rbt=$data_course_amnt['amount']+$data_serv_amnt['amount']+$data_prod_amnt['amount'];
								
								$tax_payble=$total_purchase+$total_expense;
								$revenue=$rbt-$tax_payble;
								$profit=$revenue-$total_opeex;
								echo "<td align='center'>".$total_opeex."</td>";
								echo "<td align='center'>".$rbt."</td>";
								echo "<td align='center'>".$tax_payble."</td>";
								echo "<td align='center'>".$revenue."</td>";
								echo "<td align='center'>".$profit."</td>";
								if($profit < $val_query['capex_invest'])
								{
									if($revenue < $total_opeex)
									{
										echo "<br/>Total1--".$total=$revenue*5/100;
									}
									else if($revenue > $total_opeex)
									{
										$total_op=$total_opeex*5/100;
										$tot=($revenue-$total_opeex)*10/100;
										echo "<br/>Total2--".$total=$total_op+$tot;
									}
								}
								else
								{
									echo "<br/>Total3--".$total=$profit;
								}
								echo "<td align='center'>".$total."</td>";
							
                                echo '</tr>';
								$no++;
								$bgColorCounter++;
							}
                            ?>
                            <tr class="grey_td">

    <td colspan="15">
    	<table cellspacing="0" cellpadding="0" width="100%"  style="border:1 px solid #CCC; border-collapse:collapse">
        	<tr class="grey_td">
			
                <td width="70%" align="center" colspan="3"><strong>Total</strong></td>
				
				<td width="30%" align="center"><span style='color:red'><strong><?php echo $totals_tds; ?></strong></span></td>
            </tr>
    	</table>
    </td>

    </tr>
    <tr class="head_td">
    <td colspan="15">
     <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <?php
                    /* if($no_of_records>10)
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

    </tr>

  

  

  </form>

  <?php } 

	  

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

