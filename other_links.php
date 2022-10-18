<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Other Links</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
    <script type="text/javascript" src="../js/common.js"></script>
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
    <td class="top_mid" valign="bottom"><?php include "include/general_setting_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
        
<table cellspacing="0" cellpadding="0" class="table" width="95%">
    
    
  <tr class="head_td">
    <td colspan="9">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <!--<tr>
                <td class="width5"></td>
                <td width="20%">
                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                <option value="">-Operation-</option>
                                <option value="delete">Delete</option>
                        </select></td>
                <td class="rightAlign" > 
                    <table border="0" cellspacing="0" cellpadding="0" align="right">
              <tr>
              <td></td>
              <td class="width5"></td>
                <td><input type="text" value="<?php //if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                <td class="width2"></td>
                <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
              </tr>
                    </table>	
                </td>
            </tr>-->
        </table>
        </form>	
    </td>
  </tr>
     				<form method="post"  name="frmTakeAction" action="<?php //echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                    	<tr>
                            <td width="10%" class="centerAlign"><a href="update_courses_price.php" class="table_font"><strong>Update Courses Price</strong></a> </td>
                        </tr>
                        <tr>
                            <td width="10%" class="centerAlign"><a href="enrollment_tally_report.php" class="table_font"><strong>Enrollment Tally export</strong></a> </td>
                        </tr>
                        <tr>
                            <td width="10%" class="centerAlign"><a href="product_tally_report.php" class="table_font"><strong>Product Tally export</strong></a> </td>
                        </tr>
                        <tr>
                            <td width="10%" class="centerAlign"><a href="service_tally_report.php" class="table_font"><strong>Service Tally export</strong></a> </td>
                        </tr>
                        <tr>
                            <td width="10%" class="centerAlign"><a href="purchase_tally_report.php" class="table_font"><strong>Purchase Tally Report</strong></a> </td>
                        </tr>
                        <tr>
                            <td width="10%" class="centerAlign"><a href="expense_tally_report.php" class="table_font"><strong>Expense Tally Report</strong></a> </td>
                        </tr>
                        <tr>
                            <td width="10%" class="centerAlign"><a href="expense_tally_report.php" class="table_font"><strong>Expense Tally Report</strong></a> </td>
                        </tr>
                        <tr>
                            <td width="10%" class="centerAlign"><a href="enrollment_receipt_tally_report.php" class="table_font"><strong>Enrollment Receipt Tally Report</strong></a> </td>
                        </tr>
                        <tr>
                            <td width="10%" class="centerAlign"><a href="product_receipt_tally_report.php" class="table_font"><strong>Product Sale Receipt Tally Report</strong></a> </td>
                        </tr>
                        <tr>
                            <td width="10%" class="centerAlign"><a href="service_receipt_tally_report.php" class="table_font"><strong>Service Receipt Tally Report</strong></a> </td>
                        </tr>
                        <tr>
                            <td width="10%" class="centerAlign"><a href="purchase_payment_tally_report.php" class="table_font"><strong>Product Purchase Payment Tally Report</strong></a> </td>
                        </tr>
                        <tr>
                            <td width="10%" class="centerAlign"><a href="expense_payment_tally_report.php" class="table_font"><strong>Expense Payment Tally Report</strong></a> </td>
                        </tr>
                        <!--========================================================================-->
                        <tr>
                            <td width="10%" class="centerAlign"><a href="enrollment_ledger_report.php" class="table_font"><strong>Enrollment ledger report</strong></a> </td>
                        </tr>
                        <tr>
                            <td width="10%" class="centerAlign"><a href="enrollment_ledger_report.php" class="table_font"><strong>Check Existing Campaign Inquiry</strong></a> </td>
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