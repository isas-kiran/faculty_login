<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Expense Report</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='102'";
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
<?php
$sep_url_string='';
$sep_url= explode("?",$_SERVER['REQUEST_URI']);
if($sep_url[1] !='')
{
$sep_url_string="&".$sep_url[1];
}
?>   
<table cellspacing="0" cellpadding="0" class="table" width="95%">
    
    
  <tr class="head_td">
    <td colspan="13">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                <!--<td width="20%">
                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                <option value="">-Operation-</option>
                                <option value="delete">Delete</option>
                        </select></td>-->
                        <?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
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
                        <td width="10%">
                         <input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>">
                        </td>                         
                        <td width="10%">
                         <input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date" title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>">
                         </td>
						 
						<td width="15%">
                       	<select name="cat_id" style="width:200px" class="input_text" onchange="show_category(this.value)" id="cat_id">
                            <option value="">--Select Expense Category--</option>
                            <?php
                            $sel_payment_mode="select * from expense_category";
                            $ptr_payment_mode=mysql_query($sel_payment_mode);
                            while($data_payment=mysql_fetch_array($ptr_payment_mode))
                            {
                                $selected='';
                                if($data_payment['expense_category_id'] == $row_expense['expense_category_id'])
                                {
                                    $selected='selected="selected"';
                                }
                                echo '<option '.$selected.' value="'.$data_payment['expense_category_id'].'">'.$data_payment['name'].'</option>';
                            }
                            
                            ?>
                         </select>
                         </td>
						 <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                                
                <td class="rightAlign" > 
                   <!-- <table border="0" cellspacing="0" cellpadding="0" align="right">
              <tr>
              <td></td>
              <td class="width5"></td>
                <td><input type="text" value="<?php //if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                <td class="width2"></td>
                <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
              </tr>
                    </table>	-->
                </td>
            </tr>
            <tr>
            	<td colspan="5" style="color:red">Note: <strong>Payable Amount</strong> and <strong>Remaining Amount</strong> feature is applicable from 24/10/2020</td>
            </tr>
        </table>
        </form>	
        <!--<form method="get" name="search">
		<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                         <td width="10%">
                         <input type="hidden" name="send_mail"  value="mail">
                         </td>
                         <td width="10%"><input type="submit" name="send_mail" value="Send Mail" class="inputButton"/></td>
              </tr>
        </table>
        </form>	-->
    </td>
  </tr>
    
     	<?php
		if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
		{
			$sep=explode("/",$_REQUEST['from_date']);
			$from_date=$sep[2]."-".$sep[1]."-".$sep[0];
			$pre_from_date=" and added_date >='".date('Y-m-d',strtotime($from_date))."'";
		}
		else
		{
			$pre_from_date=""; 
			$enquiry_date="";
			$installment_from_date="";                           
		}
		if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
		{
			 
			$sep=explode("/",$_REQUEST['to_date']);
			$to_date=$sep[2]."-".$sep[1]."-".$sep[0];
			$pre_to_date=" and added_date<='".date('Y-m-d',strtotime($to_date))."'";
		}
		else
		{
			$pre_to_date="";
			$enquiery_to_date="";
			$installment_to_date="";
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
				$cm_ids=$data_cm_id['cm_id'];
			}
			else
			{
				$search_cm_id='';
			}
		}
		if($_REQUEST['cat_id'])
		{
			$cat_id=" and expense_category_id='".$_REQUEST['cat_id']."'";
		}
		else
		{
			$cat_id="";
		}
		if($_REQUEST['expense_type'])
		{
			$expense_type=" and expense_type_id='".$_REQUEST['expense_type']."'";
		}
		else
		{
			$expense_type="";
		}
		
		if($_REQUEST['keyword']!="Keyword")
			$keyword=trim($_REQUEST['keyword']);
		if($keyword)
			$pre_keyword=" and (amount like '%".$keyword."%' )";
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

		if($_GET['orderby']=='amount' )
			$img1 = $img;

		if($_GET['order'] !='' && ($_GET['orderby']=='expense_id'))
		{
			$select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
			$date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
		}
		else
		   $select_directory='order by expense_category_id desc';
								
		$sql_query= "SELECT * FROM expense where 1 ".$_SESSION['where']." ".$pre_from_date." ".$pre_to_date." ".$search_cm_id." ".$cat_id." ".$expense_type." ".$pre_keyword." ".$select_directory." "; 
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
			<?php
			if($_SESSION['type'] =='S' || $edit_access=='yes' )
			{
				?>
				<td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
				<?php
			}
			?>
			<td width="5%" align="center"><strong>Sr. No.</strong></td>
			<td width="10%" align="center"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=category".$query_string;?>" class="table_font"><strong>Payment Mode</strong></a> <?php echo $img1;?></td>
			<td width="10%" align="center"><strong>Bank Details</strong></td>
			<td width="10%" align="center"><strong>Category</strong></td>
			<td width="10%" align="center"><strong>Expense Type</strong></td>
			<td width="10%" align="center"><strong>Total Amount</strong></td>
			<td width="10%" align="center"><strong>Payable Amount</strong></td>
			<td width="10%" align="center"><strong>Remaining Amount</strong></td>
			<td width="10%" align="center"><strong>Vendor</strong></td>
			<td width="10%" align="center"><strong>Employee</strong></td>
			<td width="10%" align="center"><strong>Added date</strong></td>
			</tr>
			<?php
			while($val_query=mysql_fetch_array($all_records))
			{
				if($bgColorCounter%2==0)
					$bgcolor='class="grey_td"';
				else
					$bgcolor="";                
				
				$listed_record_id=$val_query['expense_id']; 
				
				include "include/paging_script.php";
				
				$sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$val_query['payment_mode_id']."'";
				$ptr_payment_mode=mysql_query($sel_payment_mode);
				$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
				
				$sel_bank="select bank_name from bank where bank_id='".$val_query['bank_id']."'";
				$ptr_bank=mysql_query($sel_bank);
				$data_bank_name=mysql_fetch_array($ptr_bank);
				
				/*$sel_vendor="select vendor_name from vendor where vendor_id='".$val_query['vendor_id']."'";
				$ptr_vendor=mysql_query($sel_vendor);
				$data_vendor=mysql_fetch_array($ptr_vendor);*/
				
				$sel_emp="select name from site_setting where admin_id='".$val_query['employee_id']."'";
				$ptr_emp=mysql_query($sel_emp);
				$data_emp=mysql_fetch_array($ptr_emp);
				
				
				if($_SESSION['type'] =='S'|| $edit_access=='yes')
				{
					echo '<tr '.$bgcolor.'><td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
				}
				echo '<td align="center">'.$sr_no.'</td>';    
				if($_SESSION['type'] =='S'|| $edit_access=='yes')
				{								
					echo '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" class="table_font">'.$data_payment_mode['payment_mode'].'</a></td>';
				}
				else
				{
					echo '<td >'.$data_payment_mode['payment_mode'].'</td>';
				}
				if($data_bank_name['bank_name'] !='')
				{
					echo '<td align="center"><b>Bank Name:</b> '.$data_bank_name['bank_name'].'<br/><b>Account No:</b>'.$val_query['account_no'].'<br/><b>Cheque No:</b>'.$val_query['chaque_no'].'<br/><b>Cheque Date:</b>'.$val_query['chaque_date'].'</td>';
				}
				else
				{
					echo '<td></td>';
				}
				
				$sel_vendor="select name from vendor where vendor_id='".$val_query['vendor_id']."'";
				$ptr_vendor=mysql_query($sel_vendor);
				$data_vendor_name=mysql_fetch_array($ptr_vendor);
				
				$sel_cat="select name from expense_category where expense_category_id='".$val_query['expense_category_id']."'";
				$ptr_cat=mysql_query($sel_cat);
				$data_cat=mysql_fetch_array($ptr_cat);
				
				$sel_exp="select expense_type from expense_type where expense_type_id='".$val_query['expense_type_id']."'";
				$ptr_exp=mysql_query($sel_exp);
				$data_exp=mysql_fetch_array($ptr_exp);
				
				echo '<td align="center">'.$data_cat['name'].'</td>';
				echo '<td align="center"><a href="expense_type_report.php?expense_category='.$val_query['expense_category_id'].''.$sep_url_string.'">'.$data_exp['expense_type'].'</a></td>';
				echo '<td align="center">'.$val_query['amount'].'</td>';
				echo '<td align="center">'.$val_query['payable_amount'].'</td>';
				echo '<td align="center">'.$val_query['remaining_amount'].'</td>';
				echo '<td align="center">'.$data_vendor_name['name'].'</td>';
				echo '<td align="center">'.$data_emp['name'].'</td>';
				echo '<td align="center">'.$val_query['added_Date'].'</td>';
				
				echo '</tr>';
				$bgColorCounter++;
			}    
			?>
			<tr class="head_td">
    			<td colspan="13">
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
    		</tr>
            </form>
      		<?php 
		} 
      	else
        	echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No category found related to your search criteria, please try again</div><br></td></tr>';?>
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
<script>
function show_category(value)
{
	category_id= value;
	var cat_data="action=show_expense_cat&category_id="+category_id+"&type=for_exp_report";
	
	$.ajax({
		url: "ajax.php",type:"post", data: cat_data,cache: false,
		success: function(retbank)
		{
			document.getElementById("expense_subcategory").innerHTML=retbank;
			//$("#expense_type").chosen({allow_single_deselect:true});
		}
	});
}
</script>
<!--footer end-->
</body>
</html>