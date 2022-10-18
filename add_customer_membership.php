<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM customer where cust_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
	
	///echo $row_record['cust_id'];
	$sel_payment_mode1="select payment_mode from payment_mode where payment_mode_id='".$row_record['payment_mode_id']."'";
	$ptr_payment_mode1=mysql_query($sel_payment_mode1);
	$data_payment_mode1=mysql_fetch_array($ptr_payment_mode1);
	$pay_mode=trim($data_payment_mode1['payment_mode']);
	
	$sel_acc_no="select account_no,bank_name from bank where bank_id='".$row_record['bank_id']."'";
	$ptr_bank_id=mysql_query($sel_acc_no);
	$data_bank_id=mysql_fetch_array($ptr_bank_id);
}
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='122'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?>Customer Membership</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
    </script>
<!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <link rel="stylesheet" href="js/chosen.css" />
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
	pageName='';
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
			$("#customer_id").chosen({allow_single_deselect:true});
			$("#membership_id").chosen({allow_single_deselect:true});
			$("#realtxt").chosen({allow_single_deselect:true});
        });
    </script>
<script>
mail1=Array();
<?php
$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='122' ".$_SESSION['where']."";
$ptr_sel_sms=mysql_query($sel_sms_cnt);
$tot_num_rows=mysql_num_rows($ptr_sel_sms);
$i=0;
while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
{
	"<br/>".$sel_act="select email from site_setting where admin_id='".$data_sel_cnt['staff_id']."' ".$_SESSION['where']."";
	$ptr_cnt=mysql_query($sel_act);
	if(mysql_num_rows($ptr_cnt))
	{
		$data_cnt=mysql_fetch_array($ptr_cnt);
		?>
		mail1[<?php echo $i; ?>]='<?php echo  $data_cnt['email'];?>';
		<?php
		$i++;
	}
}
if($_SESSION['type']!='S')
{
	"<br/>".$sel_act="select contact_phone,email from site_setting where type='S'";
	$ptr_cnt=mysql_query($sel_act);
	if(mysql_num_rows($ptr_cnt))
	{
		$j=$tot_num_rows;
		while($data_cnt=mysql_fetch_array($ptr_cnt))
		{
			?>
			mail[<?php echo $j; ?>]='<?php echo  $data_cnt['email'];?>';
			<?php
			$j++;
		}
	}
}
"<br/>".$sel_mail_text="select email_text from previleges where privilege_id='122'";
$ptr_mail_text=mysql_query($sel_mail_text);
if($tot_mail_text=mysql_num_rows($ptr_mail_text))
{
	$data_mail_text=mysql_fetch_array($ptr_mail_text);
	?>
	email_text_msg='<?php echo  urlencode($data_mail_text['email_text']);?>';
	<?php
}
?>
//alert(mail1);
function send()
	{
		//alert('hi');
		  branch=document.getElementById('branch_name');
	     var branch_name=branch.options[branch.selectedIndex].text;
		// alert(branch_name);
		 
		var realtxt =document.getElementById('realtxt').value;
		var mail =document.getElementById('mail').value;
		 //alert(realtxt);
		   
		customer =document.getElementById('customer_id');
		var customer_id=customer.options[customer.selectedIndex].text;
		//alert(customer_id);
		membership =document.getElementById('membership_id');
		var membership_id=membership.options[membership.selectedIndex].text;
		
		//alert(membership_id);
		var memb_disc =document.getElementById('memb_disc').value;
		//alert(memb_disc);
		var dayss =document.getElementById('days').value;
		//alert(dayss);
		var start_date =document.getElementById('start_date').value;
		//alert(start_date);
		var end_date =document.getElementById('end_date').value;
		//alert(end_date);
		var payment_mode =document.getElementById('payment_mode').value;
		//alert(payment_mode);
		 bank =document.getElementById('bank_name');
	     //alert(bank);
	      var  bank_details=bank.options[bank.selectedIndex].text;
		var account_no =document.getElementById('account_no').value;
	    //alert(account_no);
		var chaque_details =document.getElementById('chaque_no').value;
		//alert(chaque_details);
		var cheque_date =document.getElementById('cheque_date').value;
		//alert(cheque_date);
		//var credit_details =document.getElementById('credit_details').value;
		//alert(credit_details);
		var credit_card_no =document.getElementById('credit_card_no').value;
		//alert(credit_card_no);
		var vouchers_name=document.getElementById('vouchers_name').value;
		
		var vouchers_start_date =document.getElementById('vouchers_start_date').value;
		//alert(vouchers_start_date);
		var vouchers_end_date =document.getElementById('vouchers_end_date').value;
		//alert(vouchers_end_date);
		var vouchers_price =document.getElementById('vouchers_price').value;
		//alert(vouchers_price);
		var totals_price =document.getElementById('totals_price').value;
		//alert(totals_price);
		
		var remaining_voucher =document.getElementById('remaining_voucher').value;
		//alert(remaining_voucher);
		var amount =document.getElementById('amount').value;
		//alert(amount);
		var users_mail=mail1;
		
		data1='action=add_customer_membership&branch_name='+branch_name+'&realtxt='+realtxt+'&customer_id='+customer_id+'&membership_id='+membership_id+'&memb_disc='+memb_disc+'&dayss='+dayss+'&start_date='+start_date+'&end_date='+end_date+'&payment_mode='+payment_mode+'&bank_details='+bank_details+'&account_no='+account_no+'&chaque_details='+chaque_details+'&cheque_date='+cheque_date+'&credit_card_no='+credit_card_no+'&vouchers_name='+vouchers_name+'&vouchers_start_date='+vouchers_start_date+'&vouchers_end_date='+vouchers_end_date+'&vouchers_price='+vouchers_price+'&totals_price='+totals_price+'&amount='+amount+'&users_mail='+users_mail+'&mail='+mail+"&email_text_msg="+email_text_msg;
		alert(data1);
		$.ajax({
		url:'http://www.htdpt.in/tracking/send_email.php',type:"post",data:data1,cache:false,crossDomain:true, async:false,
		  success: function(response) {
			 alert(response);
	 return true;
  }
              });
			  
	

		   
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
		document.getElementById("voucher_no").style.display = 'none';
		
		show_bank(branch_name,"cheque")
	}
	else if(payment_mode[0]=="Credit Card")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'block';
		document.getElementById("voucher_no").style.display = 'none';
		show_bank(branch_name,"credit_card")
		
	}
	else if(payment_mode[0]=="paytm")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		document.getElementById("voucher_no").style.display = 'none';
		show_bank(branch_name,"paytm")
	}
	else if(payment_mode[0]=="voucher")
	{
		//alert(payment_mode[0]);
		var cust_id=document.getElementById("customer_id").value;
		//alert(cust_id);
		var data="action=check_voucher_id&cust_id="+cust_id+"&record_id="+record_id;
		$.ajax({
			url:"ajax.php", type:"post", data:data, cache:false,
			success : function(html)
			{
				sep=html.split("###");
				voucher=sep[0].trim();
				deals=sep[1].trim();
				//alert(html);
				if(voucher !='')
				{
					document.getElementById("voucher_no").style.display = 'block';
					document.getElementById("chaque_details").style.display = 'none';
					document.getElementById("bank_details").style.display = 'none';
					document.getElementById("credit_details").style.display = 'none';
					document.getElementById("voucher_no").innerHTML= deals;
					document.getElementById("voucher_div_id").style.display = 'block';
					
					voucher_id=document.getElementById("voucher_deal_id").value;
					show_voucher_details(voucher_id)
				}
				
				else
				{
					alert("Voucher is Not added for this customer. Please buy voucher first");
					document.getElementById("payment_mode").selectedIndex=0;
				}
			}
		});
		show_bank(branch_name,"voucher")
	}
	else
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'none';
		document.getElementById("credit_details").style.display = 'none';
		document.getElementById("voucher_no").style.display = 'none';
		show_bank(branch_name,"")
	}
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
		//alert(html);
		 document.getElementById('account_no').value=html;
	}
	});
}
function show_bank(branch_id,vals)
{
	//document.getElementById("bank_record").style.display="none";
	record_id= document.getElementById("record_id").value;
	var bank_data="action=customer&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
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
	/*var tax_data="show_tax=1&branch_id="+branch_id;
	//alert(tax_data);
	$.ajax({
	url: "show_tax.php",type:"post", data: tax_data,cache: false,
	success: function(rettax)
	{
		var taxes=rettax.split('-');
		service_tax= taxes[0];
		installment_tax= taxes[1];
		document.getElementById("service_tax_id").innerHTML=service_tax;
		//alert(service_tax);
		//document.getElementById("inst_tax_id").innerHTML=installment_tax;
		
		document.getElementById("service_taxes").value=service_tax;
		//document.getElementById("inst_taxes").value=installment_tax;
		//alert("service tax- "+service_tax);
	}
	
	});*/
}


function getMembership(membership_id)
{
	
				
	var data1="membership_id="+membership_id;	
	//alert(data1);
        $.ajax({
            url: "get_membership_discount.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				//alert(html);
				
				if(html.trim() =='')
				{
					document.getElementById('membership_ids').style.display="none";
					
				}
				else
				{
					document.getElementById('membership_ids').style.display="block";
					var sep_val=html.split("-",3);
					var memb_disc= sep_val[0].trim();
					var amount= sep_val[1].trim();
					var days= sep_val[2].trim();
					
					document.getElementById('memb_disc').innerHTML=memb_disc;
					document.getElementById('memb_disc').value=memb_disc;
					document.getElementById("amount").value=amount;
					document.getElementById("days").value=days;
					document.getElementById("dayss").innerHTML=days;
					if(document.getElementById("voucher_deal_id"))
					{
						voucher_id= document.getElementById("voucher_deal_id").value;
						show_voucher_details(voucher_id);
					}
						
				}
            }
            });
	
}

function show_mobile_no(cust_ids)
{
	var data2="customer_id="+cust_ids;
	//alert(data2);
	 $.ajax({
	url: "get_mail.php", type: "post", data: data2, cache: false,
	success: function (html)
	{
			//alert(html);
			//var mail= sep_val[0].trim();
			document.getElementById('mail').value=html;
			 //$("#cus").html(data);
			
	}
	});
}
function validme()
{
 frm = document.jqueryForm;
 error='';
 disp_error = 'Clear The Following Errors : \n\n';
 if(frm.cust_id.value=='')
 {
	 disp_error +='Select Customer\n';
	 document.getElementById('customer_id').style.border = '1px solid #f00';
	 frm.customer_id.focus();
	 error='yes';
 }
 
 if(frm.membership_id.value=='')
 {
	 disp_error +='Select Membership \n';
	 document.getElementById('membership_id').style.border = '1px solid #f00';
	 frm.membership_id.focus();
	 error='yes';
 }
 
 if(frm.start_date.value=='')
 {
	 disp_error +='Enter Start Date   \n';
	 document.getElementById('start_date').style.border = '1px solid #f00';
	 frm.start_date.focus();
	 error='yes';
 }
  
 if(frm.end_date.value=='')
 {
	 disp_error +='Enter End Date\n';
	 document.getElementById('end_date').style.border = '1px solid #f00';
	 frm.end_date.focus();
	 error='yes';
 }
  

 if(frm.payment_mode.value=='')
 {
	 disp_error +='Select Payment Mode \n';
	 document.getElementById('payment_mode').style.border = '1px solid #f00';
	 frm.payment_mode.focus();
	 error='yes';
 }
 

 if(frm.amount.value=='')
 {
	 disp_error +='Enter Amount \n';
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
 {
	 alert('hi');
	return send();
	
  }
      return true;
 
}


function getdate() {
    var tt = document.getElementById('start_date').value;
	sep = tt.split("/");
	var tt=sep[1]+"/"+sep[0]+"/"+sep[2];
	
	var days = Number(document.getElementById('days').value);
    var date = new Date(tt);
    var newdate = new Date(date);
    newdate.setDate(newdate.getDate() + days);
    var dd = newdate.getDate();
    var mm = newdate.getMonth() + 1;
    var y = newdate.getFullYear();
    var someFormattedDate = dd + '/' + mm + '/' + y;
    document.getElementById('end_date').value = someFormattedDate;
}


function searchSel(value) 
{
	var data1="action=membership&mobile_no="+value;	
	$.ajax({
	url: "get_name.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		if(html.trim()!='')
		{
			sep=html.split("###");
			/*$( "#customer_id_chosen").toggleClass("chosen-with-drop chosen-container-active");
			$( "#customer_id").find("[data-option-array-index="+html+"]").toggleClass("result-selected");*/
			document.getElementById("sel_cust").innerHTML=sep[1];
			$("#customer_id").chosen({allow_single_deselect:true});
			/*$("#customer_id option").removeAttr("selected");
			$("#customer_id option[value="+html+"]").attr("selected", "selected");
			*/
			
			setTimeout(getMembership(sep[0].trim()),500);
			//alert(html);
			document.getElementById("mail").value=sep[2];
		}
	}
	});
} 
	
/*function searchSel() {
  var input=document.getElementById('realtxt').value.toLowerCase();
  
  var output=document.getElementById('cust_id').options;
  
  for(var i=0;i<output.length;i++) {
    if(output[i].value.indexOf(input)==0){
      output[i].selected=true;
    }
    if(document.getElementById('realtxt').value==''){
      output[0].selected=true;
    }
  }
}*/
function show_voucher_details(value)
{
	voucher_id=value;
	cust_id=document.getElementById("customer_id").value;
	
	var data="voucher_id="+voucher_id+"&cust_id="+cust_id;
	$.ajax({
	url:"get_voucher_details.php", type:"post", data:data,cache:false,
	success:function(html)
	{
		//alert(html);
		var new_html=html.split("###");
		if(new_html[0].trim() =='')
		{
			document.getElementById('voucher_div_id').style.display="none";
		}
		else
		{
			document.getElementById('voucher_div_id').style.display="block";
			var sep_val=new_html[0].split("/",4);
			var name= sep_val[0].trim();
			var price= sep_val[1].trim();
			var start_date= sep_val[2].trim();
			var end_date= sep_val[3].trim();
			
			document.getElementById('voucher_name').innerHTML=name;
			document.getElementById("vouchers_name").value=name;
			document.getElementById("voucher_price").innerHTML=price;
			document.getElementById("vouchers_price").value=price;
			document.getElementById("voucher_start_date").innerHTML=start_date;
			document.getElementById("vouchers_start_date").value=start_date;
			document.getElementById("voucher_end_date").innerHTML=end_date;
			document.getElementById("vouchers_end_date").value=end_date;
			
			document.getElementById("voucher_prices").innerHTML=price;
			var amnt=document.getElementById("amount").value;
			document.getElementById("amount_prices").innerHTML=amnt;
			
			total=Number(price)-Number(amnt);
			document.getElementById("total_price").innerHTML=Math.abs(total);
			document.getElementById("totals_price").value=Math.abs(total);
			//var amount=document.getElementById("amount").value;
			
			if(total < 0)
			{
				document.getElementById("amount").value=Math.abs(total);
			}
			else
			{
				document.getElementById("amount").value=0;
				document.getElementById("remaining_voucher").value=Math.abs(total);
			}
		}
	}	
	});
}

</script>
 <!--<link href="newjs/select2.css" rel="stylesheet"/>
 
<script src="newjs/jquery-1.8.0.min.js"></script>
    <script src="newjs/select2.js"></script>
    <script>
	$.noConflict();
	jQuery( document ).ready(function( $ ) {
	  jQuery("#cust_id").select2();   
	});
      
    </script> -->
<!--<link rel="stylesheet" href="js/chosen.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
<script src="js/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript"> 
var $j = jQuery.noConflict();
	$j(document).ready(function(){
	$j("#cust_id").chosen({allow_single_deselect:true});
	$j("#membership_id").chosen({allow_single_deselect:true});
});
</script>-->
</head>
<body>
<?php include "include/header.php";?>
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
    <td class="top_mid" valign="bottom"><?php include "include/services_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
        <table width="100%" cellspacing="0" cellpadding="0">
            
        <?php
                        $errors=array(); $i=0;
                        $success=0;
                        if($_POST['save_changes'])
                        {
							$branch_name=( ($_POST['branch_name'])) ? $_POST['branch_name'] : "";
                          	//$cust_id=$_POST['customer_id'];
							$cust_id=( ($_POST['customer_id'])) ? $_POST['customer_id'] : "0";
                            //$membership_id=$_POST['membership_id'];  
							$membership_id=( ($_POST['membership_id'])) ? $_POST['membership_id'] : "0";
							if($_POST['start_date'] !='')
							{
								$start_date=$_POST['start_date'];
								$tan_date = explode('/',$start_date);
								$start_date=$tan_date[2].'-'.$tan_date[1].'-'.$tan_date[0];
							}
							else
								$start_date='';
							if($_POST['end_date'] !='')
							{
								$end_date=$_POST['end_date'];
								$tan_dates = explode('/',$end_date);
								$end_date=$tan_dates[2].'-'.$tan_dates[1].'-'.$tan_dates[0];
							}
							else
								$end_date='';
							
							$bank_name='0';
							$chaque_no='';
							$date='';
							$credit_card_no='';
							$voucher_number='';
							$voucher_deal_id='0';
							
							$payment_mode="";
							$payment_mode_id="0";
							//$payment_mode=$_POST['payment_mode'];
							if($_POST['payment_mode'] !='')
							{
								$payment_mode=$_POST['payment_mode'];
								$sep=explode("-",$payment_mode);
								$payment_mode_id=$sep[1];
							}
							//$amount=$_POST['amount'];
							$amount=( ($_POST['amount'])) ? $_POST['amount'] : "";
							//$remaining_voucher=$_POST['remaining_voucher'];
							$remaining_voucher=( ($_POST['remaining_voucher'])) ? $_POST['remaining_voucher'] : "";
							if($payment_mode_id =="6")
							{
								$voucher_number=$_POST['voucher_number'];
								$voucher_deal_id=$_POST['voucher_deal_id'];
							}
							if($payment_mode_id !="1" || $payment_mode_id !="3" ||$payment_mode_id !="5")
							{
								$bank_name=( ($_POST['bank_name'])) ? $_POST['bank_name'] : "0";
								$chaque_no=( ($_POST['chaque_no'])) ? $_POST['chaque_no'] : "";
								$credit_card_no=( ($_POST['credit_card_no'])) ? $_POST['credit_card_no'] : "";
								$chaque_date=( ($_POST['cheque_date'])) ? $_POST['cheque_date'] : "";
							}
							
							if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
							{
								$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
								$cm_id=$data_branch['cm_id'];
								$branch_name1=$branch_name;
								$data_record['cm_id']=$cm_id;
							}	
							else
							{
								$branch_name1=$_SESSION['branch_name'];
								$data_record['cm_id']=$_SESSION['cm_id'];
							}
							 
							if($record_id=='')
							 {
								  $sel_cat="select cust_id,membership_id from customer where cust_id ='".$cust_id."' and membership_id='".$membership_id."' and status='inactive' ";
								  $ptr_cat=mysql_query($sel_cat);
								  $count_cust_id=mysql_num_rows($ptr_cat);
								 
								  if($count_cust_id)
								  {
									$success=0;
									$errors[$i++]="Mebership already Exist.";
								  }
							 }
							
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
                                $data_record['membership'] ="yes";
                                $data_record['membership_id'] =$membership_id;
								$data_record['start_date'] =$start_date;
								$data_record['end_date'] =$end_date;
								$data_record['price'] =$amount;
								
								$data_record['payment_mode_id'] =$payment_mode_id;
								$data_record['chaque_no'] =$chaque_no;
								$data_record['chaque_date'] =$chaque_date;
								$data_record['credit_card_no'] =$credit_card_no;
								$data_record['bank_id'] =$bank_name;
								$data_record['added_date'] =date("Y-m-d H:i:s");
								$data_record['voucher_number'] =$voucher_number;
								$data_record['voucher_deal_id'] =$voucher_deal_id;
								$data_record['memb_added_by'] =$_SESSION['admin_id'];
								
								
								$data_record_sales['status'] ="inactive";
								
								if($remaining_voucher >0)
								{
									$data_record_sales['amount'] =$remaining_voucher;
									$data_record_sales['status'] ="active";
								}
                               	if($record_id)
                                {
                                    $where_record=" cust_id='".$cust_id."'";
                                    $db->query_update("customer", $data_record,$where_record);
									
                                    $where_record="cust_id='".$record_id."' and voucher_id='".$voucher_deal_id."'";
                                    $db->query_update("sales_package_voucher_memb", $data_record_sales,$where_record);
									
									$sql_query= "SELECT cust_id,cust_name FROM customer where cust_id='".$cust_id."'";
									$ptr_query=mysql_query($sql_query);
									$data_cust=mysql_fetch_array($ptr_query);   
										
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_cust_membership','Edit','".$data_cust['cust_name']."','".$record_id."','".date('Y-m-d H:i:s')."','".$data_record['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);  
							
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
									$where_record=" cust_id='".$cust_id."'";
                                   	$db->query_update("customer", $data_record,$where_record);
									
									$where_record="cust_id='".$cust_id."' and voucher_id='".$voucher_deal_id."'";
                                    $db->query_update("sales_package_voucher_memb", $data_record_sales,$where_record);
									
									$sql_query= "SELECT cust_id,cust_name,rewards_point FROM customer where cust_id='".$cust_id."'";
									$ptr_query=mysql_query($sql_query);
									$data_cust=mysql_fetch_array($ptr_query);   
										
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_cust_membership','Add','".$data_cust['cust_name']."','".$record_id."','".date('Y-m-d H:i:s')."','".$data_record['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert); 
							
							
									
									$selct_rpc="SELECT * FROM `reward_point_config` where cm_id='".$data_record['cm_id']."'";
									$ptr_rpc=mysql_query($selct_rpc);
									$data_rpc=mysql_fetch_array($ptr_rpc);	
									
									$rpc=$amount/$data_rpc['rupees'];
									$total_rp=$rpc*$data_rpc['reward_point'];
									
									$total_rewards_pt=$data_cust['rewards_point']+$total_rp;
									
									$update_cust="update customer set rewards_point=".$total_rewards_pt." where cust_id='".$cust_id."'";
									$ptr_reward=mysql_query($update_cust);
									
									
									$name=$data_cust_name['cust_name'];
									$contact=$data_cust_name['mobile1'];
									$mesg ="Hi ".$name." your membership is add";
									$sel_inq="select sms_text from previleges where privilege_id='122'";
									$ptr_inq=mysql_query($sel_inq);
									$txt_msg='';
									if(mysql_num_rows($ptr_query))
									{
										$dta_msg=mysql_fetch_array($ptr_inq);
										$txt_msg=$dta_msg['sms_text'];
									}
									$messagessss =$mesg.$txt_msg;
									"<br/>".$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='122' ".$_SESSION['where']."";
									$ptr_sel_sms=mysql_query($sel_sms_cnt);
									while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
									{
										"<br/>".$sel_act="select contact_phone from site_setting where admin_id='".$data_sel_cnt['staff_id']."' ".$_SESSION['where']."";
										$ptr_cnt=mysql_query($sel_act);
										if(mysql_num_rows($ptr_cnt))
										{
											$data_cnt=mysql_fetch_array($ptr_cnt);
											send_sms_function($data_cnt['contact_phone'],$messagessss);
										}
									}
									if($_SESSION['type']!='S' )
									{
										"<br/>".$sel_act="select contact_phone from site_setting where type='S' ";
										$ptr_cnt=mysql_query($sel_act);
										if(mysql_num_rows($ptr_cnt))
										{
											while($data_cnt=mysql_fetch_array($ptr_cnt))
											{
												send_sms_function($data_cnt['contact_phone'],$messagessss);
											}
										}
									}
									send_sms_function($contact,$messagessss);
									
									
									
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                                }
                            }
                        }
                        if($success==0)
                        {
                        
                        ?>
						<script>
						/*$(document).ready(function(){
							
										$('#save_changes').click(function(){
											return send1();
										});
									});*/
						</script>
            <tr><td>
   <form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data" onSubmit="return validme();">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
                <input type="hidden" name="record_id" id="record_id" value="<?php if($_REQUEST['record_id']) { echo $record_id ;} ?>"  />
                </tr>
                
                 <?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
						{
					?>
					  <tr>
						<td>Select Branch</td>
						<td>

						<?php 
						if($_REQUEST['record_id'])
						{
						$sel_cm_id="select branch_name from site_setting where cm_id=".$row_record['cm_id']." ";
						$ptr_query=mysql_query($sel_cm_id);
						$data_branch_nmae=mysql_fetch_array($ptr_query);
						}
						$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
						$query_branch = mysql_query($sel_branch);
						$total_Branch = mysql_num_rows($query_branch);
						echo '<table width="100%"><tr><td>'; 
						echo ' <select id="branch_name" name="branch_name" onchange="show_bank(this.value)">';
						while($row_branch = mysql_fetch_array($query_branch))
						{
							?>
							<option value="<?php echo $row_branch['branch_name'];?>" <?php if ($_POST['branch_name'] ==$row_branch['branch_name']) echo 'selected="selected"'; else if($row_branch['branch_name']==$data_branch_nmae['branch_name']) echo 'selected="selected"' ?> /><?php echo $row_branch['branch_name']; ?> 

							</option>
							<?php
						}
							echo '</select>';
							echo "</td></tr></table>";
							?>
					</td>
				</tr>
				<?php }  else { ?>
                       <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                       <?php }?>
            <tr>
            	<td>Search by Mobile no.</td>
            	<td>
                	<select id="realtxt" name="realtxt" onChange="searchSel(this.value)">
                    <option value="">Select Mobile No.</option>
                    <?php  
					
                        $sql_cust = "select mobile1,cust_id,email from customer where 1 ".$_SESSION['where']." order by cust_id asc";
                        $ptr_cust = mysql_query($sql_cust);
                        while($data_cust = mysql_fetch_array($ptr_cust))
                        { 
								
                                $selecteds = '';
                                if($data_cust['cust_id']==$row_record['customer_id'])
                                $selecteds = 'selected="selected"';	
                            echo "<option value='".$data_cust['mobile1']."' ".$selecteds.">".$data_cust['mobile1']."</option>";
        
                        }
                        ?>
                    </select>
                    
                </td>
            </tr> 
            <tr>
                  <td width="15%" valign="top">Select Customer <span class="orange_font">*</span></td>
                  <td width="50%" id="sel_cust">
                  <select name="customer_id" id="customer_id" class="chzn-select" onChange="show_mobile_no(this.value)">  
                        <option value=""> Select Customers</option>
                        <?php
                            $select_category = "select cust_id,cust_name,mobile1,email from customer where 1  and (membership IS NULL or membership='' or  membership='no' or end_date < '".date('Y=m-d')."') ".$_SESSION['where']." order by cust_id desc";
                            $ptr_category = mysql_query($select_category);
							
                            while($data_category = mysql_fetch_array($ptr_category))
                            {
                                if($data_category['cust_id'] == $row_record['cust_id'])
								{
                                    echo '<option value='.$data_category['cust_id'].' selected="selected">'.$data_category['cust_name'].'</option>';
								}
                                else
                                    echo '<option value='.$data_category['cust_id'].'>'.$data_category['cust_name'].'</option>';
								//echo '<input type="hidden" name="mobile_no" id="mobile_no" value="'.$data_category['mobile1'].'" >';
                            }
                            ?>
                   </select>
                   
                  </td> 
                  <td width="10%"><input type="hidden" name="mail" id="mail" value=""  /></td>
              </tr>
           <tr>
            <td width="15%" valign="top">Select Membership <span class="orange_font">*</span></td>
             <td width="50%">
             <select name="membership_id" id="membership_id"  onChange="getMembership(this.value)">  
                        <option value=""> Select Membership</option>
                        <?php
                            $select_category = "select membership_id,membership_name from membership order by membership_id desc";
                            $ptr_category = mysql_query($select_category);
							
                            while($data_category = mysql_fetch_array($ptr_category))
                            {
                                if($data_category['membership_id'] == $row_record['membership_id'])
                                    echo '<option value='.$data_category['membership_id'].' selected="selected">'.$data_category['membership_name'].'</option>';
                                else
                                    echo '<option value='.$data_category['membership_id'].'>'.$data_category['membership_name'].'</option>';
                            }
                            ?>
                                   
                    </select>
             </td> 
              <td width="10%"></td>

            </tr>
            
            <tr>
                <td width="20%" valign="top" colspan="3">
                <div id="membership_ids" >
                <table style="width:100%">
					<tr>
					<td width="6%">Membership Details</td>
					<td width="23%">Discount(in %) : <span id="memb_disc"></span><input type="hidden" name="memb_disc" id="memb_disc" value="" /></td>
					</tr>
                    <tr>
					<td width="6%"></td>
					<td width="23%">Days : <span id="dayss"></span><input type="hidden" name="days" id="days" value="" /></td>
					</tr>
                </table>
                </div>
                </td>
            </tr>
            
            <tr>
            <td width="15%" valign="top">Start Date <span class="orange_font">*</span></td>
            	<td width="70%"><input type="text"  class=" input_text datepicker" name="start_date" onChange="getdate()" id="start_date" value="<?php if($_POST['save_changes']) echo $_POST['start_date']; else echo $row_record['start_date'];?>" /></td> 
            	<td width="10%"></td>

            </tr>    
            <tr>
                <td width="20%" valign="top">End Date <span class="orange_font">*</span></td>
                <td width="70%"><input type="text"  class=" input_text datepicker" name="end_date" id="end_date" value="<?php if($_POST['save_changes']) echo $_POST['end_date']; else echo $row_record['end_date'];?>" /></td> 
                <td width="10%"></td>
            </tr>
               <!---------------------------------------Payment mode------------------------------------->  
            <tr>
            	<td class="tr-header">Select Payment Mode <span class="orange_font">*</span></td>
                <td width="25%"><select name="payment_mode" id="payment_mode" onChange="payment(this.value)" >
                <option value="">--Select--</option>
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
                    <td colspan="2">
                    
                    <div id="bank_details" <?php  if($data_payment_mode1['payment_mode']=='Credit Card' || $data_payment_mode1['payment_mode']=='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
                         <table width="100%">
                         <tr>
                         <td width="21%" class="tr-header" >Bank Name</td>
                         
                         <td>
            <?php 
            /*if($_SESSION['type'] !="S")
            {
            ?>
             <select name="bank_name" id="bank_name" onChange="show_acc_no(this.value)">
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
             }*/
             ?>
             <div id="bank_record">
            <?php 
            /*if($record_id !='')
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
             }*/
             ?></div>
             <div id="bank_id"></div>
             </td>
         </tr>
         <tr>
             <td class="tr-header" width="23%">Account No</td>
             <td><input type="text" name="account_no" readonly="readonly" id="account_no" value="<?php if($_POST['account_no']) echo $_POST['account_no']; else echo $data_bank_id['account_no']; ?>" /></td>
         </tr>
      </table>
    </div>
    <div id="chaque_details" <?php  if($data_payment_mode1['payment_mode']=='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
     <table width="100%">
     	<tr>
     		<td class="tr-header" width="23%">Enter Chaque No</td>
     		<td><input type="text" name="chaque_no" id="chaque_no" value="<?php if($_POST['chaque_no']) echo $_POST['chaque_no']; else echo $row_record['chaque_no']; ?>" /></td>
     	</tr>
     	<tr>
     		<td class="tr-header" width="23%">Enter Chaque Date</td>
     		<td><input type="text" name="cheque_date" id="cheque_date" class="datepicker" value="<?php if($_POST['cheque_date']) echo $_POST['cheque_date']; else echo $row_record['chaque_date']; ?>"  /></td>
     	</tr>
    </table>
    </div>
    <div id="credit_details" <?php  if($data_payment_mode1['payment_mode']=='Credit Card') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
    <table width="100%">
    	<tr>
    		<td class="tr-header" width="23%">Enter Credit Card No</td>
    		<td><input type="text" name="credit_card_no" id="credit_card_no" maxlength="4" value="<?php if($_POST['credit_card_no']) echo $_POST['credit_card_no']; else echo $row_record['credit_card_no']; ?>" /></td>
    	</tr>
    </table>
    </div>
    <div id="voucher_no"></div>
    </td>
   </tr>
   <tr>
       <td colspan="3">
            <div id="voucher_div_id" style="display:none">
                <table style="width:100%">
                    <tr>
                        <td width="6%">Voucher Details</td>
                        <td width="23%">Voucher Name : <span id="voucher_name"></span><input type="hidden" name="vouchers_name" id="vouchers_name" value="" /></td>
                    </tr>
                    <tr>
                        <td width="6%">
                        </td><td width="23%">Start Date : <span id="voucher_start_date"></span><input type="hidden" name="vouchers_start_date" id="vouchers_start_date" value="" /></td>
                    </tr>
                    <tr>
                        <td width="6%"></td>
                        <td width="23%">End Date : <span id="voucher_end_date"></span><input type="hidden" name="vouchers_end_date" id="vouchers_end_date" value="" /></td>
                    </tr>
                    <tr>
                        <td width="6%"></td>
                        <td width="23%">Price : <span id="voucher_price"></span><input type="hidden" name="vouchers_price" id="vouchers_price" value="" /></td>
                    </tr>
                    
                    <tr>
                        <td width="6%"></td>
                        <td width="23%">Redumption : <span id="voucher_prices"></span> - <span id="amount_prices"></span> = <span id="total_price"></span><input type="hidden" name="totals_price" id="totals_price" value="" /></td>
                    </tr>
               </table>
           </div>
       </td>
    </tr>
      <!---------------------------------------End Payment mode------------------------------------->
  	<tr>
    		<td width="20%" valign="top">Amount (Non taxable)<span class="orange_font">*</span></td>
    		<td width="70%"><input type="text"  class=" input_text " name="amount" id="amount" value="<?php if($_POST['save_changes']) echo $_POST['amount']; else echo $row_record['price'];?>" /></td> 
   			<td width="10%"><input type="hidden" name="remaining_voucher" id="remaining_voucher" value="0"  /></td>
  	</tr>
  	<tr>
   			<td>&nbsp;</td>
    		<td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Customer Membership" name="save_changes"  id="save_changes"  /></td>
    		<td></td>
  	</tr>
</table>
</form>
</td></tr>
<?php  }   ?>
</table></td>
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
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->

<?php
/*if($_SESSION['type']=="S" && $record_id=='')
{
	?>
    <script>
	branch_name =document.getElementById("branch_name").value;
	//alert(branch_name);
	show_bank(branch_name);
	
	</script>
    <?php
	//exit();
}*/

if($record_id )
{ ?>
	<script>
	if(document.getElementById("membership_id").value)
	{
        memb_disc_edit =document.getElementById("membership_id").value;
        getMembership(memb_disc_edit);
	}
    </script>	
<?php
}
if($record_id || $_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
{
	?>
	 <script>
	if(document.getElementById("payment_mode").value)
	{
		vals= document.getElementById("payment_mode").value;
		payment(vals);
	}
	</script>
	<?php
}
?>
</body>
</html>
<?php $db->close();?>