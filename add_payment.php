<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php if($record_id) echo "Edit"; else echo "Enrollment ";?>
 Form</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>
    </head>
<body>
<?php include "include/header.php";?>

<div id="info"> 

<?php include "include/menuLeft.php"; ?>
<!--left end-->
<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/student_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
                                <form method="get" name="jqueryForm" id="jqueryForm">
                                    <table align="center" border="0" width="75%"> 
                                <tr>
                                <td width="30%" > <input type="text" name="bill_id" class="input defaultText" id="bill_id" title="Bill Number" value="<?php if($_REQUEST['enroll_id']!="Bill Number") echo $_REQUEST['enroll_id'];?>"> </td>
                                 <td width="10%" > <select name="customer_id">
                                 <option value="">Select Student</option>
                                 <?php
								 $select_customers = " select enroll_id as user_id ,name from enrollment order by name asc  ";
								 $ptr_customer = mysql_query($select_customers);
								 while($data_customer = mysql_fetch_array($ptr_customer))
								 {	$selecteds='';
									 if($record_id==$data_customer['user_id'])
									 $selecteds = '  selected="selected" ';
									echo "<option value='".$data_customer['user_id']."' $selecteds >".$data_customer['name']."</option>";	 
								 }
								 ?>
                                 </select>
                                  </td>
                                 
                                    
                                    <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                                    <td width="20%"></td>
                                </tr>
                                </table>
                                </form>
                         
                      <?php
                       if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
                      {
                  $pre_from_date=" and date_format(added_date,'%Y-%m-%d')>='".date('Y-m-d',strtotime($_REQUEST['from_date']))."'";
                                    /*$sql_previos_total= "SELECT sum(amount) as credits FROM dd_user_payement where status='Active' and user_id='".$_SESSION['user_id']."' and debit_credit='Credit' and added_date<'".$_REQUEST['from_date']." 00:00:00'";
                                    $row_previos_total=$db->fetch_array($db->query($sql_previos_total));

                                    $sql_previos_total1= "SELECT sum(amount) as debits FROM dd_user_payement where status='Active' and user_id='".$_SESSION['user_id']."' and debit_credit='Debit' and added_date<'".$_REQUEST['from_date']." 00:00:00'";
                                    $row_previos_total1=$db->fetch_array($db->query($sql_previos_total1));
                                    $balance=$row_previos_total['credits']-$row_previos_total1['debits'];*/
                                }
                                else
                                {
                                    $balance=0;
                                    $pre_from_date="";                            
                                }
                               
									
                                $sql_records= "SELECT * FROM invoice 
								where 1 ".$pre_transcation_id." ".$pre_from_date." ".$pre_to_date." ".$pre_status."  
								order by invoice_id desc";
                                $no_of_records=mysql_num_rows($db->query($sql_records));
                                if($no_of_records)
                                {
                           
                                    $bgColorCounter=1;
                                    if(!$_SESSION['showRecords'])
                                        $_SESSION['showRecords']=10;

                                    $query_string.="&show_records=".$showRecord;
                                    $pager = new PS_Pagination($sql_records,$_SESSION['show_records'],10,$query_string);
                                    $all_records= $pager->paginate();?>
                                    <form method="post" name="frmTakeAction">
                                    <table cellpadding="0" cellspacing="0" width="100%" border="0">
                                    <tr><td valign="middle" align="right">
                                            <table width="100%" cellpadding="0" callspacing="0" border="0">
                                                <tr>
                                                    <?php
                                                    if($no_of_records>10)
                                                    {
                                                        echo '<td width="3%" align="left">Show</td>
                                                        <td width="12%" align="left"><select class="inputSelect" name="show_records" onchange="redirect(this.value)">';

                                                        for($s=0;$s<count($show_records);$s++)
                                                        {
                                                            if($_SESSION['show_records']==$show_records[$s])
                                                                echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                            else
                                                                echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                        }
                                                        echo'</td></select>';
                                                    }
                                                    ?>
                                                   <!-- <td width="70%" align="right"><a href="javascript:void(0);" onClick="window.open('csvcompany_manage.php','win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=800,height=600,directories=no,location=no'); return false;" ><img src="images/csv.png" border="0"/></a>
    
    <img src='images/view.jpeg' title='View Invoice' border='0' 
	onclick="window.open('invoice-generate-company.php')" style='cursor:pointer' > 
    <img src='images/print1.jpeg'
								onclick="window.open('invoice-generate-company.php?action=print','View Invoice')" style='cursor:pointer'title='Print Invoice' border='0'>
                                            </td>-->
                                                    <td align="right"><?php echo $pager->renderFullNav();?></td>
                                                </tr>
                                            </table>
                                        </td></tr>
                                    <tr><td height="10"></td></tr>
                                    <tr><td valign="top" colspan="2">
                                       <table cellspacing="1"  cellpadding="0" style="width: 100%;" align="center">
								<tr align="center"><td class="tr-header">Sr.</td><td class="tr-header">Invoice No.</td><td class="tr-header">Customer Name</td>
                                <td class="tr-header">Total</td><td  class="tr-header">Discount</td><td class="tr-header">Paid</td><td class="tr-header">Balance Amount</td><td class="tr-header"> Date </td><td class="tr-header"> Add Payment </td><td class="tr-header">View</td><td class="tr-header">Print</td></tr><?php
                                    while($val_record=mysql_fetch_array($all_records))
                                    {
										 $enroll_id=$val_record['enroll_id'];
										 $paid_totas=0;
                                        if($bgColorCounter%2==0)
                                            $bgclass="tr-sub_white1";
                                        else
                                            $bgclass="tr-sub1";
                                       // include "paging_script.php";
                                        echo '<tr class="'.$bgclass.'">';
                                        echo '<td>'.$sr_no.'</td>';
										echo "<td>".$val_record['enroll_id']."</td>";
										$name ='';
										$email_id = '';
										$phone_no ='';
					
									   echo  $select_firstname = " select name ,mail , contact as phone_no  from enrollment where enroll_id='".$val_record['enroll_id']."' ";
										$data_select = mysql_fetch_array(mysql_query($select_firstname));
										
										echo '<td align="left" style="padding-left:5px;"><b>'.$data_select['name'].'</b><br />'.$data_select['mail'].'<br />'.$data_select['phone_no'].' </td>';
                                        echo '<td>'.$val_record['amount'].'</td>';
                                        echo '<td >';
                                        	
                                          echo $val_record['discount'];
                                        echo '</td>'; 
									    $val_record['paid']. ' ';
										$selectpaid="select sum(installment_amount) as amount_paid  from installment 
										where enroll_id=".$val_record['enroll_id']." "; 
										$ptr_selectpaid=mysql_query($selectpaid);
										if(mysql_num_rows($ptr_selectpaid))
										 {
										while($val_selectedpaid=mysql_fetch_array($ptr_selectpaid))
										{
									    $totsss=$val_record['balance_amount']-$val_selectedpaid['amount_paid'];										                                        $paid_totas=$paid_totas+$val_record['paid']+$val_selectedpaid['amount_paid']; 
										}
										}
									   echo '<td>'.$paid_totas.'</td>'; 
									   echo '<td>'.$totsss.'</td>';
									    echo '<td>';
										echo date("d-m-Y",strtotime($val_record['added_date']));
										echo'</td>';
								echo '<td> <a href="Add-payment-to-do.php?bill_id='.$enroll_id.'&customer_supplier_id='.
								$customer_supplier_idd.'">
						<img src="images/add1-.png" border="0" title="Add Payment"></a></td>';
                                        echo "<td>
										<img src='images/view.jpeg' title='View Invoice' border='0' 
										onclick=\"window.open('invoice-generate.php?invoice_id=".$val_record['enroll_id']."','View Invoice','width=750,height=700')\" style='cursor:pointer' >
										</td>";
										echo "<td><img src='images/print1.jpeg'
								onclick=\"window.open('invoice-generate.php?invoice_id=".$val_record['enroll_id']."&action=print','View Invoice','width=750,height=700')\"      style='cursor:pointer'title='Print Invoice' border='0'></td>";
										
                                        echo '</tr>';
                                        $bgColorCounter++;
                                    }
                                  
                                    ?>
                                        </table>
                                    </td></tr>
                                    <tr><td height="10"></td></tr>
                                    <tr><td valign="middle" align="right">
                                            <table width="100%" cellpadding="0" callspacing="0" border="0">
                                                <tr>
                                                    <?php
                                                    if($no_of_records>10)
                                                    {
                                                        echo '<td width="3%" align="left">Show</td>
                                                        <td width="12%" align="left"><select class="inputSelect" name="show_records" onchange="redirect(this.value)">';

                                                        for($s=0;$s<count($show_records);$s++)
                                                        {
                                                            if($_SESSION['show_records']==$show_records[$s])
                                                                echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                            else
                                                                echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                        }
                                                        echo'</td></select>';
                                                    }
                                                    ?>
                                                    <td align="right"><?php echo $pager->renderFullNav();?></td>
                                                </tr>
                                            </table>
                                        </td></tr>
                                    </table>
                                    </form><?php
                                }
                                else if($_GET['search'])
                                    echo'<center><br><div id="alert" style="width:80%">Records not found related to your search criteria, please try again to get more results</div><br></center>';
                                else
                                    echo'<center><br><div id="alert" style="width:30%">No Payment history here</div><br></center>';
                            ?>
                     </div>
<!--right end-->
</div>
<!--info end-->
<div class="clearit"></div> 
                    <noscript>
                            Warning! JavaScript must be enabled for proper operation of the Administrator backend.				</noscript>
                 <div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>