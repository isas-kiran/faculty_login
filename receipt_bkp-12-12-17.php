<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php
if($_REQUEST['record_id'])
{
	$record_id=$_REQUEST['record_id'];
	$sel="select * from receipt where receipt_id='".$record_id."'";
	$ptr_data=mysql_query($sel);
	if(mysql_num_rows($ptr_data))
		$row_record=mysql_fetch_array($ptr_data);
		
	$sel_payment_mode1="select payment_mode from payment_mode where payment_mode_id='".$row_record['payment_mode_id']."'";
	$ptr_payment_mode1=mysql_query($sel_payment_mode1);
	$data_payment_mode1=mysql_fetch_array($ptr_payment_mode1);
	$pay_mode=trim($data_payment_mode1['payment_mode']);
	
	$sel_acc_no="select account_no from bank where bank_id='".$row_record['bank_id']."'";
	$ptr_bank_id=mysql_query($sel_acc_no);
	$data_bank_id=mysql_fetch_array($ptr_bank_id);
}
else
{
	$record_id='';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Receipt</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>

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
    <!--End multiselect -->
     <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    
    <script type="text/javascript">
       
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear',dateFormat: 'dd/mm/yy'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
       });
	</script>
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
    <script>
	function payment(value)
	{
		payment_mode=value.split("-")
		//alert(payment_mode[0]);
		var branch_name=document.getElementById("branch_name").value;
		if(payment_mode[0]=="cheque")
		{
			document.getElementById("chaque_details").style.display = 'block';
			document.getElementById("bank_details").style.display = 'block';
			document.getElementById("credit_details").style.display = 'none';
			
			show_bank(branch_name,"cheque")
		}
		else if(payment_mode[0]=="Credit Card")
		{
			document.getElementById("chaque_details").style.display = 'none';
			document.getElementById("bank_details").style.display = 'block';
			document.getElementById("credit_details").style.display = 'block';
			show_bank(branch_name,"credit_card")
			
		}
		else if(payment_mode[0]=="paytm")
		{
			document.getElementById("chaque_details").style.display = 'none';
			document.getElementById("bank_details").style.display = 'block';
			document.getElementById("credit_details").style.display = 'none';
			show_bank(branch_name,"paytm")
		}
		else
		{
			document.getElementById("chaque_details").style.display = 'none';
			document.getElementById("bank_details").style.display = 'none';
			document.getElementById("credit_details").style.display = 'none';
			show_bank(branch_name,"")
			
			
		}
	}
	
	</script>
 <script>   
    function validme()
	 {
		frm = document.save;
		error='';
		disp_error = 'Clear The Following Errors : \n\n';
	 	if(frm.category.value=='select')
		{
			 disp_error +='Select Category Name\n';
			 document.getElementById('category').style.border = '1px solid #f00';
			 frm.category.focus();
			 error='yes';
	    }
		/* else
		 {
			 if(frm.category.value=='bank')
			 {
				  if(frm.bank_name.value=='')
				 {
					 disp_error +='Select Bank Name\n';
					 document.getElementById('bank_name').style.border = '1px solid #f00';
					 frm.bank_name.focus();
					 error='yes';
				 }
				 
			 }
		 }*/
		 if(frm.payment_mode.value=='select')
		 {
			 disp_error +='Select Payment Mode\n';
			 document.getElementById('payment_mode').style.border = '1px solid #f00';
			 frm.payment_mode.focus();
			 error='yes';
	     }
		 else
		 {
			pay_value=$('#payment_mode').val();
			pay_type=pay_value.split('-');
			payment_types=pay_type[0];
			if(payment_types=='cheque')
			{
				 if(frm.bank_name.value=='')
				 {
					 disp_error +='Select Bank Name\n';
					 document.getElementById('bank_name').style.border = '1px solid #f00';
					 frm.bank_name.focus();
					 error='yes';
				 }
				 
				 if(frm.account_no.value=='')
				 {
					 disp_error +='Enter Account Number\n';
					 document.getElementById('account_no').style.border = '1px solid #f00';
					 frm.account_no.focus();
					 error='yes';
				 }
				 if(frm.chaque_no.value=='')
				 {
					 disp_error +='Enter Chaque Number\n';
					 document.getElementById('chaque_no').style.border = '1px solid #f00';
					 frm.chaque_no.focus();
					 error='yes';
				 }
				 if(frm.date.value=='')
				 {
					 disp_error +='Enter Cheque Date\n';
					 document.getElementById('date').style.border = '1px solid #f00';
					 frm.date.focus();
					 error='yes';
				 }
			 }
			 if(payment_types=='Credit Card')
			 {
				 if(frm.bank_name.value=='')
				 {
					 disp_error +='Select Bank Name\n';
					 document.getElementById('bank_name').style.border = '1px solid #f00';
					 frm.bank_name.focus();
					 error='yes';
				 }
				 if(frm.credit_card_no.value=='')
				 {
					 disp_error +='Enter Credit Card Number\n';
					 document.getElementById('credit_card_no').style.border = '1px solid #f00';
					 frm.credit_card_no.focus();
					 error='yes';
				 }
			 }
		 }
	 	if(frm.amount.value=='')
		{
			 disp_error +='Plese Enter Amount\n';
			 document.getElementById('amount').style.border = '1px solid #f00';
			 frm.amount.focus();
			 error='yes';
		}
		if(error=='yes')
		{
			 alert(disp_error);
			 return false;
		}
		 else
		 return true;
	
	 }
	 function isPastDate(value) 
	 {
        var now = new Date;
        var target = new Date(value);
        if (target.getFullYear() < now.getFullYear()) {
            return true;
        } else if (target.getMonth() < now.getMonth()) {
            return true;
        } else if (target.getDate() < now.getDate()) {
            return true;
        }

        return false;
    }
	function isFeatureDate(value) {
        var now = new Date;
        var target = new Date(value);
        if (target.getFullYear() > now.getFullYear()) {
            return true;
        } else if (target.getMonth() > now.getMonth()) {
            return true;
        } else if (target.getDate() > now.getDate()) {
            return true;
        }
        return false;
    }
function isSpclChar(id)
{
var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>? ";

 vals = document.getElementById(id).value;
for (var i = 0; i < vals.length; i++) {
    if (iChars.indexOf(vals.charAt(i)) != -1) {
          return 'yes';
        }
    }
	
}  
function validateEmail(emailField)
{
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	if(document.getElementById('email').value !='')
	{
		if (reg.test(document.getElementById('email').value) == false) 
		{
			alert('Invalid Email Address');
			document.getElementById('email').style.border = '1px solid #f00';
			document.getElementById('email').focus();
			return false;
		}
	}
	return true;
}
function show_acc_no(bank_id)
{
	//alert(bank_id);
	var data1="action=show_account&bank_id="+bank_id;
	//alert(data1);
	$.ajax({
	url: "ajax.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		document.getElementById('account_no').value=html;
	}
	});
}
function show_bank(branch_id,vals)
{
	document.getElementById("bank_record").style.display="none";
	record_id= document.getElementById("record_id").value;
	var bank_data="action=receipt&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
	$.ajax({
	url: "show_bank.php",type:"post", data: bank_data,cache: false,
	success: function(retbank)
	{
		document.getElementById("bank_id").innerHTML=retbank;
		if(document.getElementById("bank_name").value)
		{
			//alert(document.getElementById("bank_name").value);
			var bank_ids=document.getElementById("bank_name").value;
			show_acc_no(bank_ids)
		}
	}
});
}
function show_category(category)
{
	//alert(category);
	if(category =="voucher")
	{
		var cat_data="action=show_category_name&category_name="+category;
		//alert(cat_data);
		$.ajax({
		url: "ajax.php",type:"post", data: cat_data,cache: false,
		success: function(retcat)
		{
			//alert(retcat);
			document.getElementById("cat_id").style.display="block"
			document.getElementById("cat_id").innerHTML=retcat;
		}
		});
	}
	else
	{
		document.getElementById("cat_id").style.display="none"
	}
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
    <td class="top_mid" valign="bottom"><?php include "include/expense_menu.php";?></td>
    <td class="top_right"></td>
</tr>
    <?php       
	if($_POST['formAction'])
	{
		if($_POST['formAction']=="delete")
		{
			for($r=0;$r<count($_POST['chkRecords']);$r++)
			{
				$del_record_id=$_POST['chkRecords'][$r];
				$sql_query= "SELECT receipt_id FROM ".$GLOBALS["pre_db"]."receipt where receipt_id ='".$del_record_id."'";
				if(mysql_num_rows($db->query($sql_query)))
					{
													
						"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('receipt','Delete','receipt','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
						$query=mysql_query($insert);           
						
						$delete_query="delete from ".$GLOBALS["pre_db"]."receipt where receipt_id='".$del_record_id."'";
						$db->query($delete_query);                                                                                        
					}
			 }
			 ?>
					<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record(s) deleted successfully</p></center></div>
					<script type="text/javascript">
					   // $("#statusChangesDiv").dialog();
						$(document).ready(function() {
							$( "#statusChangesDiv" ).dialog({
								modal: true,
								buttons: {
											Ok: function() { $( this ).dialog( "close" ); }
										 }
								});
							});
					</script>
			<?php                            
				}
	 }
	if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
	{
		$del_record_id=$_REQUEST['record_id'];
		$sql_query= "SELECT receipt_id FROM ".$GLOBALS["pre_db"]."receipt where receipt_id='".$del_record_id."'";
		if(mysql_num_rows($db->query($sql_query)))
		{      
			"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('receipt','Delete','receipt','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
			$query=mysql_query($insert);     
								 
			$delete_query="delete from ".$GLOBALS["pre_db"]."receipt where receipt_id='".$del_record_id."'";
			$db->query($delete_query);      
			?>
			<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record deleted successfully</p></center></div>
			<script type="text/javascript">
			   // $("#statusChangesDiv").dialog();
				$(document).ready(function() {
					$( "#statusChangesDiv" ).dialog({
						modal: true,
						buttons: {
									Ok: function() { $( this ).dialog( "close" ); }
								 }
						});
					});
			</script>
			<?php
		}
	}
	?>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
    <?php
    $success=0;
	if($_POST['save_changes'])
	{
		$bank_name='';
		$chaque_no='';
		$date='';
		$credit_card_no='';
		
		$payment_mode=$_POST['payment_mode'];
		$sep=explode("-",$payment_mode);
		$payment_mode_id=$sep[1];
		
		$description =$_POST['description'];
		$category=$_POST['category'];
		
		$branch_name=$_POST['branch_name'];
		
		if($category =="voucher")
		{
			$voucher=$_POST['voucher'];
		}
		$amount=$_POST['amount'];
		
		
		if($payment_mode_id !="1" && $category !="cash_transfer" )
		{
			$bank_name=$_POST['bank_name'];
			$chaque_no=$_POST['chaque_no'];
			$credit_card_no=$_POST['credit_card_no'];
			$date=$_POST['date'];
			
		}
		if($_POST['added_date'] !=''){
			$ad_date=explode('/',$_POST['added_date'],3);
			$added_date=$ad_date[2].'-'.$ad_date[1].'-'.$ad_date[0];
		}
		else $added_date='';
		if(count($errors))
				{
					?>
					<tr>
						<td> <br></br>
						<table align="left" style="text-align:left;" class="alert">
						<tr><td ><strong>Please correct the following errors</strong><ul>
								<?php
								for($k=0;$k<count($errors);$k++)
										echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>
								</ul>
						</td></tr>
						</table>
						</td>
					</tr>   <br></br>  
					<?php
				}
				
		else
          {
		
			$success=1;
			$data_record['category'] = $category;
			$data_record['amount'] = $amount;
			$data_record['bank_id'] =$bank_name;
			$data_record['description'] = $description;
			$data_record['payment_mode_id'] = $payment_mode_id;
			$data_record['chaque_no'] = $chaque_no;
			$data_record['chaque_date'] =$date;
			$data_record['credit_card_no'] =$credit_card_no;
			$data_record['voucher'] =$voucher;
			//===============================CM ID for Super Admin===============
			if($_SESSION['type']=='S')
			{
				$sel_branch="select cm_id ,admin_id from site_setting where branch_name='".$branch_name."' and type='A'";
				$ptr_branch=mysql_query($sel_branch);
				$data_branch=mysql_fetch_array($ptr_branch);
				$cm_id=$data_branch['cm_id'];
				$branch_name1=$branch_name;
				$_SESSION['cm_id_notification']=$data_branch['cm_id'];
			}	
			else
			{
				$cm_id=$_SESSION['cm_id'];
				$branch_name1=$_SESSION['branch_name'];
			}
			$admin_id=$_SESSION['admin_id'];
			//========================================================================
			if($record_id)
			{
				
				 $update="update receipt set category='".$data_record['category']."', amount='".$data_record['amount']."', bank_id='".$data_record['bank_id']."', payment_mode_id='".$payment_mode_id."', chaque_no='".$chaque_no."', chaque_date='".$date."', credit_card_no='".$credit_card_no."', description='".$description."', cm_id='".$cm_id."', voucher='".$data_record['voucher']."' where receipt_id='".$record_id."'";
				$ptr_update=mysql_query($update);
				
				"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('receipt','Edit','receipt','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
				$query=mysql_query($insert);     
				
				echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
				?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Receipt added successfully</p></center></div>
						<script type="text/javascript">
							$(document).ready(function() {
								$( "#statusChangesDiv" ).dialog({
										modal: true,
										buttons: {
													Ok: function() { $( this ).dialog( "close" );}
												 }
								});
							});
						   setTimeout('document.location.href="receipt.php";',1000);
						</script>
                        <?php
			}
			else
			{
			 	$insert_for_receipt = "insert into receipt (`category`,`bank_id`,`amount`,`added_date`,`payment_mode_id`,`chaque_no`,`chaque_date`,`credit_card_no`,`description`,`cm_id`,`voucher`) values('".$data_record['category']."','".$data_record['bank_id']."','".$data_record['amount']."','".$added_date."','".$payment_mode_id."','".$chaque_no."','".$date."','".$credit_card_no."','".$description."','".$cm_id."','".$data_record['voucher']."')";
				$ptr_insert_receipt = mysql_query($insert_for_receipt);
				$receipt_ids=mysql_insert_id();
				
				"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('receipt','Add','receipt','".$receipt_ids."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
				$query=mysql_query($insert); 						
				echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
				?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Receipt added successfully</p></center></div>
						<script type="text/javascript">
							$(document).ready(function() {
								$( "#statusChangesDiv" ).dialog({
										modal: true,
										buttons: {
													Ok: function() { $( this ).dialog( "close" );}
												 }
								});
							});
					 	setTimeout('document.location.href="receipt.php";',1000);
						</script>
			<?php
			}
			
		  }
	}
	?>
<form name="save" method="post">
<table cellspacing="3" cellpadding="3" style="border:1px solid #CCC; margin-top: 15px;" width="95%">
<? if($_SESSION['type']=='S')
{
	?>
<tr>
<td align="center">Select Branch</td>
<input type="hidden" name="record_id" id="record_id" value="<?php if($_REQUEST['record_id']) { echo $record_id ;} ?>"  />
<td>
<?php
$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
$query_branch = mysql_query($sel_branch);
$total_Branch = mysql_num_rows($query_branch);
echo '<table width="100%"><tr><td>';
echo ' <select id="branch_name" name="branch_name" onchange="show_bank(this.value)">';

while($row_branch = mysql_fetch_array($query_branch))
{
	$selected='';
	if($_POST['branch_name']== $row_branch['branch_name'])
	{
		 $selected='selected="selected"';
	}
	$selected_branch="select branch_name from site_setting where cm_id= '".$row_record['cm_id']."' and type='A' ";
	$ptr_selected=mysql_query($selected_branch);
	if(mysql_num_rows($ptr_selected))
	{
		$data_cm_id=mysql_fetch_array($ptr_selected);
		if($data_cm_id['branch_name'] == $row_branch['branch_name'] )
		{
			 $selected='selected="selected"';
		}
		
	}
	?>
	<option <?php echo $selected; ?> value="<?php echo $row_branch['branch_name'];?>"><?php echo $row_branch['branch_name']; ?> 
	</option>
	<?php
}
echo '</select>';
echo "</td></tr></table>";
?>
</td>
</tr>
<?php } 
else { ?>
       <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
<?php }?>
 <tr>
	<td width="20%" align="center">Date<span class="orange_font">*</span></td>
	<td width="49%"><input type="text" id="added_date" name="added_date" class="input_text datepicker" value="<?php if($_POST['added_date']) echo $_POST['added_date']; else if($row_record['added_date']!=''){$arrage_date= explode('-',$row_record['added_date'],3);echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];}else{echo date("d/m/Y");}?>" />
	</td>
</tr>
 <tr>
    <td width="52%" class="tr-header" align="center">Select Category</td>
    <td width="25%"><select name="category" id="category" onchange="show_category(this.value)">
    <option value="select">--Select--</option>
    <option  value="incoming" <?php if($_POST['category']=="incoming") echo 'selected="selected"'; elseif($row_record['category'] =="incoming") echo 'selected="selected"'; ?>>Incoming</option>
    <option value="business" <?php if($_POST['category']=="business") echo 'selected="selected"'; elseif($row_record['category'] =="business") echo 'selected="selected"'; ?>>Business</option>
    <option value="product" <?php if($_POST['category']=="product") echo 'selected="selected"'; elseif($row_record['category'] =="product") echo 'selected="selected"'; ?>>Product</option>
    <option value="bank" <?php if($_POST['category']=="bank") echo 'selected="selected"'; elseif($row_record['category'] =="bank") echo 'selected="selected"'; ?>>Bank</option>
    <option value="innocent" <?php if($_POST['category']=="innocent") echo 'selected="selected"'; elseif($row_record['category'] =="innocent") echo 'selected="selected"'; ?>>Innocent</option>
    <option value="other" <?php if($_POST['category']=="other") echo 'selected="selected"'; elseif($row_record['category'] =="other") echo 'selected="selected"'; ?>>Other</option>
    <option value="santosh" <?php if($_POST['category']=="santosh") echo 'selected="selected"'; elseif($row_record['category'] =="santosh") echo 'selected="selected"'; ?>>Santosh Sapke</option>
    <option value="voucher" <?php if($_POST['category']=="voucher") echo 'selected="selected"'; elseif($row_record['category'] =="voucher") echo 'selected="selected"'; ?>>Voucher</option>
    </select></td>
 </tr>
<!-- <tr>
 <td colspan="2">
 <div id="bank_details" style="display:none">
 <table width="100%">
 <tr>
 <td width="68%" class="tr-header" align="center">Bank Name</td>
 <td><select name="bank_name" id="bank_name">
 <option value="">--Select--</option>
 <?php
/* $sle_bank_name="select bank_id,bank_name from bank ".$_SESSION['where_cm_id'].""; 
 $ptr_bank_name=mysql_query($sle_bank_name);
 while($data_bank=mysql_fetch_array($ptr_bank_name))
 {
	$selected='';
	if($data_bank['bank_id'] == $row_expense['bank_id'])
	{
		$selected='selected="selected"';
	}
	 echo '<option '.$selected.' value="'.$data_bank['bank_id'].'">'.$data_bank['bank_name'].'</option>';
 }*/
 ?>
 </select>
 </td>
 </tr>
 
 </table>
 </div>
 </td>
 </tr>-->
 <tr>
 	<td colspan="3" align="center"><div id="cat_id"></div>
    
    <?php
	/*if($record_id !='' && $row_record['category']=='voucher')
	{
				$sel_class = "select * from voucher";
				$execute_class = mysql_query($sel_class);
				echo '<table width="100%"><tr><td width="52%" align="center">Select Deal Name</td><td width="25%"><select name="voucher">';
				while($data_voucher=mysql_fetch_array($execute_class))
				{
					$sel='';
					if($row_record['voucher']==$data_voucher['voucher_id'])
					{
						echo $sel='selected="selected"';
					}
					echo '<option '.$sel.' value="'.$data_voucher['voucher_id'].'">'.$data_voucher['deal_name'].'</option>';
				}
				?>
				
       <?php
	}*/
	?>
    </td>
 </tr>
 
 <!---------------------------------------Payment mode------------------------------------->  
 
 <tr>
    <td width="39%" class="tr-header" align="center">Select Payment Mode</td>
    <td width="46%"><select name="payment_mode" id="payment_mode" onchange="payment(this.value)">
    <option value="select">--Select--</option>
    <?php
	$sel_payment_mode="select payment_mode,payment_mode_id from payment_mode";
	$ptr_payment_mode=mysql_query($sel_payment_mode);
	while($data_payment=mysql_fetch_array($ptr_payment_mode))
	{
		$selected='';
		if($data_payment['payment_mode_id'] == $row_record['payment_mode_id'])
		{
			$selected='selected="selected"';
		}
		echo '<option '.$selected.' value="'.$data_payment['payment_mode'].'-'.$data_payment['payment_mode_id'].'">'.$data_payment['payment_mode'].'</option>';
	}
	?>
    </select></td>
 </tr>
 <tr>
 <td colspan="3">
 <div id="bank_details" <?php  if($data_payment_mode1['payment_mode']=='Credit Card' || $data_payment_mode1['payment_mode']=='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
 <table width="100%">
 <tr>
 <td width="53%" class="tr-header" align="center">Bank Name</td>
 <td>
  <?php 
if($_SESSION['type'] !="S")
{
?>
 <select name="bank_name" id="bank_name" onchange="show_acc_no(this.value)">
 <option value="">--Select--</option>
 <?php
 $sle_bank_name="select bank_id,bank_name from bank ".$_SESSION['where_cm_id'].""; 
 $ptr_bank_name=mysql_query($sle_bank_name);
 while($data_bank=mysql_fetch_array($ptr_bank_name))
 {
	$selected='';
	if($data_bank['bank_id'] == $row_record['bank_id'])
	{
		$selected='selected="selected"';
	}
	 echo '<option '.$selected.' value="'.$data_bank['bank_id'].'">'.$data_bank['bank_name'].'</option>';
 	}
 	?>
 	</select>
  	<?php
 	}
 	?>
    
    <div id="bank_record">
            <?php 
            if($record_id !='')
            {
            ?>
             <select name="bank_name" id="bank_name" onChange="show_acc_no(this.value)">
             <option value="">--Select--</option>
             <?php
            echo $sle_bank_name="select bank_id,bank_name from bank where cm_id='".$row_record['cm_id']."'"; 
             $ptr_bank_name=mysql_query($sle_bank_name);
             while($data_bank=mysql_fetch_array($ptr_bank_name))
             {
                $selected='';
                if($data_bank['bank_id'] == $row_record['bank_id'])
                {
                    $selected='selected="selected"';
                }
                 echo '<option '.$selected.' value="'.$data_bank['bank_id'].'">'.$data_bank['bank_name'].'</option>';
             }
             ?>
             </select>
              <?php
             }
             ?></div>
    
	 <div id="bank_id"></div>
 	</td>
 </tr>
 <tr>
 	<td width="53%" class="tr-header" align="center">Account No</td>
	<td><input type="text" name="account_no" readonly="readonly" id="account_no" value="<?php if($_POST['account_no']) echo $_POST['account_no']; else echo $data_bank_id['account_no']; ?>" /></td>
 </tr>
 </table>
 </div>
 
 
 <div id="chaque_details" <?php  if($data_payment_mode1['payment_mode']=='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
 <table width="100%">

 	<tr>
         <td class="tr-header" width="53%" align="center">Enter Chaque No</td>
          <td><input type="text" name="chaque_no" id="chaque_no" value="<?php if($_POST['chaque_no']) echo $_POST['chaque_no']; else echo $row_record['chaque_no']; ?>" /></td>
    </tr>
    
 	<tr>
 		<td width="53%" class="tr-header" align="center">Enter Chaque Date</td>
 		<td><input type="text" name="date" id="date" class="datepicker" value="<?php if($_POST['date']) echo $_POST['date']; else echo $row_record['chaque_date']; ?>"  /></td>
 	</tr>
 </table>
 </div>
 
 <div id="credit_details" <?php  if($data_payment_mode1['payment_mode']=='Credit Card') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
 <table width="100%">
 
 	<tr>
 		<td width="53%" class="tr-header" align="center">Enter Credit Card No</td>
 		<td><input type="text" name="credit_card_no" id="credit_card_no" maxlength="4" value="<?php if($_POST['credit_card_no']) echo $_POST['credit_card_no']; else echo $row_record['credit_card_no']; ?>" /></td>
 	</tr>
 </table>
 </div>
 
 
 <tr>
    <td width="52%" class="tr-header" align="center">Amount</td>
    <td width="25%"><input type="text" name="amount" id="amount" value="<?php if($_POST['amount']) echo $_POST['amount']; else echo $row_record['amount']; ?>"  /></td>
 </tr>
 <tr>
  <tr>
    <td width="52%" class="tr-header" align="center">Description</td>
    <td width="25%"><textarea name="description" id="description" ><?php if($_POST['description']) echo $_POST['description']; else echo $row_record['description']; ?></textarea></td>
 </tr>
 <tr>
 <?php
$select_amnt1="select SUM(amount) as total from receipt order by receipt_id desc limit 0,1";
$ptr_amt1=mysql_query($select_amnt1);
$total_amount1=0;
if(mysql_num_rows($ptr_amt1))
{
	$data_amnt1=mysql_fetch_array($ptr_amt1);
	$total_amount1=$data_amnt1['total'];
}
 ?>
    <td align="center" colspan="2"><input type="submit" onclick="return validme()" name="save_changes" value="Save"  /> Total Cash : <?php echo $total_amount1; ?></td>
 </tr>
</table>
</form>
<table cellspacing="0" cellpadding="0" class="table" width="95%">
  <tr class="head_td">
    <td colspan="11">
    <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                <td width="20%">
                <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                        <option value="">-Operation-</option>
                        <option value="delete">Delete</option>
                </select></td>
                <td width="10%"><input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>"></td>
                <td width="10%"><input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>"></td>
                <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                <td class="rightAlign" > 
                    <table border="0" cellspacing="0" cellpadding="0" align="right">
              <tr>
              <td></td>
              <td class="width5"></td>
                <td><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                <td class="width2"></td>
                <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
              </tr>
                    </table>	
                </td>
            </tr>
        </table>
        </form>	
    </td>
  </tr>
    <?php
						$from_date="";
						$to_date="";
						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						{
							$frm_date=explode("/",$_REQUEST['from_date']);
							$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							
							$from_date=" and added_date >='".date('Y-m-d',strtotime($frm_dates))."'";
						}
						if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
						{
							$to_dates=explode("/",$_REQUEST['to_date']);
							$to_date=$to_dates[2]."-".$to_dates[1]."-".$to_dates[0];
							
							$to_date=" and added_date<='".date('Y-m-d',strtotime($to_date))."'";
						}
							
						
                        if($_REQUEST['keyword']!="Keyword")
                            $keyword=trim($_REQUEST['keyword']);
                        if($keyword)
						{
							$cm_id_filter='';
							$sel_branch="select cm_id from site_setting where branch_name like '".$keyword."' "; 
							$ptr_branch=mysql_query($sel_branch);     
							if(mysql_num_rows($ptr_branch)) 
							{
								$data_branch=mysql_fetch_array($ptr_branch);
								$cm_id_filter="|| cm_id = '".$data_branch['cm_id']."'";
							} 
							
							$pay_mode_filter='';
							$sel_pay_id="select payment_mode_id from payment_mode where payment_mode like '%".$keyword."%' "; 
							$ptr_pay_id=mysql_query($sel_pay_id);    
							if(mysql_num_rows($ptr_pay_id)) 
							{
								$data_pay_id=mysql_fetch_array($ptr_pay_id);
								$pay_mode_filter="|| payment_mode_id = '".$data_pay_id['payment_mode_id']."'";
							}  
							$bank_name_filter='';
							$select_bank = " select bank_id from bank where bank_name like '%".$keyword."%' ";
							$ptr_bank = mysql_query($select_bank);
							if($total=mysql_num_rows($ptr_bank))
							{
								while($data_bank_name = mysql_fetch_array($ptr_bank))
								{
									$bank_name_filter.= " || bank_id =".$data_bank_name['bank_id'];
								}
							}
							
							/*$enquiry_added='';
							$sel_enq="select admin_id from site_setting where name like '%".$keyword."%'";
							$ptr_enq=mysql_query($sel_enq);
							if(mysql_num_rows($ptr_enq))
							{
								$data_enq=mysql_fetch_array($ptr_enq);
								$enquiry_added="|| admin_id = '".$data_enq['admin_id']."'";
							}*/
							
							$pre_keyword =" and (category like '%".$keyword."%' ".$cm_id_filter." ".$pay_mode_filter." ".$bank_name_filter." || chaque_no like '%".$keyword."%' || chaque_date like '%".$keyword."%' || amount like '%".$keyword."%')";
						}
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

                        if($_GET['orderby']=='category' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='receipt_id'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                            $select_directory='order by receipt_id desc';  
							
						$record_cat_id='';
						if($_GET['record_id'] !='')
						{
							$record_cat_id="and receipt_id='".$_GET['record_id']."' ";
							
						}                     
                          	$sql_query= "SELECT * FROM receipt where 1 ".$record_cat_id." ".$_SESSION['where']." ".$pre_keyword." ".$from_date." ".$to_date." and category !='cash_transfer' ".$select_directory." "; 
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
  <?php
	if($_SESSION['type']=='S')
	{
	?>								
    <td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
	<?php } ?>
   <td width="5%" align="center"><strong>Sr. No.</strong></td>
    <td width="20%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=category".$query_string;?>" class="table_font"><strong>Category Name</strong></a> <?php echo $img1;?></td>
    <?php
	if($_SESSION['type']=="S")
	{
	?>
    <td width="15%"><strong>Branch Name</strong></td>
    <?php } ?>
    <td width="15%"><strong>Payment Mode</strong></td>
    <td width="15%"><strong>Bank Name</strong></td>
    <td width="15%"><strong>Chaque No</strong></td>
    <td width="15%"><strong>Chaque Date</strong></td>
    <td width="10%"><strong>Amount</strong></td>
    <td width="10%"><strong>Added date</strong></td>
    <!--<td width="15%"><strong>Tag</strong></td>
    <td width="20%" class="centerAlign"><strong>Image</strong></td>-->
	<?php
	if($_SESSION['type']=='S')
	{
	?>
    <td width="10%" class="centerAlign"><strong>Action</strong></td>
	<?php } ?>
  </tr>
                            <?php

                            while($val_query=mysql_fetch_array($all_records))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                
                                $listed_record_id=$val_query['receipt_id']; 
                                
                                include "include/paging_script.php";
                                
								
								
								$sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$val_query['payment_mode_id']."'";
								$ptr_payment_mode=mysql_query($sel_payment_mode);
								$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
								
								$sel_expense_type="select expense_type from expense_type where expense_type_id='".$val_query['expense_type_id']."'";
								$ptr_expense_type=mysql_query($sel_expense_type);
								$data_expense_type=mysql_fetch_array($ptr_expense_type);
								
								$sel_bank="select bank_name from bank where bank_id='".$val_query['bank_id']."'";
								$ptr_bank=mysql_query($sel_bank);
								$data_bank_name=mysql_fetch_array($ptr_bank);
								
								$sel_branch="select branch_name from site_setting where cm_id='".$val_query['cm_id']."'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
								
								
								
                                echo '<tr '.$bgcolor.' >';
								if($_SESSION['type']=='S')
								{
                                    echo'<td align="center">';	
									echo '<input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'">';
									echo'</td>';
								}
                                echo '<td align="center">'.$sr_no.'</td>';      
								if($_SESSION['type']=='S')
								{
									echo '<td ><a href="receipt.php?record_id='.$listed_record_id.'" class="table_font">'.$val_query['category'].'</a></td>';
								}
								else
									echo '<td >'.$val_query['category'].'</td>';
								if($_SESSION['type']=="S")
								{
									echo '<td >'.$data_branch['branch_name'].'</td>';
								}
								echo '<td >'.$data_payment_mode['payment_mode'].'</td>';
								
								echo '<td >'.$data_bank_name['bank_name'].'</td>';
								echo '<td >'.$val_query['chaque_no'].'</td>';
								echo '<td >'.$val_query['chaque_date'].'</td>';
                                echo '<td >'.$val_query['amount'].'</td>';
								echo '<td >'.$val_query['added_date'].'</td>';
								if($_SESSION['type']=='S')
								{
									echo '<td align="center"><a href="receipt.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
										  <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';

									echo '</td>';
								}
                                echo '</tr>';
                                                                
                                $bgColorCounter++;
                            }    
                                ?>
  
  
  <tr class="head_td">
    <td colspan="11">
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
<?php
if($_SESSION['type']=="S" && $record_id=='')
{
	?>
    <script>
	branch_name =document.getElementById("branch_name").value;
	//alert(branch_name);
	show_bank(branch_name);
	</script>
    <?php
}
if($record_id)
{
	if($row_record['category']=="voucher")
	{
		?>
        <script>
		
		category=document.getElementById("category").value;
		//alert(category);
		show_category(category);
		</script>
        <?php
	}

}
if($record_id || $_SESSION['type']=="S")
{
	?>
	 <script>
	vals= document.getElementById("payment_type").value;
	show_payment(vals);
	</script>
	<?php
}
?>
</body>
</html>
