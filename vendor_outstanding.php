<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php
if($_REQUEST['record_id'])
{
	$record_id=$_REQUEST['record_id'];
	$sele_record="select * from vendor where vendor_id='".$record_id."'";
	$ptr_record=mysql_query($sele_record);
	$data_record=mysql_fetch_array($ptr_record);
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
<title>Vendor Outstanding</title>
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
    var  pageName = "add_expense";
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
			document.getElementById("bank_ref_no").style.display = 'none';
			document.getElementById("paytm_details").style.display = 'none';
			
			show_bank_for_payment_mode(branch_name,"cheque")
		}
		else if(payment_mode[0]=="Credit Card")
		{
			document.getElementById("chaque_details").style.display = 'none';
			document.getElementById("bank_details").style.display = 'block';
			document.getElementById("credit_details").style.display = 'block';
			document.getElementById("bank_ref_no").style.display = 'none';
			document.getElementById("paytm_details").style.display = 'none';
			
			show_bank_for_payment_mode(branch_name,"credit_card")
			
		}
		else if(payment_mode[0]=="paytm")
		{
			document.getElementById("chaque_details").style.display = 'none';
			document.getElementById("bank_details").style.display = 'block';
			document.getElementById("credit_details").style.display = 'none';
			document.getElementById("bank_ref_no").style.display = 'none';
			document.getElementById("paytm_details").style.display = 'none';
			
			show_bank_for_payment_mode(branch_name,"paytm")
		}
		else if(payment_mode[0]=="online")
		{
			document.getElementById("bank_ref_no").style.display = 'block';
			document.getElementById("chaque_details").style.display = 'none';
			document.getElementById("bank_details").style.display = 'block';
			document.getElementById("credit_details").style.display = 'none';
			document.getElementById("paytm_details").style.display = 'none';
			
			show_bank_for_payment_mode(branch_name,"online")
		}
		else
		{
			document.getElementById("chaque_details").style.display = 'none';
			document.getElementById("bank_details").style.display = 'none';
			document.getElementById("credit_details").style.display = 'none';
			show_bank_for_payment_mode(branch_name,"")
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
	 	if(frm.amount.value=='')
		{
			 disp_error +='Plese Enter Amount\n';
			 document.getElementById('amount').style.border = '1px solid #f00';
			 frm.amount.focus();
			 error='yes';
		}
		if(frm.description.value=='')
		{
			 disp_error +='Plese Enter Description\n';
			 document.getElementById('description').style.border = '1px solid #f00';
			 frm.description.focus();
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
	if(document.getElementById("record_id"))
		record_id= document.getElementById("record_id").value;
	else
		record_id='';	
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

	var tax_data1="show_tax=1&branch_id="+branch_id;
	$.ajax({
	url: "show_tax_type.php",type:"post", data: tax_data1,cache: false,
	success: function(rettax)
	{
		//alert(rettax);
		document.getElementById("create_type1").innerHTML='';
		document.getElementById("res1").value=rettax;
	}
	});
}
function show_bank_for_payment_mode(branch_id,vals)
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
function calculte_amount_tax(val_tax_ids)
{
	tax_value='';
	tot_amount=0;
	var total_tax_length=document.getElementsByName("total_tax[]").length;
	if(val_tax_ids!=0 || total_tax_length!=0)
	{
		var total_tax=document.getElementsByName("total_tax[]").length;
		//alert(total_tax);
		tot_tax_amount=0;
		for(i=1;i<=total_tax;i++)
		{
			tax_id='tax_value'+i;
			tax_amount_id='tax_amount'+i;
			tax_value = Number(document.getElementById(tax_id).value);
		
			cost_tot_tt=parseInt(document.getElementById("amount_wo_tax").value);
			cal_tot_amount=cost_tot_tt * (tax_value/100);
			
			//document.getElementById(tax_amount_id).value=cal_tot_amount;
			$('#tax_amount'+i).val(cal_tot_amount);
			tot_tax_amount=parseInt(Number(tot_tax_amount) + Number(cal_tot_amount))
		}
		tot_amount=parseInt(cost_tot_tt + tot_tax_amount)
		$('#amount').val(tot_amount);
	}
	else
	{
		cost_tot_tt=parseInt(document.getElementById("amount_wo_tax").value);
		$('#amount').val(cost_tot_tt);
	}
	
}
function delete_tax(id,tax_types)
{
	//alert(id);
	if(confirm('Do you really want to delete record'))
	{
		$('#tax_type'+id).replaceWith(function(){
			return $('<input type="text" name="tax_type'+id+'" id="tax_type'+id+'" value="" />', {html: $(this).html()});
		});
		$('#tax_value'+id).replaceWith(function(){
			return $('<input type="text" name="tax_value'+id+'" id="tax_value'+id+'" value="" />', {html: $(this).html()});
		});
		$('#tax_amount'+id).replaceWith(function(){
			return $('<input type="text" name="tax_amount'+id+'" id="tax_amount'+id+'" value="" />', {html: $(this).html()});
		});
		if(tax_types=='total_type1')
		{  
			$('#type1_id'+id).hide();
			$('#del_floor_type1'+id).val('yes');
			tax_val=$('#tax_value'+id).val;
			//show_tax(tax_val);
			calculte_amount_tax(id);
		}
	}
}
</script>
<script language="javascript" src="js/script.js"></script>
<script language="javascript" src="js/conditions-script.js"></script>
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
    <td class="top_mid" valign="bottom"><?php include "include/product_category_menu.php";?></td>
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
				$sql_query= "SELECT outstand_id FROM enroll_outstanding where outstand_id ='".$del_record_id."'";
				if(mysql_num_rows($db->query($sql_query)))
				{
													
					"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('enroll outstanding','Delete','enroll_outstanding','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
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
		$sql_query= "SELECT outstand_id FROM enroll_outstanding where outstand_id='".$del_record_id."'";
		if(mysql_num_rows($db->query($sql_query)))
		{      
			"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('Enrol outstand','Delete','enroll_outstand','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
			$query=mysql_query($insert);     
								 
			$delete_query="delete from enroll_outstanding where outstand_id='".$del_record_id."'";
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
		$branch_name=$_POST['branch_name'];
		$category=$_POST['category'];
		$amount=( ($_POST['amount'])) ? $_POST['amount'] : "0";
		$description =$_POST['description'];
		$bank_ref_no=( ($_POST['bank_ref_no'])) ? $_POST['bank_ref_no'] : "0";
		
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
			$data_record['amount'] = $amount;
			$data_record['reason'] = $description;
			$cm_id=$data_record['cm_id'];
			
			$admin_id=$_SESSION['admin_id'];
			if($record_id)
			{
				/*"<br/>".$insert_for_outstand = "insert into enroll_outstanding (`enroll_id`,`type`,`amount`,`reason`,`added_date`,`cm_id`,`admin_id`) values('".$data_record['enroll_id']."','".$data_record['type']."','".$data_record['amount']."','".$data_record['reason']."','".$added_date."','".$cm_id."','".$_SESSION['admin_id']."')";
				$ptr_insert_outstand= mysql_query($insert_for_outstand);
				$out_ids=mysql_insert_id();*/
				
				$update="update vendor set wallet_balance=wallet_balance+".$amount.",description='".$description."' where vendor_id='".$record_id."'";
				$ptr_update=mysql_query($update);
				
				"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('Vendor Advance','Add','".$data_record['enroll_id']."','".$out_ids."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
				$query=mysql_query($insert);
				//------send notification on inquiry addition--------------------
				/*$notification_args['reference_id'] = $receipt_ids;
				$notification_args['on_action'] = 'receipt_payment';
				$notification_status = addNotifications($notification_args);
				*/
				
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
				setTimeout('document.location.href="manage_enroll_student.php?record_id=<?php echo $record_id; ?>";',1000);
				</script>
            	<?php
			}
			else
			{
			 	
				"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('Enroll Outstanding','Edit','".$data_record['enroll_id']."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
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
						   setTimeout('document.location.href="manage_vendor.php";',1000);
				</script>
            	<?php
			
				
			}
		}
	}
	?>
	
<form name="save" method="post">
<table cellspacing="3" cellpadding="3" style="border:1px solid #CCC; margin-top: 15px;" width="95%">
	<tr>
		<td width="15%" align="center">Date<input type="hidden" name="res1" id="res1" /></td>
		<td width="25%"><?php if($_POST['added_date']) echo $_POST['added_date']; else if($row_record['added_date']!=''){$arrage_date= explode('-',$row_record['added_date'],3);echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];}else{echo date("d/m/Y");}?>
        <input type="hidden"  style="width:200px" id="added_date" name="added_date" class="input_text datepicker" value="<?php if($_POST['added_date']) echo $_POST['added_date']; else if($row_record['added_date']!=''){$arrage_date= explode('-',$row_record['added_date'],3);echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];}else{echo date("d/m/Y");}?>" /><td></td>
		</td>
	</tr>
    
	 <!--<tr>
		<td width="15%" class="tr-header" align="center">Select Category<span class="orange_font">*</span></td>
		<td width="15%"><select name="category"  style="width:200px" class="input_text" id="category">
		<option value="select">--Select Type--</option>
		<option  value="outstanding" <?php //if($_POST['category']=="outstanding") echo 'selected="selected"'; elseif($row_record['category'] =="outstanding") echo 'selected="selected"'; ?>>Outstanding</option>
		<option value="pay_to_student" <?php //if($_POST['category']=="pay_to_student") echo 'selected="selected"'; elseif($row_record['category'] =="pay_to_student") echo 'selected="selected"'; ?>>Pay to student</option>
		</select></td>
	</tr>-->
	<tr>
		<td width="15%" class="tr-header" width="15%" align="center">Amount<span class="orange_font">*</span></td>
		<td width="25%"><input type="text" name="amount" id="amount" style="width:200px" class="input_text" value="<?php if($_POST['amount']) echo $_POST['amount']; else echo $row_record['amount']; ?>"  /></td>
	</tr>
	<tr>
		<td width="15%" class="tr-header" align="center">Reason<span class="orange_font">*</span></td>
		<td width="25%"><textarea name="description" id="description" style="width:300px;height:70px" class="input_text" ><?php if($_POST['description']) echo $_POST['description']; else echo $row_record['description']; ?></textarea></td>
	</tr>
	<tr>
		<?php
		$select_amnt1="select SUM(amount) as total from enroll_outstanding where 1 and enroll_id='".$record_id."' and type='outstanding' order by outstand_id";
		$ptr_amt1=mysql_query($select_amnt1);
		$total_amount1=0;
		if(mysql_num_rows($ptr_amt1))
		{
			$data_amnt1=mysql_fetch_array($ptr_amt1);
			$total_outstand=$data_amnt1['total'];
		}
		$select_amnt2="select SUM(amount) as total from enroll_outstanding where 1 and enroll_id='".$record_id."' and type='pay_to_student' order by outstand_id";
		$ptr_amt2=mysql_query($select_amnt2);
		$total_amount1=0;
		if(mysql_num_rows($ptr_amt2))
		{
			$data_amnt2=mysql_fetch_array($ptr_amt2);
			$total_pay=$data_amnt2['total'];
		}
		?>
		<td align="center" colspan="2"><input type="submit" onclick="return validme()" name="save_changes" value="Save"  /> <span>Total Outstand : <?php echo $total_outstand; ?></span>&nbsp;&nbsp;&nbsp; <span>Total Pay : <?php echo $total_pay; ?></span></td>
	</tr>
</table>
</form>

<table cellspacing="0" cellpadding="0" class="table" width="95%">
  <!--<tr class="head_td">
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
  </tr>-->
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
							
							
							$pre_keyword =" and (type like '%".$keyword."%' ".$cm_id_filter." || amount like '%".$keyword."%')";
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
                            $select_directory='order by outstand_id desc';  
							
						             
                        $sql_query= "SELECT * FROM enroll_outstanding where 1 ".$_SESSION['where']." ".$pre_keyword." ".$from_date." ".$to_date." ".$select_directory." "; 
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
  <!--<tr class="grey_td" >
  <?php
	if($_SESSION['type']=='S')
	{
		?>								
		<td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
		<?php 
	}
	?>
   	<td width="5%" align="center"><strong>Sr. No.</strong></td>
    <td width="15%"><strong>Type</strong></td>
    <td width="15%"><strong>Amount</strong></td>
    <td width="30%"><strong>Reason</strong></td>
    <td width="15%"><strong>Added date</strong></td>
	<?php
	if($_SESSION['type']=='S')
	{
	?>
    <td width="10%" class="centerAlign"><strong>Action</strong></td>
	<?php } ?>
  </tr>-->
                            <?php

                            while($val_query=mysql_fetch_array($all_records))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                
                                $listed_record_id=$val_query['outstand_id']; 
                                include "include/paging_script.php";
                                
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
								
								echo '<td >'.$val_query['type'].'</td>';
                                echo '<td >'.$val_query['amount'].'</td>';
								echo '<td >'.$val_query['reason'].'</td>';
								echo '<td >'.$val_query['added_date'].'</td>';
								if($_SESSION['type']=='S')
								{
									echo '<td align="center"><a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';

									echo '</td>';
								}
                                echo '</tr>';
                                                                
                                $bgColorCounter++;
                            }    
                                ?>
  
  
  <!--<tr class="head_td">
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
    </tr>--></form>
      <?php } 
      //else
        //echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No category found related to your search criteria, please try again</div><br></td></tr>';?>
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
?>
<script>
branch_name =document.getElementById("branch_name").value;
//alert(branch_name);
show_bank(branch_name);
//alert(branch_name);
</script>
   
</body>
</html>
