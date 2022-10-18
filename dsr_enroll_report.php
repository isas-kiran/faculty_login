<?php include 'inc_classes.php';
ini_set('max_execution_time',1000);
?>
<?php //include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>DSR Report</title>
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
		function check_dsr(vals)
		{
			var dates=document.getElementById('date').value;
			var cm_id=document.getElementById('cm_ids').value;
			var bank_data="action=dsr_matched&cm_id="+cm_id+"&vals="+vals+"&dates="+dates;
			$.ajax({
			url: "ajax.php",type:"post", data: bank_data,cache: false,
			success: function(retbank)
			{
				alert("Records Save Successfully");
			}
			}); 
		}
    </script>
</head>
<body>
<?php
$sep_url_string='';
$sep_url= explode("?",$_SERVER['REQUEST_URI']);
if($sep_url[1] !='')
{
	$sep_url_string=$sep_url[1];
}
//echo $_GET['branch_id'];
if($_GET['branch_id'] =='' )
{
	$branch_id="  and cm_id ='2'";
	$cm_id1='2';
	$branch_name='Pune';
}
else
{
	$branch_id= " and cm_id = '".$_GET['branch_id']."'";
	$cm_id1= $_GET['branch_id'];
	
	$sel_branch_name="select branch_name from site_setting where cm_id=".$cm_id1." and type='A'";
	$ptr_branch_name=mysql_query($sel_branch_name);
	$data_branch=mysql_fetch_array($ptr_branch_name);
	$branch_name=$data_branch['branch_name'];
}
?>
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
    <td class="top_mid" valign="bottom"><?php include "include/student_menu.php";?></td>
    <td class="top_right"></td>
  </tr>  
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center"> 
		<table cellspacing="0" cellpadding="0" class="table" width="95%">
			<tr class="head_td">
    			<td colspan="13">
    				<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              			<tr>
                            <form method="get" name="search">
                            <td width="30%" align="right">Date: </td>
                            <td width="20%" align="left"><input type="text" name="date" class="input_text datepicker" placeholder="date" id="date" title="Date" value="<?php if($_REQUEST['date']!='') echo $_REQUEST['date']; else echo date('d/m/Y'); ?>">
                            <input type="hidden" name="cm_ids" id="cm_ids" value="<?php echo $cm_id1; ?>"  /></td>
                            <?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
                            {
                            	?>
								<td width="100%" align="center" ><strong>Select Branch</strong> &nbsp;&nbsp;
                        		<?php
								$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
								$query_branch = mysql_query($sel_branch);
								$total_Branch = mysql_num_rows($query_branch);
								//echo '<table width="100%"><tr><td>';
								echo ' <select id="branch_id" name="branch_id">';
								echo '<option value="">Select Branch</option>';
								while($row_branch = mysql_fetch_array($query_branch))
								{
									$selected_branch="select cm_id from site_setting where branch_name='".$row_branch['branch_name']."' and type='A'";
									$ptr_selected=mysql_query($selected_branch);
									if(mysql_num_rows($ptr_selected))
									{
										$data_cm_id=mysql_fetch_array($ptr_selected);
										$cm_id= $data_cm_id['cm_id'];
									}
									$selected='';
									if($_REQUEST['branch_id'] !='' && $_REQUEST['branch_id']== $cm_id)
									{
										 $selected='selected="selected"';
									}
									else if($_REQUEST['branch_id'] =='' && $row_branch['branch_name']=='Pune')
									{
										$selected='selected="selected"';
									}
									?>
									<option <?php echo $selected; ?> value="<?php echo $cm_id;?>"><?php echo $row_branch['branch_name']; ?> 
									</option>
									<?php
								
								}
								echo '</select>';
								//echo "</td></tr></table>";
								?>                      
 								</td>
								<?php 	
							} 	?>
                    		<td><input type="submit" name="search" value="Search" class="inputButton"/></td>
                			</form>	
						</tr>
        			</table>
    			</td>
			</tr>
			<?php 
			$date=date('Y-m-d');
			$date_for_month=date('Y-m');
			if($_REQUEST['date'] && $_REQUEST['date']!=="0000-00-00" && $_REQUEST['date']!="date")
			{
				$frm_date=explode("/",$_REQUEST['date']);
				$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
				$date=date('Y-m-d',strtotime($frm_dates));
				$date_for_month=date('Y-m',strtotime($frm_dates));
			}
			if(isset($_POST['sending_mail']))
			{
				if($cm_id1=='2')
				{
					?><script>
					document.location.href="dsr_mail_pune.php?<?php echo $sep_url_string; ?>&send_mail=mail";
					</script>
					<?php
				}
				if($cm_id1=='60')
				{
					?><script>
					document.location.href="dsr_mail_ahm.php?<?php echo $sep_url_string; ?>&send_mail=mail";
					</script>
					<?php
				}
				if($cm_id1=='87')
				{
					?><script>
					document.location.href="dsr_mail_baramati.php?<?php echo $sep_url_string; ?>&send_mail=mail";
					</script>
					<?php
				}
				if($cm_id1=='115')
				{
					?><script>
					document.location.href="dsr_mail_pcmc.php?<?php echo $sep_url_string; ?>&send_mail=mail";
					</script>
					<?php
				}
			?><script>
			document.location.href="dsr_mail.php?<?php echo $sep_url_string; ?>&send_mail=mail";
			</script>
			<?php
		}
		?>
		<form method="post" name="search">
			<tr  bgcolor="#AFD8E0">
				<td align="center" colspan="10"><strong>Incoming Courses</strong></td>
			</tr>
			<tr>
				<?php 
				//===================Total receive balance===============================
				$sel_total_inc="select SUM(amount) as total_amt from invoice where DATE(`added_date`) = '".$date."' ".$branch_id."";
				$ptr_total_inc=mysql_query($sel_total_inc);
				$data_total_inc=mysql_fetch_array($ptr_total_inc);
				$total_todays_bal=$data_total_inc['total_amt']; //DATE(added) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
				//==============================================================================
			  	?>
  				<td align="left" colspan="10" style="color:#F00"><strong>Total Incoming</strong> : <?php echo $total_todays_bal; ?></td>
  				<input type="hidden" name="total_incoming" value="<?php echo $total_todays_bal; ?>"  />
			</tr>
    		<?php                        
			$select_directory='order by enroll_id asc';                      
			$sql_query= "SELECT enroll_id,name FROM enrollment where added_date='".$date."' ".$branch_id." ".$pre_keyword." ".$select_directory." "; 
			//echo $sql_query;
			$db_query=mysql_query($sql_query);
			$no_of_records=mysql_num_rows($db_query);
			?>
  			<tr class="grey_td" style="background-color:#999">
				<td width="45" align="center"><strong>Sr. No.</strong></td>
                <td width="102" align="center" colspan="2"><strong>Sale Type</strong></td>
                <td width="121" align="center"><strong>Student Name</strong></td>
                <td width="241" align="center"><strong>Payment Mode</strong></td>
                <td width="126" align="center"><strong>Bank</strong></td>
                <td width="104" align="center"><strong>Account No</strong></td>
                <td width="105" align="center"><strong>Chaque No</strong></td>
                <!-- <td width="10%" align="center"><strong>chaque Date</strong></td>-->
                <td width="151" align="center"><strong>Amount</strong></td>
                <!--<td width="10%" class="centerAlign"><strong>Action</strong></td>-->
			</tr>
			<?php
            $ent=1;
            if($no_of_records)
            {
                while($val_query=mysql_fetch_array($db_query))
                {
                    if($bgColorCounter%2==0)
                        $bgcolor='class="grey_td"';
                    else
                        $bgcolor="";                
                    $listed_record_id=$val_query['enroll_id']; 
                    include "include/paging_script.php";
                    
                    $sql_invoice="select invoice_id,chaque_date,paid_type,bank_name,cheque_detail,amount from invoice where enroll_id='".$val_query['enroll_id']."' ".$branch_id."";
                    $my_query_invoice=mysql_query($sql_invoice);
                    $row_invoice= mysql_fetch_array($my_query_invoice);
                    
                    $sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$row_invoice['paid_type']."' ";
                    $ptr_payment_mode=mysql_query($sel_payment_mode);
                    $data_payment_mode=mysql_fetch_array($ptr_payment_mode);
                    
                    $sel_bank="select bank_name,account_no from bank where bank_id='".$row_invoice['bank_name']."' ";
                    $ptr_bank=mysql_query($sel_bank);
                    $data_bank_name=mysql_fetch_array($ptr_bank);
                    
                    echo '<tr '.$bgcolor.' >';
                    echo '<td align="center">'.$ent.'</td>';   
                    echo '<td align="center" colspan="2">Course</td>';    
                    echo '<td align="center">'.$val_query['name'].'</td>';
                    echo '<td align="center">'.$data_payment_mode['payment_mode'].'</td>';
                    echo '<td align="center">'.$data_bank_name['bank_name'].'</td>';
                    echo '<td align="center">'.$data_bank_name['account_no'].'</td>';
                    echo '<td align="center">'.$row_invoice['cheque_detail'].'</td>';
                    /*echo '<td align="center">'.$row_invoice['chaque_date'].'</td>';*/
                    echo '<td align="center">'.$row_invoice['amount'].'</td>';
                
                    echo '</tr>';
                    $ent++;		
                    $bgColorCounter++;
                }    
            } 
			$select_directory1='order by invoice_id asc';
			$sql_query_inv= "SELECT invoice_id,enroll_id,paid_type,bank_name,cheque_detail,amount FROM invoice where DATE(added_date)='".$date."' and amount>0 ".$branch_id." ".$select_directory1." "; 
			$ptr_in=mysql_query($sql_query_inv);
			$no_of_records_inv=mysql_num_rows($ptr_in);
			if($no_of_records_inv)
			{
				$inv=$ent;
				while($val_query_inv=mysql_fetch_array($ptr_in))
				{
					$sel_enroll="select enroll_id,invoice_no from enrollment where invoice_no= '".$val_query_inv['invoice_id']."'";
					$ptr_enroll=mysql_query($sel_enroll);
					if(!mysql_num_rows($ptr_enroll))
					{
						if($bgColorCounter%2==0)
							$bgcolor='class="grey_td"';
						else
							$bgcolor="";                
						$listed_record_id=$val_query['invoice_id'];
						 
						include "include/paging_script.php";
						
						"<br/>".$sql_name="select name from enrollment where enroll_id='".$val_query_inv['enroll_id']."' ".$branch_id."";
						$my_name=mysql_query($sql_name);
						$row_name= mysql_fetch_array($my_name);
						
						$sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$val_query_inv['paid_type']."' ";
						$ptr_payment_mode=mysql_query($sel_payment_mode);
						$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
						
						$sel_bank="select bank_name,account_no from bank where bank_id='".$val_query_inv['bank_name']."' ";
						$ptr_bank=mysql_query($sel_bank);
						$data_bank_name=mysql_fetch_array($ptr_bank);
						
						echo '<tr '.$bgcolor.' >';
						echo '<td align="center">'.$inv.'</td>';   
						echo '<td align="center" colspan="2">Installment</td>';    
						echo '<td align="center">'.$row_name['name'].'</td>';
						echo '<td align="center">'.$data_payment_mode['payment_mode'].'</td>';
						echo '<td align="center">'.$data_bank_name['bank_name'].'</td>';
						echo '<td align="center">'.$data_bank_name['account_no'].'</td>';
						echo '<td align="center">'.$val_query_inv['cheque_detail'].'</td>';
						/*echo '<td align="center">'.$row_invoice['chaque_date'].'</td>';*/
						echo '<td align="center">'.$val_query_inv['amount'].'</td>';
						echo '</tr>';
						$inv++;
						$bgColorCounter++;
					}
				} 
			}
			if($no_of_records !='')
			{}
			else
				echo '<tr><td class="text" align="center" colspan="9"><br><div class="msgbox" style="width:50%;">No Student record added on today</div><br></td></tr>';?>
		<!--</form>-->
		<!--=========================================END=======================================================-->
            <tr>
            	<td class="width5" colspan="10" align="center" style="font-size:15px !important">
					<?php
                    $sel_dsr="select * from dsr_match_reprot where 1 and status='yes' and added_by='".$_SESSION['admin_id']."' and DATE(dsr_date)='".$date."' ".$branch_id." ";
                    $ptr_date=mysql_query($sel_dsr);
                    $data_dsr_matched=mysql_fetch_array($ptr_date);
                    
                    ?>
                    <strong>Is DSR Matched </strong>&nbsp;&nbsp;&nbsp; <input type="radio" <?php if($data_dsr_matched['status']=='yes' || $data_dsr_matched['status']=='') echo 'checked="checked"'; ?> name="dsr_matched" id="dsr_matched" value="yes" onclick="check_dsr('yes')"  />Yes &nbsp;&nbsp;&nbsp; <input <?php if($data_dsr_matched['status']!='yes') echo 'checked="checked"'; ?> type="radio" name="dsr_matched" id="dsr_matched" value="no" onclick="check_dsr('no')" />No
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