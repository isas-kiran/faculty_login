<?php include 'inc_classes.php';?>
<?php //include "admin_authentication.php";?>
<?php
//====================== Connection 1 - PUNE PVT LTD ============================
$host = "localhost";
$dbuid = "isasadmin";
$dbpwd = "isasadmin007";
$dbname = "isasbeautyschool_org";

$link1 = mysql_connect($host ,$dbuid, $dbpwd);
mysql_select_db($dbname,$link1);
// Check for connection
if($link1 == true) {
    //echo "database1 Connected Successfully";
}
else {
    die("ERROR: Could not connect " . mysql_error());
}
//======================= Connection 2 - PUNE LLP ================================
$host1 = "localhost";
$dbuid1	= "isasllp";
$dbpwd1 = "isasllp!@!2021";
$dbname1 = "isas.llp";

$link2 = mysql_connect($host1 ,$dbuid1, $dbpwd1);
mysql_select_db($dbname1,$link2);
// Check for connection
if($link2 == true) {
    //echo "database2 Connected Successfully";
}
else {
    die("ERROR: Could not connect " . mysql_error());
}
//======================= Connection 3 - Dubai ===================================
$host3 = "localhost";
$dbuid3	= "isas_dubai";
$dbpwd3 = "isas_dubai@007";
$dbname3 = "isas_dubai";

$link3 = mysql_connect($host3 ,$dbuid3, $dbpwd3);
mysql_select_db($dbname3,$link3);
// Check for connection
if($link3 == true) {
    //echo "database2 Connected Successfully";
}
else {
    die("ERROR: Could not connect " . mysql_error());
}
//================================================================================
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>ALl DSR Report</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='338'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
    <script type="text/javascript" src="../js/common.js"></script>
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <link rel="stylesheet" href="js/chosen.css" />
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
       
    $(document).ready(function()
	{            
		$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
		$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
		}
		$("#staff_id").chosen({allow_single_deselect:true});
		<?php 
		if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
		{
			?>
			$("#branch_name").chosen({allow_single_deselect:true});
			<?php
		}
		?>
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
		
		function getstaff(branch_id)
		{
			var data1="action=stack_report&branch_id="+branch_id;	
			$.ajax({
			url: "show_councellor.php", type: "post", data: data1, cache: false,
			success: function (html)
			{
				if(html !='')
				{
					//alert(html);
					document.getElementById("staff_details").innerHTML=html;
					$("#staff_id").chosen({allow_single_deselect:true});
				}
			},
			error:function(exception){alert('Exception:'+exception);}
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
    	<td class="top_mid" valign="bottom"><?php include "include/report_menu.php";?></td>
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
								<?php 
								/*if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
                                {
									?>
									<td width="15%">
										<select name="branch_name" id="branch_name" class="input_select_login" style="width: 150px;" onchange="getstaff(this.value)">
                                        <option value="">-Branch Name-</option>
                                        <?php 
										$sel_branch="select branch_id,branch_name from branch";
										$ptr_sel=mysql_query($sel_branch,$link1);
										while($data_branch=mysql_fetch_array($ptr_sel))
										{
											$sel='';
											if($data_branch['branch_name']==$_REQUEST['branch_name'] || ($_REQUEST['branch_name']=='') && $data_branch['branch_name']=='Pune' )
											{
												$sel='selected="selected"';
											}
											echo '<option '.$sel.' value="'.$data_branch['branch_name'].'" > '.$data_branch['branch_name'].'</option>';
										}
										$sel_branch2="select branch_id,branch_name from branch";
										$ptr_sel2=mysql_query($sel_branch2,$link2);
										while($data_branch2=mysql_fetch_array($ptr_sel2))
										{
											$sel='';
											if($data_branch2['branch_name']==$_REQUEST['branch_name'] || ($_REQUEST['branch_name']=='') && $data_branch2['branch_name']=='Pune' )
											{
												$sel='selected="selected"';
											}
											echo '<option '.$sel.' value="'.$data_branch2['branch_name'].'" > '.$data_branch2['branch_name'].'</option>';
										}
										$sel_branch3="select branch_id,branch_name from branch";
										$ptr_sel3=mysql_query($sel_branch3,$link3);
										while($data_branch3=mysql_fetch_array($ptr_sel3))
										{
											$sel='';
											if($data_branch3['branch_name']==$_REQUEST['branch_name'] || ($_REQUEST['branch_name']=='') && $data_branch3['branch_name']=='Pune' )
											{
												$sel='selected="selected"';
											}
											echo '<option '.$sel.' value="'.$data_branch3['branch_name'].'" > '.$data_branch3['branch_name'].'</option>';
										}
                                        ?>
										</select>
									</td>
									<?php
                                }
								else 
								{
									?>
									<td colspan="2" align="left">
									<input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"/> 
									</td>
									<?php 
								}*/
								/*if($_SESSION['type']=="S" || $_SESSION['type']=="A" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
								{
									?>
									<td width="10%" align="center" style="padding-left:0px;width: 15%;" id="staff_details">
										<select name="staff_id" id="staff_id" class="input_select" style="width:150px">
										<option value="">Select Staff</option>
										<?php
										if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
										{
											if($_REQUEST['branch_name']!='')
											{
												$branch_name=$_REQUEST['branch_name'];
												$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
												$ptr_cm_id=mysql_query($select_cm_id);
												$data_cm_id=mysql_fetch_array($ptr_cm_id);
												$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
												$cm_ids=$data_cm_id['cm_id'];
											}
											else
											{
												$search_cm_id=" and cm_id='2'";
												$cm_ids='2';
											}
										}
										$sle_name="select admin_id,name from site_setting where 1 ".$search_cm_id." and system_status='Enabled' and (type='C' || type='A') order by name asc"; 
										$ptr_name=mysql_query($sle_name);
										while($data_name=mysql_fetch_array($ptr_name))
										{
											$selected='';
											if($data_name['admin_id'] == $_REQUEST['staff_id'])
											{
												$selected='selected="selected"';
											}
											echo '<option '.$selected.' value="'.$data_name['admin_id'].'">'.$data_name['name'].'</option>';
										}
										?>
										</select>
									</td>
									<?php
								}*/
								?>
                				<!--<td width="20%">
                                <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                        <option value="">-Operation-</option>
                                        <option value="delete">Delete</option>
                                </select></td>-->
                        
                                <td width="10%">
                                <input type="text" name="date" class="input_text datepicker" placeholder="Date" readonly="1" id="date" title="Date" value="<?php if($_REQUEST['date']) echo $_REQUEST['date']; else echo date('d/m/Y') //$enquiry_from_date=date('d/m/Y',strtotime('-1 days')) ?>">
                                </td>
                                 
                                <!--<td width="10%">
                                <input type="text" name="end_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="end_date"  title="To Date" value="<?php //if($_REQUEST['end_date']) echo $_REQUEST['end_date']; else echo date('d/m/Y');?>">
                                </td>-->
                                <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                                <!--<td class="leftAlign" width="140px"> 
                                    <a href="daily_stack_report.php" target="_blank" style="font-size:14; font-weight:800">Daily Stack Report</a>
                                </td>-->
                                <!--<td class="leftAlign" ><a href="manage_inq_report.php" target="_blank" style="font-size:14; font-weight:800">Total Stack Report</a>-->
                                <!--<table border="0" cellspacing="0" cellpadding="0" align="right">
                                    <tr>
                                        <td></td>
                                        <td class="width5"></td>
                                        <td><input type="text" value="<?php //if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                                        <td class="width2"></td>
                                        <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
                                    </tr>
                                </table>-->
                                <!--</td>-->
            				</tr>
        				</table>
        			</form>	
				</td>
			</tr>
			<?php
            $sep_url_string='';
            $sep_url= explode("?",$_SERVER['REQUEST_URI']);
            if($sep_url[1] !='')
            {
                $sep_url_string="&".$sep_url[1];
            }
            
			$date=date('Y-m-d');
            $date_for_month=date('Y-m');
            if($_REQUEST['date'] && $_REQUEST['date']!=="0000-00-00" && $_REQUEST['date']!="date")
            {
                $frm_date=explode("/",$_REQUEST['date']);
                $frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
                $date=date('Y-m-d',strtotime($frm_dates));
                $date_for_month=date('Y-m',strtotime($frm_dates));
            }
			
			$search_cm_id='';
            $cm_ids=$_SESSION['cm_id'];
            if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
            {
                if($_REQUEST['branch_name']!='')
                {
                    $branch_name=$_REQUEST['branch_name'];
                    $select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
                    $ptr_cm_id=mysql_query($select_cm_id);
                    $data_cm_id=mysql_fetch_array($ptr_cm_id);
                    $search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
					$search_cm_id_i=" and i.cm_id='".$data_cm_id['cm_id']."'";
                    $cm_ids=$data_cm_id['cm_id'];
                }
                else
                {
                    $search_cm_id=" ";
					$search_cm_id_i=" ";
                    $cm_ids='';
                }
            }
			if($_SESSION['where']!='')
			{
				$where_i=" and i.cm_id='".$_SESSION['cm_id']."'";
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
           	
           	//$select_directory='order by name asc';
			$cash_in_hands='';
			$petty_cash_in_hands='';
			$opening_cash1='';
			$opening_petty_cash='';
			$tota_exp_business='';
			$tots='';
			$cash_withdrawl_in_petty_cash='';
			$cash_transfer_in_petty_cash='';
			$tota_exp='';
			$tots1='';
			$outgoing='';
			$total_todays_bal='';
			$search_cm_id='';
			$sql_query="select DISTINCT(bank_id) as bank_name,cm_id from bank where 1 and status='Active' ".$_SESSION['where']." ".$search_cm_id." and show_in_report !='No' order by cm_id desc";
			$ptr_records=mysql_query($sql_query,$link1); //and system_status='Enabled'
			$no_of_records=mysql_num_rows($ptr_records);
            if($no_of_records)
            {
                $bgColorCounter=1;
                /*$query_string='&keyword='.$keyword.'&branch_name='.$_REQUEST['branch_name'].'&date='.$_REQUEST['date'];
                $query_string1=$query_string.$date_query;
                $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                $all_records= $pager->paginate();*/
				
                ?>  
                <form method="post" name="frmTakeAction"  action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>">
                <input type="hidden" name="formAction" id="formAction" value=""/>
                <tr><td align="left" colspan="17"><strong>Note: Default Date start from <?php echo $start_date; ?> to <?php echo $end_date; ?></strong></td></tr>
                
                <tr class="grey_td" >
                <td width="5%" align="center"><strong>Sr. No.</strong></td>
                <td width="10%" align="center"><strong>Branch Name</strong></td>
                <td width="15%" align="center"><strong>Bank Name</strong></td>
                <td width="10%" align="center"><strong>Account No.</strong></td>
                <td width="10%" align="center"><strong>Today Incoming in Bank</strong></td>
                <td width="10%" align="center"><strong>Todays Outgoing from Bank</strong></td>
                <td width="10%" align="center"><strong>Yesterdays Bank Balance</strong></td>
                <td width="10%" align="center"><strong>Todays Bank Balance</strong></td>
                <td width="10%" align="center"><strong>Business Cash</strong></td>
                <td width="10%" align="center"><strong>Petty Cash</strong></td>
                </tr>
                <?php
                $i=1;
				$k=1;
				$tot_todays_incoming =0;
				$tot_todays_outgoing =0;
				$tot_yesterday_bank =0;
				$tot_todays_bank =0;
				$tot_toaday_business_cash=0;
				$tot_todays_petty_cash=0;
                while($data_ptr_sel1=mysql_fetch_array($ptr_records))
                {
                    $name = '';
					$tota_exp=0;
					$tota_exp_business=0;
                    if($bgColorCounter%2==0)
                        $bgcolor='class="grey_td"';
                    else
                        $bgcolor="";                
                    $listed_record_id=$data_ptr_sel1['bank_id']; 
                    //include "include/paging_script.php";
                    echo '<tr>';
                    echo '<td align="center">'.$i.'</td>';
					
					$search_cm_id=" and cm_id ='".$data_ptr_sel1['cm_id']."'";
					$search_cm_id_i=" and i.cm_id ='".$data_ptr_sel1['cm_id']."'";
					
					$sel_bal="select branch_name from site_setting where cm_id='".$data_ptr_sel1['cm_id']."'";
					$ptr_bal=mysql_query($sel_bal,$link1);
					$dara_bal=mysql_fetch_array($ptr_bal);
					
                    echo '<td align="center">'.$dara_bal['branch_name'].'</td>';
					//================FOR ISAS PVT LTD==================
					$sel_bank="select bank_name,account_no from bank where bank_id='".$data_ptr_sel1['bank_name']."'";
					$ptr_bank=mysql_query($sel_bank,$link1);
					$data_bank_name=mysql_fetch_array($ptr_bank);
					
					$data_sel_expense_amount=0;
					$sel_expense="select SUM(payable_amount) as total_amt from expense_invoice where bank_id='".$data_ptr_sel1['bank_name']."' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_expense_bank_id=mysql_query($sel_expense,$link1);
					if($num_data=mysql_num_rows($ptr_expense_bank_id))
					{
						$data_sel_expense=mysql_fetch_array($ptr_expense_bank_id);
						$data_sel_expense_amount=$data_sel_expense['total_amt'];
					}
					
					$data_sel_refund_amount=0;
					$sel_refund="select SUM(total_refund) as total_amt from enrollment_refund where bank_name='".$data_ptr_sel1['bank_name']."' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_refund_bank_id=mysql_query($sel_refund,$link1);
					if($num_data1=mysql_num_rows($ptr_refund_bank_id))
					{
						$data_sel_refund=mysql_fetch_array($ptr_refund_bank_id);
						$data_sel_refund_amount=$data_sel_refund['total_amt'];
					}
					$data_sel_recipt_out_amount=0;
					$sel_receipt_out="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel1['bank_name']."' and cash_transfer_mode='inword' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_bank_id_out=mysql_query($sel_receipt_out,$link1);
					if($num_rec=mysql_num_rows($ptr_bank_id_out))
					{
						$data_sel_recipt_out=mysql_fetch_array($ptr_bank_id_out);
						$data_sel_recipt_out_amount=$data_sel_recipt_out['total_amt'];
					}
					
					$data_inv_amount=0;
					$sel_inv="select SUM(payable_amount) as total_amt from inventory_invoice where bank_id='".$data_ptr_sel1['bank_name']."' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptrinv=mysql_query($sel_inv,$link1);
					if($num_inv=mysql_num_rows($ptrinv))
					{
						$data_inv=mysql_fetch_array($ptrinv);
						$data_inv_amount=$data_inv['total_amt'];
					}

					$data_cc_expense_amount=0;
					$sel_cc_expense="select SUM(amount) as total_amt from expense where cc_bank_name='".$data_ptr_sel1['bank_name']."' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_cc_expense=mysql_query($sel_cc_expense,$link1);
					if($num_expe=mysql_num_rows($ptr_cc_expense))
					{
						$data_cc_expense=mysql_fetch_array($ptr_cc_expense);
						$data_cc_expense_amount=$data_cc_expense['total_amt'];
					}
					
					$data_bank_out_amount=0;
					$sel_bank_out="select SUM(amount) as total_amt from receipt where from_bank_name='".$data_ptr_sel1['bank_name']."' and category='cash_transfer' and cash_transfer_mode='bank_to_bank' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_bank_out=mysql_query($sel_bank_out,$link1);
					if($num_banko=mysql_num_rows($ptr_bank_out))
					{
						$data_bank_out=mysql_fetch_array($ptr_bank_out);
						$data_bank_out_amount=$data_bank_out['total_amt'];
					}
					
					$outgoing=$data_sel_expense_amount + $data_sel_recipt_out_amount+$data_inv_amount+$data_cc_expense_amount+$data_bank_out_amount+$data_sel_refund_amount;

					$data_total_inc_amount=0;
					$sel_total_inc="select SUM(amount) as total_amt from invoice where bank_name='".$data_ptr_sel1['bank_name']."' and DATE(`added_date`) = '".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_total_inc=mysql_query($sel_total_inc,$link1);
					if($num_inc=mysql_num_rows($ptr_total_inc))
					{
						$data_total_inc=mysql_fetch_array($ptr_total_inc);
						$data_total_inc_amount=$data_total_inc['total_amt'];
					}
					
					$data_total_inc2_amount=0;
					$sel_total_inc2="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel1['bank_name']."' and (cash_transfer_mode = 'outword' OR cash_transfer_mode IS NULL ) and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_total_inc2=mysql_query($sel_total_inc2,$link1);
					if($num_inc2=mysql_num_rows($ptr_total_inc2))
					{
						$data_total_inc2=mysql_fetch_array($ptr_total_inc2);
						$data_total_inc2_amount=$data_total_inc2['total_amt'];
					}
					
					$data_total_inc3_amount=0;
					$sel_total_inc3="select SUM(payable_amount) as total_amt from customer_service_invoice where bank_id='".$data_ptr_sel1['bank_name']."'  and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_total_inc3=mysql_query($sel_total_inc3,$link1);
					if($num_inc3=mysql_num_rows($ptr_total_inc3))
					{
						$data_total_inc3=mysql_fetch_array($ptr_total_inc3);
						$data_total_inc3_amount=$data_total_inc3['total_amt'];
					}
					
					$data_total_inc4_amount=0;
					$sel_total_inc4="select SUM(payable_amount) as total_amt from sales_product_invoice where bank_id='".$data_ptr_sel1['bank_name']."'  and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_total_inc4=mysql_query($sel_total_inc4,$link1);
					if($num_inc4=mysql_num_rows($ptr_total_inc4))
					{
						$data_total_inc4=mysql_fetch_array($ptr_total_inc4);
						$data_total_inc4_amount=$data_total_inc4['total_amt'];
					}
					
					$data_total_inc5_amount=0;
					$sel_total_inc5="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where bank_id='".$data_ptr_sel1['bank_name']."'  and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_total_inc=mysql_query($sel_total_inc5,$link1);
					if($num_inc5=mysql_num_rows($ptr_total_inc))
					{
						$data_total_inc5=mysql_fetch_array($ptr_total_inc5);
						$data_total_inc5_amount=$data_total_inc5['total_amt'];
					}
					
					$data_total_inc6_amount=0;
					$sel_total_inc6="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel1['bank_name']."' and category='cash_transfer' and cash_transfer_mode='bank_to_bank' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_total_inc6=mysql_query($sel_total_inc6,$link1);
					if($num_inc6=mysql_num_rows($ptr_total_inc6))
					{
						$data_total_inc6=mysql_fetch_array($ptr_total_inc6);
						$data_total_inc6_amount=mysql_fetch_array($ptr_total_inc6);
					}
					
					$total_todays_bal=$data_total_inc_amount+$data_total_inc2_amount+$data_total_inc3_amount+$data_total_inc4_amount+$data_total_inc5_amount+$data_total_inc6_amount;
					
					$data_yesterday_amount=0;
					$sele_yesterday_bal="select todays_balance from dsr_bank_summery where bank_id='".$data_ptr_sel1['bank_name']."' ".$_SESSION['where']." ".$search_cm_id." and added_date=DATE_SUB('".$date."', INTERVAL 1 DAY) order by added_date desc limit 0,1 "; //and added_date = '".$prv_date."'
					$ptr_yest=mysql_query($sele_yesterday_bal,$link1);
					if($num_yesterday=mysql_num_rows($ptr_yest))
					{
						$data_yesterday=mysql_fetch_array($ptr_yest);
						$data_yesterday_amount=$data_yesterday['todays_balance'];
					}
					
					$total_todays_bank= floatval($total_todays_bal+$data_yesterday_amount) - $outgoing;
					$tot=$total_todays_bank;
					
					$tot_todays_incoming +=$total_todays_bal;
					$tot_todays_outgoing +=$outgoing;
					$tot_yesterday_bank +=$data_yesterday_amount;
					$tot_todays_bank +=$total_todays_bank;
					//echo '<td align="center" style="border:1px solid #CCC">'.$k.'</td> <input type="hidden" name="total_banks" value="'.$total_bank.'"  />';       
					echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td> <input type="hidden" name="bank_id_'.$k.'" value="'.$data_bank_name['bank_name'].'" />';
					echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td> <input type="hidden" name="account_no_'.$k.'" value="'.$data_bank_name['account_no'].'"/>';
					echo '<td align="center" style="border:1px solid #CCC">'.$total_todays_bal.'</td> <input type="hidden" name="incoming_'.$k.'" value="'.$total_todays_bal.'"  />';
					echo '<td align="center" style="border:1px solid #CCC">'.$outgoing.'</td> <input type="hidden" name="outgoing_'.$k.'" value="'.$outgoing.'"  />';
					echo '<td align="center" style="border:1px solid #CCC">'.$data_yesterday_amount.'</td><input type="hidden" name="yesterday_bal_'.$k.'"value="'.$data_yesterday['todays_balance'].'"/>';
					echo '<td align="center" style="border:1px solid #CCC">'.$total_todays_bank.'</td> <input type="hidden" name="todays_bal_'.$k.'" value="'.$total_todays_bank.'"  />';
					
					//=================== Cash Balance===============================
					$sele_cm="select DISTINCT(cm_id) as cm_id from bank where 1 and status='Active' and show_in_report !='No' order by cm_id desc";
					$ptr_cm=mysql_query($sele_cm,$link1);
					if(mysql_num_rows($ptr_cm))
					{
						$data_cmids=mysql_fetch_array($ptr_cm);
						
						$search_cm_id=" and cm_id ='".$data_cmids['cm_id']."'";
						$search_cm_id_i=" and i.cm_id ='".$data_cmids['cm_id']."'";
					
						$data_ptr_sel_amount=0;
						$sel_inv="select SUM(amount) as total_amt from invoice where paid_type='1' and DATE(`added_date`) = '".$date."' ".$_SESSION['where']." ".$search_cm_id."";
						$ptr_amnt=mysql_query($sel_inv,$link1);
						if($total=mysql_num_rows($ptr_amnt))
						{
							$data_ptr_sel=mysql_fetch_array($ptr_amnt);
							$data_ptr_sel_amount=$data_ptr_sel['total_amt'];
						}
						
						$data_sel_recipt_amount=0;
						$sel_receipt="select SUM(amount) as total_amt from receipt where payment_mode_id='1' and category !='cash_transfer' and category !='innocent' and category !='santosh' and category !='voucher' and cash_type='business_cash' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
						$ptr_bank_id=mysql_query($sel_receipt,$link1);
						if($num_recp=mysql_num_rows($ptr_bank_id))
						{
							$data_sel_recipt=mysql_fetch_array($ptr_bank_id);
							$data_sel_recipt_amount=$data_sel_recipt['total_amt'];
						}
						
						$data_sel_recipt_petty_cash_amount=0;
						$sel_receipt_petty="select SUM(amount) as total_amt from receipt where payment_mode_id='1' and category !='cash_transfer' and category !='innocent' and category !='santosh' and category !='voucher' and cash_type='petty_cash' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
						$ptr_petty_cash=mysql_query($sel_receipt_petty,$link1);
						if($num_petty=mysql_num_rows($ptr_petty_cash))
						{
							$data_sel_recipt_petty_cash=mysql_fetch_array($ptr_petty_cash);
							$data_sel_recipt_petty_cash_amount=$data_sel_recipt_petty_cash['total_amt'];
						}
						
						$data_sel_voucher_amount=0;
						$sel_voucher="select SUM(amount) as total_amt from receipt where payment_mode_id='1' and category ='voucher' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
						$ptr_voucher=mysql_query($sel_voucher,$link1);
						if($numvoucher=mysql_num_rows($ptr_voucher))
						{
							$data_sel_voucher=mysql_fetch_array($ptr_voucher);
							$data_sel_voucher_amount=$data_sel_voucher['total_amt'];
						}
								
						//===================Cash received from sir===============================
						$data_cash_received_sir_amount=0;
						$sel_cash_received_sir="select SUM(amount) as total_amt from receipt where category ='santosh' and cash_type='business_cash' and payment_mode_id='1' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
						$ptr_cash_received_sir=mysql_query($sel_cash_received_sir,$link1);
						if($num_sir=mysql_num_rows($ptr_cash_received_sir))
						{
							$data_cash_received_sir=mysql_fetch_array($ptr_cash_received_sir);
							$data_cash_received_sir_amount=$data_cash_received_sir['total_amt'];
						}
						
						$data_cash_received_sir_in_petty_amount=0;
						$sel_cash_received_sir_in_petty="select SUM(amount) as total_amt from receipt where category ='santosh' and cash_type='petty_cash' and payment_mode_id='1' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
						$ptr_cash_received_sir_in_petty=mysql_query($sel_cash_received_sir_in_petty,$link1);
						if($num_sir_petty=mysql_num_rows($ptr_cash_received_sir_in_petty))
						{
							$data_cash_received_sir_in_petty=mysql_fetch_array($ptr_cash_received_sir_in_petty);
							$data_cash_received_sir_in_petty_amount=$data_cash_received_sir_in_petty['total_amt'];
						}
						
						$data_total_expense_amount=0;
						$sel_total_expense="select SUM(i.payable_amount) as total_amt from expense e,expense_invoice i where i.expense_id=e.expense_id and i.paid_type ='1' and e.expense_type_id !='1' and e.expense_type_id !='119'  and e.expense_type_id !='120' and e.cash_type='petty_cash' and i.added_date='".$date."' ".$where_i." ".$search_cm_id_i."";
						$ptr_total_expense=mysql_query($sel_total_expense,$link1);
						if($num_expense=mysql_num_rows($ptr_total_expense))
						{
							$data_total_expense=mysql_fetch_array($ptr_total_expense);
							$data_total_expense_amount=$data_total_expense['total_amt'];
						}
						
						$data_total_expense_business_amount=0;
						$sel_total_expense_business="select SUM(i.payable_amount) as total_amt from expense e,expense_invoice i where i.expense_id=e.expense_id and i.paid_type ='1' and e.expense_type_id !='1' and e.expense_type_id !='119'  and e.expense_type_id !='120' and e.cash_type='business_cash' and i.added_date='".$date."' ".$where_i." ".$search_cm_id_i."";
						$ptr_total_expense_business=mysql_query($sel_total_expense_business,$link1);
						if($num_exp_b=mysql_num_rows($ptr_total_expense_business))
						{
							$data_total_expense_business=mysql_fetch_array($ptr_total_expense_business);
							$data_total_expense_business_amount=$data_total_expense_business['total_amt'];
						}
									
						//===================Total Cash Refund===============================
						$data_total_refund_amount=0;
						$sel_total_refund="select SUM(total_refund) as total_amt from enrollment_refund where paid_type ='1' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
						$ptr_total_refund=mysql_query($sel_total_refund,$link1);
						if($num_ref=mysql_num_rows($ptr_total_refund))
						{
							$data_total_refund=mysql_fetch_array($ptr_total_refund);
							$data_total_refund_amount=$data_total_refund['total_amt'];
						}
						
						//===================Cash Given to sir===============================
						$data_cash_from_sir_petty_amount=0;
						$sel_cash_from_sir_petty="select SUM(i.payable_amount) as total_amt from expense e,expense_invoice i where i.expense_id=e.expense_id and i.paid_type ='1' and (expense_type_id='1' or expense_type_id='119' or expense_type_id='120') and cash_type='petty_cash' and i.added_date='".$date."' ".$where_i." ".$search_cm_id_i."";
						$ptr_cash_from_sir_petty=mysql_query($sel_cash_from_sir_petty,$link1);
						if($num_c_petty=mysql_num_rows($ptr_cash_from_sir_petty))
						{
							$data_cash_from_sir_petty=mysql_fetch_array($ptr_cash_from_sir_petty);
							$data_cash_from_sir_petty_amount=$data_cash_from_sir_petty['total_amt'];
						}
						
						$data_cash_from_sir_business_amount=0;
						$sel_cash_from_sir_business="select SUM(i.payable_amount) as total_amt from expense e,expense_invoice i where i.expense_id=e.expense_id and i.paid_type ='1' and (expense_type_id='1' or expense_type_id='119' or expense_type_id='120') and cash_type='business_cash' and i.added_date='".$date."' ".$where_i." ".$search_cm_id_i."";
						$ptr_cash_from_sir_business=mysql_query($sel_cash_from_sir_business,$link1);
						if($num_s_buss=mysql_num_rows($ptr_cash_from_sir_business))
						{
							$data_cash_from_sir_business=mysql_fetch_array($ptr_cash_from_sir_business);
							$data_cash_from_sir_business_amount=$data_cash_from_sir_business['total_amt'];
						}
						
						//====================CASH TRANSFER - INWORD =======================================
						$data_cash_rec_amount=0;
						$sel_cash_rec="select SUM(amount) as total_amt from receipt where 1 and category='cash_transfer' and (cash_transfer_mode is NULL or cash_transfer_mode !='outword' ) and cash_transfer_mode!= 'bank_to_bank' and category !='santosh' and category !='voucher' and cash_transfer_mode!='cash_to_cash' and cash_type='business_cash' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
						$ptr_cash_rec=mysql_query($sel_cash_rec,$link1);
						if($num_rec=mysql_num_rows($ptr_cash_rec))
						{
							$data_cash_rec=mysql_fetch_array($ptr_cash_rec); //cash_type='business_cash' (3/6/19)
							$data_cash_rec_amount=$data_cash_rec['total_amt'];
						}
						
						//=============================SERVICE===============================================
						$data_service_amount=0;
						$total_service=0;
						$sel_service="select SUM(payable_amount) as total_amt from customer_service_invoice where paid_type='1' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
						$ptr_service=mysql_query($sel_service,$link1);
						if($num_serv=mysql_num_rows($ptr_service))
						{
							$data_service=mysql_fetch_array($ptr_service);
							$data_service_amount=$data_service['total_amt'];
							$total_service=$data_service_amount;
						}
						
						$data_membership_amount=0;
						$sel_memb="select SUM(price) as total_amt from customer where payment_mode_id='1' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
						$ptr_memb=mysql_query($sel_memb,$link1);
						if($num_memb=mysql_num_rows($ptr_memb))
						{
							$data_membership=mysql_fetch_array($ptr_memb);
							$data_membership_amount=$data_membership['total_amt'];
						}
						
						//=============================PRODUCT===============================================
						$data_product_amount=0;
						$sel_product="select SUM(payable_amount) as total_amt from inventory_invoice where paid_type='1' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
						$ptr_product=mysql_query($sel_product,$link1);
						if($num_products=mysql_num_rows($ptr_product))
						{
							$data_product=mysql_fetch_array($ptr_product);
							$data_product_amount=$data_product['total_amt'];
						}
						
						$data_sales_product_amount=0;
						$sel_sales_product="select SUM(payable_amount) as total_amt from sales_product_invoice where paid_type='1' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
						$ptr_sales_product=mysql_query($sel_sales_product,$link1);
						if($num_s_product=mysql_num_rows($ptr_sales_product))
						{
							$data_sales_product=mysql_fetch_array($ptr_sales_product);
							$data_sales_product_amount=$data_sales_product['total_amt'];
						}
						
						$total_produts=$data_product_amount-$data_sales_product_amount;
						
						$data_sales_membership_amount=0;
						$sel_sales_membership="select SUM(price) as total_amt from customer where payment_mode_id='1' and membership='yes' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
						$ptr_sales_membership=mysql_query($sel_sales_membership,$link1);
						if($num_sale_mem=mysql_num_rows($ptr_sales_membership))
						{
							$data_sales_membership=mysql_fetch_array($ptr_sales_membership);
							$data_sales_membership_amount=$data_sales_membership['total_amt'];
						}
						
						$data_sales_package_amount=0;
						$sel_sales_package="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where payment_mode_id='1' and category='Package' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
						$ptr_sales_package=mysql_query($sel_sales_package,$link1);
						if($num_pkg=mysql_num_rows($ptr_sales_package))
						{
							$data_sales_package=mysql_fetch_array($ptr_sales_package);
							$data_sales_package_amount=$data_sales_package['total_amt'];
						}
						
						$data_sales_voucher_amount=0;
						$sel_sales_voucher="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where payment_mode_id='1' and category='Voucher' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
						$ptr_sales_voucher=mysql_query($sel_sales_voucher,$link1);
						if($num_vouc=mysql_num_rows($ptr_sales_voucher))
						{
							$data_sales_voucher=mysql_fetch_array($ptr_sales_voucher);
							$data_sales_voucher_amount=$data_sales_voucher['total_amt'];
						}
						
						//=================================Cash Withdrawl in petty cash====================== (3/6/19)
						$cash_withdrawl_in_petty_cash=0;
						$sel_withd="select SUM(amount) as total_amt from receipt where cash_transfer_mode='inword' and cash_type='petty_cash' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
						$ptr_cash_withd=mysql_query($sel_withd,$link1);
						if(mysql_num_rows($ptr_cash_withd))
						{
							$data_cash_withdrawl=mysql_fetch_array($ptr_cash_withd);
							$cash_withdrawl_in_petty_cash=$data_cash_withdrawl['total_amt'];
						}
						//=================================Cash Transfer in petty cash====================== (27/6/19)
						$cash_transfer_in_petty_cash=0;
						$sel_transf="select SUM(amount) as total_amt from receipt where cash_transfer_mode='cash_to_cash' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
						$ptr_cash_transf=mysql_query($sel_transf,$link1);
						if(mysql_num_rows($ptr_cash_transf))
						{
							$data_cash_transfer=mysql_fetch_array($ptr_cash_transf);
							$cash_transfer_in_petty_cash=$data_cash_transfer['total_amt'];
						}
						//===================================================================================
						//$prv_date = trim(date('Y-m-d',strtotime('-1 day')));
						$prv_date =date('Y-m-d', strtotime('-1 day', strtotime($date)));
						//$opening_cash=$total_yest_bal;
						$opening_cash1=0;
						$opening_petty_cash=0; //(3/6/19)
						
						$sele_yest_bal="select cash_in_hand,petty_cash_in_hand from dsr where 1 ".$_SESSION['where']." ".$search_cm_id." and added_date = '".$prv_date."' order by dsr_id desc limit 0,1"; //where added_date = '".$prv_date."'
						$ptr_yest1=mysql_query($sele_yest_bal,$link1);
						if(mysql_num_rows($ptr_yest1))
						{
							$data_yest_bal=mysql_fetch_array($ptr_yest1);
							$opening_cash1=$data_yest_bal['cash_in_hand'];
							$opening_petty_cash=$data_yest_bal['petty_cash_in_hand']; //(3/6/19)
						}
						$tota_exp1=$data_product_amount+$data_total_expense_amount+$data_total_refund_amount;
						//echo "<br/>expense- 1- ".$data_product_amount." 2- ".$data_total_expense_amount." 3- ".$data_total_refund_amount;
						$tota_exp_business1=$data_total_expense_business_amount;
						//===================Cash Deposited in Bank===============================
						$sel_dist_bank_id="Select DISTINCT(bank_id) from receipt where added_date='".$date."' and bank_id !='' and (category ='cash_transfer' and category !='voucher' and cash_transfer_mode !='inword' and cash_transfer_mode !='cash_to_cash') and cash_type='business_cash' and payment_mode_id='1' ".$_SESSION['where']." ".$search_cm_id." ";// 29-12-17 category !='cash_transfer'
						$ptr_dist_bank_id=mysql_query($sel_dist_bank_id,$link1);
						$total=mysql_num_rows($ptr_dist_bank_id);
						$is=1;
						$tt='';
						$tots=0;
						while($data_dist_bank_id=mysql_fetch_array($ptr_dist_bank_id))
						{
							$sel_cash_from_bank="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and category ='cash_transfer' and cash_transfer_mode ='outword' and cash_type='business_cash' and payment_mode_id='1' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";// 29-12-17 category !='cash_transfer'
							$ptr_cash_from_bank=mysql_query($sel_cash_from_bank,$link1);
							$data_cash_from_bank=mysql_fetch_array($ptr_cash_from_bank);
							
							$sel_bank_amnt="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and category ='cash_transfer' and cash_transfer_mode ='bank_to_bank' and cash_type='business_cash' and payment_mode_id='1' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";// 29-12-17 category !='cash_transfer'
							$ptr_bank_amnt=mysql_query($sel_bank_amnt,$link1);
							$data_bank_amnt=mysql_fetch_array($ptr_bank_amnt);
							
							$total_bank_bal=$data_cash_from_bank['total_amt']+$data_bank_amnt['total_amt'];
							
							$sel_bank="select bank_name from bank where bank_id='".$data_dist_bank_id['bank_id']."'";
							$ptr_bank=mysql_query($sel_bank,$link1);
							$data_bank_name=mysql_fetch_array($ptr_bank);
							
							//$data_bank_name['bank_name']." : ".$total_bank_bal;
							
							$tots +=$total_bank_bal;
							$tt +=$data_cash_from_bank['total_amt'];
							
							if($is !=$total)
							{
							}
							$is++;
						}
						
						//-----------------------------------CASH DEPSOIT IN BANK from PETYY CASH---------------------------------
						$sel_dist_bank_id1="Select DISTINCT(bank_id) from receipt where added_date='".$date."' and bank_id !='' and (category ='cash_transfer' and category !='voucher' and cash_transfer_mode !='inword' and cash_transfer_mode !='cash_to_cash') and cash_type='petty_cash' and payment_mode_id='1' ".$_SESSION['where']." ".$search_cm_id."";// 29-12-17 category !='cash_transfer'
						$ptr_dist_bank_id=mysql_query($sel_dist_bank_id1,$link1);
						$total1=mysql_num_rows($ptr_dist_bank_id);
						$i1=1;
						$tt1='';
						$tots1=0;
						while($data_dist_bank_id=mysql_fetch_array($ptr_dist_bank_id))
						{
							$sel_cash_from_bank="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and category ='cash_transfer' and cash_transfer_mode ='outword' and cash_type='petty_cash' and payment_mode_id='1' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";// 29-12-17 category !='cash_transfer'
							$ptr_cash_from_bank=mysql_query($sel_cash_from_bank,$link1);
							$data_cash_from_bank=mysql_fetch_array($ptr_cash_from_bank);
							
							$sel_bank_amnt="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and category ='cash_transfer' and cash_transfer_mode ='bank_to_bank' and cash_type='petty_cash' and payment_mode_id='1' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." "; // 29-12-17 category !='cash_transfer'
							$ptr_bank_amnt=mysql_query($sel_bank_amnt,$link1);
							$data_bank_amnt=mysql_fetch_array($ptr_bank_amnt);
							
							$total_bank_bal=$data_cash_from_bank['total_amt']+$data_bank_amnt['total_amt'];
							
							$sel_bank="select bank_name from bank where bank_id='".$data_dist_bank_id['bank_id']."'";
							$ptr_bank=mysql_query($sel_bank,$link1);
							$data_bank_name=mysql_fetch_array($ptr_bank);
							
							$data_bank_name['bank_name']." : ".$total_bank_bal;
							$tots1 +=$total_bank_bal;
							$tt1 +=$data_cash_from_bank['total_amt'];
							
							if($i1 !=$total1)
							{
								
							}
							$i1++;
						}				
						//====================================CASH IN HAND================================================
						$data_total_inc1_amount=0;
						$sel_total_inc1="select SUM(amount) as total_amt from invoice where DATE(`added_date`) = '".$date."' and (bank_name='' or bank_name= 'select') ".$_SESSION['where']." ".$search_cm_id."";
						$ptr_total_inc1=mysql_query($sel_total_inc1,$link1);
						if(mysql_num_rows($ptr_total_inc1))
						{
							$data_total_inc1=mysql_fetch_array($ptr_total_inc1);
							$data_total_inc1_amount=$data_total_inc1['total_amt'];
						}
						
						$data_total_inc21_amount=0;
						$sel_total_inc21="select SUM(amount) as total_amt from receipt where category !='cash_transfer' and category !='voucher'  and added_date='".$date."' and bank_id='' ".$_SESSION['where']." ".$search_cm_id."";
						$ptr_total_inc21=mysql_query($sel_total_inc21,$link1);
						if(mysql_num_rows($ptr_total_inc21))
						{
							$data_total_inc21=mysql_fetch_array($ptr_total_inc21);
							$data_total_inc21_amount=$data_total_inc21['total_amt'];
						}
						
						$cash_in_hand=$data_total_inc1_amount+$data_total_inc21_amount;
						$total_cash_fees=$data_ptr_sel_amount;
						$total_cash_product= $data_sel_recipt_amount;
						//========================================BUSINESS CASH IN HAND===========================================
						$cash_in_hands=$opening_cash1 + $data_ptr_sel_amount +$data_sel_recipt_amount+$total_service + $data_sales_product_amount+$data_cash_received_sir_amount + $data_sel_voucher_amount + $data_sales_membership_amount + $data_sales_package_amount+$data_sales_voucher_amount+$data_cash_rec_amount-$cash_transfer_in_petty_cash - $data_cash_from_sir_business_amount- $tota_exp_business1 - $tots ;
						
						//echo "<br/>expense- 1- ".$data_product_amount." 2- ".$data_total_expense_amount." 3- ".$data_total_refund_amount;
						//echo "<br/>1- ".$opening_cash1.'2- '.$data_ptr_sel_amount.'3-'.$data_sel_recipt_amoun.'4-'.$total_service.'5-'.$data_sales_product_amount.'6-'.$data_cash_received_sir_amount.'7-'.$data_sel_voucher_amount.'8-'.$data_sales_membership_amount.'9-'.$data_sales_package_amount.'10-'.$data_sales_voucher_amount.'11-'.$data_cash_rec_amount.'12-'.$cash_transfer_in_petty_cash.'13-'.$data_cash_from_sir_business_amount.'14-'.$tota_exp_business1.' 15-'.$tots;
						//========================================PETTY CASH IN HAND===========================================
						$petty_cash_in_hands=intval($data_sel_recipt_petty_cash_amount + $opening_petty_cash + $cash_withdrawl_in_petty_cash + $cash_transfer_in_petty_cash - $tota_exp1 - $data_cash_from_sir_petty_amount+$data_cash_received_sir_in_petty_amount - $tots1) ; //(3/6/19)
						
						//echo "<br/>petty cash - 1- (".$data_sel_recipt_petty_cash_amount.")+2- (".$opening_petty_cash.")+3- (".$cash_withdrawl_in_petty_cash.")+4- (".$cash_transfer_in_petty_cash.")-5- (".$tota_exp1.")-6- (".$data_cash_from_sir_petty_amount.")+7- (".$data_cash_received_sir_in_petty_amount.")-8- (".$tots1.")";
						//echo "<br/>expense- 1- ".$data_product_amount." 2- ".$data_total_expense_amount." 3- ".$data_total_refund_amount;
						//echo "<br/>1- ".$opening_cash1.'2- '.$data_ptr_sel_amount.'3-'.$data_sel_recipt_amoun.'4-'.$total_service.'5-'.$data_sales_product_amount.'6-'.$data_cash_received_sir_amount.'7-'.$data_sel_voucher_amount.'8-'.$data_sales_membership_amount.'9-'.$data_sales_package_amount.'10-'.$data_sales_voucher_amount.'11-'.$data_cash_rec_amount.'12-'.$cash_transfer_in_petty_cash.'13-'.$data_cash_from_sir_business_amount.'14-'.$tota_exp_business1.' 15-'.$tots;
						//=====================================================================================================
						
						$tot_toaday_business_cash +=$cash_in_hands;
						$tot_todays_petty_cash +=$petty_cash_in_hands;
						
						echo '<td align="center" style="border:1px solid #CCC">'.round($cash_in_hands,2).'</td> <input type="hidden" name="cash_in_hand" value="'.round($cash_in_hands,2).'"  />';
						echo '<td align="center" style="border:1px solid #CCC">'.round($petty_cash_in_hands,2).'</td> <input type="hidden" name="petty_cash_in_hand" value="'.round($petty_cash_in_hands,2).'" >';	//(3/6/19)
					}
					else
					{
						echo '<td></td><td></td>';
					}
					//===============================================================
					echo '</tr>';
                    $i++;
					$k++;
					$bgColorCounter++;
                }
			}
			
			//==============**************===== ISAS LLP ====****************==============
			$cash_in_hands='';
			$petty_cash_in_hands='';
			$opening_cash1='';
			$opening_petty_cash='';
			$tota_exp_business2='';
			$tots='';
			$cash_withdrawl_in_petty_cash='';
			$cash_transfer_in_petty_cash='';
			$tota_exp2='';
			$tots1='';
			$outgoing='';
			$total_todays_bal='';
			$search_cm_id='';
			$sql_query1="select DISTINCT(bank_id) as bank_name,cm_id from bank where 1 and status='Active' ".$_SESSION['where']." ".$search_cm_id." and show_in_report !='No'";
			$ptr_records1=mysql_query($sql_query1,$link2); //and system_status='Enabled'
			$no_of_records +=mysql_num_rows($ptr_records1);
			if($no_of_records)
			{
				while($data_ptr_sel2=mysql_fetch_array($ptr_records1))
				{
					$name = '';
					$tota_exp2=0;
					$tota_exp_business2=0;
					if($bgColorCounter%2==0)
						$bgcolor='class="grey_td"';
					else
						$bgcolor="";                
					$listed_record_id=$data_ptr_sel2['bank_id'];
					$search_cm_id=" and cm_id ='".$data_ptr_sel2['cm_id']."'"; 
					$search_cm_id_i=" and i.cm_id ='".$data_ptr_sel2['cm_id']."'";
					//include "include/paging_script.php";
					echo '<tr>';
					echo '<td align="center">'.$i.'</td>';
					
					$sel_bal="select branch_name from site_setting where cm_id='".$data_ptr_sel2['cm_id']."'";
					$ptr_bal=mysql_query($sel_bal,$link2);
					$dara_bal=mysql_fetch_array($ptr_bal);
					
					if($data_ptr_sel2['cm_id']=='2')
					{
						$branch_names='ISAS LLP Pune';
					}
					else
						$branch_names=$dara_bal['branch_name'];
						
					echo '<td align="center">'.$branch_names.'</td>';
					$sel_bank="select bank_name,account_no from bank where bank_id='".$data_ptr_sel2['bank_name']."'";
					$ptr_bank=mysql_query($sel_bank,$link2);
					$data_bank_name=mysql_fetch_array($ptr_bank);
					
					$data_sel_expense_amount1=0;
					$sel_expense="select SUM(payable_amount) as total_amt from expense_invoice where bank_id='".$data_ptr_sel2['bank_name']."' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					if($ptr_expense_bank_id=mysql_query($sel_expense,$link2))
					{
						$data_sel_expense=mysql_fetch_array($ptr_expense_bank_id);
						$data_sel_expense_amount1=$data_sel_expense['total_amt'];
					}
					
					$data_sel_refund_amount1=0;
					$sel_refund="select SUM(total_refund) as total_amt from enrollment_refund where bank_name='".$data_ptr_sel2['bank_name']."' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_refund_bank_id=mysql_query($sel_refund,$link2);
					if($num_data1=mysql_num_rows($ptr_refund_bank_id))
					{
						$data_sel_refund=mysql_fetch_array($ptr_refund_bank_id);
						$data_sel_refund_amount1=$data_sel_refund['total_amt'];
					}
					
					$data_sel_recipt_out_amount1=0;
					$sel_receipt_out="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel2['bank_name']."' and cash_transfer_mode='inword' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_bank_id_out=mysql_query($sel_receipt_out,$link2);
					if($num_rec=mysql_num_rows($ptr_bank_id_out))
					{
						$data_sel_recipt_out=mysql_fetch_array($ptr_bank_id_out);
						$data_sel_recipt_out_amount1=$data_sel_recipt_out['total_amt'];
					}
					
					$data_inv_amount1=0;
					$sel_inv="select SUM(payable_amount) as total_amt from inventory_invoice where bank_id='".$data_ptr_sel2['bank_name']."' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptrinv=mysql_query($sel_inv,$link1);
					if($num_inv=mysql_num_rows($ptrinv))
					{
						$data_inv=mysql_fetch_array($ptrinv);
						$data_inv_amount1=$data_inv['total_amt'];
					}
					
					$data_cc_expense_amount1=0;
					$sel_cc_expense="select SUM(amount) as total_amt from expense where cc_bank_name='".$data_ptr_sel2['bank_name']."' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_cc_expense=mysql_query($sel_cc_expense,$link2);
					if($num_expe=mysql_num_rows($ptr_cc_expense))
					{
						$data_cc_expense=mysql_fetch_array($ptr_cc_expense);
						$data_cc_expense_amount1=$data_cc_expense['total_amt'];
					}
					
					$data_bank_out_amount1=0;
					$sel_bank_out="select SUM(amount) as total_amt from receipt where from_bank_name='".$data_ptr_sel2['bank_name']."' and category='cash_transfer' and cash_transfer_mode='bank_to_bank' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_bank_out=mysql_query($sel_bank_out,$link2);
					if($num_banko=mysql_num_rows($ptr_bank_out))
					{
						$data_bank_out=mysql_fetch_array($ptr_bank_out);
						$data_bank_out_amount1=$data_bank_out['total_amt'];
					}
					
					$outgoing=$data_sel_expense_amount1 + $data_sel_recipt_out_amount1+$data_inv_amount1+$data_cc_expense_amount1+$data_bank_out_amount1+$data_sel_refund_amount1;
			
					$data_total_inc_amount1=0;
					$sel_total_inc="select SUM(amount) as total_amt from invoice where bank_name='".$data_ptr_sel2['bank_name']."' and DATE(`added_date`) = '".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_total_inc=mysql_query($sel_total_inc,$link2);
					if($num_inc=mysql_num_rows($ptr_total_inc))
					{
						$data_total_inc=mysql_fetch_array($ptr_total_inc);
						$data_total_inc_amount1=$data_total_inc['total_amt'];
					}
					
					$data_total_inc2_amount1=0;
					$sel_total_inc2="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel2['bank_name']."' and (cash_transfer_mode = 'outword' OR cash_transfer_mode IS NULL ) and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_total_inc2=mysql_query($sel_total_inc2,$link2);
					if($num_inc2=mysql_num_rows($ptr_total_inc2))
					{
						$data_total_inc2=mysql_fetch_array($ptr_total_inc2);
						$data_total_inc2_amount1=$data_total_inc2['total_amt'];
					}
					
					$data_total_inc3_amount1=0;
					$sel_total_inc3="select SUM(payable_amount) as total_amt from customer_service_invoice where bank_id='".$data_ptr_sel2['bank_name']."'  and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_total_inc3=mysql_query($sel_total_inc3,$link2);
					if($num_inc3=mysql_num_rows($ptr_total_inc3))
					{
						$data_total_inc3=mysql_fetch_array($ptr_total_inc3);
						$data_total_inc3_amount1=$data_total_inc3['total_amt'];
					}
					
					$data_total_inc4_amount1=0;
					$sel_total_inc4="select SUM(payable_amount) as total_amt from sales_product_invoice where bank_id='".$data_ptr_sel2['bank_name']."'  and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_total_inc4=mysql_query($sel_total_inc4,$link2);
					if($num_inc4=mysql_num_rows($ptr_total_inc4))
					{
						$data_total_inc4=mysql_fetch_array($ptr_total_inc4);
						$data_total_inc4_amount1=$data_total_inc4['total_amt'];
					}
					
					$data_total_inc5_amount1=0;
					$sel_total_inc5="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where bank_id='".$data_ptr_sel2['bank_name']."'  and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_total_inc=mysql_query($sel_total_inc5,$link2);
					if($num_inc5=mysql_num_rows($ptr_total_inc))
					{
						$data_total_inc5=mysql_fetch_array($ptr_total_inc5);
						$data_total_inc5_amount1=$data_total_inc5['total_amt'];
					}
					
					$data_total_inc6_amount1=0;
					$sel_total_inc6="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel2['bank_name']."' and category='cash_transfer' and cash_transfer_mode='bank_to_bank' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_total_inc6=mysql_query($sel_total_inc6,$link2);
					if($num_inc6=mysql_num_rows($ptr_total_inc6))
					{
						$data_total_inc6=mysql_fetch_array($ptr_total_inc6);
						$data_total_inc6_amount1=mysql_fetch_array($ptr_total_inc6);
					}
					
					$total_todays_bal=$data_total_inc_amount1+$data_total_inc2_amount1+$data_total_inc3_amount1+$data_total_inc4_amount1+$data_total_inc5_amount1+$data_total_inc6_amount1;
					
					$data_yesterday_amount1=0;
					$sele_yesterday_bal="select todays_balance from dsr_bank_summery where bank_id='".$data_ptr_sel2['bank_name']."' ".$_SESSION['where']." ".$search_cm_id." and added_date=DATE_SUB('".$date."', INTERVAL 1 DAY) order by added_date desc limit 0,1 "; //and added_date = '".$prv_date."'
					$ptr_yest=mysql_query($sele_yesterday_bal,$link2);
					if($num_yesterday=mysql_num_rows($ptr_yest))
					{
						$data_yesterday=mysql_fetch_array($ptr_yest);
						$data_yesterday_amount1=$data_yesterday['todays_balance'];
					}
					
					$total_todays_bank= floatval($total_todays_bal+$data_yesterday_amount1) - $outgoing;
					$tot=$total_todays_bank;
					
					$tot_todays_incoming +=$total_todays_bal;
					$tot_todays_outgoing +=$outgoing;
					$tot_yesterday_bank +=$data_yesterday_amount1;
					$tot_todays_bank +=$total_todays_bank;
					
					echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td> <input type="hidden" name="bank_id_'.$k.'" value="'.$data_bank_name['bank_name'].'" />';
					echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td> <input type="hidden" name="account_no_'.$k.'" value="'.$data_bank_name['account_no'].'"/>';
					echo '<td align="center" style="border:1px solid #CCC">'.$total_todays_bal.'</td> <input type="hidden" name="incoming_'.$k.'" value="'.$total_todays_bal.'"  />';
					echo '<td align="center" style="border:1px solid #CCC">'.$outgoing.'</td> <input type="hidden" name="outgoing_'.$k.'" value="'.$outgoing.'"  />';
					echo '<td align="center" style="border:1px solid #CCC">'.$data_yesterday_amount1.'</td><input type="hidden" name="yesterday_bal_'.$k.'"value="'.$data_yesterday_amount1.'"/>';
					echo '<td align="center" style="border:1px solid #CCC">'.$total_todays_bank.'</td> <input type="hidden" name="todays_bal_'.$k.'" value="'.$total_todays_bank.'"  />';
					//====================== CASH BALANCE==============================
					$data_ptr_sel_amount=0;
					$sel_inv="select SUM(amount) as total_amt from invoice where paid_type='1' and DATE(`added_date`) = '".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_amnt=mysql_query($sel_inv,$link2);
					if($total=mysql_num_rows($ptr_amnt))
					{
						$data_ptr_sel=mysql_fetch_array($ptr_amnt);
						$data_ptr_sel_amount=$data_ptr_sel['total_amt'];
					}
					
					$data_sel_recipt_amount=0;
					$sel_receipt="select SUM(amount) as total_amt from receipt where payment_mode_id='1' and category !='cash_transfer' and category !='innocent' and category !='santosh' and category !='voucher' and cash_type='business_cash' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_bank_id=mysql_query($sel_receipt,$link2);
					if($num_recp=mysql_num_rows($ptr_bank_id))
					{
						$data_sel_recipt=mysql_fetch_array($ptr_bank_id);
						$data_sel_recipt_amount=$data_sel_recipt['total_amt'];
					}
					
					$data_sel_recipt_petty_cash_amount=0;
					$sel_receipt_petty="select SUM(amount) as total_amt from receipt where payment_mode_id='1' and category !='cash_transfer' and category !='innocent' and category !='santosh' and category !='voucher' and cash_type='petty_cash' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_petty_cash=mysql_query($sel_receipt_petty,$link2);
					if($num_petty=mysql_num_rows($ptr_petty_cash))
					{
						$data_sel_recipt_petty_cash=mysql_fetch_array($ptr_petty_cash);
						$data_sel_recipt_petty_cash_amount=$data_sel_recipt_petty_cash['total_amt'];
					}
					
					$data_sel_voucher_amount=0;
					$sel_voucher="select SUM(amount) as total_amt from receipt where payment_mode_id='1' and category ='voucher' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_voucher=mysql_query($sel_voucher,$link2);
					if($numvoucher=mysql_num_rows($ptr_voucher))
					{
						$data_sel_voucher=mysql_fetch_array($ptr_voucher);
						$data_sel_voucher_amount=$data_sel_voucher['total_amt'];
					}
							
					//===================Cash received from sir===============================
					$data_cash_received_sir_amount=0;
					$sel_cash_received_sir="select SUM(amount) as total_amt from receipt where category ='santosh' and cash_type='business_cash' and payment_mode_id='1' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_cash_received_sir=mysql_query($sel_cash_received_sir,$link2);
					if($num_sir=mysql_num_rows($ptr_cash_received_sir))
					{
						$data_cash_received_sir=mysql_fetch_array($ptr_cash_received_sir);
						$data_cash_received_sir_amount=$data_cash_received_sir['total_amt'];
					}
					
					$data_cash_received_sir_in_petty_amount=0;
					$sel_cash_received_sir_in_petty="select SUM(amount) as total_amt from receipt where category ='santosh' and cash_type='petty_cash' and payment_mode_id='1' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_cash_received_sir_in_petty=mysql_query($sel_cash_received_sir_in_petty,$link2);
					if($num_sir_petty=mysql_num_rows($ptr_cash_received_sir_in_petty))
					{
						$data_cash_received_sir_in_petty=mysql_fetch_array($ptr_cash_received_sir_in_petty);
						$data_cash_received_sir_in_petty_amount=$data_cash_received_sir_in_petty['total_amt'];
					}
					
					$data_total_expense_amount=0;
					$sel_total_expense="select SUM(i.payable_amount) as total_amt from expense e,expense_invoice i where i.expense_id=e.expense_id and i.paid_type ='1' and e.expense_type_id !='1' and e.expense_type_id !='119'  and e.expense_type_id !='120' and e.cash_type='petty_cash' and i.added_date='".$date."' ".$where_i." ".$search_cm_id_i."";
					$ptr_total_expense=mysql_query($sel_total_expense,$link2);
					if($num_expense=mysql_num_rows($ptr_total_expense))
					{
						$data_total_expense=mysql_fetch_array($ptr_total_expense);
						$data_total_expense_amount=$data_total_expense['total_amt'];
					}
					
					$data_total_expense_business_amount=0;
					$sel_total_expense_business="select SUM(i.payable_amount) as total_amt from expense e,expense_invoice i where i.expense_id=e.expense_id and i.paid_type ='1' and e.expense_type_id !='1' and e.expense_type_id !='119'  and e.expense_type_id !='120' and e.cash_type='business_cash' and i.added_date='".$date."' ".$where_i." ".$search_cm_id_i."";
					$ptr_total_expense_business=mysql_query($sel_total_expense_business,$link2);
					if($num_exp_b=mysql_num_rows($ptr_total_expense_business))
					{
						$data_total_expense_business=mysql_fetch_array($ptr_total_expense_business);
						$data_total_expense_business_amount=$data_total_expense_business['total_amt'];
					}
								
					//===================Total Cash Refund===============================
					$data_total_refund_amount=0;
					$sel_total_refund="select SUM(total_refund) as total_amt from enrollment_refund where paid_type ='1' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_total_refund=mysql_query($sel_total_refund,$link2);
					if($num_ref=mysql_num_rows($ptr_total_refund))
					{
						$data_total_refund=mysql_fetch_array($ptr_total_refund);
						$data_total_refund_amount=$data_total_refund['total_amt'];
					}
					
					//===================Cash Given to sir===============================
					$data_cash_from_sir_petty_amount=0;
					$sel_cash_from_sir_petty="select SUM(i.payable_amount) as total_amt from expense e,expense_invoice i where i.expense_id=e.expense_id and i.paid_type ='1' and (expense_type_id='1' or expense_type_id='119' or expense_type_id='120') and cash_type='petty_cash' and i.added_date='".$date."' ".$where_i." ".$search_cm_id_i."";
					$ptr_cash_from_sir_petty=mysql_query($sel_cash_from_sir_petty,$link2);
					if($num_c_petty=mysql_num_rows($ptr_cash_from_sir_petty))
					{
						$data_cash_from_sir_petty=mysql_fetch_array($ptr_cash_from_sir_petty);
						$data_cash_from_sir_petty_amount=$data_cash_from_sir_petty['total_amt'];
					}
					
					$data_cash_from_sir_business_amount=0;
					$sel_cash_from_sir_business="select SUM(i.payable_amount) as total_amt from expense e,expense_invoice i where i.expense_id=e.expense_id and i.paid_type ='1' and (expense_type_id='1' or expense_type_id='119' or expense_type_id='120') and cash_type='business_cash' and i.added_date='".$date."' ".$where_i." ".$search_cm_id_i."";
					$ptr_cash_from_sir_business=mysql_query($sel_cash_from_sir_business,$link2);
					if($num_s_buss=mysql_num_rows($ptr_cash_from_sir_business))
					{
						$data_cash_from_sir_business=mysql_fetch_array($ptr_cash_from_sir_business);
						$data_cash_from_sir_business_amount=$data_cash_from_sir_business['total_amt'];
					}
					
					//====================CASH TRANSFER - INWORD =======================================
					$data_cash_rec_amount=0;
					$sel_cash_rec="select SUM(amount) as total_amt from receipt where 1 and category='cash_transfer' and (cash_transfer_mode is NULL or cash_transfer_mode !='outword' ) and cash_transfer_mode!= 'bank_to_bank' and category !='santosh' and category !='voucher' and cash_transfer_mode!='cash_to_cash' and cash_type='business_cash' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_cash_rec=mysql_query($sel_cash_rec,$link2);
					if($num_rec=mysql_num_rows($ptr_cash_rec))
					{
						$data_cash_rec=mysql_fetch_array($ptr_cash_rec); //cash_type='business_cash' (3/6/19)
						$data_cash_rec_amount=$data_cash_rec['total_amt'];
					}
					
					//=============================SERVICE===============================================
					$data_service_amount=0;
					$total_service=0;
					$sel_service="select SUM(payable_amount) as total_amt from customer_service_invoice where paid_type='1' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_service=mysql_query($sel_service,$link2);
					if($num_serv=mysql_num_rows($ptr_service))
					{
						$data_service=mysql_fetch_array($ptr_service);
						$data_service_amount=$data_service['total_amt'];
						$total_service=$data_service_amount;
					}
					
					$data_membership_amount=0;
					$sel_memb="select SUM(price) as total_amt from customer where payment_mode_id='1' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_memb=mysql_query($sel_memb,$link2);
					if($num_memb=mysql_num_rows($ptr_memb))
					{
						$data_membership=mysql_fetch_array($ptr_memb);
						$data_membership_amount=$data_membership['total_amt'];
					}
					
					//=============================PRODUCT===============================================
					$data_product_amount=0;
					$sel_product="select SUM(payable_amount) as total_amt from inventory_invoice where paid_type='1' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_product=mysql_query($sel_product,$link2);
					if($num_products=mysql_num_rows($ptr_product))
					{
						$data_product=mysql_fetch_array($ptr_product);
						$data_product_amount=$data_product['total_amt'];
					}
					
					$data_sales_product_amount=0;
					$sel_sales_product="select SUM(payable_amount) as total_amt from sales_product_invoice where paid_type='1' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_sales_product=mysql_query($sel_sales_product,$link2);
					if($num_s_product=mysql_num_rows($ptr_sales_product))
					{
						$data_sales_product=mysql_fetch_array($ptr_sales_product);
						$data_sales_product_amount=$data_sales_product['total_amt'];
					}
					
					$total_produts=$data_product_amount-$data_sales_product_amount;
					
					$data_sales_membership_amount=0;
					$sel_sales_membership="select SUM(price) as total_amt from customer where payment_mode_id='1' and membership='yes' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_sales_membership=mysql_query($sel_sales_membership,$link2);
					if($num_sale_mem=mysql_num_rows($ptr_sales_membership))
					{
						$data_sales_membership=mysql_fetch_array($ptr_sales_membership);
						$data_sales_membership_amount=$data_sales_membership['total_amt'];
					}
					
					$data_sales_package_amount=0;
					$sel_sales_package="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where payment_mode_id='1' and category='Package' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_sales_package=mysql_query($sel_sales_package,$link2);
					if($num_pkg=mysql_num_rows($ptr_sales_package))
					{
						$data_sales_package=mysql_fetch_array($ptr_sales_package);
						$data_sales_package_amount=$data_sales_package['total_amt'];
					}
					
					$data_sales_voucher_amount=0;
					$sel_sales_voucher="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where payment_mode_id='1' and category='Voucher' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_sales_voucher=mysql_query($sel_sales_voucher,$link2);
					if($num_vouc=mysql_num_rows($ptr_sales_voucher))
					{
						$data_sales_voucher=mysql_fetch_array($ptr_sales_voucher);
						$data_sales_voucher_amount=$data_sales_voucher['total_amt'];
					}
					
					
					//=================================Cash Withdrawl in petty cash====================== (3/6/19)
					$cash_withdrawl_in_petty_cash=0;
					$sel_withd="select SUM(amount) as total_amt from receipt where cash_transfer_mode='inword' and cash_type='petty_cash' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_cash_withd=mysql_query($sel_withd,$link2);
					if(mysql_num_rows($ptr_cash_withd))
					{
						$data_cash_withdrawl=mysql_fetch_array($ptr_cash_withd);
						$cash_withdrawl_in_petty_cash=$data_cash_withdrawl['total_amt'];
					}
					//=================================Cash Transfer in petty cash====================== (27/6/19)
					$cash_transfer_in_petty_cash=0;
					$sel_transf="select SUM(amount) as total_amt from receipt where cash_transfer_mode='cash_to_cash' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_cash_transf=mysql_query($sel_transf,$link2);
					if(mysql_num_rows($ptr_cash_transf))
					{
						$data_cash_transfer=mysql_fetch_array($ptr_cash_transf);
						$cash_transfer_in_petty_cash=$data_cash_transfer['total_amt'];
					}
					//===================================================================================
					//$prv_date = trim(date('Y-m-d',strtotime('-1 day')));
					$prv_date =date('Y-m-d', strtotime('-1 day', strtotime($date)));
					//$opening_cash=$total_yest_bal;
					$opening_cash1=0;
					$opening_petty_cash=0; //(3/6/19)
					
					$sele_yest_bal="select cash_in_hand,petty_cash_in_hand from dsr where 1 ".$_SESSION['where']." ".$search_cm_id." and added_date = '".$prv_date."'  order by dsr_id desc limit 0,1"; //where added_date = '".$prv_date."'
					$ptr_yest1=mysql_query($sele_yest_bal,$link2);
					if(mysql_num_rows($ptr_yest1))
					{
						$data_yest_bal=mysql_fetch_array($ptr_yest1);
						$opening_cash1=$data_yest_bal['cash_in_hand'];
						$opening_petty_cash=$data_yest_bal['petty_cash_in_hand']; //(3/6/19)
					}
					$tota_exp1=$data_product_amount+$data_total_expense_amount+$data_total_refund_amount;
					//echo "<br/>1- ".$data_product['total_amt']." 2- ".$data_total_expense['total_amt']." 3- ".$data_total_refund['total_amt'];
					$tota_exp_business1=$data_total_expense_business_amount;
					//===================Cash Deposited in Bank===============================
					$sel_dist_bank_id="Select DISTINCT(bank_id) from receipt where added_date='".$date."' and bank_id !='' and (category ='cash_transfer' and category !='voucher' and cash_transfer_mode !='inword' and cash_transfer_mode !='cash_to_cash') and cash_type='business_cash' and payment_mode_id='1' ".$_SESSION['where']." ".$search_cm_id." ";// 29-12-17 category !='cash_transfer'
					$ptr_dist_bank_id=mysql_query($sel_dist_bank_id,$link2);
					$total=mysql_num_rows($ptr_dist_bank_id);
					$is=1;
					$tt='';
					$tots=0;
					while($data_dist_bank_id=mysql_fetch_array($ptr_dist_bank_id))
					{
						$sel_cash_from_bank="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and category ='cash_transfer' and cash_transfer_mode ='outword' and cash_type='business_cash' and payment_mode_id='1' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";// 29-12-17 category !='cash_transfer'
						$ptr_cash_from_bank=mysql_query($sel_cash_from_bank,$link2);
						$data_cash_from_bank=mysql_fetch_array($ptr_cash_from_bank);
						
						$sel_bank_amnt="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and category ='cash_transfer' and cash_transfer_mode ='bank_to_bank' and cash_type='business_cash' and payment_mode_id='1' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";// 29-12-17 category !='cash_transfer'
						$ptr_bank_amnt=mysql_query($sel_bank_amnt,$link2);
						$data_bank_amnt=mysql_fetch_array($ptr_bank_amnt);
						
						$total_bank_bal=$data_cash_from_bank['total_amt']+$data_bank_amnt['total_amt'];
						
						$sel_bank="select bank_name from bank where bank_id='".$data_dist_bank_id['bank_id']."'";
						$ptr_bank=mysql_query($sel_bank,$link2);
						$data_bank_name=mysql_fetch_array($ptr_bank);
						
						//$data_bank_name['bank_name']." : ".$total_bank_bal;
						
						$tots +=$total_bank_bal;
						$tt +=$data_cash_from_bank['total_amt'];
						
						if($is !=$total)
						{
						}
						$is++;
					}
					
					//-----------------------------------CASH DEPSOIT IN BANK from PETYY CASH---------------------------------
					$sel_dist_bank_id1="Select DISTINCT(bank_id) from receipt where added_date='".$date."' and bank_id !='' and (category ='cash_transfer' and category !='voucher' and cash_transfer_mode !='inword' and cash_transfer_mode !='cash_to_cash') and cash_type='petty_cash' and payment_mode_id='1' ".$_SESSION['where']." ".$search_cm_id."";// 29-12-17 category !='cash_transfer'
					$ptr_dist_bank_id=mysql_query($sel_dist_bank_id1,$link2);
					$total1=mysql_num_rows($ptr_dist_bank_id);
					$i1=1;
					$tt1='';
					$tots1=0;
					while($data_dist_bank_id=mysql_fetch_array($ptr_dist_bank_id))
					{
						$sel_cash_from_bank="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and category ='cash_transfer' and cash_transfer_mode ='outword' and cash_type='petty_cash' and payment_mode_id='1' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";// 29-12-17 category !='cash_transfer'
						$ptr_cash_from_bank=mysql_query($sel_cash_from_bank,$link2);
						$data_cash_from_bank=mysql_fetch_array($ptr_cash_from_bank);
						
						$sel_bank_amnt="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and category ='cash_transfer' and cash_transfer_mode ='bank_to_bank' and cash_type='petty_cash' and payment_mode_id='1' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." "; // 29-12-17 category !='cash_transfer'
						$ptr_bank_amnt=mysql_query($sel_bank_amnt,$link2);
						$data_bank_amnt=mysql_fetch_array($ptr_bank_amnt);
						
						$total_bank_bal=$data_cash_from_bank['total_amt']+$data_bank_amnt['total_amt'];
						
						$sel_bank="select bank_name from bank where bank_id='".$data_dist_bank_id['bank_id']."'";
						$ptr_bank=mysql_query($sel_bank,$link2);
						$data_bank_name=mysql_fetch_array($ptr_bank);
						
						$data_bank_name['bank_name']." : ".$total_bank_bal;
						$tots1 +=$total_bank_bal;
						$tt1 +=$data_cash_from_bank['total_amt'];
						
						if($i1 !=$total1)
						{
							
						}
						$i1++;
					}				
					//====================================CASH IN HAND================================================
					$data_total_inc1_amount=0;
					$sel_total_inc1="select SUM(amount) as total_amt from invoice where DATE(`added_date`) = '".$date."' and (bank_name='' or bank_name= 'select') ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_total_inc1=mysql_query($sel_total_inc1,$link2);
					if(mysql_num_rows($ptr_total_inc1))
					{
						$data_total_inc1=mysql_fetch_array($ptr_total_inc1);
						$data_total_inc1_amount=$data_total_inc1['total_amt'];
					}
					
					$data_total_inc21_amount=0;
					$sel_total_inc21="select SUM(amount) as total_amt from receipt where category !='cash_transfer' and category !='voucher'  and added_date='".$date."' and bank_id='' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_total_inc21=mysql_query($sel_total_inc21,$link2);
					if(mysql_num_rows($ptr_total_inc21))
					{
						$data_total_inc21=mysql_fetch_array($ptr_total_inc21);
						$data_total_inc21_amount=$data_total_inc21['total_amt'];
					}
					
					$cash_in_hand=$data_total_inc1_amount+$data_total_inc21_amount;
					$total_cash_fees=$data_ptr_sel_amount;
					$total_cash_product= $data_sel_recipt_amount;
					//========================================BUSINESS CASH IN HAND===========================================
					$cash_in_hands=$opening_cash1 + $data_ptr_sel_amount +$data_sel_recipt_amount+$total_service + $data_sales_product_amount+$data_cash_received_sir_amount + $data_sel_voucher_amount + $data_sales_membership_amount + $data_sales_package_amount+$data_sales_voucher_amount+$data_cash_rec_amount-$cash_transfer_in_petty_cash - $data_cash_from_sir_business_amount	- $tota_exp_business1 - $tots ;
					
					//echo "<br/>1- ".$opening_cash1.'2- '.$data_ptr_sel_amount.'3-'.$data_sel_recipt_amount.'4-'.$total_service.'5-'.$data_sales_product_amount.'6-'.$data_cash_received_sir_amount.'7-'.$data_sel_voucher_amount.'8-'.$data_sales_membership_amount.'9-'.$data_sales_package_amount.'10-'.$data_sales_voucher_amount.'11-'.$data_cash_rec_amount.'12-'.$cash_transfer_in_petty_cash.'13-'.$data_cash_from_sir_business_amount.'14-'.$tota_exp_business1.' 15-'.$tots;
					
					//echo "<br/>1- ".$opening_cash1.'2- '.$data_ptr_sel['total_amt'].'3-'.$data_sel_recipt['total_amt'].'4-'.$total_service .'5-'. $data_sales_product['total_amt'].'6-'.$data_cash_received_sir['total_amt'] .'7-'.$data_sel_voucher['total_amt'].'8-'.$data_sales_membership['total_amt'].'9-'.$data_sales_package['total_amt'].'10-'.$data_sales_voucher['total_amt'].'11-'.$data_cash_rec['total_amt'].'12-'.$cash_transfer_in_petty_cash.'13-'.$data_cash_from_sir_business['total_amt'].'14-'.$tota_exp_business.' 15-'.$tots;
					//========================================PETTY CASH IN HAND===========================================
					$petty_cash_in_hands=intval($data_sel_recipt_petty_cash_amount + $opening_petty_cash + $cash_withdrawl_in_petty_cash + $cash_transfer_in_petty_cash - $tota_exp1 - $data_cash_from_sir_petty_amount+$data_cash_received_sir_in_petty_amount - $tots1) ; //(3/6/19)
					
					//echo "<br/>1- (".$data_sel_recipt_petty_cash['total_amt'].")+2- (".$opening_petty_cash.")+3- (".$cash_withdrawl_in_petty_cash.")+4- (".$cash_transfer_in_petty_cash.")-5- (".$tota_exp.")-6- (".$data_cash_from_sir_petty['total_amt'].")+7- (".$data_cash_received_sir_in_petty['total_amt'].")-8- (".$tots1.")";
					//========================================================================================================
					$tot_toaday_business_cash +=$cash_in_hands;
					$tot_todays_petty_cash +=$petty_cash_in_hands;
					
					echo '<td align="center" style="border:1px solid #CCC">'.round($cash_in_hands,2).'</td> <input type="hidden" name="cash_in_hand" value="'.round($cash_in_hands,2).'"  />';
					echo '<td align="center" style="border:1px solid #CCC">'.round($petty_cash_in_hands,2).'</td> <input type="hidden" name="petty_cash_in_hand" value="'.round($petty_cash_in_hands,2).'" >';	//(3/6/19)
					//===============================================================
					//=================================================================
					echo '</tr>';
					$i++;
					$k++;
					$bgColorCounter++;
				}
			}

			//=================*****************== ISAS DUBAI ==*****************================
			$cash_in_hands='';
			$petty_cash_in_hands='';
			$opening_cash1='';
			$opening_petty_cash='';
			$tota_exp_business3='';
			$tots='';
			$cash_withdrawl_in_petty_cash='';
			$cash_transfer_in_petty_cash='';
			$tota_exp3='';
			$tots1='';
			$outgoing='';
			$total_todays_bal='';
			$search_cm_id='';
			$tot_todays_incoming_dub=0;
			$tot_todays_outgoing_dub=0;
			$tot_yesterday_bank_dub=0;
			$tot_todays_bank_dub=0;
			
			$sql_query3="select DISTINCT(bank_id) as bank_name,cm_id from bank where 1 and status='Active' ".$_SESSION['where']." ".$search_cm_id." and show_in_report !='No'";
			$ptr_records3=mysql_query($sql_query3,$link3); //and system_status='Enabled'
			$no_of_records +=mysql_num_rows($ptr_records3);
            if($no_of_records)
            {
                //$bgColorCounter=1;
                /*$query_string='&keyword='.$keyword.'&branch_name='.$_REQUEST['branch_name'].'&date='.$_REQUEST['date'];
                $query_string1=$query_string.$date_query;
                $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                $all_records= $pager->paginate();*/
				
               	while($data_ptr_sel3=mysql_fetch_array($ptr_records3))
                {
                    $name = '';
					$tota_exp3=0;
					$tota_exp_business3=0;
                    if($bgColorCounter%2==0)
                        $bgcolor='class="grey_td"';
                    else
                        $bgcolor="";                
                    $listed_record_id=$data_ptr_sel3['bank_id'];
					$search_cm_id=" and cm_id ='".$data_ptr_sel3['cm_id']."'"; 
					$search_cm_id_i=" and i.cm_id ='".$data_ptr_sel3['cm_id']."'";
                   	// include "include/paging_script.php";
                    echo '<tr>';
                    echo '<td align="center">'.$i.'</td>';
					
					$sel_bal="select branch_name from site_setting where cm_id='".$data_ptr_sel3['cm_id']."'";
					$ptr_bal=mysql_query($sel_bal,$link3);
					$dara_bal=mysql_fetch_array($ptr_bal);
					
                    echo '<td align="center">'.$dara_bal['branch_name'].'</td>';
					$sel_bank="select bank_name,account_no from bank where bank_id='".$data_ptr_sel3['bank_name']."'";
					$ptr_bank=mysql_query($sel_bank,$link3);
					$data_bank_name=mysql_fetch_array($ptr_bank);
					
					$data_sel_expense_amount2=0;
					$sel_expense="select SUM(payable_amount) as total_amt from expense_invoice where bank_id='".$data_ptr_sel3['bank_name']."' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					if($ptr_expense_bank_id=mysql_query($sel_expense,$link3))
					{
						$data_sel_expense=mysql_fetch_array($ptr_expense_bank_id);
						$data_sel_expense_amount2=$data_sel_expense['total_amt'];
					}
					
					$data_sel_refund_amount2=0;
					$sel_refund="select SUM(total_refund) as total_amt from enrollment_refund where bank_name='".$data_ptr_sel3['bank_name']."' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_refund_bank_id=mysql_query($sel_refund,$link3);
					if($num_data1=mysql_num_rows($ptr_refund_bank_id))
					{
						$data_sel_refund=mysql_fetch_array($ptr_refund_bank_id);
						$data_sel_refund_amount2=$data_sel_refund['total_amt'];
					}
					
					$data_sel_recipt_out_amount2=0;
					$sel_receipt_out="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel3['bank_name']."' and cash_transfer_mode='inword' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_bank_id_out=mysql_query($sel_receipt_out,$link3);
					if($num_rec=mysql_num_rows($ptr_bank_id_out))
					{
						$data_sel_recipt_out=mysql_fetch_array($ptr_bank_id_out);
						$data_sel_recipt_out_amount2=$data_sel_recipt_out['total_amt'];
					}
					
					$data_inv_amount2=0;
					$sel_inv="select SUM(payable_amount) as total_amt from inventory_invoice where bank_id='".$data_ptr_sel3['bank_name']."' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptrinv=mysql_query($sel_inv,$link3);
					if($num_inv=mysql_num_rows($ptrinv))
					{
						$data_inv=mysql_fetch_array($ptrinv);
						$data_inv_amount2=$data_inv['total_amt'];
					}
					
					$data_cc_expense_amount1=0;
					$sel_cc_expense="select SUM(amount) as total_amt from expense where cc_bank_name='".$data_ptr_sel3['bank_name']."' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_cc_expense=mysql_query($sel_cc_expense,$link3);
					if($num_expe=mysql_num_rows($ptr_cc_expense))
					{
						$data_cc_expense=mysql_fetch_array($ptr_cc_expense);
						$data_cc_expense_amount1=$data_cc_expense['total_amt'];
					}
					
					$data_bank_out_amount1=0;
					$sel_bank_out="select SUM(amount) as total_amt from receipt where from_bank_name='".$data_ptr_sel3['bank_name']."' and category='cash_transfer' and cash_transfer_mode='bank_to_bank' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_bank_out=mysql_query($sel_bank_out,$link3);
					if($num_banko=mysql_num_rows($ptr_bank_out))
					{
						$data_bank_out=mysql_fetch_array($ptr_bank_out);
						$data_bank_out_amount1=$data_bank_out['total_amt'];
					}
					
					$outgoing=$data_sel_expense_amount2+ $data_sel_recipt_out_amount2 +$data_inv_amount2+$data_cc_expense_amount1+$data_bank_out_amount1+$data_sel_refund_amount2;

					$data_total_inc_amount2=0;
					$sel_total_inc="select SUM(amount) as total_amt from invoice where bank_name='".$data_ptr_sel3['bank_name']."' and DATE(`added_date`) = '".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_total_inc=mysql_query($sel_total_inc,$link3);
					if($num_inc=mysql_num_rows($ptr_total_inc))
					{
						$data_total_inc=mysql_fetch_array($ptr_total_inc);
						$data_total_inc_amount2=$data_total_inc['total_amt'];
					}
					
					$data_total_inc2_amount2=0;
					$sel_total_inc2="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel3['bank_name']."' and (cash_transfer_mode = 'outword' OR cash_transfer_mode IS NULL ) and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_total_inc2=mysql_query($sel_total_inc2,$link3);
					if($num_inc2=mysql_num_rows($ptr_total_inc2))
					{
						$data_total_inc2=mysql_fetch_array($ptr_total_inc2);
						$data_total_inc2_amount2=$data_total_inc2['total_amt'];
					}
					
					$data_total_inc3_amount2=0;
					$sel_total_inc3="select SUM(payable_amount) as total_amt from customer_service_invoice where bank_id='".$data_ptr_sel3['bank_name']."'  and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_total_inc3=mysql_query($sel_total_inc3,$link3);
					if($num_inc3=mysql_num_rows($ptr_total_inc3))
					{
						$data_total_inc3=mysql_fetch_array($ptr_total_inc3);
						$data_total_inc3_amount2=$data_total_inc3['total_amt'];
					}
					
					$data_total_inc4_amount2=0;
					$sel_total_inc4="select SUM(payable_amount) as total_amt from sales_product_invoice where bank_id='".$data_ptr_sel3['bank_name']."'  and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_total_inc4=mysql_query($sel_total_inc4,$link3);
					if($num_inc4=mysql_num_rows($ptr_total_inc4))
					{
						$data_total_inc4=mysql_fetch_array($ptr_total_inc4);
						$data_total_inc4_amount2=$data_total_inc4['total_amt'];
					}
					
					$data_total_inc5_amount2=0;
					$sel_total_inc5="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where bank_id='".$data_ptr_sel3['bank_name']."'  and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_total_inc=mysql_query($sel_total_inc5,$link3);
					if($num_inc5=mysql_num_rows($ptr_total_inc))
					{
						$data_total_inc5=mysql_fetch_array($ptr_total_inc5);
						$data_total_inc5_amount2=$data_total_inc5['total_amt'];
					}
					
					$data_total_inc6_amount2=0;
					$sel_total_inc6="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel3['bank_name']."' and category='cash_transfer' and cash_transfer_mode='bank_to_bank' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_total_inc6=mysql_query($sel_total_inc6,$link3);
					if($num_inc6=mysql_num_rows($ptr_total_inc6))
					{
						$data_total_inc6=mysql_fetch_array($ptr_total_inc6);
						$data_total_inc6_amount2=mysql_fetch_array($ptr_total_inc6);
					}
					
					$total_todays_bal=$data_total_inc_amount2+$data_total_inc2_amount2+$data_total_inc3_amount2+$data_total_inc4_amount2+$data_total_inc5_amount2+$data_total_inc6_amount2;
					
					$data_yesterday_amount2=0;
					$sele_yesterday_bal="select todays_balance from dsr_bank_summery where bank_id='".$data_ptr_sel3['bank_name']."' ".$_SESSION['where']." ".$search_cm_id." and added_date=DATE_SUB('".$date."', INTERVAL 1 DAY) order by added_date desc limit 0,1 "; //and added_date = '".$prv_date."'
					$ptr_yest=mysql_query($sele_yesterday_bal,$link3);
					if($num_yesterday=mysql_num_rows($ptr_yest))
					{
						$data_yesterday=mysql_fetch_array($ptr_yest);
						$data_yesterday_amount2=$data_yesterday['todays_balance'];
					}
					
					$total_todays_bank= floatval($total_todays_bal+$data_yesterday_amount2) - $outgoing;
					$tot=$total_todays_bank;
					
					$tot_todays_incoming_dub=$total_todays_bal;
					$tot_todays_outgoing_dub=$outgoing;
					$tot_yesterday_bank_dub=$data_yesterday_amount2;
					$tot_todays_bank_dub=$total_todays_bank;
					
					echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td> <input type="hidden" name="bank_id_'.$k.'" value="'.$data_bank_name['bank_name'].'" >';
					echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td> <input type="hidden" name="account_no_'.$k.'" value="'.$data_bank_name['account_no'].'">';
					echo '<td align="center" style="border:1px solid #CCC">'.$total_todays_bal.'</td> <input type="hidden" name="incoming_'.$k.'" value="'.$total_todays_bal.'" >';
					echo '<td align="center" style="border:1px solid #CCC">'.$outgoing.'</td> <input type="hidden" name="outgoing_'.$k.'" value="'.$outgoing.'" >';
					echo '<td align="center" style="border:1px solid #CCC">'.$data_yesterday_amount2.'</td><input type="hidden" name="yesterday_bal_'.$k.'"value="'.$data_yesterday['todays_balance'].'">';
					echo '<td align="center" style="border:1px solid #CCC">'.$total_todays_bank.'</td> <input type="hidden" name="todays_bal_'.$k.'" value="'.$total_todays_bank.'" >';
					//====================== CASH Balance ===========================
					
					$data_ptr_sel_amount=0;
					$sel_inv="select SUM(amount) as total_amt from invoice where paid_type='1' and DATE(`added_date`) = '".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_amnt=mysql_query($sel_inv,$link3);
					if($total=mysql_num_rows($ptr_amnt))
					{
						$data_ptr_sel=mysql_fetch_array($ptr_amnt);
						$data_ptr_sel_amount=$data_ptr_sel['total_amt'];
					}
					
					$data_sel_recipt_amount=0;
					$sel_receipt="select SUM(amount) as total_amt from receipt where payment_mode_id='1' and category !='cash_transfer' and category !='innocent' and category !='santosh' and category !='voucher' and cash_type='business_cash' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_bank_id=mysql_query($sel_receipt,$link3);
					if($num_recp=mysql_num_rows($ptr_bank_id))
					{
						$data_sel_recipt=mysql_fetch_array($ptr_bank_id);
						$data_sel_recipt_amount=$data_sel_recipt['total_amt'];
					}
					
					$data_sel_recipt_petty_cash_amount=0;
					$sel_receipt_petty="select SUM(amount) as total_amt from receipt where payment_mode_id='1' and category !='cash_transfer' and category !='innocent' and category !='santosh' and category !='voucher' and cash_type='petty_cash' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_petty_cash=mysql_query($sel_receipt_petty,$link3);
					if($num_petty=mysql_num_rows($ptr_petty_cash))
					{
						$data_sel_recipt_petty_cash=mysql_fetch_array($ptr_petty_cash);
						$data_sel_recipt_petty_cash_amount=$data_sel_recipt_petty_cash['total_amt'];
					}
					
					$data_sel_voucher_amount=0;
					$sel_voucher="select SUM(amount) as total_amt from receipt where payment_mode_id='1' and category ='voucher' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_voucher=mysql_query($sel_voucher,$link3);
					if($numvoucher=mysql_num_rows($ptr_voucher))
					{
						$data_sel_voucher=mysql_fetch_array($ptr_voucher);
						$data_sel_voucher_amount=$data_sel_voucher['total_amt'];
					}
							
					//===================Cash received from sir===============================
					$data_cash_received_sir_amount=0;
					$sel_cash_received_sir="select SUM(amount) as total_amt from receipt where category ='santosh' and cash_type='business_cash' and payment_mode_id='1' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_cash_received_sir=mysql_query($sel_cash_received_sir,$link3);
					if($num_sir=mysql_num_rows($ptr_cash_received_sir))
					{
						$data_cash_received_sir=mysql_fetch_array($ptr_cash_received_sir);
						$data_cash_received_sir_amount=$data_cash_received_sir['total_amt'];
					}
					
					$data_cash_received_sir_in_petty_amount=0;
					$sel_cash_received_sir_in_petty="select SUM(amount) as total_amt from receipt where category ='santosh' and cash_type='petty_cash' and payment_mode_id='1' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_cash_received_sir_in_petty=mysql_query($sel_cash_received_sir_in_petty,$link3);
					if($num_sir_petty=mysql_num_rows($ptr_cash_received_sir_in_petty))
					{
						$data_cash_received_sir_in_petty=mysql_fetch_array($ptr_cash_received_sir_in_petty);
						$data_cash_received_sir_in_petty_amount=$data_cash_received_sir_in_petty['total_amt'];
					}
					
					$data_total_expense_amount=0;
					$sel_total_expense="select SUM(i.payable_amount) as total_amt from expense e,expense_invoice i where i.expense_id=e.expense_id and i.paid_type ='1' and e.expense_type_id !='1' and e.expense_type_id !='119'  and e.expense_type_id !='120' and e.cash_type='petty_cash' and i.added_date='".$date."' ".$where_i." ".$search_cm_id_i."";
					$ptr_total_expense=mysql_query($sel_total_expense,$link3);
					if($num_expense=mysql_num_rows($ptr_total_expense))
					{
						$data_total_expense=mysql_fetch_array($ptr_total_expense);
						$data_total_expense_amount=$data_total_expense['total_amt'];
					}
					
					$data_total_expense_business_amount=0;
					$sel_total_expense_business="select SUM(i.payable_amount) as total_amt from expense e,expense_invoice i where i.expense_id=e.expense_id and i.paid_type ='1' and e.expense_type_id !='1' and e.expense_type_id !='119'  and e.expense_type_id !='120' and e.cash_type='business_cash' and i.added_date='".$date."' ".$where_i." ".$search_cm_id_i."";
					$ptr_total_expense_business=mysql_query($sel_total_expense_business,$link3);
					if($num_exp_b=mysql_num_rows($ptr_total_expense_business))
					{
						$data_total_expense_business=mysql_fetch_array($ptr_total_expense_business);
						$data_total_expense_business_amount=$data_total_expense_business['total_amt'];
					}
								
					//===================Total Cash Refund===============================
					$data_total_refund_amount=0;
					$sel_total_refund="select SUM(total_refund) as total_amt from enrollment_refund where paid_type ='1' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_total_refund=mysql_query($sel_total_refund,$link3);
					if($num_ref=mysql_num_rows($ptr_total_refund))
					{
						$data_total_refund=mysql_fetch_array($ptr_total_refund);
						$data_total_refund_amount=$data_total_refund['total_amt'];
					}
					
					//===================Cash Given to sir===============================
					$data_cash_from_sir_petty_amount=0;
					$sel_cash_from_sir_petty="select SUM(i.payable_amount) as total_amt from expense e,expense_invoice i where i.expense_id=e.expense_id and i.paid_type ='1' and (expense_type_id='1' or expense_type_id='119' or expense_type_id='120') and cash_type='petty_cash' and i.added_date='".$date."' ".$where_i." ".$search_cm_id_i."";
					$ptr_cash_from_sir_petty=mysql_query($sel_cash_from_sir_petty,$link3);
					if($num_c_petty=mysql_num_rows($ptr_cash_from_sir_petty))
					{
						$data_cash_from_sir_petty=mysql_fetch_array($ptr_cash_from_sir_petty);
						$data_cash_from_sir_petty_amount=$data_cash_from_sir_petty['total_amt'];
					}
					
					$data_cash_from_sir_business_amount=0;
					$sel_cash_from_sir_business="select SUM(i.payable_amount) as total_amt from expense e,expense_invoice i where i.expense_id=e.expense_id and i.paid_type ='1' and (expense_type_id='1' or expense_type_id='119' or expense_type_id='120') and cash_type='business_cash' and i.added_date='".$date."' ".$where_i." ".$search_cm_id_i."";
					$ptr_cash_from_sir_business=mysql_query($sel_cash_from_sir_business,$link3);
					if($num_s_buss=mysql_num_rows($ptr_cash_from_sir_business))
					{
						$data_cash_from_sir_business=mysql_fetch_array($ptr_cash_from_sir_business);
						$data_cash_from_sir_business_amount=$data_cash_from_sir_business['total_amt'];
					}
					
					//====================CASH TRANSFER - INWORD =======================================
					$data_cash_rec_amount=0;
					$sel_cash_rec="select SUM(amount) as total_amt from receipt where 1 and category='cash_transfer' and (cash_transfer_mode is NULL or cash_transfer_mode !='outword' ) and cash_transfer_mode!= 'bank_to_bank' and category !='santosh' and category !='voucher' and cash_transfer_mode!='cash_to_cash' and cash_type='business_cash' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_cash_rec=mysql_query($sel_cash_rec,$link3);
					if($num_rec=mysql_num_rows($ptr_cash_rec))
					{
						$data_cash_rec=mysql_fetch_array($ptr_cash_rec); //cash_type='business_cash' (3/6/19)
						$data_cash_rec_amount=$data_cash_rec['total_amt'];
					}
					
					//=============================SERVICE===============================================
					$data_service_amount=0;
					$total_service=0;
					$sel_service="select SUM(payable_amount) as total_amt from customer_service_invoice where paid_type='1' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_service=mysql_query($sel_service,$link3);
					if($num_serv=mysql_num_rows($ptr_service))
					{
						$data_service=mysql_fetch_array($ptr_service);
						$data_service_amount=$data_service['total_amt'];
						$total_service=$data_service_amount;
					}
					
					$data_membership_amount=0;
					$sel_memb="select SUM(price) as total_amt from customer where payment_mode_id='1' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_memb=mysql_query($sel_memb,$link3);
					if($num_memb=mysql_num_rows($ptr_memb))
					{
						$data_membership=mysql_fetch_array($ptr_memb);
						$data_membership_amount=$data_membership['total_amt'];
					}
					
					//=============================PRODUCT===============================================
					$data_product_amount=0;
					$sel_product="select SUM(payable_amount) as total_amt from inventory_invoice where paid_type='1' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_product=mysql_query($sel_product,$link3);
					if($num_products=mysql_num_rows($ptr_product))
					{
						$data_product=mysql_fetch_array($ptr_product);
						$data_product_amount=$data_product['total_amt'];
					}
					
					$data_sales_product_amount=0;
					$sel_sales_product="select SUM(payable_amount) as total_amt from sales_product_invoice where paid_type='1' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_sales_product=mysql_query($sel_sales_product,$link3);
					if($num_s_product=mysql_num_rows($ptr_sales_product))
					{
						$data_sales_product=mysql_fetch_array($ptr_sales_product);
						$data_sales_product_amount=$data_sales_product['total_amt'];
					}
					
					$total_produts=$data_product_amount-$data_sales_product_amount;
					
					$data_sales_membership_amount=0;
					$sel_sales_membership="select SUM(price) as total_amt from customer where payment_mode_id='1' and membership='yes' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_sales_membership=mysql_query($sel_sales_membership,$link3);
					if($num_sale_mem=mysql_num_rows($ptr_sales_membership))
					{
						$data_sales_membership=mysql_fetch_array($ptr_sales_membership);
						$data_sales_membership_amount=$data_sales_membership['total_amt'];
					}
					
					$data_sales_package_amount=0;
					$sel_sales_package="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where payment_mode_id='1' and category='Package' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_sales_package=mysql_query($sel_sales_package,$link3);
					if($num_pkg=mysql_num_rows($ptr_sales_package))
					{
						$data_sales_package=mysql_fetch_array($ptr_sales_package);
						$data_sales_package_amount=$data_sales_package['total_amt'];
					}
					
					$data_sales_voucher_amount=0;
					$sel_sales_voucher="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where payment_mode_id='1' and category='Voucher' and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_sales_voucher=mysql_query($sel_sales_voucher,$link3);
					if($num_vouc=mysql_num_rows($ptr_sales_voucher))
					{
						$data_sales_voucher=mysql_fetch_array($ptr_sales_voucher);
						$data_sales_voucher_amount=$data_sales_voucher['total_amt'];
					}
					
					
					//=================================Cash Withdrawl in petty cash====================== (3/6/19)
					$cash_withdrawl_in_petty_cash=0;
					$sel_withd="select SUM(amount) as total_amt from receipt where cash_transfer_mode='inword' and cash_type='petty_cash' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_cash_withd=mysql_query($sel_withd,$link3);
					if(mysql_num_rows($ptr_cash_withd))
					{
						$data_cash_withdrawl=mysql_fetch_array($ptr_cash_withd);
						$cash_withdrawl_in_petty_cash=$data_cash_withdrawl['total_amt'];
					}
					//=================================Cash Transfer in petty cash====================== (27/6/19)
					$cash_transfer_in_petty_cash=0;
					$sel_transf="select SUM(amount) as total_amt from receipt where cash_transfer_mode='cash_to_cash' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";
					$ptr_cash_transf=mysql_query($sel_transf,$link3);
					if(mysql_num_rows($ptr_cash_transf))
					{
						$data_cash_transfer=mysql_fetch_array($ptr_cash_transf);
						$cash_transfer_in_petty_cash=$data_cash_transfer['total_amt'];
					}
					//===================================================================================
					//$prv_date = trim(date('Y-m-d',strtotime('-1 day')));
					$prv_date =date('Y-m-d', strtotime('-1 day', strtotime($date)));
					//$opening_cash=$total_yest_bal;
					$opening_cash1=0;
					$opening_petty_cash=0; //(3/6/19)
					
					$sele_yest_bal="select cash_in_hand,petty_cash_in_hand from dsr where 1 ".$_SESSION['where']." ".$search_cm_id." and added_date = '".$prv_date."'  order by dsr_id desc limit 0,1"; //where added_date = '".$prv_date."'
					$ptr_yest1=mysql_query($sele_yest_bal,$link3);
					if(mysql_num_rows($ptr_yest1))
					{
						$data_yest_bal=mysql_fetch_array($ptr_yest1);
						$opening_cash1=$data_yest_bal['cash_in_hand'];
						$opening_petty_cash=$data_yest_bal['petty_cash_in_hand']; //(3/6/19)
					}
					$tota_exp1=$data_product_amount+$data_total_expense_amount+$data_total_refund_amount;
					//echo "<br/>1- ".$data_product['total_amt']." 2- ".$data_total_expense['total_amt']." 3- ".$data_total_refund['total_amt'];
					$tota_exp_business1=$data_total_expense_business_amount;
					//===================Cash Deposited in Bank===============================
					$sel_dist_bank_id="Select DISTINCT(bank_id) from receipt where added_date='".$date."' and bank_id !='' and (category ='cash_transfer' and category !='voucher' and cash_transfer_mode !='inword' and cash_transfer_mode !='cash_to_cash') and cash_type='business_cash' and payment_mode_id='1' ".$_SESSION['where']." ".$search_cm_id." ";// 29-12-17 category !='cash_transfer'
					$ptr_dist_bank_id=mysql_query($sel_dist_bank_id,$link3);
					$total=mysql_num_rows($ptr_dist_bank_id);
					$is=1;
					$tt='';
					while($data_dist_bank_id=mysql_fetch_array($ptr_dist_bank_id))
					{
						$sel_cash_from_bank="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and category ='cash_transfer' and cash_transfer_mode ='outword' and cash_type='business_cash' and payment_mode_id='1' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";// 29-12-17 category !='cash_transfer'
						$ptr_cash_from_bank=mysql_query($sel_cash_from_bank,$link3);
						$data_cash_from_bank=mysql_fetch_array($ptr_cash_from_bank);
						
						$sel_bank_amnt="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and category ='cash_transfer' and cash_transfer_mode ='bank_to_bank' and cash_type='business_cash' and payment_mode_id='1' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";// 29-12-17 category !='cash_transfer'
						$ptr_bank_amnt=mysql_query($sel_bank_amnt,$link3);
						$data_bank_amnt=mysql_fetch_array($ptr_bank_amnt);
						
						$total_bank_bal=$data_cash_from_bank['total_amt']+$data_bank_amnt['total_amt'];
						
						$sel_bank="select bank_name from bank where bank_id='".$data_dist_bank_id['bank_id']."'";
						$ptr_bank=mysql_query($sel_bank,$link3);
						$data_bank_name=mysql_fetch_array($ptr_bank);
						
						//$data_bank_name['bank_name']." : ".$total_bank_bal;
						
						$tots +=$total_bank_bal;
						$tt +=$data_cash_from_bank['total_amt'];
						
						if($is !=$total)
						{
						}
						$is++;
					}
					
					//-----------------------------------CASH DEPSOIT IN BANK from PETYY CASH---------------------------------
					$sel_dist_bank_id1="Select DISTINCT(bank_id) from receipt where added_date='".$date."' and bank_id !='' and (category ='cash_transfer' and category !='voucher' and cash_transfer_mode !='inword' and cash_transfer_mode !='cash_to_cash') and cash_type='petty_cash' and payment_mode_id='1' ".$_SESSION['where']." ".$search_cm_id."";// 29-12-17 category !='cash_transfer'
					$ptr_dist_bank_id=mysql_query($sel_dist_bank_id1,$link3);
					$total1=mysql_num_rows($ptr_dist_bank_id);
					$i1=1;
					$tt1='';
					while($data_dist_bank_id=mysql_fetch_array($ptr_dist_bank_id))
					{
						$sel_cash_from_bank="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and category ='cash_transfer' and cash_transfer_mode ='outword' and cash_type='petty_cash' and payment_mode_id='1' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." ";// 29-12-17 category !='cash_transfer'
						$ptr_cash_from_bank=mysql_query($sel_cash_from_bank,$link3);
						$data_cash_from_bank=mysql_fetch_array($ptr_cash_from_bank);
						
						$sel_bank_amnt="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and category ='cash_transfer' and cash_transfer_mode ='bank_to_bank' and cash_type='petty_cash' and payment_mode_id='1' and added_date='".$date."' ".$_SESSION['where']." ".$search_cm_id." "; // 29-12-17 category !='cash_transfer'
						$ptr_bank_amnt=mysql_query($sel_bank_amnt,$link3);
						$data_bank_amnt=mysql_fetch_array($ptr_bank_amnt);
						
						$total_bank_bal=$data_cash_from_bank['total_amt']+$data_bank_amnt['total_amt'];
						
						$sel_bank="select bank_name from bank where bank_id='".$data_dist_bank_id['bank_id']."'";
						$ptr_bank=mysql_query($sel_bank,$link3);
						$data_bank_name=mysql_fetch_array($ptr_bank);
						
						$data_bank_name['bank_name']." : ".$total_bank_bal;
						$tots1 +=$total_bank_bal;
						$tt1 +=$data_cash_from_bank['total_amt'];
						
						if($i1 !=$total1)
						{
							
						}
						$i1++;
					}				
					//====================================CASH IN HAND================================================
					$data_total_inc1_amount=0;
					$sel_total_inc1="select SUM(amount) as total_amt from invoice where DATE(`added_date`) = '".$date."' and (bank_name='' or bank_name= 'select') ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_total_inc1=mysql_query($sel_total_inc1,$link3);
					if(mysql_num_rows($ptr_total_inc1))
					{
						$data_total_inc1=mysql_fetch_array($ptr_total_inc1);
						$data_total_inc1_amount=$data_total_inc1['total_amt'];
					}
					
					$data_total_inc21_amount=0;
					$sel_total_inc21="select SUM(amount) as total_amt from receipt where category !='cash_transfer' and category !='voucher'  and added_date='".$date."' and bank_id='' ".$_SESSION['where']." ".$search_cm_id."";
					$ptr_total_inc21=mysql_query($sel_total_inc21,$link3);
					if(mysql_num_rows($ptr_total_inc21))
					{
						$data_total_inc21=mysql_fetch_array($ptr_total_inc21);
						$data_total_inc21_amount=$data_total_inc21['total_amt'];
					}
					
					$cash_in_hand=$data_total_inc1_amount+$data_total_inc21_amount;
					$total_cash_fees=$data_ptr_sel_amount;
					$total_cash_product= $data_sel_recipt_amount;
					//========================================BUSINESS CASH IN HAND===========================================
					$cash_in_hands=$opening_cash1 + $data_ptr_sel_amount +$data_sel_recipt_amount+$total_service + $data_sales_product_amount+$data_cash_received_sir_amount + $data_sel_voucher_amount + $data_sales_membership_amount + $data_sales_package_amount+$data_sales_voucher_amount+$data_cash_rec_amount-$cash_transfer_in_petty_cash - $data_cash_from_sir_business_amount - $tota_exp_business1 - $tots ;
					
					//echo "<br/>1- ".$opening_cash1.'2- '.$data_ptr_sel['total_amt'].'3-'.$data_sel_recipt['total_amt'].'4-'.$total_service .'5-'. $data_sales_product['total_amt'].'6-'.$data_cash_received_sir['total_amt'] .'7-'.$data_sel_voucher['total_amt'].'8-'.$data_sales_membership['total_amt'].'9-'.$data_sales_package['total_amt'].'10-'.$data_sales_voucher['total_amt'].'11-'.$data_cash_rec['total_amt'].'12-'.$cash_transfer_in_petty_cash.'13-'.$data_cash_from_sir_business['total_amt'].'14-'.$tota_exp_business.' 15-'.$tots;
					//========================================PETTY CASH IN HAND===========================================
					$petty_cash_in_hands=intval($data_sel_recipt_petty_cash_amount + $opening_petty_cash + $cash_withdrawl_in_petty_cash + $cash_transfer_in_petty_cash - $tota_exp1 - $data_cash_from_sir_petty_amount+$data_cash_received_sir_in_petty_amount - $tots1) ; //(3/6/19)
					
					//echo "<br/>1- (".$data_sel_recipt_petty_cash['total_amt'].")+2- (".$opening_petty_cash.")+3- (".$cash_withdrawl_in_petty_cash.")+4- (".$cash_transfer_in_petty_cash.")-5- (".$tota_exp.")-6- (".$data_cash_from_sir_petty['total_amt'].")+7- (".$data_cash_received_sir_in_petty['total_amt'].")-8- (".$tots1.")";
					//========================================================================================================
					$tot_toaday_business_cash_dub +=$cash_in_hands;
					$tot_todays_petty_cash_dub += $petty_cash_in_hands;
					
					echo '<td align="center" style="border:1px solid #CCC">'.round($cash_in_hands,2).'</td> <input type="hidden" name="cash_in_hand" value="'.round($cash_in_hands,2).'"  />';
					echo '<td align="center" style="border:1px solid #CCC">'.round($petty_cash_in_hands,2).'</td> <input type="hidden" name="petty_cash_in_hand" value="'.round($petty_cash_in_hands,2).'" >';	//(3/6/19)
					//===============================================================
					echo '</tr>';
					$i++;
					$k++;
					$bgColorCounter++;
            	}
			}
	  		?>
            <tr class="head_td">
            	<!--<td colspan="10">
                	<table cellspacing="0" cellpadding="0" width="100%" style="font-size:12px; font-weight:700">
                    	<tr>-->
                        	<td align="center" style="font-size:12px; font-weight:700" colspan="4">Total (For India)</td>
                            <td align="center" style="font-size:12px; font-weight:700"><?php echo $tot_todays_incoming; ?></td>
                            <td align="center" style="font-size:12px; font-weight:700"><?php echo $tot_todays_outgoing; ?></td>
                            <td align="center" style="font-size:12px; font-weight:700"><?php echo $tot_yesterday_bank; ?></td>
                            <td align="center" style="font-size:12px; font-weight:700"><?php echo $tot_todays_bank; ?></td>
                            <td align="center" style="font-size:12px; font-weight:700"><?php echo $tot_toaday_business_cash; ?></td>
                            <td align="center" style="font-size:12px; font-weight:700"><?php echo $tot_todays_petty_cash; ?></td>
                       <!-- </tr>
                    </table>
                </td>-->
            </tr>
            <tr class="head_td">
            	<!--<td colspan="10">
                	<table cellspacing="0" cellpadding="0" width="100%" style="font-size:12px; font-weight:700">
                    	<tr>-->
                        	<td align="center" style="font-size:12px; font-weight:700" colspan="4">Total (For Dubai)</td>
                            <td align="center" style="font-size:12px; font-weight:700"><?php echo $tot_todays_incoming_dub; ?></td>
                            <td align="center" style="font-size:12px; font-weight:700"><?php echo $tot_todays_outgoing_dub; ?></td>
                            <td align="center" style="font-size:12px; font-weight:700"><?php echo $tot_yesterday_bank_dub; ?></td>
                            <td align="center" style="font-size:12px; font-weight:700"><?php echo $tot_todays_bank_dub; ?></td>
                            <td align="center" style="font-size:12px; font-weight:700"><?php echo $tot_toaday_business_cash_dub; ?></td>
                            <td align="center" style="font-size:12px; font-weight:700"><?php echo $tot_todays_petty_cash_dub; ?></td>
                       <!-- </tr>
                    </table>
                </td>-->
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