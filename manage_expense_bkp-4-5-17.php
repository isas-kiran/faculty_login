<?php include 'inc_classes.php';?>
<?php //include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Total Enrollment</title>
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
                        
                         <td width="10%">
                         <input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>">
                         </td>
                         
                         <td width="10%">
                         <input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>">
                         </td>
                         
                                <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                                
                <td class="rightAlign" > 
                   <!-- <table border="0" cellspacing="0" cellpadding="0" align="right">
              <tr>
              <td></td>
              <td class="width5"></td>
                <td><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                <td class="width2"></td>
                <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
              </tr>
                    </table>	-->
                </td>
            </tr>
        </table>
        </form>	
        <form method="get" name="search">
		<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                         <td width="10%">
                         <input type="hidden" name="send_mail"  value="mail">
                         </td>
                         <td width="10%"><input type="submit" name="send_mail" value="Send Mail" class="inputButton"/></td>
              </tr>
        </table>
        </form>	
    </td>
  </tr>
    
     <?php
						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						 {
						  	$pre_from_date=" and added_date >='".date('Y-m-d',strtotime($_REQUEST['from_date']))."'";
						 }
						else
						{
							$pre_from_date=""; 
							$enquiry_date="";
							$installment_from_date="";                           
						}
						
						if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
						{
							 $_REQUEST['to_date'];
							 $pre_to_date=" and added_date<='".date('Y-m-d',strtotime($_REQUEST['to_date']))."'";
							
							
						}
						else
						{
							$pre_to_date="";
							$enquiery_to_date="";
							$installment_to_date="";
						}
						if($_REQUEST['send_mail'])
						{
							/*------------send a mail to admin about this---------------------*/
							$subject = " Todays Expense Report of ".$GLOBALS['domainName']."";
							
							$sql_expense= "SELECT * FROM expense where 1 and added_Date=CURDATE() ".$_SESSION['where']." "; 
							$ptr_expense=mysql_query($sql_expense);
							while($data_expense=mysql_fetch_array($ptr_expense))
							{
								
								$sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$data_expense['payment_mode_id']."'";
								$ptr_payment_mode=mysql_query($sel_payment_mode);
								$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
								
								$sel_bank="select bank_name from bank where bank_id='".$data_expense['bank_id']."'";
								$ptr_bank=mysql_query($sel_bank);
								$data_bank_name=mysql_fetch_array($ptr_bank);
								
								$sel_vendor="select name from vendor where vendor_id='".$data_expense['vendor_id']."'";
								$ptr_vendor=mysql_query($sel_vendor);
								$data_vendor=mysql_fetch_array($ptr_vendor);
								
								$sel_emp="select name from site_setting where admin_id='".$data_expense['employee_id']."'";
								$ptr_emp=mysql_query($sel_emp);
								$data_emp=mysql_fetch_array($ptr_emp);
								
								
								$message .= '
								<table cellpadding="3" align="left" cellspacing="3" width="75%">
								 <tr>
									<td width="35%"><strong>Payment Mode</strong></td>
									<td>:</td>
									<td width="65%">'.$data_payment_mode['payment_mode'].'</td>
								</tr>';
								
								  
								 
								$message.= '
								
								<tr>
									<td width="35%"><strong>Amount</strong></td>
									<td>:</td>
									<td width="65%">'.$data_expense['amount'].'</td>
								</tr>';
								//if($birth_date)
								
								$message.= '
								<tr>
									<td><strong>Description</strong></td>
									<td>:</td>
									<td>'.$data_expense['description'].'<td>
								</tr>';
								
								$message.= '
								<tr>
									<td><strong>Vendor</strong></td>
									<td>:</td>
									<td>'.$data_vendor['name'].'<td>
								</tr>';
								
								$message.= '
								<tr>
									<td><strong>Employee</strong></td>
									<td>:</td>
									<td>'.$data_emp['name'].'<td>
								</tr>';
								
								
								$message.='<tr><td colspan="3"><strong>Todays Expense Report</strong></td></tr>
								</table>';
							}
					
							$sendMessage=$GLOBALS['box_message_top'];
							$sendMessage.=$message;
							$sendMessage.=$GLOBALS['box_message_bottom'];
							$from_id='support<support@'.$GLOBALS['siteUrlName'].'>';
							$headers= 'MIME-Version: 1.0' . "\n";
							$headers.='Content-type: text/html; charset=utf-8' . "\n";
							$headers.='From:'.$from_id;
							
							
								
								$select_email_id = " select email from site_setting where (cm_id='".$_SESSION['cm_id']."' or admin_id='".$_SESSION['admin_id']."' or branch_name='".$branch_name1."') and email !='' ";
								$ptr_emails = mysql_query($select_email_id);
								while($data_emails = mysql_fetch_array($ptr_emails))
								{
									mail($data_emails['email'], $subject, $sendMessage, $headers);
								}
						
							
						/*-------------------------------------------------------------------------*/
							}
						?>
                        
                        
     <?php
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
                            $select_directory='order by expense_id desc';                      
                            $sql_query= "SELECT * FROM expense where 1  ".$_SESSION['where']." ".$pre_from_date." ".$pre_to_date." ".$pre_keyword." ".$select_directory." "; 
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
                            ?>
    <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                                 <input type="hidden" name="formAction" id="formAction" value=""/>
  <tr class="grey_td" >
    <td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
    <td width="5%" align="center"><strong>Sr. No.</strong></td>
    <td width="20%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=category".$query_string;?>" class="table_font"><strong>Payment Mode</strong></a> <?php echo $img1;?></td>
     <td width="10%"><strong>Bank Name</strong></td>
    <td width="10%"><strong>Account No</strong></td>
     <td width="10%"><strong>Chaque No</strong></td>
    <td width="10%"><strong>chaque Date</strong></td>
    <td width="10%"><strong>Amount</strong></td>
     <td width="10%"><strong>Description</strong></td>
    <td width="10%"><strong>Vendor</strong></td>
     <td width="10%"><strong>Employee</strong></td>
    <td width="10%"><strong>Added date</strong></td>
    <td width="10%" class="centerAlign"><strong>Action</strong></td>
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
								
								
								
                                echo '<tr '.$bgcolor.' >
                                      <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
                                echo '<td align="center">'.$sr_no.'</td>';       
                                echo '<td ><a href="expense.php?record_id='.$listed_record_id.'" class="table_font">'.$data_payment_mode['payment_mode'].'</a></td>';
                                echo '<td >'.$data_bank_name['bank_name'].'</td>';
								echo '<td >'.$val_query['account_no'].'</td>';
								echo '<td >'.$val_query['chaque_no'].'</td>';
								echo '<td >'.$val_query['chaque_date'].'</td>';
								echo '<td >'.$val_query['amount'].'</td>';
								echo '<td >'.$val_query['description'].'</td>';
								echo '<td >'.$val_query['vendor_id'].'</td>';
								echo '<td >'.$data_emp['name'].'</td>';
								echo '<td >'.$val_query['added_Date'].'</td>';
                                echo '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
                                      <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';

                                echo '</td>';
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
    </tr></form>
      <?php } 
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
<!--footer end-->
</body>
</html>
