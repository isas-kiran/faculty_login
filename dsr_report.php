<?php include 'inc_classes.php';
ini_set('max_execution_time',1000);
?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>DSR Report</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='103'";
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
//echo $_GET['baranch_id'];
if($_GET['baranch_id'] =='' )
{
	if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
	{
		$branch_id= "and cm_id = '2'"; //$_SESSION['where']
		$exp_branch_id="and i.cm_id = '2'";//For expense_invoice and expense Join query
		$cm_id1= "2";//$_SESSION['cm_id'];
		$branch_name='Pune';//''
	}
	else
	{
		$branch_id="and cm_id='".$_SESSION['cm_id']."'"; //$_SESSION['where']
		$exp_branch_id="and i.cm_id='".$_SESSION['cm_id']."'";//For expense_invoice and expense Join query
		$cm_id1= $_SESSION['cm_id'];//$_SESSION['cm_id'];
		$branch_name=$_SESSION['branch_name'];//''
	}
	
}
else
{
	$branch_id= "and cm_id = '".$_GET['baranch_id']."'";
	$exp_branch_id="and i.cm_id='".$_GET['baranch_id']."'";//For expense_invoice and expense Join query
	$cm_id1= $_GET['baranch_id'];
	
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
    <td class="top_mid" valign="bottom"><?php include "include/report_menu.php";?></td>
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
			  					<td width="20%" align="left"><input type="text" name="date" class="input_text datepicker" placeholder="date" id="date" title="Date" value="<?php if($_REQUEST['date']!='') echo $_REQUEST['date']; else echo date('d/m/Y');?>">
                                <input type="hidden" name="cm_ids" id="cm_ids" value="<?php echo $cm_id1; ?>"  /></td>
								<?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
                                {
									?>
									<td width="100%" align="center" ><strong>Select Branch</strong> &nbsp;&nbsp;
									<?php
                                    $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
                                    $query_branch = mysql_query($sel_branch);
                                    $total_Branch = mysql_num_rows($query_branch);
                                    //echo '<table width="100%"><tr><td>';
                                    echo ' <select id="baranch_id" name="baranch_id">';
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
                                        if($_GET['baranch_id']== $cm_id)
                                        {
                                             $selected='selected="selected"';
                                        }
                                        else if($row_branch['branch_name']=='Pune' && $_GET['baranch_id']=='')
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
                                    <!-- <td width="10%">
                                     <input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php //if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>">
                                     </td>
                                     
                                     <td width="10%">
                                     <input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php //if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>">
                                     </td>-->
                                    </td>
                                    <?php 
								} ?>
                                <td><input type="submit" name="search" value="Search" class="inputButton"/></td>
                                    <!--<td class="rightAlign" > 
                                        <table border="0" cellspacing="0" cellpadding="0" align="right">
                                            <tr>
                                                <td></td>
                                                <td class="width5"></td>
                                                <td><input type="text" value="<?php //if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                                                <td class="width2"></td>
                                                <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
                                            </tr>
                                        </table>	
                                    </td>-->
                            </form>	
                                      <!--<form method="get" name="search">
                     
                                    <td class="width5"></td>
                                     <td width="10%">
                                     <input type="hidden" name="send_mail"  value="mail">
                                     </td>
                                     <td width="10%"><a href="dsr_mail.php"><input type="button" name="send_mail" value="Send Mail" class="inputButton"/></a></td>
                                    </form>-->
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
		
				/* $insert_dsr="insert into dsr(`total_incoming`, `total_outgoing`, `yesterday_bal`, `total_cash_fees`, `total_cash_product`, `total_cash_taken_from_bank`, `cash_received_from_director`, `total_cash_expense`, `cash_given_to_director`,`cash_received_from_innocent`,`cash_in_hand`,`added_date`,`cm_id`) values ('".$_POST['total_incoming']."','".$_POST['total_outgoing']."','".$_POST['opening_cash']."','".$_POST['total_cash_fees']."','".$_POST['total_cash_product']."','".$_POST['total_cash_taken_from_bank']."','".$_POST['cash_received_from_director']."','".$_POST['total_cash_expense']."','".$_POST['cash_given_to_director']."','".$_POST['cash_received_from_innocent']."','".$_POST['cash_in_hand']."','".$date."','".$cm_id1."')";
			  	$ptr_insert=mysql_query($insert_dsr);
				for($i=1;$i<=$_POST['total_banks']; $i++)
				{
					$insert_into_dsr_bank=" insert into dsr_bank_summery (`bank_id`,`account_no`,`incoming`,`	outgoing`,`yesterdas_balance`,`todays_balance`,`added_date`) values('".$_POST['bank_id_'.$i.'']."','".$_POST['account_no'.$i.'']."','".$_POST['incoming'.$i.'']."','".$_POST['outgoing'.$i.'']."','".$_POST['yesterday_bal'.$i.'']."','".$_POST['today_bal'.$i.'']."','".$date."')";
					  
					  $ptr_banks=mysql_query($insert_into_dsr_bank);
				}*/
				?><script>
				//document.location.href="dsr_mail.php?<?php //echo $sep_url_string; ?>&send_mail=mail";
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
					
					$sel_course_cash="select SUM(amount) as total_amt from invoice where 1 and paid_type='1' and  DATE(`added_date`)='".$date."' ".$branch_id."";
                    $ptr_course_cash=mysql_query($sel_course_cash);
                    $data_course_cash=mysql_fetch_array($ptr_course_cash);
					$total_course_cash_incoming = $data_course_cash['total_amt'];
					
					$sel_course_online="select SUM(amount) as total_amt from invoice where 1 and (paid_type='2' or paid_type='3' or paid_type='4' or paid_type='5') and  DATE(`added_date`)='".$date."' ".$branch_id."";
                    $ptr_course_online=mysql_query($sel_course_online);
                    $data_course_online=mysql_fetch_array($ptr_course_online);
					$total_course_online_incoming = $data_course_online['total_amt'];
                    //==============================================================================
                    ?>
                    <td align="left" colspan="3" style="color:#F00"><strong>Total Incoming</strong> : <?php echo $total_todays_bal; ?></td>
                     <td align="left" colspan="2" style="color:#F00"><strong>Total Cash Incoming</strong> : <?php echo $total_course_cash_incoming; ?></td>
                    <td align="left" colspan="3" style="color:#F00"><strong>Total Online Incoming</strong> : <?php echo $total_course_online_incoming; ?></td>
                    
              		<input type="hidden" name="total_incoming" value="<?php echo $total_todays_bal; ?>">
                    <input type="hidden" name="total_course_cash_incoming" value="<?php echo $total_course_cash_incoming; ?>">
                    <input type="hidden" name="total_course_online_incoming" value="<?php echo $total_course_online_incoming?>">
              	</tr>
				<?php
				$select_directory='order by enroll_id asc';                      
				$sql_query= "SELECT enroll_id,name FROM enrollment where added_date='".$date."' ".$branch_id." ".$pre_keyword." ".$select_directory." "; 
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
                    /*$bgColorCounter=1;
                    $query_string='&keyword='.$keyword;
                    $query_string1=$query_string.$date_query;
                    $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);*/
                    
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
                    
                        /*echo '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
                              <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
            
                        echo '</td>';*/
                        echo '</tr>';
                        $ent++;		
                        $bgColorCounter++;
                    }    
						?>
					<?php 
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
				"<br/>".$sel_enroll="select enroll_id,invoice_no from enrollment where invoice_no= '".$val_query_inv['invoice_id']."'";
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
					
					
					
					echo '<tr '.$bgcolor.' >
						  ';
					echo '<td align="center">'.$inv.'</td>';   
					echo '<td align="center" colspan="2">Installment</td>';    
					echo '<td align="center">'.$row_name['name'].'</td>';
					echo '<td align="center">'.$data_payment_mode['payment_mode'].'</td>';
					echo '<td align="center">'.$data_bank_name['bank_name'].'</td>';
					echo '<td align="center">'.$data_bank_name['account_no'].'</td>';
					echo '<td align="center">'.$val_query_inv['cheque_detail'].'</td>';
					/*echo '<td align="center">'.$row_invoice['chaque_date'].'</td>';*/
					echo '<td align="center">'.$val_query_inv['amount'].'</td>';
				
					/*echo '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
						  <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
		
					echo '</td>';*/
					echo '</tr>';
					$inv++;
					$bgColorCounter++;
				}
					
			}    
				?>
      <?php } 
	  
	  
	  if($no_of_records !='')
	  {}
      else
        echo '<tr><td class="text" align="center" colspan="9"><br><div class="msgbox" style="width:50%;">No Student record added on today</div><br></td></tr>';?>
        <!--</form>-->
        
 <!--==============================================================================INCOMMING SERVICES==============================================================-->
 
  <tr  bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Incoming Service /Membership</strong></td>
  </tr>
  <tr>
  <?php 
//===================Total receive balance===============================
$sel_total_servicec="select SUM(payable_amount) as total_amt from customer_service_invoice where paid_type!='0' and payable_amount>'0' and DATE(`added_date`)='".$date."' ".$branch_id."";
$ptr_total_service=mysql_query($sel_total_servicec);
$data_total_service=mysql_fetch_array($ptr_total_service);

$sql_customer= "SELECT price FROM customer where DATE(`added_date`)='".$date."' and membership ='yes' ".$branch_id." "; 
$ptr_customer=mysql_query($sql_customer);
while($data_customer=mysql_fetch_array($ptr_customer))
{
	$price +=$data_customer['price'];
}

$total_service_amount=$data_total_service['total_amt']+$price;
//-------------------------------Incoming Cash-----------------------------------
$sel_total_servicec_cash="select SUM(payable_amount) as total_amt from customer_service_invoice where paid_type ='1' and payable_amount>'0' and DATE(`added_date`)='".$date."' ".$branch_id."";
$ptr_total_service_cash=mysql_query($sel_total_servicec_cash);
$data_total_service_cash=mysql_fetch_array($ptr_total_service_cash);

$sql_customer_cash= "SELECT price FROM customer where DATE(`added_date`)='".$date."' and membership ='yes' and payment_mode_id='1' ".$branch_id." "; 
$ptr_customer_cash=mysql_query($sql_customer_cash);
while($data_customer_cash=mysql_fetch_array($ptr_customer_cash))
{
	$price_c +=$data_customer_cash['price'];
}

$total_service_cash_amount=$data_total_service_cash['total_amt']+$price_c;
//------------------------------Incoming Online-----------------------------------
$sel_total_servicec_online="select SUM(payable_amount) as total_amt from customer_service_invoice where 1 and (paid_type ='2' or paid_type ='3' or paid_type ='4' or paid_type ='5') and payable_amount>'0' and DATE(`added_date`)='".$date."' ".$branch_id."";
$ptr_total_service_online=mysql_query($sel_total_servicec_online);
$data_total_service_online=mysql_fetch_array($ptr_total_service_online);

$sql_customer_online="SELECT price FROM customer where DATE(`added_date`)='".$date."' and membership ='yes' and (payment_mode_id='2' or payment_mode_id='3' or payment_mode_id='4' or payment_mode_id='5' or ) ".$branch_id." "; 
$ptr_customer_online=mysql_query($sql_customer_online);
while($data_customer_online=mysql_fetch_array($ptr_customer_online))
{
	$price_o +=$data_customer_online['price'];
}

$total_service_online_amount=$data_total_service_online['total_amt']+$price_o; 
//==============================================================================
  ?>
  <td align="left" colspan="3" style="color:#F00"><strong>Total Incoming</strong> : <?php echo $total_service_amount; ?></td>
  <td align="left" colspan="2" style="color:#F00"><strong>Total Cash Incoming</strong> : <?php echo $total_service_cash_amount; ?></td>
    <td align="left" colspan="3" style="color:#F00"><strong>Total Online Incoming</strong> : <?php echo $total_service_online_amount; ?></td>
    
  <input type="hidden" name="total_incoming_service" value="<?php echo $total_service_amount; ?>" >
  <input type="hidden" name="total_incoming_service_cash" value="<?php echo $total_service_cash_amount; ?>">
  <input type="hidden" name="total_incoming_service_online" value="<?php echo $total_service_online_amount; ?>">
  </tr>
	<?php
	$select_directory='order by invoice_id asc';                      
	$sql_query= "SELECT invoice_id,paid_type,bank_id,customer_service_id,voucher_number,cheque_detail,payable_amount FROM customer_service_invoice where paid_type!='0' and payable_amount>0 and DATE(`added_date`)='".$date."' ".$branch_id." ".$select_directory." "; 
    //echo $sql_query;
	$ptr_query=mysql_query($sql_query);
	$no_of_records=mysql_num_rows($ptr_query);
	?>
    <tr class="grey_td" style="background-color:#999">
        <td width="45" align="center"><strong>Sr. No.</strong></td>
        <td align="center" colspan="2"><strong>Sale Type</strong></td>
        <td width="241" align="center"><strong>Customer Name</strong></td>
        <td width="126" align="center"><strong>Payment Mode</strong></td>
        <td width="104" align="center"><strong>Bank</strong></td>
        <td width="105" align="center"><strong>Account No</strong></td>
        <td width="151" align="center"><strong>Chaque No</strong></td>
        <td width="144" align="center"><strong>Amount</strong></td>
    </tr>
    <?php
	if($no_of_records)
	{
		$ser_no=1;
		while($val_query=mysql_fetch_array($ptr_query))
		{
			if($bgColorCounter%2==0)
				$bgcolor='class="grey_td"';
			else
				$bgcolor="";                
			$listed_record_id=$val_query['invoice_id']; 
			include "include/paging_script.php";
			/*$sql_invoice="select invoice_id,chaque_date,paid_type,bank_name,cheque_detail,amount from invoice where enroll_id='".$val_query['enroll_id']."' ".$branch_id."";
			$my_query_invoice=mysql_query($sql_invoice);
			$row_invoice= mysql_fetch_array($my_query_invoice);*/
			
			$sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$val_query['paid_type']."' ";
			$ptr_payment_mode=mysql_query($sel_payment_mode);
			$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
			
			$sel_bank="select bank_name,account_no from bank where bank_id='".$val_query['bank_id']."' ";
			$ptr_bank=mysql_query($sel_bank);
			$data_bank_name=mysql_fetch_array($ptr_bank);
			
			$sel_="select customer_id,type from customer_service where customer_service_id='".$val_query['customer_service_id']."'";
			$ptr_sels=mysql_query($sel_);
			$data_cust_srv=mysql_fetch_array($ptr_sels);
			
			/*$sel_cust_name="select cust_name from customer where cust_id='".$data_cust_srv['customer_id']."' ";
			$ptr_cust_name=mysql_query($sel_cust_name);
			$data_cust_name=mysql_fetch_array($ptr_cust_name);*/
			$name='';
			if($data_cust_srv['type']=='Student')
			{
				$sql_product = "select name,contact from enrollment where enroll_id='".$data_cust_srv['customer_id']."' ";
				$ptr_product = mysql_query($sql_product);
				$data_product = mysql_fetch_array($ptr_product);
				$name=$data_product['name'];
				$mobile=$data_product['contact'];
			}
			else if($data_cust_srv['type']=='Employee')
			{
				$sql_product="select name, admin_id,contact_phone from site_setting where admin_id='".$data_cust_srv['customer_id']."' ";
				$ptr_product=mysql_query($sql_product);
				$data_product=mysql_fetch_array($ptr_product);
				$name=$data_product['name'];
				$mobile=$data_product['contact_phone'];
			}
			else 
			{
				$sql_product="select cust_name,cust_id,mobile1 from customer where cust_id='".$data_cust_srv['customer_id']."' ";
				$ptr_product=mysql_query($sql_product);
				$data_product=mysql_fetch_array($ptr_product);
				$name=$data_product['cust_name'];
				$mobile=$data_product['mobile1'];
			}
			
			$voucher_no=='';
			if($data_payment_mode['payment_mode'] =="6")
			{
				$voucher_no="Voucher No.- ".$val_query['voucher_number'];
			}
			echo '<tr '.$bgcolor.' >';
			echo '<td align="center">'.$ser_no.'</td>';   
			echo '<td align="center" colspan="2">Service</td>';    
			echo '<td align="center">'.$name.'</td>';
			echo '<td align="center">'.$data_payment_mode['payment_mode']."<br/>".$voucher_no.'</td>';
			echo '<td align="center">'.$data_bank_name['bank_name'].'</td>';
			echo '<td align="center">'.$data_bank_name['account_no'].'</td>';
			echo '<td align="center">'.$val_query['cheque_detail'].'</td>';
			echo '<td align="center">'.$val_query['payable_amount'].'</td>';
			/*echo '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
				  <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
			echo '</td>';*/
			echo '</tr>';
			$bgColorCounter++;
			$ser_no++;
		}
	?>
<?php }
else
echo '<tr><td class="text" align="center" colspan="9"><br><div class="msgbox" style="width:50%;">No Service added on today</div><br></td></tr>';
		
		$select_directory='order by cust_id asc';
		$sql_querys= "SELECT payment_mode_id,bank_id,customer_id,chaque_no,price FROM customer where DATE(`added_date`)='".$date."' and membership ='yes'  ".$branch_id." ".$select_directory." "; 
        //echo $sql_query;
        $no_of_recordss=mysql_num_rows($db->query($sql_querys));
		if($no_of_recordss)
		{
			$bgColorCounter=1;
			//$_SESSION['show_records'] = 10;
			$query_string='&keyword='.$keyword;
			$query_string1=$query_string.$date_query;
			// $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
			$pager = new PS_Pagination($sql_querys,$_SESSION['show_records'],5,$query_string1);
			$all_records= $pager->paginate();
			while($val_query=mysql_fetch_array($all_records))
			{
				if($bgColorCounter%2==0)
					$bgcolor='class="grey_td"';
				else
					$bgcolor="";                
				//$listed_record_id=$val_query['customer_service_id']; 
				//include "include/paging_script.php";
				
				
				$sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$val_query['payment_mode_id']."' ";
				$ptr_payment_mode=mysql_query($sel_payment_mode);
				$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
				
				$sel_bank="select bank_name,account_no from bank where bank_id='".$val_query['bank_id']."' ";
				$ptr_bank=mysql_query($sel_bank);
				$data_bank_name=mysql_fetch_array($ptr_bank);
				
				$sel_cust_name="select cust_name from customer where cust_id='".$val_query['customer_id']."' ";
				$ptr_cust_name=mysql_query($sel_cust_name);
				$data_cust_name=mysql_fetch_array($ptr_cust_name);
				
				echo '<tr '.$bgcolor.' >';
				echo '<td align="center">'.$sr_no.'</td>'; 
				echo '<td align="center" colspan="2">Membership</td>';    
				echo '<td align="center">'.$data_cust_name['cust_name'].'</td>';
				echo '<td align="center">'.$data_payment_mode['payment_mode'].'</td>';
				echo '<td align="center">'.$data_bank_name['bank_name'].'</td>';
				echo '<td align="center">'.$data_bank_name['account_no'].'</td>';
				echo '<td align="center">'.$val_query['chaque_no'].'</td>';
				echo '<td align="center">'.$val_query['price'].'</td>';
				/*echo '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
					  <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
				echo '</td>';*/
				echo '</tr>';
				$bgColorCounter++;
			} 
		
		}
		?>
 <!--====================================END================================================-->
 <!--================================INCOMMING PRODUCT======================================-->
  <tr  bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Incoming for Product</strong></td>
  </tr>
  <tr>
  <?php 
//===================Total receive balance===============================
$sel_total_servicec="SELECT SUM(payable_amount) as total_amt FROM sales_product_invoice where DATE(`added_date`)='".$date."' and payable_amount>0 ".$branch_id."";
$ptr_total_service=mysql_query($sel_total_servicec);
$data_total_service=mysql_fetch_array($ptr_total_service);
$total_service_amount=$data_total_service['total_amt'];
//----------------------------Total Cash Incoming-----------------------------------
$sel_total_servicec_cash="SELECT SUM(payable_amount) as total_amt FROM sales_product_invoice where 1 and paid_type='1' and DATE(`added_date`)='".$date."' and payable_amount>0 ".$branch_id."";
$ptr_total_service_cash=mysql_query($sel_total_servicec_cash);
$data_total_service_cash=mysql_fetch_array($ptr_total_service_cash);
$total_service_amount_cash=$total_service_amount_cash['total_amt'];
//----------------------------Total Online Incoming------------------------------------
$sel_total_servicec_online="SELECT SUM(payable_amount) as total_amt FROM sales_product_invoice where 1 and (paid_type='2' or poraid_type='3' or paid_type='4' or paid_type='5') and DATE(`added_date`)='".$date."' and payable_amount>0 ".$branch_id."";
$ptr_total_service_online=mysql_query($sel_total_servicec_online);
$data_total_service_online=mysql_fetch_array($ptr_total_service_online);
$total_service_amount_online=$data_total_service_online['total_amt'];
//==============================================================================
  ?>
  <td align="left" colspan="3" style="color:#F00"><strong>Total Incoming</strong> : <?php echo $total_service_amount; ?></td>
  <td align="left" colspan="2" style="color:#F00"><strong>Total Cash Incoming</strong> : <?php echo $total_service_amount_cash; ?></td>
  <td align="left" colspan="3" style="color:#F00"><strong>Total Online Incoming</strong> : <?php echo $total_service_amount_online; ?></td>
  
  <input type="hidden" name="total_incoming_service" value="<?php echo $total_service_amount; ?>">
  <input type="hidden" name="total_service_amount_cash" value="<?php echo $total_service_amount_cash; ?>">
  <input type="hidden" name="total_service_amount_online" value="<?php echo $total_service_amount_online; ?>">
  </tr>

  <tr class="grey_td" style="background-color:#999">
    <td width="45" align="center"><strong>Sr. No.</strong></td>
    <td width="102" align="center"><strong>Invoice Id</strong></td>
    <td width="121" align="center" colspan="2"><strong>Customer Name</strong></td>
    <td width="126" align="center"><strong>Payment Mode</strong></td>
    <td width="104" align="center"><strong>Bank</strong></td>
    <td width="105" align="center"><strong>Account No</strong></td>
    <td width="151" align="center"><strong>Chaque No</strong></td>
    <td width="144" align="center"><strong>Amount</strong></td>
  </tr>
  <?php  
	$select_directory='order by invoice_id asc';                      
	$sql_query= "SELECT invoice_id,sales_product_id,paid_type,bank_id,cheque_detail,payable_amount FROM sales_product_invoice where DATE(`added_date`)='".$date."' and payable_amount>0 ".$branch_id." ".$select_directory.""; 
	//echo $sql_query;
	$sql_query=mysql_query($sql_query);
	$no_of_records=mysql_num_rows($sql_query);
    if($no_of_records)
	{
		$ij=1;
		while($val_query=mysql_fetch_array($sql_query))
		{
			if($bgColorCounter%2==0)
				$bgcolor='class="grey_td"';
			else
				$bgcolor="";                
			$listed_record_id=$val_query['invoice_id']; 
			include "include/paging_script.php";
				
			$sel_sales_products="select sales_product_id,customer_id,type from sales_product where sales_product_id='".$val_query['sales_product_id']."'";	
			$ptr_products=mysql_query($sel_sales_products);
			$data_products=mysql_fetch_array($ptr_products);
			
			$sel_cust="select cust_name from customer where cust_id= '".$data_products['customer_id']."'";
			$ptr_cust=mysql_query($sel_cust);
			$data_cust=mysql_fetch_array($ptr_cust);
									
			$sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$val_query['paid_type']."' ";
			$ptr_payment_mode=mysql_query($sel_payment_mode);
			$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
			
			$sel_bank="select bank_name,account_no from bank where bank_id='".$val_query['bank_id']."' ";
			$ptr_bank=mysql_query($sel_bank);
			$data_bank_name=mysql_fetch_array($ptr_bank);
			
			$sel_cust_name="select name from vendor where vendor_id='".$data_products['vendor_id']."' ";
			$ptr_cust_name=mysql_query($sel_cust_name);
			$data_cust_name=mysql_fetch_array($ptr_cust_name);
			
			$name='';
			if($data_products['type']=='Customer')
			{
				$sql_product ="select cust_name, cust_id from customer where cust_id='".$data_products['customer_id']."' ";
				$ptr_product = mysql_query($sql_product);
				$data_product = mysql_fetch_array($ptr_product);
				$name=$data_product['cust_name'];
			}
			else
			if($data_products['type']=='Employee')
			{
				$sql_product ="select name, admin_id from site_setting where admin_id='".$data_products['customer_id']."' ";
				$ptr_product = mysql_query($sql_product);
				$data_product = mysql_fetch_array($ptr_product);
				$name=$data_product['name'];
			}
			else
			{
				$sql_product ="select name from enrollment where enroll_id='".$data_products['customer_id']."' ";
				$ptr_product = mysql_query($sql_product);
				$data_product = mysql_fetch_array($ptr_product);
				$name=$data_product['name'];
			}
			
			echo '<tr '.$bgcolor.' >';
			echo '<td align="center">'.$ij.'</td>';   
			echo '<td align="center">SALE-'.$val_query['sales_product_id'].'-'.$val_query['invoice_id'].'</td>';
			$sel_prod="select product_id from sales_product_map where sales_product_id = '".$data_products['sales_product_id']."'";
			$ptr_prod=mysql_query($sel_prod);
			$total_Sales=mysql_num_rows($ptr_prod);
			echo '<td align="center" colspan="2">';
			echo $name;
			echo '</td>';
			
			echo '<td align="center">'.$data_payment_mode['payment_mode'].'</td>';
			echo '<td align="center">'.$data_bank_name['bank_name'].'</td>';
			echo '<td align="center">'.$data_bank_name['account_no'].'</td>';
			echo '<td align="center">'.$val_query['cheque_detail'].'</td>';
			echo '<td align="center">'.$val_query['payable_amount'].'</td>';
			/*echo '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
				  <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
			echo '</td>';*/
			echo '</tr>';
			$ij++;
			$bgColorCounter++;
		}
	} 
	else
        echo '<tr><td class="text" align="center" colspan="9"><br><div class="msgbox" style="width:50%;">No Sales Product added on today</div><br></td></tr>';?>   
     
 <!--=====================================END=================================================================-->
 <!--============================================Sale Vouchers/ Membership/Package=================================-->
  <tr  bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Sale Vouchers/ Package</strong></td>
  </tr>
  <tr>
  <?php 
//===================Total receive balance===============================
$sel_sales_pack="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where membership_id='0' and DATE(`added_date`) = '".$date."' ".$branch_id."";
$ptr_sales_pack=mysql_query($sel_sales_pack);
$data_sales_pack=mysql_fetch_array($ptr_sales_pack);

$total_sales_pack=$data_sales_pack['total_amt'];
//------------------------------Total Cash-------------------------------
$sel_sales_pack_cash="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where 1 and payment_mode_id='1' and membership_id='0' and DATE(`added_date`) = '".$date."' ".$branch_id."";
$ptr_sales_pack_cash=mysql_query($sel_sales_pack_cash);
$data_sales_pack_cash=mysql_fetch_array($ptr_sales_pack_cash);

$total_sales_pack_cash=$data_sales_pack_cash['total_amt'];
//-----------------------------Total Online-----------------------------
$sel_sales_pack_online="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where 1 and (payment_mode_id='2' or payment_mode_id='3' or payment_mode_id='4' or payment_mode_id='5') and membership_id='0' and DATE(`added_date`) = '".$date."' ".$branch_id."";
$ptr_sales_pack_online=mysql_query($sel_sales_pack_online);
$data_sales_pack_online=mysql_fetch_array($ptr_sales_pack_online);

$total_sales_pack_online=$data_sales_pack_online['total_amt'];
//==============================================================================
  ?>
  <td align="left" colspan="3" style="color:#F00"><strong>Total Incoming</strong> : <?php echo $total_sales_pack; ?></td>
  <td align="left" colspan="2" style="color:#F00"><strong>Total Cash Incoming</strong> : <?php echo $total_sales_pack_cash; ?></td>
  <td align="left" colspan="3" style="color:#F00"><strong>Total Online Incoming</strong> : <?php echo $total_sales_pack_online; ?></td>
  <input type="hidden" name="total_sales_pack" value="<?php echo $total_sales_pack; ?>"  />
  <input type="hidden" name="total_sales_pack_cash" value="<?php echo $total_sales_pack_cash; ?>"  />
    <input type="hidden" name="total_sales_pack_online" value="<?php echo $total_sales_pack_online; ?>"  />
  </tr>
  <tr class="grey_td" style="background-color:#999">
    <td width="45" align="center"><strong>Sr. No.</strong></td>
    <td width="102" align="center"><strong>Category</strong></td>
    <td width="121" align="center" colspan="2"><strong>Name</strong></td>
    <td width="126" align="center"><strong>Payment Mode</strong></td>
    <td width="104" align="center"><strong>Bank</strong></td>
    <td width="105" align="center"><strong>Account No</strong></td>
    <td width="151" align="center"><strong>Chaque No</strong></td>
    <td width="144" align="center"><strong>Amount</strong></td>
  </tr>

  	<?php  
	$select_directory='order by id asc';                      
	$sql_query= "SELECT id,cust_id,payment_mode_id,bank_id,category,membership_id,package_id,voucher_id,chaque_no,payable_amount FROM sales_package_voucher_memb where membership_id='0' and  DATE(`added_date`)='".$date."' ".$branch_id." ".$select_directory." "; 
	//echo $sql_query;
	$no_of_records=mysql_num_rows($db->query($sql_query));
    if($no_of_records)
	{
		$bgColorCounter=1;
		//$_SESSION['show_records'] = 10;
		$query_string='&keyword='.$keyword;
		$query_string1=$query_string.$date_query;
		// $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
		$pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
		$all_records= $pager->paginate();
		while($val_query=mysql_fetch_array($all_records))
		{
			if($bgColorCounter%2==0)
				$bgcolor='class="grey_td"';
			else
				$bgcolor="";                
			$listed_record_id=$val_query['id']; 
			//include "include/paging_script.php";
			
			$cust_name="select cust_name from customer where cust_id='".$val_query['cust_id']."'";
			$ptr_cust=mysql_query($cust_name);
			$data_cust=mysql_fetch_array($ptr_cust);
																
			$sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$val_query['payment_mode_id']."' ";
			$ptr_payment_mode=mysql_query($sel_payment_mode);
			$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
			
			$sel_bank="select bank_name,account_no from bank where bank_id='".$val_query['bank_id']."' ";
			$ptr_bank=mysql_query($sel_bank);
			$data_bank_name=mysql_fetch_array($ptr_bank);
			
			$name=='';
			if($val_query['category']=='Membership')
			{
				$sl_memb="select membership_name from membership where membership_id='".$val_query['membership_id']."'";
				$ptr_memb=mysql_query($sl_memb);
				$data_memb=mysql_fetch_array($ptr_memb);
				$name=$data_memb['membership_name'];
			}
			else if($val_query['category']=='Package')
			{
				$sl_package="select package_name from package where package_id='".$val_query['package_id']."'";
				$ptr_package=mysql_query($sl_package);
				$data_package=mysql_fetch_array($ptr_package);
				$name=$data_package['package_name'];
			}else if($val_query['category']=="Voucher")
			{
				$sl_voucher="select deal_name from voucher where voucher_id='".$val_query['voucher_id']."'";
				$ptr_voucher=mysql_query($sl_voucher);
				$data_voucher=mysql_fetch_array($ptr_voucher);
				$name=$data_voucher['deal_name'];
			}
			/*$sel_cust_name="select name from vendor where vendor_id='".$val_query['vendor_id']."' ";
			$ptr_cust_name=mysql_query($sel_cust_name);
			$data_cust_name=mysql_fetch_array($ptr_cust_name);
			*/
			echo '<tr '.$bgcolor.' >';
			echo '<td align="center">'.$sr_no.'</td>';   
			echo '<td align="center">'.$val_query['category'].'</td>';
			echo '<td align="center" colspan="2">'.$name.'</td>';
			echo '<td align="center">'.$data_payment_mode['payment_mode'].'</td>';
			echo '<td align="center">'.$data_bank_name['bank_name'].'</td>';
			echo '<td align="center">'.$data_bank_name['account_no'].'</td>';
			echo '<td align="center">'.$val_query['chaque_no'].'</td>';
			echo '<td align="center">'.$val_query['payable_amount'].'</td>';
			/*echo '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
				  <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
			echo '</td>';*/
			echo '</tr>';
			$bgColorCounter++;
	  }    
     ?>
  <?php } 
      else
        echo '<tr><td class="text" align="center" colspan="9"><br><div class="msgbox" style="width:50%;">No Sales Product added on today</div><br></td></tr>';?>   
 <!--====================================================END============================================-->
  <tr bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Incommimg (Receipt)</strong></td>
  </tr>
  <tr>
  <?php 
	$sel_total_inc2="select SUM(amount) as total_amt from receipt where 1 and category !='cash_transfer' and added_date='".$date."' ".$branch_id."";
	$ptr_total_inc2=mysql_query($sel_total_inc2);
	$data_total_inc2=mysql_fetch_array($ptr_total_inc2);
	$total=$data_total_inc2['total_amt'];
	//-------------------------Total Cash Incoming-------------------------------
	$sel_total_inc2_cash="select SUM(amount) as total_amt from receipt where 1 and payment_mode_id='1' and category !='cash_transfer' and added_date='".$date."' ".$branch_id."";
	$ptr_total_inc2_cash=mysql_query($sel_total_inc2_cash);
	$data_total_inc2_cash=mysql_fetch_array($ptr_total_inc2_cash);
	$total_cash=$data_total_inc2_cash['total_amt'];
	//------------------------Total Online Incoming----------------------------
	$sel_total_inc2_online="select SUM(amount) as total_amt from receipt where 1 and category !='cash_transfer' and added_date='".$date."' ".$branch_id."";
	$ptr_total_inc2_online=mysql_query($sel_total_inc2_online);
	$data_total_inc2_online=mysql_fetch_array($ptr_total_inc2_online);
	$total_online=$data_total_inc2_online['total_amt'];
	//--------------------------------------------------------------------------------------------
  ?>
  <td align="left" colspan="3" style="color:#F00"><strong>Total Incomming</strong> : <?php echo $total; ?></td>
  <td align="left" colspan="2" style="color:#F00"><strong>Total Cash Incomming</strong> : <?php echo $total_cash; ?></td>
  <td align="left" colspan="3" style="color:#F00"><strong>Total Online Incomming</strong> : <?php echo $total_online; ?></td>
  
  <input type="hidden" name="total_incomming" value="<?php echo $total; ?>">
  <input type="hidden" name="total_cash_incomming" value="<?php echo $total_cash; ?>">
  <input type="hidden" name="total_online_incomming" value="<?php echo $total_online; ?>">
  </tr>
  
  <tr>
 <td colspan="10" >
 <table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #999">
 <tr style="background-color:#999">
    <td width="04%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
    <td width="10%" align="center" style="border:1px solid #CCC"><strong>Type</strong></td>
    <td width="10%" align="center" style="border:1px solid #CCC"><strong>Payment Mode</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Bank</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Descrription</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Customer name</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Amount</strong></td>
 </tr>
    <?php
	$sele_recep="select receipt_id,category,payment_mode_id,bank_id,amount,added_date,cash_transfer_mode,customer_id,emp_type,description from receipt where 1 and category !='cash_transfer' and cash_transfer_mode is NULL and added_date='".$date."' ".$branch_id."";
	$ptr_recep=mysql_query($sele_recep);
	$i=1;
	if(mysql_num_rows($ptr_recep))
	{
		while($data_recep=mysql_fetch_array($ptr_recep))
		{
			$sele_pay_name="select payment_mode from payment_mode where payment_mode_id='".$data_recep['payment_mode_id']."'";
			$ptr_pay_name=mysql_query($sele_pay_name);
			$data_pay_name=mysql_fetch_array($ptr_pay_name);
			
			$sel_bank="select bank_name,account_no from bank where bank_id='".$data_recep['bank_id']."'";
			$ptr_bank=mysql_query($sel_bank);
			$data_bank_name=mysql_fetch_array($ptr_bank);
			$cash_modes='';
			if($data_recep['cash_transfer_mode']!='')
			{
				$cash_modes='('.$data_recep['cash_transfer_mode'].')';
			}
			$category=$data_recep['category'];
			if($data_recep['category']=="cash_transfer")
			{
				$category='Cash Transfer';
			}
			
			$name='';
			if($data_recep['emp_type']=="Student")
			{
				$sel_student="select name from enrollment where enroll_id='".$data_recep['customer_id']."'";
				$ptr_stud=mysql_query($sel_student);
				$data_stud=mysql_fetch_array($ptr_stud);
				$name=$data_stud['name'];
			}
			else if($data_recep['emp_type']=="Customer")
			{
				$sel_cust="select cust_name from customer where cust_id='".$data_recep['customer_id']."'";
				$ptr_cust=mysql_query($sel_cust);
				$data_cust=mysql_fetch_array($ptr_cust);
				$name=$data_cust['cust_name'];
			}
			else if($data_recep['emp_type']=="Employee")
			{
				$sel_emp="select name from site_setting where admin_id='".$data_recep['customer_id']."'";
				$ptr_emp=mysql_query($sel_emp);
				$data_emp=mysql_fetch_array($ptr_emp);
				$name=$data_emp['name'];
			}
			else if($data_recep['emp_type']=="Vendor")
			{
				$sel_vendor="select name from vendor where vendor_id='".$data_recep['customer_id']."'";
				$ptr_vendor=mysql_query($sel_vendor);
				$data_vendor=mysql_fetch_array($ptr_vendor);
				$name=$data_vendor['name'];
			}
			echo '<tr>';
			echo '<td align="center" style="border:1px solid #CCC">'.$i.'</td>';       
			echo '<td align="center" style="border:1px solid #CCC">'.$category.' '.$cash_modes.'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_pay_name['payment_mode'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td>';
			//echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_recep['description'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$name.'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_recep['amount'].'</td>';
			$i++;
		}
	}
	
 ?> 
 
 <?php
		/*$select_directory='order by inventory_id asc';                      
		$sql_query= "SELECT * FROM inventory where DATE(`added_date`)='".$date."' ".$branch_id." ".$select_directory." "; 
		$no_of_records=mysql_num_rows($db->query($sql_query));
		?>
	  <?php
		if($no_of_records)
		{
			$bgColorCounter=1;
			$query_string='&keyword='.$keyword;
			$query_string1=$query_string.$date_query;
			$pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
			$all_records= $pager->paginate();
			while($val_query=mysql_fetch_array($all_records))
			{
				if($bgColorCounter%2==0)
					$bgcolor='class="grey_td"';
				else
					$bgcolor="";                
				$listed_record_id=$val_query['inventory_id']; 
				$sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$val_query['payment_mode_id']."' ";
				$ptr_payment_mode=mysql_query($sel_payment_mode);
				$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
				
				$sel_bank="select bank_name,account_no from bank where bank_id='".$val_query['bank_id']."' ";
				$ptr_bank=mysql_query($sel_bank);
				$data_bank_name=mysql_fetch_array($ptr_bank);
				
				$sel_cust_name="select name from vendor where vendor_id='".$val_query['vendor_id']."' ";
				$ptr_cust_name=mysql_query($sel_cust_name);
				$data_cust_name=mysql_fetch_array($ptr_cust_name);
				
				echo '<tr '.$bgcolor.' >';
				echo '<td align="center" style="border:1px solid #CCC">'.$sr_no.'</td>';   
				$sel_prod="select product_id from inventory_product_map where inventory_id = '".$listed_record_id."'";
				$ptr_prod=mysql_query($sel_prod);
				$total_inventory=mysql_num_rows($ptr_prod);
				echo '<td align="center" style="border:1px solid #CCC">Purchase Produc ('.$total_inventory.')</td>';
				echo '<td align="center" style="border:1px solid #CCC">-</td>';
				echo '<td align="center" style="border:1px solid #CCC">'.$data_payment_mode['payment_mode'].'</td>';
				echo '<td align="center" style="border:1px solid #CCC">'.$data_cust_name['name'].'</td>';
				echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td>';
				echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td>';
				
				echo '<td align="center" style="border:1px solid #CCC">'.$val_query['payable_amount'].'</td>';
				echo '</tr>';
				$bgColorCounter++;
		  }    
				?>
  <?php }    */   ?>
   </table>
   </td>
  </tr>
 <!--================================================END===============================================-->
  <tr bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Outgoing (Expense)</strong></td>
  </tr>
  <tr>
  <?php 
	$select_inv="select SUM(payable_amount) as total from inventory_invoice where DATE(added_date)='".$date."' ".$branch_id." ";
	$ptr_inv=mysql_query($select_inv);
	$total_inv=0;
	if(mysql_num_rows($ptr_inv))
	{
		$data_inv=mysql_fetch_array($ptr_inv);
		$total_inv=$data_inv['total'];
	}
	
  	$select_amnt1="select SUM(payable_amount) as total from expense_invoice where DATE(added_date)='".$date."' ".$branch_id." ";
	$ptr_amt1=mysql_query($select_amnt1);
	$total_amount1=0;
	if(mysql_num_rows($ptr_amt1))
	{
		$data_amnt1=mysql_fetch_array($ptr_amt1);
		$total_amount1=$data_amnt1['total'];
	}
	$sele_exp="select SUM(total_refund) as total_refund from enrollment_refund where DATE(added_date)='".$date."' ".$branch_id."";
	$ptr_exp=mysql_query($sele_exp);
	$totatl_refund=0;
	if(mysql_num_rows($ptr_exp))
	{
		$data_refund=mysql_fetch_array($ptr_exp);
		$totatl_refund=$data_refund['total_refund'];
	}
	$total=$total_inv+$total_amount1+$totatl_refund;
	//---------------------------Total Cash--------------------------------------
	$select_inv_cash="select SUM(payable_amount) as total from inventory_invoice where 1 and paid_type='1' and DATE(added_date)='".$date."' ".$branch_id." ";
	$ptr_inv_cash=mysql_query($select_inv_cash);
	$total_inv_cash=0;
	if(mysql_num_rows($ptr_inv_cash))
	{
		$data_inv_cash=mysql_fetch_array($ptr_inv_cash);
		$total_inv_cash=$data_inv_cash['total'];
	}
	
  	$select_amnt1_cash="select SUM(payable_amount) as total from expense_invoice where 1 and paid_type='1' and DATE(added_date)='".$date."' ".$branch_id." ";
	$ptr_amt1_cash=mysql_query($select_amnt1_cash);
	$total_amount1=0;
	if(mysql_num_rows($ptr_amt1_cash))
	{
		$data_amnt1_cash=mysql_fetch_array($ptr_amt1_cash);
		$total_amount1_cash=$data_amnt1_cash['total'];
	}
	$sele_exp_cash="select SUM(total_refund) as total_refund from enrollment_refund where 1 and paid_type='1' and DATE(added_date)='".$date."' ".$branch_id."";
	$ptr_exp_cash=mysql_query($sele_exp_cash);
	$totatl_refund_cash=0;
	if(mysql_num_rows($ptr_exp_cash))
	{
		$data_refund_cash=mysql_fetch_array($ptr_exp_cash);
		$totatl_refund_cash=$data_refund_cash['total_refund'];
	}
	$total_cash=$total_inv_cash+$total_amount1_cash+$totatl_refund_cash;
	//----------------------------Total Online Incoming-------------------------------------
	$select_inv_online="select SUM(payable_amount) as total from inventory_invoice where 1 and (paid_type!='1') and DATE(added_date)='".$date."' ".$branch_id." ";
	$ptr_inv_online=mysql_query($select_inv_online);
	$total_inv_online=0;
	if(mysql_num_rows($ptr_inv_online))
	{
		$data_inv_online=mysql_fetch_array($ptr_inv_online);
		$total_inv_online=$data_inv_online['total'];
	}
	
  	$select_amnt1_online="select SUM(payable_amount) as total from expense_invoice where 1 and (paid_type!='1') and DATE(added_date)='".$date."' ".$branch_id." ";
	$ptr_amt1_online=mysql_query($select_amnt1_online);
	$total_amount1_online=0;
	if(mysql_num_rows($ptr_amt1_online))
	{
		$data_amnt1_online=mysql_fetch_array($ptr_amt1_online);
		$total_amount1_online=$data_amnt1_online['total'];
	}
	$sele_exp_online="select SUM(total_refund) as total_refund from enrollment_refund where 1 and (paid_type!='1') and DATE(added_date)='".$date."' ".$branch_id."";
	$ptr_exp_online=mysql_query($sele_exp_online);
	$totatl_refund_online=0;
	if(mysql_num_rows($ptr_exp_online))
	{
		$data_refund_online=mysql_fetch_array($ptr_exp_online);
		$totatl_refund_online=$data_refund_online['total_refund'];
	}
	$total_online=$total_inv_online+$total_amount1_online+$totatl_refund_online;
	//----------------------------------------------------------------------------------------------
  ?>
  <td align="left" colspan="3" style="color:#F00"><strong>Total Outgoing</strong> : <?php echo $total; ?></td>
  <td align="left" colspan="2" style="color:#F00"><strong>Total cash Outgoing</strong> : <?php echo $total_cash; ?></td>
  <td align="left" colspan="3" style="color:#F00"><strong>Total Online Outgoing</strong> : <?php echo $total_online; ?></td>
  <input type="hidden" name="total_outgoing" value="<?php echo $total; ?>" >
  <input type="hidden" name="total_outgoing_cash" value="<?php echo $total_cash; ?>" >
  <input type="hidden" name="total_outgoing_online" value="<?php echo $total_online; ?>" >
  </tr>
  
  <tr>
 <td colspan="10" >
 <table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #999">
 <tr style="background-color:#999">
    <td width="4%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
    <td width="12%" align="center" style="border:1px solid #CCC"><strong>Expense Type</strong></td>
    <td width="16%" align="center" style="border:1px solid #CCC"><strong>Employee</strong></td>
    <td width="11%" align="center" style="border:1px solid #CCC"><strong>Payment Mode</strong></td>
    <td width="13%" align="center" style="border:1px solid #CCC"><strong>Vendor</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Bank</strong></td>
    <td width="13%" align="center" style="border:1px solid #CCC"><strong>Account No.</strong></td>
    <td width="16%" align="center" style="border:1px solid #CCC"><strong>Amount</strong></td>
 </tr>
    <?php
	//$sele_exp="select expense_id,expense_type_id,employee_id,vendor_id,payment_mode_id,bank_id from expense where added_Date='".$date."' ".$branch_id."";
	
	$select_directory='order by invoice_id asc';   
	$sele_exp="select * from expense_invoice where DATE(`added_date`)='".$date."' and payable_amount>0 ".$branch_id." ".$select_directory."";
	$ptr_exp=mysql_query($sele_exp);
	$i=1;
	if(mysql_num_rows($ptr_exp))
	{
		while($data_expense_inv=mysql_fetch_array($ptr_exp))
		{
			$sele_exps="select expense_id,expense_type_id,employee_id,vendor_id,payment_mode_id,bank_id from expense where expense_id='".$data_expense_inv['expense_id']."'";
			$ptr_exps=mysql_query($sele_exps);
			$data_exp=mysql_fetch_array($ptr_exps);
			
			$exp_name="select expense_type from expense_type where expense_type_id='".$data_exp['expense_type_id']."'";
			$ptr_expense=mysql_query($exp_name);
			$data_expense=mysql_fetch_array($ptr_expense);
			
			/*$sel_inv1="select SUM(amount) as total_amt from expense where expense_type_id='".$data_exp['expense_type_id']."' and added_Date='".$date."' and expense_id= '".$data_exp['expense_id']."'";
			$ptr_amnt1=mysql_query($sel_inv1);
			$data_ptr_sel1=mysql_fetch_array($ptr_amnt1);*/
			
			$sele_pay_name="select payment_mode from payment_mode where payment_mode_id='".$data_expense_inv['paid_type']."'";
			$ptr_pay_name=mysql_query($sele_pay_name);
			$data_pay_name=mysql_fetch_array($ptr_pay_name);
			
			$sel_emp="select name from site_setting where admin_id='".$data_exp['employee_id']."'";
			$ptr_emp=mysql_query($sel_emp);
			$data_emp=mysql_fetch_array($ptr_emp);
			
			$sel_vendor="select name from vendor where vendor_id='".$data_exp['vendor_id']."'";
			$ptr_vendor=mysql_query($sel_vendor);
			$data_vendor=mysql_fetch_array($ptr_vendor);
			
			$sel_bank="select bank_name,account_no from bank where bank_id='".$data_expense_inv['bank_id']."'";
			$ptr_bank=mysql_query($sel_bank);
			$data_bank_name=mysql_fetch_array($ptr_bank);
			
			echo '<tr>';
			echo '<td align="center" style="border:1px solid #CCC">'.$i.'</td>';       
			echo '<td align="center" style="border:1px solid #CCC">'.$data_expense['expense_type'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_emp['name'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_pay_name['payment_mode'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_vendor['name'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_expense_inv['payable_amount'].'</td>';
			echo'</tr>';
			$i++;
		}
	}
	//------------------------------------------ENROLLMENT REFUND----------------------------------------------
	$sele_exp="select * from enrollment_refund where DATE(added_date)='".$date."' ".$branch_id."";
	$ptr_exp=mysql_query($sele_exp);
	$j=$i;
	if(mysql_num_rows($ptr_exp))
	{
		while($data_exp=mysql_fetch_array($ptr_exp))
		{
			$exp_name="select name from enrollment where enroll_id='".$data_exp['enroll_id']."'";
			$ptr_stud=mysql_query($exp_name);
			$data_student=mysql_fetch_array($ptr_stud);
			
			/*$sel_inv1="select SUM(amount) as total_amt from expense where expense_type_id='".$data_exp['expense_type_id']."' and added_Date='".$date."' and expense_id= '".$data_exp['expense_id']."'";
			$ptr_amnt1=mysql_query($sel_inv1);
			$data_ptr_sel1=mysql_fetch_array($ptr_amnt1);*/
			
			$sele_pay_name="select payment_mode from payment_mode where payment_mode_id='".$data_exp['paid_type']."'";
			$ptr_pay_name=mysql_query($sele_pay_name);
			$data_pay_name=mysql_fetch_array($ptr_pay_name);
			
			$sel_emp="select name from site_setting where admin_id='".$data_exp['admin_id']."'";
			$ptr_emp=mysql_query($sel_emp);
			$data_emp=mysql_fetch_array($ptr_emp);
			
						
			$sel_bank="select bank_name,account_no from bank where bank_id='".$data_exp['bank_name']."'";
			$ptr_bank=mysql_query($sel_bank);
			$data_bank_name=mysql_fetch_array($ptr_bank);
			
			echo '<tr>';
			echo '<td align="center" style="border:1px solid #CCC">'.$j.'</td>';       
			echo '<td align="center" style="border:1px solid #CCC">Enroolment Refund</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_student['name'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_pay_name['payment_mode'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">---</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_exp['total_refund'].'</td></tr>';
		$j++;
		}
	}
	//------------------------------------------INVENTORY INVOICE----------------------------------------------
 	$select_directory='order by inventory_id asc';                      
	$sql_query= "SELECT invoice_id,inventory_id,paid_type,bank_id,payable_amount FROM inventory_invoice where DATE(`added_date`)='".$date."' and payable_amount > 0 ".$branch_id." ".$select_directory." "; 
	$ptr_query=mysql_query($sql_query);
	$no_of_records=mysql_num_rows($ptr_query);
	if($no_of_records)
	{
		$bgColorCounter=1;
		$k=$j;
		while($val_query=mysql_fetch_array($ptr_query))
		{
			if($bgColorCounter%2==0)
				$bgcolor='class="grey_td"';
			else
				$bgcolor="";              
			$listed_record_id=$val_query['inventory_id']; 
			//include "include/paging_script.php";
											
			$sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$val_query['paid_type']."' ";
			$ptr_payment_mode=mysql_query($sel_payment_mode);
			$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
				
			$sel_bank="select bank_name,account_no from bank where bank_id='".$val_query['bank_id']."' ";
			$ptr_bank=mysql_query($sel_bank);
			$data_bank_name=mysql_fetch_array($ptr_bank);
			
			$sele_inv="select vendor_id from inventory where inventory_id ='".$val_query['inventory_id']."' order by inventory_id asc limit 0,1";
			$ptr_inv1=mysql_query($sele_inv);
			$data_inv=mysql_fetch_array($ptr_inv1);
			
			$sel_cust_name="select name from vendor where vendor_id='".$data_inv['vendor_id']."' ";
			$ptr_cust_name=mysql_query($sel_cust_name);
			$data_cust_name=mysql_fetch_array($ptr_cust_name);
			
			echo '<tr '.$bgcolor.' >';
			echo '<td align="center" style="border:1px solid #CCC">'.$k.'</td>';   
			
			$sel_prod="select product_id from inventory_product_map where inventory_id = '".$listed_record_id."'";
			$ptr_prod=mysql_query($sel_prod);
			$total_inventory=mysql_num_rows($ptr_prod);
			echo '<td align="center" style="border:1px solid #CCC">Purchase Produc ('.$total_inventory.') - Rec. no-('.$listed_record_id.')- Inv. No('.$val_query['invoice_id'].')</td>';
			echo '<td align="center" style="border:1px solid #CCC">-</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_payment_mode['payment_mode'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_cust_name['name'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td>';
			
			echo '<td align="center" style="border:1px solid #CCC">'.$val_query['payable_amount'].'</td>';
			/*echo '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
				  <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
			echo '</td>';*/
			echo '</tr>';
			$bgColorCounter++;
			$k++;
		}    
	} 
    	
	
	
	?> 
	</table>
	</td>
</tr>
<!--========================================Fund Transfer============================================================-->
<tr bgcolor="#AFD8E0">
	<td align="center" colspan="10"><strong>Fund Transfer</strong></td>
</tr>
<tr>
	<td colspan="10"></td>
</tr>
<tr>
	<td colspan="10" >
    	<table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #999">
			<tr style="background-color:#999">
            	<td width="04%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
    			<td width="10%" align="center" style="border:1px solid #CCC"><strong>Type</strong></td>
    			<td width="10%" align="center" style="border:1px solid #CCC"><strong>Payment Mode</strong></td>
    			<td width="15%" align="center" style="border:1px solid #CCC"><strong>From Bank</strong></td>
                <td width="15%" align="center" style="border:1px solid #CCC"><strong>To Bank</strong></td>
    			<td width="15%" align="center" style="border:1px solid #CCC"><strong>Descrription</strong></td>
    			<td width="15%" align="center" style="border:1px solid #CCC"><strong>Amount</strong></td>
 			</tr>
    		<?php
			$sele_recep="select receipt_id,category,payment_mode_id,bank_id,from_bank_name,amount,added_date,cash_transfer_mode,customer_id,emp_type,description from receipt where 1 and category='cash_transfer' and cash_transfer_mode!='cash_to_cash' and added_date='".$date."' ".$branch_id."";
			$ptr_recep=mysql_query($sele_recep);
			$i=1;
			if(mysql_num_rows($ptr_recep))
			{
				while($data_recep=mysql_fetch_array($ptr_recep))
				{
					$sele_pay_name="select payment_mode from payment_mode where payment_mode_id='".$data_recep['payment_mode_id']."'";
					$ptr_pay_name=mysql_query($sele_pay_name);
					$data_pay_name=mysql_fetch_array($ptr_pay_name);
					
					$sel_from_bank="select bank_name,account_no from bank where bank_id='".$data_recep['from_bank_name']."'";
					$ptr_from_bank=mysql_query($sel_from_bank);
					$data_from_bank_name=mysql_fetch_array($ptr_from_bank);
					
					$sel_bank="select bank_name,account_no from bank where bank_id='".$data_recep['bank_id']."'";
					$ptr_bank=mysql_query($sel_bank);
					$data_bank_name=mysql_fetch_array($ptr_bank);
					$cash_modes='';
					$from_bank_name='-';
					$from_bank_acc_no='';
					if($data_recep['cash_transfer_mode']!='')
					{
						if($data_recep['cash_transfer_mode']=='outword')
						{
							$cash_modes=' Cash Deposited';
						}
						else if($data_recep['cash_transfer_mode']=='inword')
						{
							$cash_modes=' Cash Withdrawl';
						}
						else if($data_recep['cash_transfer_mode']=='bank_to_bank')
						{
							$cash_modes=' Bank to Bank Transfer';
							$from_bank_name=$data_from_bank_name['bank_name'];
							$from_bank_acc_no=$data_from_bank_name['account_no'];
						}
					}
					
					$name='';
					if($data_recep['emp_type']=="Student")
					{
						$sel_student="select name from enrollment where enroll_id='".$data_recep['customer_id']."'";
						$ptr_stud=mysql_query($sel_student);
						$data_stud=mysql_fetch_array($ptr_stud);
						$name=$data_stud['name'];
					}
					else if($data_recep['emp_type']=="Customer")
					{
						$sel_cust="select cust_name from customer where cust_id='".$data_recep['customer_id']."'";
						$ptr_cust=mysql_query($sel_cust);
						$data_cust=mysql_fetch_array($ptr_cust);
						$name=$data_cust['cust_name'];
					}
					else if($data_recep['emp_type']=="Employee")
					{
						$sel_emp="select name from site_setting where admin_id='".$data_recep['customer_id']."'";
						$ptr_emp=mysql_query($sel_emp);
						$data_emp=mysql_fetch_array($ptr_emp);
						$name=$data_emp['name'];
					}
					else if($data_recep['emp_type']=="Vendor")
					{
						$sel_vendor="select name from vendor where vendor_id='".$data_recep['customer_id']."'";
						$ptr_vendor=mysql_query($sel_vendor);
						$data_vendor=mysql_fetch_array($ptr_vendor);
						$name=$data_vendor['name'];
					}
					echo '<tr>';
					echo '<td align="center" style="border:1px solid #CCC">'.$i.'</td>';
					echo '<td align="center" style="border:1px solid #CCC">'.$cash_modes.'</td>';
					echo '<td align="center" style="border:1px solid #CCC">'.$data_pay_name['payment_mode'].'</td>';
					echo '<td align="center" style="border:1px solid #CCC">'.$from_bank_name.' '.$from_bank_acc_no.'</td>';
					echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].' ('.$data_bank_name['account_no'].')</td>';
					echo '<td align="center" style="border:1px solid #CCC">'.$data_recep['description'].'</td>';
					echo '<td align="center" style="border:1px solid #CCC">'.$data_recep['amount'].'</td>';
					$i++;
				}
			}
 			?>
		</table>
	</td>
</tr>
<!--==========================================================================================================================================================================-->
  
  <tr>
  	<td align="center" colspan="10"><strong></strong></td>
  </tr>
  <tr bgcolor="#AFD8E0">
  	<td align="center" colspan="10"><strong>Bank Summary</strong></td>
  </tr>
  <tr>
  	<td align="center" colspan="10"><strong></strong></td>
  </tr>
  <tr class="grey_td" >
 	<td colspan="10" >
 <table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #999">
 <tr style="background-color:#999">
   
   <td width="5%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
    <td width="20%" align="center" style="border:1px solid #CCC"><strong>Bank Name</strong></td>
	<td width="15%" align="center" style="border:1px solid #CCC"><strong>Account No</strong></td>
	<td width="15%" align="center" style="border:1px solid #CCC"><strong>Incoming / Inward</strong></td>
	<td width="15%" align="center" style="border:1px solid #CCC"><strong>Outgoing / Outward</strong></td>
	<td width="15%" align="center" style="border:1px solid #CCC"><strong>Yesterday`s Balance</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Todays`s Balance</strong></td>
   </tr>
    <?php
	$prv_date = trim(date('Y-m-d',strtotime('-1 day')));
	if($_GET['baranch_id']=="")
	{
		
		$cm_idA='';
		$cm_idC='';
		$cm_idE='';
	}
	else
	{
		$cm_idA="and A.cm_id= ".$cm_id1."";
		$cm_idC="and C.cm_id= ".$cm_id1."";
		$cm_idE="and C.cm_id= ".$cm_id1."";
	}
	/*$sel_inv1="Select A.bank_name
From invoice A Left Outer Join
     receipt B on A.bank_name = B.bank_id where  DATE(A.added_date) = '".$date."' and (A.bank_name !='') and (A.bank_name !='select') ".$cm_idA."
Union
Select C.bank_id
From receipt C left join
     invoice D on C.bank_id = D.bank_name where C.added_date = '".$date."' and (C.bank_id !='') and (C.bank_id !='select') ".$cm_idC."";*/
	 
	/*echo $sel_inv1="select DISTINCT(b.bank_id) as bank_name from bank b,invoice i,customer_service_invoice cs,sales_product_invoice sp,sales_package_voucher_memb spvm,receipt r where 1 or (b.bank_id=i.bank_name or b.bank_id=r.bank_id or b.bank_id=cs.bank_id or b.bank_id=sp.bank_id or b.bank_id=spvm.bank_id) or (DATE(i.added_date) = '".$date."' or  DATE(cs.added_date) = '".$date."' or DATE(sp.added_date) = '".$date."' or DATE(spvm.added_date) = '".$date."' or  DATE(r.added_date) = '".$date."')";*/
	 
	/*$sel_inv1="select DISTINCT(b.bank_id) as bank_name from bank b,invoice i,customer_service_invoice cs,sales_product_invoice sp,sales_package_voucher_memb spvm,receipt r where 1 and (b.bank_id=i.bank_name or b.bank_id=r.bank_id or b.bank_id=cs.bank_id or b.bank_id=sp.bank_id or b.bank_id=spvm.bank_id) and (DATE(i.added_date) = '".$date."' and  DATE(cs.added_date) = '".$date."' and DATE(sp.added_date) = '".$date."' and DATE(spvm.added_date) = '".$date."' and  DATE(r.added_date) = '".$date."')";*/
	 
	 	$sel_inv1="select DISTINCT(bank_id) as bank_name from bank where 1 and status='Active' ".$branch_id." and show_in_report !='No'";
		$ptr_amnt1=mysql_query($sel_inv1);
		if($total_bank=mysql_num_rows($ptr_amnt1))
		{
			$k=1;
			while($data_ptr_sel1=mysql_fetch_array($ptr_amnt1))
			{
				$sel_bank="select bank_name,account_no from bank where bank_id='".$data_ptr_sel1['bank_name']."'";
				$ptr_bank=mysql_query($sel_bank);
				$data_bank_name=mysql_fetch_array($ptr_bank);
									
				/*$sel_inv="select SUM(amount) as total_amt,bank_name from invoice where bank_name='".$data_ptr_sel1['bank_name']."' and DATE(`added_date`) = '".$date."' ".$branch_id."";
				$ptr_amnt=mysql_query($sel_inv);
				$total=mysql_num_rows($ptr_amnt);
				$data_ptr_sel=mysql_fetch_array($ptr_amnt);*/
				//===================================================================================================================================
				/*$sel_receipt="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel1['bank_name']."' and cash_transfer_mode !='outword'  and added_date='".$date."' ".$branch_id." ";
				$ptr_bank_id=mysql_query($sel_receipt);
				$data_sel_recipt=mysql_fetch_array($ptr_bank_id);*/
				
				$sel_expense="select SUM(payable_amount) as total_amt from expense_invoice where bank_id='".$data_ptr_sel1['bank_name']."' and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_expense_bank_id=mysql_query($sel_expense);
				$data_sel_expense=mysql_fetch_array($ptr_expense_bank_id);
				
				$sel_refund="select SUM(total_refund) as total_amt from enrollment_refund where bank_name='".$data_ptr_sel1['bank_name']."' and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_refund_bank_id=mysql_query($sel_refund);
				$data_sel_refund=mysql_fetch_array($ptr_refund_bank_id);
				
				$sel_receipt_out="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel1['bank_name']."' and cash_transfer_mode='inword'  and added_date='".$date."' ".$branch_id." ";
				$ptr_bank_id_out=mysql_query($sel_receipt_out);
				$data_sel_recipt_out=mysql_fetch_array($ptr_bank_id_out);
				
				$sel_inv="select SUM(payable_amount) as total_amt from inventory_invoice where bank_id='".$data_ptr_sel1['bank_name']."' and DATE(added_date)='".$date."' ".$branch_id."";
				$ptrinv=mysql_query($sel_inv);
				$data_inv=mysql_fetch_array($ptrinv);
				
				$sel_cc_expense="select SUM(amount) as total_amt from expense where cc_bank_name='".$data_ptr_sel1['bank_name']."' and added_date='".$date."' ".$branch_id."";
				$ptr_cc_expense=mysql_query($sel_cc_expense);
				$data_cc_expense=mysql_fetch_array($ptr_cc_expense);
				
				$sel_bank_out="select SUM(amount) as total_amt from receipt where from_bank_name='".$data_ptr_sel1['bank_name']."' and category='cash_transfer' and cash_transfer_mode='bank_to_bank' and added_date='".$date."' ".$branch_id." ";
				$ptr_bank_out=mysql_query($sel_bank_out);
				$data_bank_out=mysql_fetch_array($ptr_bank_out);
				
				$outgoing=$data_sel_expense['total_amt'] + $data_sel_recipt_out['total_amt'] +$data_inv['total_amt']+$data_cc_expense['total_amt']+$data_bank_out['total_amt']+$data_sel_refund['total_amt'];
				//========================================================================================================================
				"<br/>".$sel_total_inc="select SUM(amount) as total_amt from invoice where bank_name='".$data_ptr_sel1['bank_name']."' and DATE(`added_date`) = '".$date."' ".$branch_id."";
				$ptr_total_inc=mysql_query($sel_total_inc);
				$data_total_inc=mysql_fetch_array($ptr_total_inc);
				
				$sel_total_inc2="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel1['bank_name']."' and (cash_transfer_mode = 'outword' OR cash_transfer_mode IS NULL ) and added_date='".$date."' ".$branch_id."";
				$ptr_total_inc2=mysql_query($sel_total_inc2);
				$data_total_inc2=mysql_fetch_array($ptr_total_inc2);
				
				$sel_total_inc3="select SUM(payable_amount) as total_amt from customer_service_invoice where bank_id='".$data_ptr_sel1['bank_name']."'  and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_total_inc3=mysql_query($sel_total_inc3);
				$data_total_inc3=mysql_fetch_array($ptr_total_inc3);
				
				$sel_total_inc4="select SUM(payable_amount) as total_amt from sales_product_invoice where bank_id='".$data_ptr_sel1['bank_name']."'  and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_total_inc4=mysql_query($sel_total_inc4);
				$data_total_inc4=mysql_fetch_array($ptr_total_inc4);
				
				$sel_total_inc5="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where bank_id='".$data_ptr_sel1['bank_name']."'  and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_total_inc5=mysql_query($sel_total_inc5);
				$data_total_inc5=mysql_fetch_array($ptr_total_inc5);
				
				$sel_total_inc6="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel1['bank_name']."' and category='cash_transfer' and cash_transfer_mode='bank_to_bank' and added_date='".$date."' ".$branch_id." ";
				$ptr_total_inc6=mysql_query($sel_total_inc6);
				$data_total_inc6=mysql_fetch_array($ptr_total_inc6);
				//========================================================================================================================
				/*$sel_total_inc="select SUM(amount) as total_amt from invoice where bank_name='".$data_ptr_sel1['bank_name']."' and added_date = '".$prv_date."'  ".$branch_id."" ;
				$ptr_total_inc=mysql_query($sel_total_inc);
				$data_total_yesterday=mysql_fetch_array($ptr_total_inc);
				$data_total_yest = $data_total_yesterday['total_amt'];
				
				$sel_total_inc2="select SUM(amount) as total_amt from receipt where category='incoming' and bank_id='".$data_ptr_sel1['bank_name']."' and added_date = '".$prv_date."' ".$branch_id."";
				$ptr_total_inc2=mysql_query($sel_total_inc2);
				$data_total_yesterday2=mysql_fetch_array($ptr_total_inc2);
				$data_total_yest2 = $data_total_yesterday2['total_amt'];*/
				
				"<br/>".$total_todays_bal=$data_total_inc['total_amt']+$data_total_inc2['total_amt']+$data_total_inc3['total_amt']+$data_total_inc4['total_amt']+$data_total_inc5['total_amt']+$data_total_inc6['total_amt']; //DATE(added) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
				
				//$incomming=$data_sel_recipt['total_amt']+$data_ptr_sel['total_amt'];
				//$yesterday_bal=$data_total_yest+$data_total_yest2;
				
				$sele_yesterday_bal="select todays_balance from dsr_bank_summery where bank_id='".$data_ptr_sel1['bank_name']."' ".$branch_id." and added_date=DATE_SUB('".$date."', INTERVAL 1 DAY) order by added_date desc limit 0,1 "; //and added_date = '".$prv_date."'
				$ptr_yest=mysql_query($sele_yesterday_bal);
				$data_yesterday=mysql_fetch_array($ptr_yest);
				
				$total_todays_bank= floatval($total_todays_bal + $data_yesterday['todays_balance']) - $outgoing;
				$tot=$total_todays_bank;
				//if($total_todays_bank < 0)
				//{
					//$total_todays_bank= 0;
					
				//}
				//if($tot !=0)
				//{
					echo '<tr>';
					echo '<td align="center" style="border:1px solid #CCC">'.$k.'</td> <input type="hidden" name="total_banks" value="'.$total_bank.'"  />';       
					echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td> <input type="hidden" name="bank_id_'.$k.'" value="'.$data_bank_name['bank_name'].'" />';
					echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td> <input type="hidden" name="account_no_'.$k.'" value="'.$data_bank_name['account_no'].'"/>';
					echo '<td align="center" style="border:1px solid #CCC">'.$total_todays_bal.'</td> <input type="hidden" name="incoming_'.$k.'" value="'.$total_todays_bal.'"  />';
					echo '<td align="center" style="border:1px solid #CCC">'.$outgoing.'</td> <input type="hidden" name="outgoing_'.$k.'" value="'.$outgoing.'"  />';
					echo '<td align="center" style="border:1px solid #CCC">'.$data_yesterday['todays_balance'].'</td><input type="hidden" name="yesterday_bal_'.$k.'"value="'.$data_yesterday['todays_balance'].'"/>';
					echo '<td align="center" style="border:1px solid #CCC">'.$total_todays_bank.'</td> <input type="hidden" name="todays_bal_'.$k.'" value="'.$total_todays_bank.'"  />';
					echo '</tr>';
					$k++;
				//}
			}
		}
		else
		{
			echo '<tr><td class="text" align="center" colspan="7"><br><div class="msgbox" style="width:50%;">No Bank Amount added on today</div><br></td></tr>';
		}
 ?> 
   </table>
   </td>
  </tr>
 

<tr>
  	<td align="center" colspan="10"><strong></strong></td>
  </tr>
   <tr bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Cash Summary</strong></td>
  </tr>
  <tr >
  <td align="center" colspan="10"><strong></strong></td>
  </tr>
  <tr class="grey_td" >
 <td colspan="10" >
 <table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #999">
 	<tr style="background-color:#999">
        <td width="8%" align="center" style="border:1px solid #CCC"><strong>Opening Business Cash <br/>(A)</strong></td>
        <td width="8%" align="center" style="border:1px solid #CCC"><strong>Opening Petty Cash<br/>(B)</strong></td>
        <td width="10%" align="center" style="border:1px solid #CCC"><strong>Total Cash Revenue<br/>(C)</strong></td>
        <!--<td width="10%" align="center" style="border:1px solid #CCC"><strong>Total Cash Taken from Bank</strong></td>-->
        <td width="10%" align="center" style="border:1px solid #CCC"><strong>Cash Received from Sir in Business cash<br/>(D)</strong></td>
        <td width="10%" align="center" style="border:1px solid #CCC"><strong>Total Cash Expenses From Petty<br/>(G)</strong></td>
        <td width="8%" align="center" style="border:1px solid #CCC"><strong>Cash Given to Director From Business Cash<br/>(H)</strong></td>
        <td width="12%" align="center" style="border:1px solid #CCC"><strong>Cash Deposited in Bank From Business cash<br/>(J)</strong></td>
        <td width="15%" align="center" style="border:1px solid #CCC"><strong>Cash Withdrawl in Petty Cash from bank<br/>(K)</strong></td>
        <td width="8%" align="center" style="border:1px solid #CCC"><strong>Business Cash In Hand<br/>(M= A+C+D-H-J-L-P)</strong></td>
        <td width="8%" align="center" style="border:1px solid #CCC"><strong>Petty Cash In Hand<br/> (N= B+E+F+K+L-G-I)</strong></td>
	</tr>
    
    <?php
				//$sel_inv1="select DISTINCT(bank_name) from invoice where DATE(`added_date`) = '".$date."' and bank_name !='' and bank_name !='select' ".$branch_id."";
				//$ptr_amnt1=mysql_query($sel_inv1);
				//$data_ptr_sel1=mysql_fetch_array($ptr_amnt1);
				//===================Todays Total receive balance===============================
				$sel_inv="select SUM(amount) as total_amt from invoice where paid_type='1' and DATE(`added_date`) = '".$date."' ".$branch_id."";
				$ptr_amnt=mysql_query($sel_inv);
				$total=mysql_num_rows($ptr_amnt);
				$data_ptr_sel=mysql_fetch_array($ptr_amnt);
				
				$sel_receipt="select SUM(amount) as total_amt from receipt where payment_mode_id='1' and category !='cash_transfer' and category !='innocent' and category !='santosh' and category !='voucher' and cash_type='business_cash' and added_date='".$date."' ".$branch_id."";
				$ptr_bank_id=mysql_query($sel_receipt);
				$data_sel_recipt=mysql_fetch_array($ptr_bank_id);
				
				$sel_receipt_petty="select SUM(amount) as total_amt from receipt where payment_mode_id='1' and category !='cash_transfer' and category !='innocent' and category !='santosh' and category !='voucher' and cash_type='petty_cash' and added_date='".$date."' ".$branch_id."";
				$ptr_petty_cash=mysql_query($sel_receipt_petty);
				$data_sel_recipt_petty_cash=mysql_fetch_array($ptr_petty_cash);
				
				$sel_voucher="select SUM(amount) as total_amt from receipt where payment_mode_id='1' and category ='voucher' and added_date='".$date."' ".$branch_id."";
				$ptr_voucher=mysql_query($sel_voucher);
				$data_sel_voucher=mysql_fetch_array($ptr_voucher);
						
				//===================Cash received from sir===============================
				$sel_cash_received_sir="select SUM(amount) as total_amt from receipt where category ='santosh' and cash_type='business_cash' and payment_mode_id='1' and added_date='".$date."' ".$branch_id."";
				$ptr_cash_received_sir=mysql_query($sel_cash_received_sir);
				$data_cash_received_sir=mysql_fetch_array($ptr_cash_received_sir);
				
				$sel_cash_received_sir_in_petty="select SUM(amount) as total_amt from receipt where category ='santosh' and cash_type='petty_cash' and payment_mode_id='1' and added_date='".$date."' ".$branch_id."";
				$ptr_cash_received_sir_in_petty=mysql_query($sel_cash_received_sir_in_petty);
				$data_cash_received_sir_in_petty=mysql_fetch_array($ptr_cash_received_sir_in_petty);
				//============================================================================
				//===================Total Cash Expenses===============================
				/*$sel_total_expense="select SUM(amount) as total_amt from expense where payment_mode_id ='1' and expense_type_id !='1' and expense_type_id !='119'  and expense_type_id !='120' and cash_type='petty_cash' and added_date='".$date."' ".$branch_id."";
				$ptr_total_expense=mysql_query($sel_total_expense);
				$data_total_expense=mysql_fetch_array($ptr_total_expense);*/
				
				$sel_total_expense="select SUM(i.payable_amount) as total_amt from expense e,expense_invoice i where i.expense_id=e.expense_id and i.paid_type ='1' and e.expense_type_id !='1' and e.expense_type_id !='119'  and e.expense_type_id !='120' and e.cash_type='petty_cash' and i.added_date='".$date."' ".$exp_branch_id."";
				$ptr_total_expense=mysql_query($sel_total_expense);
				$data_total_expense=mysql_fetch_array($ptr_total_expense);
				
				//$sel_total_expense_business="select SUM(amount) as total_amt from expense where payment_mode_id ='1' and expense_type_id !='1' and expense_type_id !='119'  and expense_type_id !='120' and cash_type='business_cash' and added_date='".$date."' ".$branch_id."";
				$sel_total_expense_business="select SUM(i.payable_amount) as total_amt from expense e,expense_invoice i where i.expense_id=e.expense_id and i.paid_type ='1' and e.expense_type_id !='1' and e.expense_type_id !='119'  and e.expense_type_id !='120' and e.cash_type='business_cash' and i.added_date='".$date."' ".$exp_branch_id."";
				$ptr_total_expense_business=mysql_query($sel_total_expense_business);
				$data_total_expense_business=mysql_fetch_array($ptr_total_expense_business);				
				//===================Total Cash Refund===============================
				$sel_total_refund="select SUM(total_refund) as total_amt from enrollment_refund where paid_type ='1' and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_total_refund=mysql_query($sel_total_refund);
				$data_total_refund=mysql_fetch_array($ptr_total_refund);
				//===================Cash Given to sir===============================
				//$sel_cash_from_sir_petty="select SUM(amount) as total_amt from expense where payment_mode_id='1' and (expense_type_id='1' or expense_type_id='119' or expense_type_id='120') and cash_type='petty_cash' and added_date='".$date."' ".$branch_id."";
				$sel_cash_from_sir_petty="select SUM(i.payable_amount) as total_amt from expense e,expense_invoice i where i.expense_id=e.expense_id and i.paid_type ='1' and (expense_type_id='1' or expense_type_id='119' or expense_type_id='120') and cash_type='petty_cash' and i.added_date='".$date."' ".$exp_branch_id."";
				$ptr_cash_from_sir_petty=mysql_query($sel_cash_from_sir_petty);
				$data_cash_from_sir_petty=mysql_fetch_array($ptr_cash_from_sir_petty);
				
				//$sel_cash_from_sir_business="select SUM(amount) as total_amt from expense where payment_mode_id='1' and (expense_type_id='1' or expense_type_id='119' or expense_type_id='120') and cash_type='business_cash' and added_date='".$date."' ".$branch_id."";
				$sel_cash_from_sir_business="select SUM(i.payable_amount) as total_amt from expense e,expense_invoice i where i.expense_id=e.expense_id and i.paid_type ='1' and (expense_type_id='1' or expense_type_id='119' or expense_type_id='120') and cash_type='business_cash' and i.added_date='".$date."' ".$exp_branch_id."";
				$ptr_cash_from_sir_business=mysql_query($sel_cash_from_sir_business);
				$data_cash_from_sir_business=mysql_fetch_array($ptr_cash_from_sir_business);
				//===================Cash in Hand=====================================
				
				/*$sel_cash_from_cash="select SUM(amount) as total_amt from receipt where category !='cash_transfer' and category !='santosh' and category !='voucher' and payment_mode_id='1' and added_date='".$date."' ".$branch_id."";
				$ptr_cash_from_cash=mysql_query($sel_cash_from_cash);
				$data_cash_from_cash=mysql_fetch_array($ptr_cash_from_cash);*/
				
				/*$sel_cash_rec="select SUM(amount) as total_amt from receipt where 1 and category='cash_transfer' and (cash_transfer_mode is NULL or cash_transfer_mode !='outword' ) and cash_transfer_mode!= 'bank_to_bank' and category !='santosh' and category !='voucher' and added_date='".$date."' ".$branch_id."";
				$ptr_cash_rec=mysql_query($sel_cash_rec);
				$data_cash_rec=mysql_fetch_array($ptr_cash_rec);*/
				//====================CASH TRANSFER - INWORD =======================================
				$sel_cash_rec="select SUM(amount) as total_amt from receipt where 1 and category='cash_transfer' and (cash_transfer_mode is NULL or cash_transfer_mode !='outword' ) and cash_transfer_mode!= 'bank_to_bank' and category !='santosh' and category !='voucher' and cash_transfer_mode!='cash_to_cash' and cash_type='business_cash' and added_date='".$date."' ".$branch_id."";
				$ptr_cash_rec=mysql_query($sel_cash_rec);
				$data_cash_rec=mysql_fetch_array($ptr_cash_rec); //cash_type='business_cash' (3/6/19)
			
				//=============================SERVICE===============================================
			 	$sel_service="select SUM(payable_amount) as total_amt from customer_service_invoice where paid_type='1' and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_service=mysql_query($sel_service);
				$data_service=mysql_fetch_array($ptr_service);
				
				$sel_memb="select SUM(price) as total_amt from customer where payment_mode_id='1' and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_memb=mysql_query($sel_memb);
				$data_membership=mysql_fetch_array($ptr_memb);
				
				$total_service=$data_service['total_amt'];
				//============================================================================
				//=============================PRODUCT===============================================
				$sel_product="select SUM(payable_amount) as total_amt from inventory_invoice where paid_type='1' and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_product=mysql_query($sel_product);
				$data_product=mysql_fetch_array($ptr_product);
				
				$sel_sales_product="select SUM(payable_amount) as total_amt from sales_product_invoice where paid_type='1' and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_sales_product=mysql_query($sel_sales_product);
				$data_sales_product=mysql_fetch_array($ptr_sales_product);
				
				$total_produts=$data_product['total_amt']-$data_sales_product['total_amt'];
				
				$sel_sales_membership="select SUM(price) as total_amt from customer where payment_mode_id='1' and membership='yes' and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_sales_membership=mysql_query($sel_sales_membership);
				$data_sales_membership=mysql_fetch_array($ptr_sales_membership);
				
				$sel_sales_package="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where payment_mode_id='1' and category='Package' and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_sales_package=mysql_query($sel_sales_package);
				$data_sales_package=mysql_fetch_array($ptr_sales_package);
				
				$sel_sales_voucher="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where payment_mode_id='1' and category='Voucher' and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_sales_voucher=mysql_query($sel_sales_voucher);
				$data_sales_voucher=mysql_fetch_array($ptr_sales_voucher);
				//===================================================================================
				//=================================Cash Withdrawl in petty cash====================== (3/6/19)
				$cash_withdrawl_in_petty_cash=0;
				$sel_withd="select SUM(amount) as total_amt from receipt where cash_transfer_mode='inword' and cash_type='petty_cash' and added_date='".$date."' ".$branch_id." ";
				$ptr_cash_withd=mysql_query($sel_withd);
				if(mysql_num_rows($ptr_cash_withd))
				{
					$data_cash_withdrawl=mysql_fetch_array($ptr_cash_withd);
					$cash_withdrawl_in_petty_cash=$data_cash_withdrawl['total_amt'];
				}
				//===================================================================================
				//=================================Cash Transfer in petty cash====================== (27/6/19)
				$cash_transfer_in_petty_cash=0;
				$sel_transf="select SUM(amount) as total_amt from receipt where cash_transfer_mode='cash_to_cash' and added_date='".$date."' ".$branch_id." ";
				$ptr_cash_transf=mysql_query($sel_transf);
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
				"<br/>".$sele_yest_bal="select cash_in_hand,petty_cash_in_hand from dsr where 1 ".$branch_id." and added_date = '".$prv_date."'  order by dsr_id desc limit 0,1"; //where added_date = '".$prv_date."'
				$ptr_yest1=mysql_query($sele_yest_bal);
				if(mysql_num_rows($ptr_yest1))
				{
					$data_yest_bal=mysql_fetch_array($ptr_yest1);
					$opening_cash1=$data_yest_bal['cash_in_hand'];
					$opening_petty_cash=$data_yest_bal['petty_cash_in_hand']; //(3/6/19)
				}
				$tota_exp=$data_product['total_amt']+$data_total_expense['total_amt']+$data_total_refund['total_amt'];
				
				$tota_exp_business=$data_total_expense_business['total_amt'];
				
				echo '<tr>';
				
				echo '<td align="center" style="border:1px solid #CCC">'.$opening_cash1.'</td> <input type="hidden" name="opening_cash" value="'.$opening_cash1.'"  />';
				
				echo '<td align="center" style="border:1px solid #CCC">'.$opening_petty_cash.'</td><input type="hidden" name="opening_petty_cash" value="'.$opening_petty_cash.'"  />';//(3/6/19)
				echo '<td align="center" style="border:1px solid #CCC">Fees- '.$data_ptr_sel['total_amt'].'<br /><hr >Product- '.$data_sales_product['total_amt'].'<br /><hr >Service - '.$total_service.'<br /><hr >Membership - '.$data_sales_membership['total_amt'].'<br /><hr >Package - '.$data_sales_package['total_amt'].'<br /><hr >Voucher - '.$data_sales_voucher['total_amt'].'<br /><hr >Receipt - '.$data_sel_recipt['total_amt'].'<br/><hr>Cash Transfer - '.$data_cash_rec['total_amt'].'</td> ';
				
				echo '<input type="hidden" name="total_cash_fees" value="'.$data_ptr_sel['total_amt'].'"  />
				<input type="hidden" name="total_cash_product" value="'.$data_sales_product['total_amt'].'"  />';
				/*echo '<td align="center" style="border:1px solid #CCC">'.$data_expense_taken['total_amt'].'</td> <input type="hidden" name="total_cash_taken_from_bank" value="'.$data_expense_taken['total_amt'].'"  />';*/
				echo '<td align="center" style="border:1px solid #CCC"><strong>'.$data_cash_received_sir['total_amt'].'</strong> <br /><hr style="color: #1395D2">Cash Received From Sir in Petty Cash (E)<br/><br/><strong>'.$data_cash_received_sir_in_petty['total_amt'].'</strong><br /><hr style="color: #1395D2">Cash Received in Petty Cash (F)<br/><br/><strong>'.$data_sel_recipt_petty_cash['total_amt'].'</strong></td> <input type="hidden" name="cash_received_from_director" value="'.intval($data_cash_received_sir['total_amt']+$data_cash_received_sir_in_petty['total_amt']).'"  />';
				//======================Total Expense==============================
				echo '<td align="center" style="border:1px solid #CCC;" valign="middle">'.$tota_exp.'<br /><hr style="color: #1395D2">Total Cash Expense From Business (P)<br/><br/>'.$tota_exp_business.'</td><input type="hidden" name="total_cash_expense" value="'.$tota_exp.'" /><input type="hidden" name="total_cash_expense_business" value="'.$tota_exp_business.'" />';
				//===============================================================
				echo '<td align="center" style="border:1px solid #CCC" valign="middle">'.intval($data_cash_from_sir_business['total_amt']).'<br /><hr style="color: #1395D2">Cash Given to Director From Petty Cash (I)<br/>'.$data_cash_from_sir_petty['total_amt'].'</td> <input type="hidden" name="cash_given_to_director" value="'.intval($data_cash_from_sir_petty['total_amt']+$data_cash_from_sir_business['total_amt']).'"  />';
				//===================Cash Deposited in Bank===============================
				echo '<td align="center" style="border:1px solid #CCC">';
				$sel_dist_bank_id="Select DISTINCT(bank_id) from receipt where added_date='".$date."' and bank_id !='' and (category ='cash_transfer' and category !='voucher' and cash_transfer_mode !='inword' and cash_transfer_mode !='cash_to_cash') and cash_type='business_cash' and payment_mode_id='1' ".$branch_id."";// 29-12-17 category !='cash_transfer'
				$ptr_dist_bank_id=mysql_query($sel_dist_bank_id);
				$total=mysql_num_rows($ptr_dist_bank_id);
				$i=1;
				$tt='';
				while($data_dist_bank_id=mysql_fetch_array($ptr_dist_bank_id))
				{
					$sel_cash_from_bank="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and category ='cash_transfer' and cash_transfer_mode ='outword' and cash_type='business_cash' and payment_mode_id='1' and added_date='".$date."' ".$branch_id." ";// 29-12-17 category !='cash_transfer'
					$ptr_cash_from_bank=mysql_query($sel_cash_from_bank);
					$data_cash_from_bank=mysql_fetch_array($ptr_cash_from_bank);
					
					$sel_bank_amnt="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and category ='cash_transfer' and cash_transfer_mode ='bank_to_bank' and cash_type='business_cash' and payment_mode_id='1' and added_date='".$date."' ".$branch_id." ";// 29-12-17 category !='cash_transfer'
					$ptr_bank_amnt=mysql_query($sel_bank_amnt);
					$data_bank_amnt=mysql_fetch_array($ptr_bank_amnt);
					
					$total_bank_bal=$data_cash_from_bank['total_amt']+$data_bank_amnt['total_amt'];
					
					$sel_bank="select bank_name from bank where bank_id='".$data_dist_bank_id['bank_id']."'";
					$ptr_bank=mysql_query($sel_bank);
					$data_bank_name=mysql_fetch_array($ptr_bank);
					
					echo $data_bank_name['bank_name']." : ".$total_bank_bal;
					$tots +=$total_bank_bal;
					$tt +=$data_cash_from_bank['total_amt'];
					
					if($i !=$total)
					{
						echo '<br /><hr >';
					}
					$i++;
				}
				echo "<strong>Total : ".round($tots,2).'</strong>';
				echo'<br /><hr style="color: #1395D2">';
				echo '<br/><strong>Cash Deposited in Bank From Petty Cash (Q)</strong><br/><br/>';
				//-----------------------------------------------CASH DEPSOIT IN BANK from PETYY CASH---------------------------------
				$sel_dist_bank_id1="Select DISTINCT(bank_id) from receipt where added_date='".$date."' and bank_id !='' and (category ='cash_transfer' and category !='voucher' and cash_transfer_mode !='inword' and cash_transfer_mode !='cash_to_cash') and cash_type='petty_cash' and payment_mode_id='1' ".$branch_id."";// 29-12-17 category !='cash_transfer'
				$ptr_dist_bank_id=mysql_query($sel_dist_bank_id1);
				$total1=mysql_num_rows($ptr_dist_bank_id);
				$i1=1;
				$tt1='';
				while($data_dist_bank_id=mysql_fetch_array($ptr_dist_bank_id))
				{
					$sel_cash_from_bank="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and category ='cash_transfer' and cash_transfer_mode ='outword' and cash_type='petty_cash' and payment_mode_id='1' and added_date='".$date."' ".$branch_id." ";// 29-12-17 category !='cash_transfer'
					$ptr_cash_from_bank=mysql_query($sel_cash_from_bank);
					$data_cash_from_bank=mysql_fetch_array($ptr_cash_from_bank);
					
					$sel_bank_amnt="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and category ='cash_transfer' and cash_transfer_mode ='bank_to_bank' and cash_type='petty_cash' and payment_mode_id='1' and added_date='".$date."' ".$branch_id." "; // 29-12-17 category !='cash_transfer'
					$ptr_bank_amnt=mysql_query($sel_bank_amnt);
					$data_bank_amnt=mysql_fetch_array($ptr_bank_amnt);
					
					$total_bank_bal=$data_cash_from_bank['total_amt']+$data_bank_amnt['total_amt'];
					
					$sel_bank="select bank_name from bank where bank_id='".$data_dist_bank_id['bank_id']."'";
					$ptr_bank=mysql_query($sel_bank);
					$data_bank_name=mysql_fetch_array($ptr_bank);
					
					echo $data_bank_name['bank_name']." : ".$total_bank_bal;
					$tots1 +=$total_bank_bal;
					$tt1 +=$data_cash_from_bank['total_amt'];
					
					if($i1 !=$total1)
					{
						echo '<br /><hr >';
					}
					$i1++;
				}
				echo "<br/><br/><strong>Total : ".round($tots1,2).'</strong>';
				//--------------------------------------------------------------------------------------------------------------
				//----------------------------------------------------CASH DEPSOIT IN BANK from PETYY CASH---------------------------------
				/*"<br/>".$sel_dist_bank_id1="Select DISTINCT(bank_id) from receipt where added_date='".$date."' and bank_id !='' and category ='cash_transfer' and category !='voucher' and category !='cash_to_cash' and payment_mode_id='1' ".$branch_id."";// 29-12-17 category !='cash_transfer'
				$ptr_dist_bank_id1=mysql_query($sel_dist_bank_id1);
				$total=mysql_num_rows($ptr_dist_bank_id1);
				$it=1;
				$tam='';
				while($data_dist_bank_id1=mysql_fetch_array($ptr_dist_bank_id1))
				{
					"<br/>->".$sel_cash_from_bank1="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id1['bank_id']."' and category ='cash_transfer' and category !='voucher' and category !='cash_to_cash' and payment_mode_id='1' and added_date='".$date."' ".$branch_id." ";// 29-12-17 category !='cash_transfer'
					$ptr_cash_from_bank1=mysql_query($sel_cash_from_bank1);
					$data_cash_from_bank1=mysql_fetch_array($ptr_cash_from_bank1);
					
					$sel_bank1="select bank_name from bank where bank_id='".$data_cash_from_bank1['bank_id']."'";
					$ptr_bank1=mysql_query($sel_bank1);
					$data_bank_name1=mysql_fetch_array($ptr_bank1);
					
					//echo $data_bank_name['bank_name']." : ".$data_cash_from_bank1['total_amt'] ;
					$tam +=$data_cash_from_bank1['total_amt'];
					
					//if($i !=$total)
					//{
					//	echo '<br /><hr >';
					//}
					//$it++;
				}*/
					//echo"<br/>tam-".$tam;
				//====================================CASH IN HAND===================================================================
				$sel_total_inc1="select SUM(amount) as total_amt from invoice where DATE(`added_date`) = '".$date."' and (bank_name='' or bank_name= 'select') ".$branch_id."";
				$ptr_total_inc1=mysql_query($sel_total_inc1);
				$data_total_inc1=mysql_fetch_array($ptr_total_inc1);
				
				$sel_total_inc21="select SUM(amount) as total_amt from receipt where category !='cash_transfer' and category !='voucher'  and added_date='".$date."' and bank_id='' ".$branch_id."";
				$ptr_total_inc21=mysql_query($sel_total_inc21);
				$data_total_inc21=mysql_fetch_array($ptr_total_inc21);
				
				 $cash_in_hand=$data_total_inc1['total_amt']+$data_total_inc21['total_amt']; //DATE(added) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
				 
				 $total_cash_fees=$data_ptr_sel['total_amt'] ;
				 $total_cash_product= $data_sel_recipt['total_amt'];

				$cash_in_hands=$opening_cash1 + $data_ptr_sel['total_amt'] +$data_sel_recipt['total_amt'] +$total_service + $data_sales_product['total_amt']+$data_cash_received_sir['total_amt'] +$data_sel_voucher['total_amt']+$data_sales_membership['total_amt']+$data_sales_package['total_amt']+$data_sales_voucher['total_amt']+$data_cash_rec['total_amt']-$cash_transfer_in_petty_cash- $data_cash_from_sir_business['total_amt']- $tota_exp_business - $tots ;//+ $data_cash_from_innocent['total_amt'] - $tt  - $data_total_expense['total_amt'] (3/6/19)/* $data_expense_taken['total_amt'] + */ //- $data_product['total_amt'](27-6-19)
				//---------------------------------------------------------------------------------------------------------------------
				//==========================================PETTY CASH IN HAND====================================================
				$petty_cash_in_hands=intval($data_sel_recipt_petty_cash['total_amt'] + $opening_petty_cash + $cash_withdrawl_in_petty_cash + $cash_transfer_in_petty_cash - $tota_exp - $data_cash_from_sir_petty['total_amt']+$data_cash_received_sir_in_petty['total_amt'] - $tots1) ; //(3/6/19)
				//==========================================================================================================================
				echo '</td>';
				//echo '<td align="center" style="border:1px solid #CCC">'.$data_cash_from_innocent['total_amt'].'</td> <input type="hidden" name="cash_received_from_innocent" value="'.$data_cash_from_innocent['total_amt'].'"  />';
				echo '<td align="center" style="border:1px solid #CCC">'.round($cash_withdrawl_in_petty_cash,2).' <hr style="color: #1395D2"><strong>Cash Transfer from business cash to petty cash (L)</strong><br/><br/>'.round($cash_transfer_in_petty_cash,2).'</td><input type="hidden" name="cash_withdralw_in_petty_ccash" value="'.round($cash_withdrawl_in_petty_cash,2).'" />'; //(3/6/19)
				echo '<td align="center" style="border:1px solid #CCC">'.round($cash_in_hands,2).'</td> <input type="hidden" name="cash_in_hand" value="'.round($cash_in_hands,2).'"  />';
				echo '<td align="center" style="border:1px solid #CCC">'.round($petty_cash_in_hands,2).'</td> <input type="hidden" name="petty_cash_in_hand" value="'.round($petty_cash_in_hands,2).'"  />';	//(3/6/19)
 				?> 
		</table>
	</td>
</tr>  
  <!--=========================================================================MONTHLY SALE=============================================================================-->
	<tr>
        <td align="center" colspan="10"><strong></strong></td>
    </tr>
    <tr bgcolor="#AFD8E0">
  		<td align="center" colspan="10"><strong>Monthly DSR From <?php echo $date_for_month.'-01';?> To <?php echo $date;?></strong></td>
  	</tr>
	<tr>
		<td colspan="11" >
		<table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #999">
        <tr style="background-color:#999">
        <td width="12%" align="center" style="border:1px solid #CCC"><strong>Enrollment</strong></td>
        <td width="12%" align="center" style="border:1px solid #CCC"><strong>Receipt</strong></td>
        <td width="12%" align="center" style="border:1px solid #CCC"><strong>Product</strong></td>
        <td width="8%" align="center" style="border:1px solid #CCC"><strong>Service</strong></td>
        <td width="12%" align="center" style="border:1px solid #CCC"><strong>Sale Vouchre/Package</strong></td>
        <td width="12%" align="center" style="border:1px solid #CCC"><strong>Expense</strong></td>
        <td width="12%" align="center" style="border:1px solid #CCC"><strong>Purchase</strong></td>
       	<td width="12%" align="center" style="border:1px solid #CCC"><strong>Businees Booked</strong></td>
    </tr>
    <?php
		$sel_total_inc="select SUM(amount) as total_amt from invoice where DATE(`added_date`) >= '".$date_for_month."-01' and DATE(`added_date`) <= '".$date."' ".$branch_id."";
		$ptr_total_inc=mysql_query($sel_total_inc);
		$data_total_inc=mysql_fetch_array($ptr_total_inc);
		//============================================
		$sel_total_servicec="select SUM(payable_amount) as total_amt from customer_service where payable_amount>'0' and DATE(`added_date`) >= '".$date_for_month."-01' and DATE(`added_date`) <= '".$date."' ".$branch_id."";
		$ptr_total_service=mysql_query($sel_total_servicec);
		$data_total_service=mysql_fetch_array($ptr_total_service);
		$sql_customer="SELECT price FROM customer where DATE(`added_date`) >= '".$date_for_month."-01' and DATE(`added_date`) <= '".$date."' and membership ='yes' ".$branch_id." ";
		$ptr_customer=mysql_query($sql_customer);
		while($data_customer=mysql_fetch_array($ptr_customer))
		{
			$price +=$data_customer['price'];
		}
		$total_service_amount=$data_total_service['total_amt']+$price;
		//=================================================
		$sel_total_prod="SELECT SUM(payable_amount) as total_amt FROM sales_product_invoice where DATE(`added_date`) >= '".$date_for_month."-01' and DATE(`added_date`) <= '".$date."' and payable_amount>0 ".$branch_id."";
		$ptr_total_prod=mysql_query($sel_total_prod);
		$data_total_prod=mysql_fetch_array($ptr_total_prod);
		$total_product_amount=$data_total_prod['total_amt'];
		//==================================================
		$sel_sales_pack="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where membership_id='0' and DATE(`added_date`) >= '".$date_for_month."-01' and DATE(`added_date`) <= '".$date."' ".$branch_id."";
		$ptr_sales_pack=mysql_query($sel_sales_pack);
		$data_sales_pack=mysql_fetch_array($ptr_sales_pack);
		$total_sales_pack=intval($data_sales_pack['total_amt']);
		//==================================================
		$sel_total_recp="select SUM(amount) as total_amt from receipt where DATE(`added_date`) >='".$date_for_month."-01' and DATE(`added_date`) <= '".$date."' ".$branch_id.""; //category='incoming' and cash_type='business_cash'
		$ptr_total_recp=mysql_query($sel_total_recp);
		$data_total_recp=mysql_fetch_array($ptr_total_recp);
		$total_receipt=intval($data_total_recp['total_amt']);
		//==================================================
		$select_inv="select SUM(payable_amount) as total from inventory_invoice where DATE(`added_date`) >= '".$date_for_month."-01' and DATE(`added_date`) <= '".$date."' ".$branch_id." ";
		$ptr_inv=mysql_query($select_inv);
		$total_inv=0;
		if(mysql_num_rows($ptr_inv))
		{
			$data_inv=mysql_fetch_array($ptr_inv);
			$total_inv=$data_inv['total'];
		}
		//===================================================
		$select_amnt1="select SUM(payable_amount) as total from expense_invoice where DATE(`added_date`) >= '".$date_for_month."-01' and DATE(`added_date`) <= '".$date."' ".$branch_id." ";
		$ptr_amt1=mysql_query($select_amnt1);
		$total_exp=0;
		if(mysql_num_rows($ptr_amt1))
		{
			$data_amnt1=mysql_fetch_array($ptr_amt1);
			$total_exp=$data_amnt1['total'];
		}
		//====================================================
		$select_refund="select SUM(total_refund) as total from enrollment_refund where DATE(`added_Date`) >= '".$date_for_month."-01' and DATE(`added_Date`) <= '".$date."' ".$branch_id." ";
		$ptr_refund=mysql_query($select_refund);
		$total_refund=0;
		if(mysql_num_rows($ptr_refund))
		{
			$data_refund=mysql_fetch_array($ptr_amt1);
			$total_refund=$data_refund['total'];
		}
		$total_amount1=$total_exp+$total_refund;
		//====================================================
		$sel_total_bus="select SUM(net_fees) as total_amt from enrollment where DATE(`added_date`) >= '".$date_for_month."-01' and DATE(`added_date`) <= '".$date."' ".$branch_id."";
		$ptr_total_bus=mysql_query($sel_total_bus);
		$data_total_bus=mysql_fetch_array($ptr_total_bus);
		//====================================================
		echo '<tr>';
		echo '<td align="center" style="border:1px solid #CCC">'.round($data_total_inc['total_amt']).'</td>'; 
		echo '<td align="center" style="border:1px solid #CCC">'.round($total_receipt).'</td>';      
		echo '<td align="center" style="border:1px solid #CCC">'.round($total_product_amount).'</td>';
		echo '<td align="center" style="border:1px solid #CCC">'.round($total_service_amount).'</td>';
		echo '<td align="center" style="border:1px solid #CCC">'.round($total_sales_pack).'</td>';
		echo '<td align="center" style="border:1px solid #CCC">'.round($total_amount1).'</td>';
		echo '<td align="center" style="border:1px solid #CCC">'.round($total_inv,2).'</td>';
		echo '<td align="center" style="border:1px solid #CCC">'.round($data_total_bus['total_amt']).'</td>';
 	?> 
   </table>
   </td>
  </tr>    
 
  <!--===========================================END MONTHLY SALE===================================================================-->
  <tr>
  	<td colspan="12" style="color:#F00">Note -:<br/>
    <strong>Total Cash Revenue (Product)</strong> -: It calculated Excluding <strong>Inoncent</strong> and <strong>Director</strong> taken from Receipt<br />
    <strong>Total Cash Expense -:</strong> It calculate Excluding '<strong>Cash Given to Director</strong>' taken from Expense <br />
    </td>
  </tr>
  <tr>
  		<td class="width5" colspan="5" align="center" style="font-size:15px !important">
        	<?php
			$sel_dsr="select * from dsr_match_reprot where 1 and status='yes' and added_by='".$_SESSION['admin_id']."' and DATE(dsr_date)='".$date."' ".$branch_id." ";
			$ptr_date=mysql_query($sel_dsr);
			$data_dsr_matched=mysql_fetch_array($ptr_date);
			
			?>
  			<strong>Is DSR Matched </strong>&nbsp;&nbsp;&nbsp; <input type="radio" <?php if($data_dsr_matched['status']=='yes' || $data_dsr_matched['status']=='') echo 'checked="checked"'; ?> name="dsr_matched" id="dsr_matched" value="yes" onclick="check_dsr('yes')"  />Yes &nbsp;&nbsp;&nbsp; <input <?php if($data_dsr_matched['status']!='yes') echo 'checked="checked"'; ?> type="radio" name="dsr_matched" id="dsr_matched" value="no" onclick="check_dsr('no')" />No
    	</td>
  	 	<td class="width5" colspan="5" align="center">
 	 	<input type="hidden" name="send_mail"  value="mail">
	 	<?php 
     	if($_SESSION['type']=='S'|| $edit_access=='yes' )
     	{
     	    ?>
     	    <input type="submit" name="sending_mail" value="Send Mail" class="inputButton"/></td>
     	    <?php
     	}
 	 	?>
 </tr>
 </form>
<!-- <tr>
 <td colspan="10" >
 <table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #999">
 <tr style="background-color:#999">
    
    <td width="5%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
    <td width="20%" align="center" style="border:1px solid #CCC"><a href="<?php //echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=category".$query_string;?>" class="table_font"><strong>Payment Mode</strong></a> <?php echo $img1;?></td>
     <td width="10%" align="center" style="border:1px solid #CCC"><strong>Amount</strong></td>
   </tr>
    <?php
	/*$sele_pay_mode1="select payment_mode_id as total_amt from expense where added_Date=".$date."";
	$ptr_pay_mode1=mysql_query($sele_pay_mode1);
	$i=1;
	if(mysql_num_rows($ptr_pay_mode1))
	{
		while($data_pay_mode1=mysql_fetch_array($ptr_pay_mode1))
		{
			$sele_pay_name="select payment_mode from payment_mode where payment_mode_id=".$data_pay_mode1['payment_mode_id']."";
			$ptr_pay_name=mysql_query($sele_pay_name);
			$data_pay_name=mysql_fetch_array($ptr_pay_name);
			
			$sel_inv1="select SUM(amount) as total_amt from expense where payment_mode_id='".$data_pay_mode1['payment_mode_id']."'";
			$ptr_amnt1=mysql_query($sel_inv1);
			$data_ptr_sel1=mysql_fetch_array($ptr_amnt1);
			if($data_ptr_sel1['total_amt'] !=0)
			{
				echo '<tr>';
				echo '<td align="center" style="border:1px solid #CCC">'.$i.'</td>';       
				echo '<td align="center" style="border:1px solid #CCC">'.$data_pay_name['payment_mode'].'</td>';
				echo '<td align="center" style="border:1px solid #CCC">'.$data_ptr_sel1['total_amt'].'</td>';
			}
			
		$i++;
		}
	}
	else
	{
		echo '<tr><td class="text" align="center" colspan="3"><br><div class="msgbox" style="width:50%;background-color:green">No Amount added by any Payment mode on today</div><br></td></tr>';
	}*/
 ?> 
   </table>
   </td>
  </tr>-->
  
  
  
   <!--<tr>-->
  <?php 
  /*$select_amnt1="select SUM(amount) as total from expense where added_Date=".$date." order by expense_id desc";
	$ptr_amt1=mysql_query($select_amnt1);
	$total_amount1=0;
	if(mysql_num_rows($ptr_amt1))
	{
		$data_amnt1=mysql_fetch_array($ptr_amt1);
		$total_amount1=$data_amnt1['total'];
	}
	else
	{
		$total_amount1=0;
	}*/
  ?>
 <!--<td align="left" colspan="10" style="color:#F00"><strong>Todays Outgoing</strong> : <?php //echo $total_amount1; ?></td>
  </tr>-->
 <!--   <tr>
  <?php 
/*  $select_amnt1="select SUM(amount) as total from expense added_Date=subdate(currentDate, 1) order by expense_id desc limit 0,1";
	$ptr_amt1=mysql_query($select_amnt1);
	$total_amount1=0;
	if(mysql_num_rows($ptr_amt1))
	{
		$data_amnt1=mysql_fetch_array($ptr_amt1);
		$total_amount1=$data_amnt1['total'];
	}*/
  ?>
  <td align="left" colspan="10" style="color:#F00"><strong>Yesterday Outgoing</strong> : <?php //echo $total_amount1; ?></td>
  </tr>-->
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
