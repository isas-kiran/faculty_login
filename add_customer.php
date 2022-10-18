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
	$sel_payment_mode1="select payment_mode from payment_mode where payment_mode_id='".$row_record['payment_mode_id']."'";
	$ptr_payment_mode1=mysql_query($sel_payment_mode1);
	$data_payment_mode1=mysql_fetch_array($ptr_payment_mode1);
	$pay_mode=trim($data_payment_mode1['payment_mode']);
	
	$sel_acc_no="select account_no from bank where bank_id='".$row_record['bank_id']."'";
	$ptr_bank_id=mysql_query($sel_acc_no);
	$data_bank_id=mysql_fetch_array($ptr_bank_id);
}

?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='118'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Customer</title>
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
    <script>
	/*function ValidateContactForm()
     {
		 var cust_name = document.ContactForm.cust_name.value;
		  
		  if(cust_name=='')
		  {
			 alert("Please Enter Customer Name");
			 document.ContactForm.cust_name.focus();
			 
		     return false; 
		  }
		 
		
		  
		  var a = document.ContactForm.mobile1.value;
		  
		  if(a=='')
		  {
			 alert("please Enter Mobile No. ");
			 document.ContactForm.mobile1.focus();
		     return false; 
		  }
		  
		  if(a !='')
		  {
			 if(isNaN(a))
				{
					alert("Enter the valid Mobile Number(Like : 9566137117)");
					document.ContactForm.mobile1.focus();
					return false;
				}
				
			 if((a.length < 1) || (a.length > 10) || (a.length < 10))
				{
					 
					 alert("Enter Valid Mobile Number 1");
					 document.ContactForm.mobile1.focus();
		             return false;
					 
				}
				
		 }
		 
		 var b = document.ContactForm.mobile2.value;
		  
		  if(b !='')
		  {
			 if(isNaN(b))
				{
					alert("Enter the valid Mobile Number(Like : 9566137117)");
					document.ContactForm.mobile2.focus();
					return false;
				}
				
			 if((b.length < 1) || (b.length > 10) || (b.length < 10))
				{
					 
					 alert("Enter Valid Mobile Number 2");
					 document.ContactForm.mobile2.focus();
		             return false;
					 
				}
				
		 }
		 
		 var x = document.forms["ContactForm"]["email"].value;
		//alert(x)
		if(x=='')
		{
			 alert("Please Enter Email");
			 document.ContactForm.email.focus();
			 
		     return false; 
		}
		
        var atpos = x.indexOf("@");
        var dotpos = x.lastIndexOf(".");
		 if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
		  {
			alert("Not a valid e-mail address");
			return false;
		  } 
		 
		var membership= document.ContactForm.membership.value;
		
		
		if(membership=='yes')
		{
			var membership_id= document.ContactForm.membership_id.value;
			if(membership_id)
			{
				 alert("Please select Membership");
				  document.ContactForm.membership_id.focus();
				  return false;
			}
			
			var payment_mode= document.ContactForm.payment_mode.value;
			if(payment_mode)
			{
				 alert("Please select Payment Mode");
				  document.ContactForm.payment_mode.focus();
				  return false;
			}
		}
		
		
	 }*/
	 
	 
	 
	 function validme()
	 {
		 frm = document.jqueryForm;
		 error='';
		 disp_error = 'Clear The Following Errors : \n\n';
		 
		 
		
		 if(frm.cust_name.value=='')
		 {
			 disp_error +='Enter Customer Name\n';
			 document.getElementById('cust_name').style.border = '1px solid #f00';
			 frm.cust_name.focus();
			 error='yes';
	     }
		 
		 if(frm.mobile1.value=='')

		 {
			 disp_error +='Enter Mobile Number \n';
			 document.getElementById('mobile1').style.border = '1px solid #f00';
			 frm.mobile1.focus();
			 error='yes';
	     }
		 else
		 {	 var text = frm.mobile1.value;
			 if(text.length <10)
				{
					 disp_error +='Enter Valid Mobile Number \n';
					 document.getElementById('mobile1').style.border = '1px solid #f00';
					 error='yes';
				}
		 }
		 if(frm.mobile2.value !='')
		 {
		 	 var text = frm.mobile2.value;
			 if(text.length <10)
				{
					 disp_error +='Enter Valid Mobile Number 2 \n';
					 document.getElementById('mobile2').style.border = '1px solid #f00';
					 error='yes';
				}
		 }
		var x = frm.email.value;
		//alert(x)
		if(x=='')
		{
			
			 disp_error +='Enter Email \n';

			 document.getElementById('email').style.border = '1px solid #f00';

			 frm.email.focus();

			 error='yes';
		}
		else
		{
		
         var atpos = x.indexOf("@");
         var dotpos = x.lastIndexOf(".");
		 if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
		  {
			 disp_error +='Not a valid e-mail address \n';

			 document.getElementById('email').style.border = '1px solid #f00';

			 frm.email.focus();

			 error='yes';
			 
		  }
		}
		 
		  var membership = frm.membership.value; 
		
		
		if(membership=='yes')
		{ 
			 if(frm.membership_id.value=='')
			 {
				 disp_error +='Please select a Membership \n';
				 document.getElementById('membership_id').style.border = '1px solid #f00';
				 frm.membership_id.focus();
				 error='yes';
			 }
			 
			 if(frm.start_date.value=='')
			 {
				 disp_error +='Please Enter Start Date \n';
				 document.getElementById('start_date').style.border = '1px solid #f00';
				 frm.start_date.focus();
				 error='yes';
			 }
			 
			 if(frm.payment_mode.value=='')
			 {
				 disp_error +='Please select Payment Mode \n';
				 document.getElementById('payment_mode').style.border = '1px solid #f00';
				 frm.payment_mode.focus();
				 error='yes';
			 }
		}
		  
		
		 
		 if(error=='yes')
		 {
			 alert(disp_error);
			 return false;
		 }
		 else
		 return true;
	 }
	
	</script>
    
    <script type="text/javascript">
function show(membership) 
{ 
  if(membership=='yes')
	{
		document.getElementById('membership_div').style.display = 'block';		
		document.getElementById('node_div').style.display = 'none';
	
	}
	else
	{
		document.getElementById('membership_div').style.display = 'none';		
		document.getElementById('node_div').style.display = 'block';
	
	}
 }
		 
function show_member(membership_id)
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
					var price= sep_val[1].trim();
					var days= sep_val[2].trim();
					
					document.getElementById('memb_disc').innerHTML=memb_disc;
					document.getElementById("price").value=price;
					document.getElementById("days").value=days;
					document.getElementById("dayss").innerHTML=days;
						
				}
            }
            });
	
}
		 
 </script>
 
<script>
function payment(value)
{
	payment_mode=value.split("-");
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
	record_id= document.getElementById("record_id").value;
	var bank_data="action=customer&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
	$.ajax({
	url: "show_bank.php",type:"post", data: bank_data,cache: false,
	success: function(retbank)
	{
		//alert(retbank);
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
</script>
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
							//$branch_name=$_POST['branch_name'];
							$branch_name=( ($_POST['branch_name'])) ? $_POST['branch_name'] : "";
							//$cust_id=$_POST['cust_id'];
							$cust_id=( ($_POST['cust_id'])) ? $_POST['cust_id'] : "0";
                            //$cust_name=$_POST['cust_name'];
							$cust_name=( ($_POST['cust_name'])) ? $_POST['cust_name'] : "";
							//$mobile1=$_POST['mobile1'];  
							$mobile1=( ($_POST['mobile1'])) ? $_POST['mobile1'] : "";
							//$mobile2=$_POST['mobile2']; 
							$mobile2=( ($_POST['mobile2'])) ? $_POST['mobile2'] : "";
							//$email=$_POST['email'];  
							$email=( ($_POST['email'])) ? $_POST['email'] : "";
							//$address=$_POST['address']; 
							$address=( ($_POST['address'])) ? $_POST['address'] : "";
							//$cust_gst_no=$_POST['cust_gst_no'];
							$delivery_address=( ($_POST['delivery_address'])) ? $_POST['delivery_address'] : "";
							$cust_gst_no=( ($_POST['cust_gst_no'])) ? $_POST['cust_gst_no'] : "";
							if($_POST['membership']=='')
							{
								$membership='no';
							}
							else
							{
                               $membership=$_POST['membership'];
							} 
							
                            //$gender=$_POST['gender'];
							$gender=( ($_POST['gender'])) ? $_POST['gender'] : "";
							//$birth_date=$_POST['birth_date'];
							$birth_date=( ($_POST['birth_date'])) ? $_POST['birth_date'] : "";
							//$anniversary_date=$_POST['anniversary_date'];
							$anniversary_date=( ($_POST['anniversary_date'])) ? $_POST['anniversary_date'] : "";
							//$marketing_email=$_POST['marketing_email'];
							$marketing_email=( ($_POST['marketing_email'])) ? $_POST['marketing_email'] : "";
							//$transaction_email=$_POST['transaction_email'];
							$transaction_email=( ($_POST['transaction_email'])) ? $_POST['transaction_email'] : "";
							//$dnd_sms=$_POST['dnd_sms'];
							$dnd_sms=( ($_POST['dnd_sms'])) ? $_POST['dnd_sms'] : "";
							//$membership_id=$_POST['membership_id'];
							$membership_id=( ($_POST['membership_id'])) ? $_POST['membership_id'] : "0";
							//$start_date=$_POST['start_date'];
							if($_POST['start_date'] !='')
							{
								$start_date=( ($_POST['start_date'])) ? $_POST['start_date'] : "";
								$tan_date = explode('/',$start_date);
								$start_date=$tan_date[2].'-'.$tan_date[0].'-'.$tan_date[1];
							}
							if($_POST['end_date'] !='')
							{
								
								$end_date=( ($_POST['end_date'])) ? $_POST['end_date'] : "";
								$tan_dates = explode('/',$end_date);
								$end_date=$tan_dates[2].'-'.$tan_dates[0].'-'.$tan_dates[1];
							}
							//$memberships=$_POST['memberships'];
							$memberships=( ($_POST['memberships'])) ? $_POST['memberships'] : "";
							//$price=$_POST['price'];
							$memberships=( ($_POST['price'])) ? $_POST['price'] : "";
							//$notes=$_POST['notes'];
							$notes=( ($_POST['notes'])) ? $_POST['notes'] : "";
							$bank_name='';
							$chaque_no='';
							$date='';
							$credit_card_no='';
							$payment_mode="";
							$payment_mode_id="0";
							//$payment_mode=$_POST['payment_mode'];
							if($_POST['payment_mode'] !='')
							{
								$payment_mode=( ($_POST['payment_mode'])) ? $_POST['payment_mode'] : "";
								$sep=explode("-",$payment_mode);
								$payment_mode_id=$sep[1];
							}
							//$amount=$_POST['amount'];
							$amount=( ($_POST['amount'])) ? $_POST['amount'] : "";
							
							if($payment_mode_id !="1" || $payment_mode_id !="3" ||$payment_mode_id !="5")
							{
								//$bank_name=$_POST['bank_name'];
								$bank_name=( ($_POST['bank_name'])) ? $_POST['bank_name'] : "0";
								//$chaque_no=$_POST['chaque_no'];
								$chaque_no=( ($_POST['chaque_no'])) ? $_POST['chaque_no'] : "";
								//$credit_card_no=$_POST['credit_card_no'];
								$credit_card_no=( ($_POST['credit_card_no'])) ? $_POST['credit_card_no'] : "";
								//$chaque_date=$_POST['cheque_date'];
								$chaque_date=( ($_POST['cheque_date'])) ? $_POST['cheque_date'] : "";
							}
							
							if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
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
								$data_record['cm_id']=$_SESSION['cm_id'];
								$branch_name1=$_SESSION['branch_name'];
								$data_record['cm_id']=$_SESSION['cm_id'];
							}
							 
							 if($record_id=='')
							 {
								  $sel_cat="select email from customer where email ='".$email."' ";
								  $ptr_cat=mysql_query($sel_cat);
								  $count_email=mysql_num_rows($ptr_cat);
								  
								  $select_cust_name="select cust_name from customer where cust_name='".$cust_name."' ";
								  $ptr_cust_name=mysql_query($select_cust_name);
								  $count_cust_name=mysql_num_rows($ptr_cust_name);
								  
								  if($count_email && $count_cust_name)
								  {
									$success=0;
									$errors[$i++]="Customer already Exist.";
								  }
								  
								  $sel_mobile_ext="select mobile1,email from customer where mobile1 ='".$mobile1."' || email='".$email."' ";
								  $ptr_mobile_ext=mysql_query($sel_mobile_ext);
								  if(mysql_num_rows($ptr_mobile_ext))
								  {
									  $data_cust=mysql_fetch_array($ptr_mobile_ext);
									  if($mobile1==$data_cust['mobile1'])
									  {
									 	$success=0;
									 	$errors[$i++]="Mobile 1 already Exist.";
									  }
									  if($email==$data_cust['email'])
									  {
									 	$success=0;
									 	$errors[$i++]="Email ID already Exist.";
									  }
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
								$data_record['branch_name']=$branch_name;
								$data_record['customer_id'] =$cust_id;
                                $data_record['cust_name'] =$cust_name;
                                $data_record['mobile1'] =$mobile1;
								$data_record['mobile2'] =$mobile2;
								$data_record['email']=$email;
								$data_record['address']=$address;
								$data_record['delivery_address'] =$delivery_address;
								$data_record['membership']=$membership;
								$data_record['gender']=$gender;
								$data_record['birth_date']=$birth_date;
								$data_record['anniversary_date']=$anniversary_date;
								$data_record['marketing_email']=$marketing_email;
								$data_record['transaction_email']=$transaction_email;
								$data_record['dnd_sms']=$dnd_sms;
								$data_record['cust_gst_no']=$cust_gst_no;
								 
								 $data_record['membership_id']=$membership_id;
								 $data_record['start_date']=$start_date;
								 $data_record['end_date']=$end_date;
								 $data_record['memberships']=$memberships;
								 $data_record['price']=$price;
								 $data_record['notes']=$notes;
								 
                                $data_record['payment_mode_id'] =$payment_mode_id;
								$data_record['chaque_no'] =$chaque_no;
								$data_record['chaque_date'] =$chaque_date;
								$data_record['credit_card_no'] =$credit_card_no;
								$data_record['bank_id'] =$bank_name;

                               if($record_id)
                                {
                                  
                                    $where_record=" cust_id='".$record_id."'";
                                    $db->query_update("customer", $data_record,$where_record);
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_customer','Edit','".$cust_name."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert); 
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $data_record['added_date'] =date("Y-m-d H:i:s");
                                    $record_id=$db->query_insert("customer", $data_record);
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_customer','Add','".$cust_name."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert); 
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                                }
                            }
                        }
                        if($success==0)
                        {
                        
						
						$rowSQL = mysql_query("SELECT MAX(cust_id) as max FROM `customer`" );
						$row = mysql_fetch_array( $rowSQL );
						$largestNumber = $row['max']+1;
                        ?>
            <tr><td>
   <form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data" onSubmit="return validme()">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
                <input type="hidden" name="record_id" id="record_id" value="<?php if($_REQUEST['record_id']) { echo $record_id ;} ?>"  />
                </tr>
                
                <?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
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
				<?php } else { ?>
                       <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                       <?php }?>
                
                <tr>
                  <td width="15%" valign="top">Customer ID<span class="orange_font">*</span></td>
                  <td width="70%"><input type="text"  class="validate[required] input_text" name="cust_id" id="cust_id" value="<?php if($_POST['save_changes']) echo $_POST['cust_id']; else if($row_record['customer_id'] !='') echo $row_record['customer_id']; else echo $largestNumber;?>" /></td> 
                  <td width="10%"></td>
              </tr>
              <tr>
                  <td width="15%" valign="top">Customer Name<span class="orange_font">*</span></td>
                  <td width="70%"><input type="text"  class="input_text" name="cust_name" id="cust_name" value="<?php if($_POST['save_changes']) echo $_POST['cust_name']; else echo $row_record['cust_name'];?>" /></td> 
                  <td width="10%"></td>
              </tr>
              
              <tr>
               <td width="15%" valign="top">Gender</td>
               <td>
                <input type="radio" value="male" name="gender" id="gender" <?php if($row_record['gender']=='male' || $_POST['gender']=='') echo 'checked="checked"'; ?> >Male
                <input type="radio" value="female" name="gender" id="gender" <?php if($row_record['gender']=='female') echo 'checked="checked"'; ?>>Female
               
               </td>
              
              </tr>
              
           <tr>
            <td width="15%" valign="top">Birth Date</td>
             <td width="70%"><input type="text"  class=" input_text datepicker" name="birth_date" id="birth_date" value="<?php if($_POST['save_changes']) echo $_POST['birth_date']; else echo $row_record['birth_date'];?>" /></td> 
              <td width="10%"></td>

            </tr>
             
            <tr>
            <td width="15%" valign="top">Anniversary Date</td>
             <td width="70%"><input type="text"  class=" input_text datepicker" name="anniversary_date" id="anniversary_date" value="<?php if($_POST['save_changes']) echo $_POST['anniversary_date']; else echo $row_record['anniversary_date'];?>" /></td> 
              <td width="10%"></td>

            </tr>
             
           <tr>
            <td width="15%" valign="top">Mobile 1<span class="orange_font">*</span></td>
             <td width="70%"><input type="text"  class=" input_text" name="mobile1" id="mobile1" value="<?php if($_POST['save_changes']) echo $_POST['mobile1']; else echo $row_record['mobile1'];?>" /></td> 
              <td width="10%"></td>

            </tr>
            
            <tr>
            <td width="15%" valign="top">Mobile 2</td>
             <td width="70%"><input type="text"  class=" input_text" name="mobile2" id="mobile2" value="<?php if($_POST['save_changes']) echo $_POST['mobile2']; else echo $row_record['mobile2'];?>" /></td> 
              <td width="10%"></td>

            </tr>
            
             <tr>
                  <td width="20%" valign="top">Email<span class="orange_font">*</span></td>
                <td width="70%"><input type="text"  class=" input_text" name="email" id="email" value="<?php if($_POST['save_changes']) echo $_POST['email']; else echo $row_record['email'];?>"/></td> 
                <td width="10%"></td>
              </tr>
              <tr>
                  <td width="15%" valign="top">Customer GST No.<span class="orange_font"></span></td>
                  <td width="70%"><input type="text"  class="input_text" name="cust_gst_no" id="cust_gst_no" value="<?php if($_POST['save_changes']) echo $_POST['cust_gst_no']; else echo $row_record['cust_gst_no'];?>" /></td> 
                  <td width="10%"></td>
              </tr>
              <tr>
                <td width="20%" valign="top">Biling Address</td>
                <td width="70%"><textarea name="address" id="address" style="width:90%; height:100px"><?php if($_POST['address']) echo $_POST['address']; else echo $row_record['address'];?></textarea></td>
              </tr>
              <tr>
                <td width="20%" valign="top">Delivery Address</td>
                <td width="70%"><textarea name="delivery_address" id="delivery_address" style="width:90%; height:100px"><?php if($_POST['delivery_address']) echo $_POST['delivery_address']; else echo $row_record['delivery_address'];?></textarea></td>
              </tr>
              
              <tr>
                <td width="20%" valign="top">DND</td>
                <td width="70%">
                  <input type="checkbox" name="marketing_email"  value="yes" <?php if($row_record['marketing_email']=='yes') echo 'checked="checked"' ?> >Receive Marketing Email
                  &emsp;<input type="checkbox" name="transaction_email"  value="yes" <?php if($row_record['transaction_email']=='yes') echo 'checked="checked"' ?>>Transaction Email
                  &emsp;<input type="checkbox" name="dnd_sms"  value="yes" <?php if($row_record['dnd_sms']=='yes') echo 'checked="checked"' ?>>SMS
                </td>
               
              </tr>
              
               <tr>
                <td width="20%" valign="top">If Membership</td>
                <td width="70%">
                  <input type="radio" name="membership" id="membership" value="yes" <?php if($_POST['membership']=='yes') echo 'checked="checked"'; elseif($row_record['membership']=='yes') echo 'checked="checked"'; ?> onClick="show('yes');">Yes
                  <input type="radio"  name="membership" id="membership" value="no" <?php if($_POST['membership']=='no') echo 'checked="checked"'; elseif($row_record['membership']=='no' ) echo 'checked="checked"'; elseif($_POST['membership']=='') ?> onClick="show('no');">No
                </td>
               
              </tr>
              
              <tr>
             <td colspan="3">
             <div id="membership_div" <?php if($row_record['membership']=='yes' || $_POST['membership'] =='yes') echo 'style="display:block"'; else echo 'style="display:none"';?>> 
                    <table border="0" cellspacing="15" cellpadding="0" width="80%">
                        <tr>
                            <td>Select Membership <span class="orange_font">*</span></td>
                            <td width="70%">
                            <select name="membership_id" style="width:200px;" id="membership_id" onChange="show_member(this.value);" >
                             <option value="">Select Membership</option> 
                              <?php  
							    $sql_dest = " select membership_name, membership_id from membership order by membership_id asc";
								$ptr_edes = mysql_query($sql_dest);
								while($data_dist = mysql_fetch_array($ptr_edes))
								{ 
										$selecteds = '';
										if($data_dist['membership_id']==$row_record['membership_id'])
										$selecteds = 'selected="selected"';	
										   
									echo "<option value='".$data_dist['membership_id']."' ".$selecteds.">".$data_dist['membership_name']."</option>";
								}
	
	                            ?>
                            </select>
                            
                        </tr>
                        <tr>
                        	<td width="20%" valign="top" colspan="3">
                        		<div id="membership_ids" >
                        			<table style="width:100%">
                            			<tr>
                            				<td width="9%">Membership Details</td>
                            				<td width="23%">Discount(in %) : <span id="memb_disc"></span><input type="hidden" name="days" id="days" value="" /></td>
                            			</tr>
                            			<tr>
                            				<td width="9%"></td>
                            				<td width="23%">Days : <span id="dayss"></span><input type="hidden" name="days" id="days" value="" /></td>
                            			</tr>
                        			</table>
                        		</div>
                        	</td>
                     	</tr> 
                        <tr>
                            <td>Start Date</td>
                            <td width="70%"><input type="text" name="start_date" onChange="getdate()" id="start_date" class=" input_text datepicker" 
                            value="<?php if($_POST['save_changes']) echo $_POST['start_date']; else echo $row_record['start_date'];?>"/></td>
                        </tr>
                        
                        <tr>
                            <td>End Date</td>
                            <td width="70%"><input type="text" name="end_date" id="end_date" class="datepicker input_text" 
                            value="<?php if($_POST['save_changes']) echo $_POST['end_date']; else echo $row_record['end_date'];?>"/></td>
                        </tr>
                        
                        
                       
                       <tr>
                       		<td width="25%">Amount :</td>
							<td width="40%"><input type="text" name="price" class=" input_text" id="price" value="<?php if($_POST['price']) echo $_POST['price']; else echo $row_record['price'];?>" /></td>
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
           /* if($_SESSION['type'] !="S")
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
             $sle_bank_name="select bank_id,bank_name from bank where cm_id='".$row_record['cm_id']."'"; 
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
                         <td class="tr-header" width="27%">Account No</td>
                         <td><input type="text" name="account_no" readonly="readonly" id="account_no" value="<?php if($_POST['account_no']) echo $_POST['account_no']; else echo $data_bank_id['account_no']; ?>" /></td>
                         </tr>
                         </table>
                 </div>
                 
                 <div id="chaque_details" <?php  if($data_payment_mode1['payment_mode']=='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
                     <table width="100%">
                    
                     <tr>
                     <td class="tr-header" width="27%">Enter Chaque No</td>
                     <td><input type="text" name="chaque_no" id="chaque_no" value="<?php if($_POST['chaque_no']) echo $_POST['chaque_no']; else echo $row_record['chaque_no']; ?>" /></td>
                     </tr>
                     <tr>
                     <td class="tr-header" width="27%">Enter Chaque Date</td>
                     <td><input type="text" name="cheque_date" id="cheque_date" class="datepicker" value="<?php if($_POST['cheque_date']) echo $_POST['cheque_date']; else echo $row_record['chaque_date']; ?>"  /></td>
                     </tr>
                     </table>
                 </div>
                 
                 <div id="credit_details" <?php  if($data_payment_mode1['payment_mode']=='Credit Card') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
                     <table width="100%">
                    
                     <tr>
                     <td class="tr-header" width="27%">Enter Credit Card No</td>
                     <td><input type="text" name="credit_card_no" id="credit_card_no" maxlength="4" value="<?php if($_POST['credit_card_no']) echo $_POST['credit_card_no']; else echo $row_record['credit_card_no']; ?>" /></td>
                     </tr>
                     </table>
                 </div>
                 </td>
               </tr>
              <!---------------------------------------End Payment mode------------------------------------->
                         
                    </table>
                  </div>
              </td> 
              </tr>
              
              <tr>
                <td width="20%" valign="top">Notes</td>
                <td width="70%"><textarea name="notes" id="notes" style="width:50%"><?php if($_POST['notes']) echo $_POST['notes']; else echo $row_record['notes'];?></textarea></td>
              </tr>
               <tr>
												
              <td colspan="3">
               <div id="node_div" <?php  if($row_record['membership']=='no' || $_POST['membership'] =='no') echo ' style="display:none"'; else echo ' style="display:none"'; ?>> 
                     <table border="0" cellspacing="15" cellpadding="0" width="80%">
                                                
                                                     
                                                    
                     </table>
                  </div>
              </td> 
             </tr>
             
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Customer" name="save_changes"  /></td>
                  <td></td>
              </tr>
        </table>
        </form>
        </td></tr>
<?php
                        }   ?>
	 
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
if($record_id || $_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
{
	?>
	 <script>
	vals= document.getElementById("payment_mode").value;
	payment(vals);
	</script>
	<?php
}
?>
</body>
</html>
<?php $db->close();?>