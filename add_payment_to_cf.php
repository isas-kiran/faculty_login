<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];

$sel_course="select course_id,assigned_to from enrollment where enroll_id='".$record_id."'";
$ptr_course=mysql_query($sel_course);
$data_course=mysql_fetch_array($ptr_course);

$assigned_to=$data_course['assigned_to'];
$course_name="select course_name from courses where course_id='".$data_course['course_id']."'";
$ptr_c_name=mysql_query($course_name);
$data_cnama=mysql_fetch_array($ptr_c_name);

$course_name=$data_cnama['course_name'];
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
    <!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
        <script type="text/javascript">
    <?php
	if($_SESSION['type']=='S')
	{
	?>
		$(document).ready(function()
		{            
			$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear',minDate: '-50Y',
			maxDate: '+2Y',});
		});
	<?php
	}
	?>
    </script>
    <script type="text/javascript">
	function submitform()
	{
		return calculate_total($("#amount_paid").val(),1);
	}
	finish = 0;
	remain=0;
	function calculate_total(amount_paid,final_call)
	{
		if(amount_paid == "")
			amount_paid = 0;
		
		//==============================TOTAL GST ==================================// changes in 14-11-17
		var cgsttax=parseFloat(document.getElementById('cgst_taxes').value);
		var sgsttax=parseFloat(document.getElementById('sgst_taxes').value);
		var totalgst=cgsttax+sgsttax;
		
		var new_total_tax=parseFloat((totalgst+100)/100);
		var total_taxable_value = parseInt(amount_paid / new_total_tax);
		var total_gst =parseInt(amount_paid - total_taxable_value);
		//document.getElementById('total_gst').value=total_gst;
		//==========================================================================
		//==============================For CGST====================================
		/*var cgst=parseFloat(document.getElementById('cgst_taxes').value);			// changes in 14-11-17
		var new_cgst_tax=parseFloat((cgst+100)/100);
		var cgst_taxable_value = parseInt(amount_paid / new_cgst_tax);
		var cgast_tax =parseInt(amount_paid - cgst_taxable_value);*/
		cgast_tax=parseInt(total_gst/2);
		document.getElementById('cgst_tax').value=cgast_tax;
		//==========================================================================
		
		//==============================For SGST====================================
		/*var sgst=parseFloat(document.getElementById('sgst_taxes').value);			// changes in 14-11-17
		var new_sgst_tax=parseFloat((sgst+100)/100);
		var sgst_taxable_value = parseInt(amount_paid / new_sgst_tax);
		var sgast_tax =parseInt(amount_paid - sgst_taxable_value);*/
		sgast_tax=parseInt(total_gst/2);
		document.getElementById('sgst_tax').value=sgast_tax;
		//=========================================================================
		var new_tax=new_total_tax//parseFloat(new_cgst_tax)+parseFloat(new_sgst_tax); // changes in 14-11-17
		
		total_paid=parseFloat(amount_paid)+parseFloat(cgast_tax)+parseFloat(sgast_tax);
		document.getElementById('total_paid_gst').value=total_paid;
		
		var no_of_installment = $("#no_of_installment").val();
		var no_of_paid_installment = parseInt($("#no_of_paid_installment").val());
		if(no_of_paid_installment && no_of_paid_installment!=undefined)
			var start_with = no_of_paid_installment+1;
		else
			var start_with = 1;
		//alert(start_with);
		//----first reset all the values to default--
		for(c=start_with;c<=no_of_installment;c++)
		{
			$("#int_id_"+c).html(parseInt($("#inst_"+c).val()));
		}
		//-------------------------------------------
		
		var balance_amount = $("#balance_amount").val();
		var amount_to_be_paid = parseInt(amount_paid);
		var total_remaining = parseInt(balance_amount);// - parseInt(amount_to_be_paid);
		if(total_remaining-parseInt(amount_to_be_paid)<0)
		{
			alert("Invalid input.");
			return false;
		}
		//alert(start_with+'-'+no_of_installment);
		$("#bal_amt").val(total_remaining);
		for(x=start_with;x<=no_of_installment;x++)
		{
			//alert(total_remaining);
			var inst_id_val = parseInt($("#inst_"+x).val());
			if(total_remaining<0)
			{
				alert("Amount should be less than or equal to the remaining amount.");
				break;
			}
			else
			{
				var current_inst_bal = inst_id_val-amount_to_be_paid;
				//alert(inst_id_val+'='+current_inst_bal);
				if(current_inst_bal<0)
				{
					amount_to_be_paid = -1*current_inst_bal;
					total_remaining = total_remaining-inst_id_val;
					if(final_call == 1)
					{
						//alert($("#inst_original_"+start_with).val()+'<11>'+amount_paid);
						if(parseInt($("#inst_original_"+start_with).val())<amount_paid)
							$("#inst_"+x).val(0);
					}
					$("#int_id_"+x).html(0);
					continue;
				}
				else
				{
					//alert(current_inst_bal);
					if(current_inst_bal==0)
						total_remaining = total_remaining-inst_id_val;
					else
						total_remaining = total_remaining-amount_to_be_paid;
					if(final_call == 1)
					{
						//alert($("#inst_original_"+start_with).val()+'<122>'+amount_paid);
						if(parseInt($("#inst_original_"+start_with).val())>amount_paid)
						{
							
							/*amount_to_be_paid = -1*current_inst_bal;
							total_remaining = total_remaining-inst_id_val;
							if(final_call == 1)
							{
								//alert($("#inst_original_"+start_with).val()+'<11>'+amount_paid);
								if(parseInt($("#inst_original_"+start_with).val())>amount_paid)
									$("#inst_"+x).val(0);
									
								
							}
							$("#int_id_"+x).html(0);
							continue;*/
							
						    alert("Deposit amount should not be less than current installment.");
							return false;
						}
						else
						{
							$("#inst_"+x).val(current_inst_bal);
						}
					}
					$("#int_id_"+x).html(current_inst_bal);
					break;
				}
			}
		}
		if(final_call == 1)
			$('#avail_balance').val(total_remaining);	
			
		$('#avail_balance_show').html(total_remaining);
		return true;
	}
	function calculate_total_old(amount_paid)   // caloculate the total of sell
  	{
		var balance_amount= document.getElementById('balance_amount').value;
		//alert(balance_amount);
	    amount_paid_id=parseInt(amount_paid); 
		//alert(amount_paid_id);
		//amount_paid_id= document.getElementById(amount_paid_id).value;
		avail_balance_id = parseInt(balance_amount) - parseInt(amount_paid_id);
		//alert(avail_balance_id);	
		document.getElementById('bal_amt').value=avail_balance_id;
		no_of_installment = $("#no_of_installment").val();	
		//alert(no_of_installment);
		var remaining =	parseInt(balance_amount);
		
		for(x=1;x<=no_of_installment;x++)
		{ 
		  //  alert(finish);
			if(finish!=x)
			{
			inst_id_val = $("#inst_"+x).val();					
			//alert(inst_id_val);
			vlsd = inst_id_val-amount_paid_id;
			//alert(vlsd);
			//alert(amount_paid_id);
			if(vlsd<0)
			{
				remain= vlsd;
				$("#int_id_"+x).html(0);
				//$("#inst_"+(x+1)).val($("#inst_"+x).val()+remain);
				nx =(parseInt($("#inst_"+x).val())+remain);
				$("#inst_"+(x+1)).val(nx);
				$("#inst_"+x).val(vlsd)
				if(nx<0 && $("#inst_"+(x+1)))
				{
					$("#inst_"+(x+1)).val(0);
					//alert(nx);
					//alert($("#inst_"+(x+1)).val());
					$("#int_id_"+(x+1)).html(0);
					if($("#inst_"+(x+2)))
					{
						nx2 = (parseInt($("#inst_"+(x+2)).val())+nx);
						$("#int_id_"+(x+2)).html(nx2);
					}
				}
				else
				{
					$("#int_id_"+(x+1)).html(nx);
				}
				
				//alert(nx);
				
				finish=x;
				break;
					
			}else
			if(amount_paid_id <= parseInt(inst_id_val))
			{ 
				if($("#int_id_"+x).html() !=0)
				{	
					$("#int_id_"+x).html(vlsd);
					if($("#int_id_"+x).html()==0)
					finish=x;
					break;
				}
			}
			//alert(finish);
			}
		}
		//alert($("#inst_1").val());
		document.getElementById('avail_balance').value=avail_balance_id;		
		document.getElementById('avail_balance_show').innerHTML = avail_balance_id;
    }
	
	
</script>
<script>
mail1=Array();
<?php
$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='144' ".$_SESSION['where']."";
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
			mail1[<?php echo $j; ?>]='<?php echo  $data_cnt['email'];?>';
			<?php
			$j++;
		}
	}
}
"<br/>".$sel_mail_text="select email_text from previleges where privilege_id='144'";
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
	var branch =document.getElementById('branch_name');
	var branch_name=branch.options[branch.selectedIndex].text; 
	var invoice_no =document.getElementById('invoice_no').value;
	var enrolled_id =document.getElementById('record_id').value;
	var name =document.getElementById('name').value;
	var course_name =document.getElementById('course_name').value;
	
	// alert(invoice_no);
	var mail =document.getElementById('mail').value;
	//alert(inst_student_id); 
	var cm_id_branch =document.getElementById('cm_id_branch').value;
	//alert(cm_id_branch);
	var total=document.getElementById('total').value;
	// alert(total);
	var discount =document.getElementById('discount').value;
	//alert(discount);
	var down_payment =document.getElementById('down_payment').value;
	//alert(down_payment);
	
	var paid_amt =document.getElementById('paid_amt').value;
	// alert(paid_amt);
	var balance_amount =document.getElementById('balance_amount').value;
	//alert(balance_amount);
	var amount_paid =document.getElementById('amount_paid').value;
	//alert(amount_paid);
	m =document.getElementById('payment_type');
	var payment_type=m.options[m.selectedIndex].text;
	//alert(payment_type);
	var no_of_installment = $("#no_of_installment").val();
	//alert(no_of_installment);
	var cust_bank_name =document.getElementById('cust_bank_name').value;
	//alert(cust_bank_name);
	bank_id=document.getElementById('bank_name');
	var bank=bank_id.options[bank_id.selectedIndex].text;
	//alert(bank);
	var account_no =document.getElementById('account_no').value;
	//alert(account_no);
	var chaque_no =document.getElementById('chaque_no').value;
	//alert(chaque_no);
	var chaque_date =document.getElementById('chaque_date').value;
	//alert(chaque_date);
	var credit_card_no =document.getElementById('credit_card_no').value;
	// alert(credit_card_no); 
	var avail_balance =document.getElementById('avail_balance').value;
	//alert(avail_balance);
	var users_mail=mail1;
	data1='action=add_payment&branch_name='+branch_name+'&invoice_no='+invoice_no+'&cm_id_branch='+cm_id_branch+'&total='+total+'&discount='+discount+'&down_payment='+down_payment+'&paid_amt='+paid_amt+'&balance_amount='+balance_amount+'&amount_paid='+amount_paid+'&payment_type='+payment_type+'&cust_bank_name='+cust_bank_name+'&bank='+bank+'&account_no='+account_no+'&chaque_no='+chaque_no+'&chaque_date='+chaque_date+'&credit_card_no='+credit_card_no+'&avail_balance='+avail_balance+"&users_mail="+users_mail+"&mail="+mail+"&name="+name+"&email_text_msg="+email_text_msg+"&course_name="+course_name;
	//alert(data1);
	$.ajax({
	url:'send_email.php',type:"post",data:data1,cache:false,crossDomain:true,async:false,
	success: function(response)
	{
		//alert(response);
		return true;
	}
	}); 

}
</script>

 <style type = "text/css">
        #feedback{
            line-height:;
        }
		.obrderclass{ border:1px solid #f00}
    </style>  
    
    <script type="text/javascript">
        function show() { document.getElementById('payment').style.display = 'block'; $('#pay_type').removeClass("obrderclass");  }
        function hide() { document.getElementById('payment').style.display = 'none'; $('#pay_type').removeClass("obrderclass");  }
      </script> 
      
<script>
function validme()
{
	frm = document.frmTakeAction;
	error='';
	disp_error = 'Clear The Following Errors : \n\n';
 
	if($('#interest_amnt').val() =="")
	{
		disp_error +='Please enter intrest amount \n'; 
		$('#interest_amnt').addClass("obrderclass"); 
		error='yes';
	}
	if($('#gst_amount').val() =="")
	{
		disp_error +='Please enter GST amount \n'; 
		$('#gst_amount').addClass("obrderclass"); 
		error='yes';
	}
	if($('#processing_amount').val() =="")
	{
		disp_error +='Please enter processing fees \n'; 
		$('#processing_amount').addClass("obrderclass"); 
		error='yes';
	}
	
	// alert(error);
	if(error=='yes')
	{
		alert(disp_error);
		//calculate_total($("#amount_paid").val(),1);
		return false;
	}
	else
	{
		setTimeout(send,500);
		return submitform();
	}
	// return true;
}

	 
	 
function show_payment(value) 
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
		
		show_bank(branch_name,"cheque")
	}
	else if(payment_mode[0]=="Credit Card")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'block';
		document.getElementById("bank_ref_no").style.display = 'none';
		
		show_bank(branch_name,"credit_card")
		
	}
	else if(payment_mode[0]=="paytm")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		document.getElementById("bank_ref_no").style.display = 'none';
		
		show_bank(branch_name,"paytm")
	}
	else if(payment_mode[0]=="online")
	{
		document.getElementById("bank_ref_no").style.display = 'block';
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		
		show_bank(branch_name,"online")
	}
	else
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'none';
		document.getElementById("credit_details").style.display = 'none';
		document.getElementById("bank_ref_no").style.display = 'none';
		
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
		document.getElementById('account_no').value=html;
	}
	});
}
function show_bank(branch_id,vals)
{
	record_id= document.getElementById("record_id").value;
	var bank_data="action=enroll&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
	//alert(bank_data);
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
	
	var tax_data="show_tax=1&branch_id="+branch_id;
	$.ajax({
	url: "show_tax.php",type:"post", data: tax_data,cache: false,
	success: function(rettax)
	{
		var taxes=rettax.split('-');
		service_tax= taxes[0];
		installment_tax= taxes[1];
		cgst=taxes[2];
		sgst=taxes[3];
		//document.getElementById("service_tax_id").innerHTML=service_tax;
		//document.getElementById("inst_tax_id").innerHTML=installment_tax;
		document.getElementById("cgst_id").innerHTML=cgst;
		document.getElementById("sgst_id").innerHTML=sgst;
		
		//document.getElementById("service_taxes").value=service_tax;
		//document.getElementById("inst_taxes").value=installment_tax;
		document.getElementById("cgst_taxes").value=cgst;
		document.getElementById("sgst_taxes").value=sgst;
		//alert("service tax- "+service_tax);
		//course_id1 =document.getElementById("course_id").value;
		//alert(document.getElementById("service_taxes").value);
	}
	});
}
</script>
      
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
    					<?php
    						if($_POST['save_changes'])
                        	{
                            	$invoice_ids=$_GET['invoice_id'];
								$enroll_id=$_GET['record_id'];
								$interest_amnt=$_POST['interest_amnt'];
								$gst_amount=$_POST['gst_amount'];
								$processing_amount=$_POST['processing_amount'];
								$cf_date=explode('/',$_POST['payment_due_date'],3);
								$cf_added_date=$cf_date[2].'-'.$cf_date[1].'-'.$cf_date[0];
								$name=$_POST['name'];
								$branch_name=( ($_POST['branch_name'])) ? $_POST['branch_name'] : "";
								if($_SESSION['type']=='S')
								{
									$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
									$ptr_branch=mysql_query($sel_branch);
									$data_branch=mysql_fetch_array($ptr_branch);
									$cm_id=$data_branch['cm_id'];
									$branch_name1=$branch_name;
									$data_record['cm_id']=$cm_id;
									$cm_id1=$cm_id;
								}	
								else
								{
									$data_record['cm_id']=$_SESSION['cm_id'];
									$branch_name1=$_SESSION['branch_name'];
									$data_record['cm_id']=$_SESSION['cm_id'];
									$cm_id1=$_SESSION['cm_id'];
								}
								$data_record['cf_amnt_date'] =$cf_added_date;
								$data_record['cf_intrest_amnt'] =$interest_amnt;
								$data_record['cf_gst_amnt'] =$gst_amount;
								$data_record['cf_processing_fee'] =$processing_amount;
								
								if($record_id && $invoice_ids)
								{
									$where_record="invoice_id=".$invoice_ids." and enroll_id=".$enroll_id;
									$db->query_update("invoice",$data_record,$where_record);
									
									$select_inv="select * from invoice where invoice_id='".$invoice_ids."' and enroll_id='".$enroll_id."'";
									$ptr_invs=mysql_query($select_inv);
									$data_invs=mysql_fetch_array($ptr_invs);
									//=============================INTREST==========================
									$sel_exp_intrest="insert into expense (`payment_mode_id`,`bank_id`,`bank_ref_no`,`expense_category_id`,`expense_type_id`,`amount_wo_tax`,`amount`,`total_price`,`description`,`added_Date`,`admin_id`,`cm_id`) values ('".$data_invs['paid_type']."','".$data_invs['bank_name']."','".$data_invs['bank_ref_no']."','134','219','".$interest_amnt."','".$interest_amnt."','".$interest_amnt."','CF loan Intrest amount against ".$name."','".$cf_added_date."','".$_SESSION['admin_id']."','".$cm_id1."')";
									$ptr_exp=mysql_query($sel_exp_intrest);								
									//==============================================================
									//=============================GST==========================
									$sel_exp_gst="insert into expense (`payment_mode_id`,`bank_id`,`bank_ref_no`,`expense_category_id`,`expense_type_id`,`amount_wo_tax`,`amount`,`total_price`,`description`,`added_Date`,`admin_id`,`cm_id`) values ('".$data_invs['paid_type']."','".$data_invs['bank_name']."','".$data_invs['bank_ref_no']."','134','220','".$gst_amount."','".$gst_amount."','".$gst_amount."','CF loan GST amount against ".$name."','".$cf_added_date."','".$_SESSION['admin_id']."','".$cm_id1."')";
									$ptr_exp=mysql_query($sel_exp_gst);								
									//==============================================================
									//=============================PF==========================
									$sel_exp_pf="insert into expense (`payment_mode_id`,`bank_id`,`bank_ref_no`,`expense_category_id`,`expense_type_id`,`amount_wo_tax`,`amount`,`total_price`,`description`,`added_Date`,`admin_id`,`cm_id`) values ('".$data_invs['paid_type']."','".$data_invs['bank_name']."','".$data_invs['bank_ref_no']."','134','221','".$processing_amount."','".$processing_amount."','".$processing_amount."','CF loan Processing Fees against ".$name."','".$cf_added_date."','".$_SESSION['admin_id']."','".$cm_id1."')";
									$ptr_exp=mysql_query($sel_exp_pf);								
									//==============================================================
									
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('Add_CF_payment','Add','".$_POST['name']."','".$invoice_id."','".date('Y-m-d')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);  
								
									//------send notification on inquiry addition--------------------
										/*$notification_args['reference_id'] = $enroll_id;
										$notification_args['on_action'] = 'installment_payment';
										$notification_status = addNotifications($notification_args);*/
									//---------------------------------------------------------------
									//==========================================
								?>
                                	<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Payment Added Successfully</p></center></div>
                            		<script type="text/javascript">
                            			// $("#statusChangesDiv").dialog();
                                		$(document).ready(function() {
                                    	$( "#statusChangesDiv" ).dialog({
                                            modal: true,
                                            buttons: {
                                                        Ok: function() { $( this ).dialog( "close" );}
                                                     }
                                    	});
									
                                		});
									//setTimeout('document.location.href="invoice-summary.php?record_id=<?php echo $record_id; ?>";',1000);
                            		</script>
                                	<?php
								}
								else
								{
								 // $db->query_insert("pay_balace_bill_mapping", $data_college);
								 //  echo '<div id="msgbox" style="width:40%;">Supplier added successfully</center></div>';
								}
								$success=1;
                        	}
							if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
							{
								$pre_from_date=" and date_format(added_date,'%Y-%m-%d')>='".date('Y-m-d',strtotime($_REQUEST['from_date']))."'";
							}
							else
							{
								$balance=0;
								$pre_from_date="";                            
							}
									
							$sql_records= "SELECT * FROM invoice 
							where enroll_id=".$record_id." ".$pre_transcation_id." ".$pre_from_date." ".$pre_to_date." ".$pre_status."  order by invoice_id desc limit 0,1 ";
							$all_records = mysql_query($sql_records);
							$no_of_records=mysql_num_rows($db->query($sql_records));
							if($no_of_records)
							{
					   
								$bgColorCounter=1;
								if(!$_SESSION['showRecords'])
									$_SESSION['showRecords']=10;
								?>
								<form method="post" name="frmTakeAction" id="add_payment_form" onSubmit="return validme();">
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
                                                    <td height="2" align="right"></td>
                                                </tr>
                                            </table>
                                        </td></tr>
                                    <tr><td height="10"></td></tr>
                                    
                                    <tr>
                                    	<td valign="top" colspan="2">
                                        <input type="hidden" name="record_id" id="record_id" value="<?php echo $_GET['record_id']; ?>"  />
                                       <table cellspacing="1"  cellpadding="5" style="width: 60%;" align="center">
										<?php
                                    while($val_record=mysql_fetch_array($all_records))
                                    {
										if($bgColorCounter%2==0)
                                    		$bgcolor='class="grey_td"';
                                		else
                                    		$bgcolor=""; 
										 $enroll_id=$val_record['enroll_id'];
										 $paid_totas=0;
                                        /*if($bgColorCounter%2==0)
                                            $bgclass="tr-sub_white1";
                                        else
                                            $bgclass="tr-sub1";*/
                                        include "include/paging_script.php";
										if($_SESSION['type']=='S')
										{
										?>
											  <tr>
												<td>Select Branch</td>
												<td>
												<?php
												$sel_cm_id="select branch_name from site_setting where cm_id=".$val_record['cm_id']." ";
												$ptr_query=mysql_query($sel_cm_id);
												$data_branch_nmae=mysql_fetch_array($ptr_query);
												
												$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
												$query_branch = mysql_query($sel_branch);
												$total_Branch = mysql_num_rows($query_branch);
												echo '<table width="100%"><tr><td>';
												echo ' <select id="branch_name" name="branch_name" onchange="show_bank(this.value)">';
												while($row_branch = mysql_fetch_array($query_branch))
												{
													?>
													<option value="<?php if ($_POST['branch_name']) echo $_POST['branch_name']; else echo $row_branch['branch_name'];?>"  <?php if($row_branch['branch_name']==$data_branch_nmae['branch_name']) echo 'selected="selected"' ?> /><?php echo $row_branch['branch_name']; ?> 
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
                                       <?php }
									   $sel_inst1= "select * from installment where enroll_id=".$record_id." order by installment_id asc limit 0,1 ";
									   $ptr_inst=mysql_query($sel_inst1);
									   $data_inst1=mysql_fetch_array($ptr_inst);
									   ?>
									   <tr>
											<td width="20%">Payment Due Date<span class="orange_font">*</span></td>
											<td width="49%"><input type="text" id="payment_due_date" readonly="readonly" name="payment_due_date" class="input_text datepicker" value="<?php if($_POST['payment_due_date']) echo $_POST['payment_due_date']; else if($data_inst1['installment_date']!=''){$arrage_date= explode('-',$data_inst1['installment_date'],3);echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];}else{echo date("d/m/Y");}?>" />
											</td>
										</tr>
									   <?php
                                        echo '<tr class="'.$bgclass.'">';
                                        //echo '<td align="center">'.$sr_no.'</td>';	?><tr>
											<td width="20%">Date<span class="orange_font">*</span></td>
											<td width="49%"><?php if($_POST['added_date']) echo $_POST['added_date']; else if($val_record['added_date']!=''){$inv_date=explode(' ',$val_record['added_date'],2);$arrage_date= explode('-',$inv_date['0'],3);echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];}else{echo date("d/m/Y");}?>
                                            <input type="hidden" id="added_date" name="added_date" value="<?php if($_POST['added_date']) echo $_POST['added_date']; else if($val_record['added_date']!=''){ $inv_date=explode(' ',$val_record['added_date'],2); $arrage_date= explode('-',$inv_date['0'],3);echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];}else{echo date("d/m/Y");}?>" />
											</td>
										</tr> <?php
										
										echo " <td><strong>Enrollment No.</strong></td><td align='left'>".$val_record['enroll_id']."</td></tr>";
										echo '<input type="hidden" name="invoice_no" id="invoice_no" value='.$val_record['enroll_id'].'>';
										
										$name ='';
										$email_id = '';
										$phone_no ='';
					
									  	$select_firstname = " select * from enrollment where enroll_id='".$val_record['enroll_id']."' ";
									  	$ptr_query=mysql_query($select_firstname);
										$data_select = mysql_fetch_array($ptr_query);
										
										
										echo '<tr><td><strong>Student Name</strong></td><td align="left" style="padding-left:5px;"><b>'.$data_select['name'].'
										<input type="hidden" name="cm_id_branch" id="cm_id_branch" value='.$data_select['cm_id'].'><input type="hidden" name="mail" id="mail" value='.$data_select['mail'].'><input type="hidden" name="name" id="name" value='.$data_select['name'].'></td></tr>';
										echo '<tr><td><strong>Course Name</strong></td><td align="left">'.$course_name.' <input type="hidden" name="course_name" id="course_name" value='.$course_name.'></td></tr>';
                                        echo '<tr><td><strong>Total</strong></td><td align="left">'.$data_select['course_fees'].' <input type="hidden" name="total" id="total" value='.$data_select['course_fees'].'></td></tr>';
                                        echo '<tr><td><strong>Discount</strong></td><td align="left">';
                                        	echo $data_select['discount'];
                                        echo '</td><input type="hidden" name="discount" id="discount" value='.$data_select['discount'].'></tr>'; 
									    $paid=$data_select['paid'];
										/*$selectpaid="select sum(installment_amount) as amount_paid  from installment_history 
										where enroll_id=".$val_record['enroll_id']." "; 
										$ptr_selectpaid=mysql_query($selectpaid);
										if(mysql_num_rows($ptr_selectpaid))
										 {
										while($val_selectedpaid=mysql_fetch_array($ptr_selectpaid))
										{*/
									    //$totsss=$data_select['course_fees']-$data_select['discount'];
										//$bal_totas=$totsss-$data_select['paid']; 
										/*}
										}*/
										
										echo '<tr><td><strong>Down Payment</strong></td><td align="left">'.$data_select['down_payment'].'<input type="hidden" name="down_payment" id="down_payment" value='.$data_select['down_payment'].'></td></tr>'; 
										if($data_select['paid'] !='')
										{
									   		echo '<tr><td><strong>Paid</strong></td><td align="left">'.$data_select['paid'].'<input type="hidden" name="paid_amt" id="paid_amt" value="'.$data_select['paid'].'"></td></tr>'; 
										}
									   echo '<tr><td><strong>Balance Amount</strong></td><td align="left">'.$data_select['balance_amt'].'<input type="hidden" name="balance_amount" id="balance_amount" value="'.$data_select['balance_amt'].'" class="inputText"></td></tr>';
										
										echo '<tr><td><input type="hidden" name="bal_amt" id="bal_amt"/></td></tr>'		
									   ?> 
										<tr><td width="37%"><strong>Intrest Amount</strong></td><td width="63%" align="left"><input type="text" name="interest_amnt" id="interest_amnt" value="" > </td></tr>
                                        <tr><td width="37%"><strong>GST Amount</strong></td><td width="63%" align="left"><input type="text" name="gst_amount" id="gst_amount"	value="" > </td></tr>
                                        <tr><td width="37%"><strong>Processing Amount</strong></td><td width="63%" align="left"><input type="text" name="processing_amount" id="processing_amount" value="" > </td></tr>
										<!--<tr>
											  <td width="20%" class="heading">CGST <span id="cgst_id"><?php //if($_SESSION['type']!='S'){ echo $_SESSION['cgst'];} ?></span>%<span class="orange_font">*</span></td><input type="hidden" id="cgst_taxes" name="cgst_taxes" value="<?php //if($_SESSION['type']!='S'){ echo $_SESSION['cgst'];} ?>"  />
											  <td><input type="text" class="validate[required] input_text" readonly="readonly" name="cgst_tax" id="cgst_tax"  value="<?php //if($_POST['cgst_tax']) echo $_POST['cgst_tax']; else echo $row_record['cgst_tax'];?>" /></td>
										</tr>
										<tr>      
											  <td width="20%" class="heading">SGST <span id="sgst_id"><?php //if($_SESSION['type']!='S'){ echo $_SESSION['sgst'];} ?></span>%<span class="orange_font">*</span></td><input type="hidden" id="sgst_taxes" name="sgst_taxes" value="<?php //if($_SESSION['type']!='S'){ echo $_SESSION['sgst'];} ?>"  />
											  <td><input type="text" class="validate[required] input_text" readonly="readonly" name="sgst_tax" id="sgst_tax"  value="<?php //if($_POST['sgst_tax']) echo $_POST['sgst_tax']; else echo $row_record['sgst_tax'];?>" /></td>
										</tr>-->
										<tr>      
											  <td><input type="hidden" class="validate[required] input_text" readonly="readonly" name="total_paid_gst" id="total_paid_gst"  value="<?php if($_POST['total_paid_gst']) echo $_POST['total_paid_gst']; else echo $row_record['total_paid_gst'];?>" /></td>
										</tr>
                                        <!--<tr>
                                          	<td width="20%" class="heading">Select Payment Mode <span class="orange_font">*</span></td>
                                            <td><select name="payment_type" id="payment_type" onChange="show_payment(this.value)">
                                            <option value="select">--Select--</option>
                                            <?php
                                            /*$sel_payment_mode="select payment_mode,payment_mode_id from payment_mode";
                                            $ptr_payment_mode=mysql_query($sel_payment_mode);
                                            while($data_payment=mysql_fetch_array($ptr_payment_mode))
                                            {
                                            	$selected='';
												if($data_payment['payment_mode_id'] == $row_expense['payment_mode_id'])
												{
													$selected='selected="selected"';
												}
												echo '<option '.$selected.' value="'.$data_payment['payment_mode'].'-'.$data_payment['payment_mode_id'].'">'.$data_payment['payment_mode'].'</option>';
                                            }*/
                                            ?>
                                            </select></td>
                                        </tr>-->
                                        <!--<tr>
                                           		<td colspan="3">
                                                <div id="bank_ref_no" <?php //if($_POST['payment_type'] =='online-5') echo 'style="display:block"'; else if($val_record['paid_type'] =='5') echo 'style="display:block"';  else echo 'style="display:none"'; ?>>
													<table width="100%">
														<tr>
															<td width="21%" class="tr-header" align="">Ref. no<span class="orange_font">*</span></td>
															<td width="35%"><input type="text" name="bank_ref_no" id="bank_refc_no" value="<?php //if($_POST['bank_ref_no']) echo $_POST['bank_ref_no']; else echo $data_invoice['bank_ref_no']; ?>"/></td>
														</tr>
													</table>
												</div>
                                             	<div id="bank_details" style="display:none">
                                             	<table width="100%">
                                             		<tr>
                                             			<td width="62%" class="tr-header" align="">Customer Bank Name<span class="orange_font">*</span></td>
                                             			<td width="20%" style="vertical-align:bottom">
                                              			<input type="text" name="cust_bank_name" id="cust_bank_name" value="<?php //if($_POST['cust_bank_name']) echo $_POST['cust_bank_name']; else echo $row_record['cust_bank_name']; ?>"/>
                                             			</td>
                                              			<td width="20%" class="tr-header" align=""> ISAS Bank Name : &nbsp; 
                                              			
                                             			<div id="bank_id"></div>
                                             			</td>
                                             			<td width="20%" class="tr-header" align=""> ISAS Account No : &nbsp; 
                                              			<input type="text" name="account_no" readonly id="account_no" value="<?php //if($_POST['account_no']) echo $_POST['account_no']; else echo $row_record['account_no']; ?>"/>
                                            			</td>
                                             		</tr>
                                             	</table>
                                             	</div>
                                             	</td>
                                             </tr>
                                             <tr>
                                             <td colspan="2">
                                             <div id="chaque_details" style="display:none">
                                             	<table width="100%">
                                                	<tr>
                                                		<td width="37%">Customer Cheque No.</td>
                                                        <td><input type="text" name="chaque_no" id="chaque_no"  class="validate[required] input_text"  value="<?php //if($_POST['chaque_no']) echo $_POST['chaque_no']; else echo $row_invoice['chaque_no'];?>" onKeyPress="return isNumber(event)" maxlength="6"/></td>
                                                	</tr>
                                                 	<tr>
                                                 		<td>Customer Cheque Date</td>
                                                 		<td><input type="text" name="chaque_date" id="chaque_date"  class="datepicker" placeholder="cheque date " value="<?php //if($_POST['save_changes']) echo $_POST['chaque_date']; else echo $chaque_date ;?>"/></td>
                                                 	</tr>
                                            	</table>
                                            </div>
                                            <div id="credit_details" style="display:none">
                                            	<table width="100%">
                                             		<tr>
                                             			<td width="37%" class="tr-header" align="">Enter Credit Card No</td>
                                             			<td><input type="text" name="credit_card_no" id="credit_card_no" maxlength="4" value="<?php //if($_POST['credit_card_no']) echo $_POST['credit_card_no']; else echo $row_invoice['credit_card_no']; ?>" /></td>
                                             		</tr>
                                             	</table>
                                            </div>
                                            </td>
                                       	</tr>-->                                                                                                                               
										<!--<tr><td colspan="2"><strong>Installments</strong></td></tr>		
                                        <tr>
                                        <td colspan="2">
                                        <table width="95%" align="center">
                                        	<tr>
                                        	<td >
                                        		<?php
												/*$sel_inst= "select * from installment where enroll_id=".$record_id." ";
												$ptr_query_inst=mysql_query($sel_inst);
												$i=$data_select['no_of_installment'];
												echo '<input type="hidden" name="no_of_installment" value='.$i.' id="no_of_installment" /><table width="100%" style="border:1px solid black">';
												echo'<tr><td width="30%"><b>Installments</b></td><td width="20%"><b>Inst Amt</b></td><td width="25%"><b>Inst Date</b></td><td>Paid Status</td></tr>';
												//echo '<tr></tr>';
												$j=1;
                                                $no_of_paid__installment=0;
												while($data_inst=mysql_fetch_array($ptr_query_inst))
												{
                                                    if($data_inst['status'] =='paid')
                                                    $no_of_paid__installment=$no_of_paid__installment+1;
													$col_paid ='<font color="#006600">';
													if($data_inst['status'] =='not paid')
													$col_paid ='<font color="#FF3333">';
													echo '<input type="hidden" name="course_id" value="'.$data_inst['course_id'].'" id="course_id" />';
													echo'<tr><td width="15%"><b>Installment '.$j.'</b></td><td width="15%"><input type="hidden" name="inst_original_'.$j.'" id="inst_original_'.$j.'" value="'.$data_inst['installment_amount'].'"><input type="hidden" name="inst_'.$j.'" id="inst_'.$j.'" value="'.$data_inst['installment_amount'].'"><span id=int_id_'.$j.'>'.$data_inst['installment_amount'].'</span></td><td width="15%"><input type="hidden" name="inst_date'.$j.'" id="inst_date'.$j.'" value="'.$data_inst['installment_date'].'">'.$data_inst['installment_date'].'</td><td>'.$col_paid.$data_inst['status'].'</font></td></tr>';
													$j++;
													$i--;
												}
												echo '</table>';
												echo '<input type="hidden" name="no_of_paid_installment" value="'.$no_of_paid__installment.'" id="no_of_paid_installment" />';*/
												?>
                                                
                                        	</td>
                                        </tr>
                                        </table>
                                        </td>
                                        </tr>-->
                                        
								 		<!--<tr><td width="37%"><strong>Remaining </strong></td><td align="left"  width="63%"> <div id="avail_balance_show"><?php //echo $data_select['balance_amt']; ?></div><input type="hidden" name="avail_balance" id="avail_balance" /> </td></tr>-->
                               			
                                        <tr>
                                            <td colspan="2" align="center"> <input type="submit" name="save_changes" value="Add Payment" class="add_submit_button"/></td>
                                        </tr>
                                        <?php
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
                                                    <td align="right"></td>
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
<script>
/*vals= document.getElementById("payment_type").value;
show_payment(vals);*/
<?php
if($record_id || $_SESSION['type']=="S")
{
	?>
	vals= document.getElementById("payment_type").value;
	show_payment(vals);
	<?php
}

?>
</script>
<!--info end-->
<div class="clearit"></div> 
                    <noscript>
                            Warning! JavaScript must be enabled for proper operation of the Administrator backend.				</noscript>
                 <div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>