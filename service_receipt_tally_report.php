<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Service-Receipt Tally Report</title>
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
    <td colspan="17">
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
                        $sel_payment_mode="select payment_mode,payment_mode_id from payment_mode where 1 and (payment_mode_id=1 or payment_mode_id=2 or payment_mode_id=4 or payment_mode_id=5)";
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
                                <option value="<?php echo $data_src['bank_id']?>" <? if($_POST['bank_id'] == $data_src['bank_id']) echo "selected"; else if ( $data_src['bank_id']==$_REQUEST['bank_id']) echo "selected";?> > <?php echo $data_src['bank_name'] ?> </option>
                                <?
                            }
                            echo "</optgroup>";
                        }?>
                    </select>
                </td>
                <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                <td width="10%"><input type="reset" name="reset" value="Reset" class="inputButton"/></td>
                <td><a href="service_receipt_tally_export.php<?php echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a></td>
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
		$pre_keyword_i =" and (i.name like '%".$keyword."%' )";
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
			$paid_from_date=" and DATE(i.added_date) >='".date('Y-m-d',strtotime('-30 days'))."'";
			$paid_from_date_i=" and DATE(s.added_date) >='".date('Y-m-d',strtotime('-30 days'))."'";
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
		$paid_to_date=" and DATE(i.added_date)<='".date('Y-m-d')."'";
		$paid_to_date_i=" and DATE(s.added_date)<='".date('Y-m-d')."'";
	}
	$pay_type="";
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
		$select_directory .=" order by ".$_GET['orderby']." " .$_GET['order'] ;
		$date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
	}
	
	$select_directory=' order by DATE(i.added_date) asc,DATE(e.ext_invoice_no) desc';
		 
	$sql_query= "select i.*, e.ext_invoice_no,e.type,e.customer_id from customer_service_invoice i, customer_service e where 1 and i.customer_service_id=e.customer_service_id  ".$search_cm_id." ".$pre_keyword_i." ".$pay_type." ".$bank_ids." ".$paid_from_date." ".$paid_to_date." ".$select_directory." "; //and amount>0
	$my_db=mysql_query($sql_query);
	$no_of_records=mysql_num_rows($my_db);
		
	if($no_of_records)
	{
		$bgColorCounter=1;	/*$query_string='&keyword='.$keyword.'&branch_name='.$_REQUEST['branch_name'].'&&from_date='.$_REQUEST['from_date'].'&to_date='.$_REQUEST['to_date'].'&bank_id='.$_REQUEST['bank_id'].'&pay_type='.$_REQUEST['pay_type'];
		$query_string1=$query_string.$date_query;
		$pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
		$pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
		$all_records= $pager->paginate();*/
		?>
		<form method="post"  name="frmTakeAction"  action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>">
        <input type="hidden" name="formAction" id="formAction" value=""/>
        <tr class="grey_td" >
            <td width="4%" align="center"><strong>Sr. No.</strong></td>
            <?php 
            if($_SESSION['type']=="S")
            {
                ?>
                <!--<td width="10%" align="center"><strong>Branch Name</strong></td>-->
                <?php
            }
            ?>        
            <!--<td width="8%" align="center">Invoice No.</td>-->
            <td width="6%" align="center">Date</td>
            <td width="6%" align="center">Vochure No.</td>
            <td width="8%" align="center">Voucher Type</td>
            <td width="8%" align="center">Sub-Voucher Type</td>
            <td width="8%" align="center">Payment Type</td>
            <td width="12%" align="center"><strong>Student Name</strong></td>
            <td width="6%" align="center">Amount</td>
            <td width="10%" align="center">Narration</td>
            <td width="8%" align="center">Chaque No.</td>
            <td width="8%" align="center">Invoice No</td>
            <td width="10%" align="center">Cost Center</td>
            </tr>
	
			<?php
            $total_paid=0;
            $total_gst_new=0;
            $monthly_expected=0;
            $total_net=0;
            $total_cgst=0;
            $total_sgst=0;
            $total_amnt=0;
            $no=1;
            while($val_query=mysql_fetch_array($my_db))
            {
                if($bgColorCounter%2==0)
                    $bgcolor='class="grey_td"';
                else
                    $bgcolor=""; 
                
				$listed_record_id=$val_query['invoice_id'];
				
                include "include/paging_script.php";
                echo '<tr '.$bgcolor.'>';
                echo '<td align="center">'.$sr_no.'</td>';
				
				$sep=explode(" ",$val_query['added_date']);
                $sep_date=explode("-",$sep[0]);
                $date=$sep_date[2]."/".$sep_date[1]."/".$sep_date[0];
				
                echo "<td align='center' width='10%'>".$date."</td>";
				echo '<td align="center">'.$val_query['receipt_no'].'</td>';
				echo '<td align="center">Receipt</td>';
				echo '<td align="center">Service</td>';
				
				$sel_inst_amnt="select payment_mode from payment_mode where 1 and payment_mode_id='".$val_query['paid_type']."' ";
                $ptr_ins_amnt=mysql_query($sel_inst_amnt);
                $data_inst_amnt=mysql_fetch_array($ptr_ins_amnt);
				echo "<td align='center'>".$data_inst_amnt['payment_mode']."</td>";
				
				if($val_query['type']=='Student')
				{
					$sql_product="select name,contact,enroll_id from enrollment where enroll_id='".$val_query['customer_id']."'";
					$ptr_product=mysql_query($sql_product);
					$data_product=mysql_fetch_array($ptr_product);
					$name=$data_product['name'];
					$cust_id=$data_product['enroll_id'];
				}
				else if($val_query['type']=='Employee')
				{
					$sql_product="select name, admin_id,contact_phone from site_setting where admin_id='".$val_query['customer_id']."' ";
					$ptr_product=mysql_query($sql_product);
					$data_product=mysql_fetch_array($ptr_product);
					$name=$data_product['name'];
					$mobile=$data_product['contact_phone'];
					$cust_id=$data_product['admin_id'];
				}
				else
				{
					$sql_product="select cust_name,cust_id,mobile1 from customer where cust_id='".$val_query['customer_id']."' ";
					$ptr_product=mysql_query($sql_product);
					$data_product=mysql_fetch_array($ptr_product);
					$name=$data_product['cust_name'];
					$mobile=$data_product['mobile1'];
					$cust_id=$data_product['cust_id'];
				}
				$cust_name=$name;
				
				echo '<td align="center">'.$cust_name.' - '.$cust_id.'</td>';
				echo '<td align="center">'.round($val_query['payable_amount'],2).'</td>';
				echo '<td align="center">Service Amount Collected</td>';
				if($val_query['cheque_detail']!='')
				{
					echo '<td align="center" >'.$val_query['cheque_detail'].'</td>';
				}
				else
				{
					echo '<td align="center"></td>';	
				}
				echo '<td align="center">'.$val_query['ext_invoice_no'].'</td>';
				
				$sel_bnk="select bank_name,account_no from bank where 1 and bank_id='".$val_query['bank_id']."' ";
                $ptr_bnk=mysql_query($sel_bnk);
                $data_bank=mysql_fetch_array($ptr_bnk);
                if($val_query['paid_type']=='1')
				{
					echo "<td align='center'>-</td>";
				}
				else if($val_query['paid_type']=='2')
                {
                    echo "<td align='center'>";
					echo "Acc. No.- ".$data_bank['account_no']."";
                    /*echo "<br/>Bank Name- ".$data_bank['bank_name']."<br/>Acc. No.- ".$data_bank['account_no']."";
                    if($val_query['cheque_detail'] !='')
                    echo "<br/>Chaque No.- ".$val_query['cheque_detail']."<br/>";
                    if($val_query['chaque_date'] !='')
                    echo "Chaque Date.- ".$val_query['chaque_date']."<br/>";*/
                    echo "</td>";
                }
				else if($val_query['paid_type']=='4')
                {
                    echo "<td align='center'>";
					echo "<br/>Acc. No.- ".$data_bank['account_no']."";
                    /*echo "<br/>Bank Name- ".$data_bank['bank_name']."<br/>Acc. No.- ".$data_bank['account_no']."";
                    if($val_query['credit_card_no'] !='')
                    echo "<br/>Credit Card No.- ".$val_query['credit_card_no']."<br/>";*/
                    echo "</td>";
                }
				else if($val_query['paid_type']=='5')
                {
                    echo "<td align='center'>";
					echo "Acc. No.- ".$data_bank['account_no']."";
                    /*if($val_query['bank_ref_no'] !='')
                    echo "<br/>Bank Name- ".$data_bank['bank_name']."<br/>Acc. No.- ".$data_bank['account_no']."<br/> Ref No.- ".$val_query['bank_ref_no']."<br/>";*/
                    echo "</td>";
                }
				else
				{
					echo "<td align='center'></td>";
				}
                $totals_tds +=intval($val_query['amount']);
            
                echo '</tr>';
                $no++;
                $bgColorCounter++;
            }
            ?>
            <!--<tr class="grey_td">
                <td align="center" colspan="6"><strong>Total</strong></td>
                <td align="center"><span style='color:red'><strong><?php //echo $total_net; ?></strong></span></td>
                <td align="center"><span style='color:red'><strong>0</strong></span></td>
                <td align="center"><span style='color:red'><strong><?php //echo $total_amnt; ?></strong></span></td>
                <td colspan="2" align="center"></td>
    		</tr>-->
    		<!--<tr class="head_td">
    			<td colspan="15">
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