<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
 $page_name = "enrollment";
 $sele_sac_code="select sac_code from sac_code_config where page_name='".$page_name."'";
 $ptr_sac_code=mysql_query( $sele_sac_code);
 $data_sac_code=mysql_fetch_array($ptr_sac_code);
 
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM enrollment where enroll_id='".$record_id."'";
		$_SESSION['sql_articles']=$sql_record;
    if(mysql_num_rows($db->query($sql_record)))
   		$row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
	$sel_invoice="select invoice_id,paid_type,cheque_detail,bank_name,chaque_date,cust_bank_name,credit_card_no from invoice where enroll_id='".$row_record['enroll_id']."'";
	$ptr_invoice=mysql_query($sel_invoice);
	$data_invoice=mysql_fetch_array($ptr_invoice);
	
	$sel_acc="select account_no from bank where bank_id='".$data_invoice['bank_name']."'";
	$ptr_acc=mysql_query($sel_acc);
	$data_account=mysql_fetch_array($ptr_acc);

	$sel_payment_mode1="select payment_mode from payment_mode where payment_mode_id='".$data_invoice['paid_type']."'";
	$ptr_payment_mode1=mysql_query($sel_payment_mode1);
	$data_payment_mode1=mysql_fetch_array($ptr_payment_mode1);
}
$rowSQL = mysql_query("SELECT MAX(enroll_id) as max FROM `enrollment`" );
$row = mysql_fetch_array( $rowSQL );
$largestNumber = $row['max']+1;
$rowSQL_invoice= mysql_query("SELECT MAX(invoice_id) as max FROM `invoice`" );
$row_invoice = mysql_fetch_array( $rowSQL_invoice );
$largestInvoiceNumber = $row_invoice['max']+1;
if($record_id && $_REQUEST['deleteThumbnail'])
{
    $update_news="update enrollment set photo='' where enroll_id='".$record_id."'";
    //echo $update_events;
    $db->query($update_news);
    if($row_record['photo'] && file_exists("../student_photos/".$row_record['photo']))
        unlink("../student_photos/".$row_record['photo']);
    $row_record=$db->fetch_array($db->query($sql_record));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php if($record_id) echo "Edit"; else echo "Enrollment ";?>
 Form</title>
<?php include "include/headHeader_gst.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<!-- Multiselect -->
<link rel="stylesheet" href="js/chosen.css" />
<link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
<link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
<link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
<script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
<script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
<script type="text/javascript" src="multifilter/assets/prettify.js"></script>
<script src="js/chosen.jquery.js" type="text/javascript"></script>
<!--End multiselect -->
    <script type="text/javascript">
	admin_id=<?php echo $_SESSION['admin_id']; ?>;
       /* jQuery(document).ready( function() 
        {
            $("#user_id").multiselect().multiselectfilter();
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });*/
		$(document).ready(function()
		{            
			$("#country").chosen({allow_single_deselect:true});
			$("#state").chosen({allow_single_deselect:true});
			$("#city").chosen({allow_single_deselect:true});
			$("#course_id").chosen({allow_single_deselect:true});
			$("#source").chosen({allow_single_deselect:true});
			$("#qualification").chosen({allow_single_deselect:true});
			
		});
        function showdiv(val)
        {
            if(val=='Y')
            {
                $(".coursess").hide();
            }
            else
            {
                $(".coursess").show();
            }
        }
        function show_dicount(val)
        {            
            if(val=='Y')
            {
                $(".discount").show();
            }
            else
            {
                $(".discount").hide();
            }
        }
    </script>
<!--<script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
<link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
<script src="js/development-bundle/ui/jquery.ui.core.js"></script>
<script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript">
$(document).ready(function()
{            
	$('.datepicker').datepicker({ changeMonth: true,changeYear: true,dateFormat:'dd/mm/yy', showButtonPanel: true, closeText: 'Clear'});
	$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
	{
		res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
	}
});
</script>
<style type = "text/css">
        #feedback_contact,#feedback_email{
            line-height:;
        }
		.obrderclass{ border:1px solid #f00}
    </style>  
<script type = "text/javascript">
	$(document).ready(function(){ 
	$('#feedback_contact').load('check_mobile.php').show();
	$('#contact').blur(function()
	{
		frm = document.jqueryForm;
		var mobiles=frm.contact.value;
		$.post('check_mobile.php', { mobile1: mobiles },
		//then print the result
		function(result)
		{
			$('#feedback_contact').html(result).show();

		});
	});
});
	</script>
    <script type = "text/javascript">
	$(document).ready(function(){ 
	$('#feedback_email').load('check_email.php').show();
	$('#mail').blur(function()
	{
		frm = document.jqueryForm;
		var mails=frm.mail.value;
		$.post('check_email.php', { mail: mails },
		function(result)
		{
			$('#feedback_email').html(result).show();
		});
	});
});

$(document).ready(function(){ 
	$('#feedback').load('check.php').show();
	$('#username').blur(function()
	{
		//this will pass the form input
		frm = document.jqueryForm;
		var username=frm.username.value;
		$.post('check.php', { username: username },
		//then print the result
		function(result)
		{
			//alert(result);
			$('#feedback').html(result).show();
		});
	});
});
$(document).ready(function()
{ 
	$('#coupon').load('coupon_check.php').show();
	$('#discount_coupon').blur(function()
	{
		frm = document.jqueryForm;
		var discount_coupon=frm.discount_coupon.value;
        $.post('coupon_check.php', { discount_coupon: discount_coupon },
        function(result)
		{
        	$('#coupon').html(result).show();
        });
    });
$('#discount_coupon').blur(function(){
$.post('coupon_check.php', { discount_coupon: jqueryForm.discount_coupon.value },
	function(result)
	{
		$('#coupon').html(result).show();
		});
	});

});
	</script>
	
	<script>
	mail1=Array();
<?php
$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='40' ".$_SESSION['where']."";
$ptr_sel_sms=mysql_query($sel_sms_cnt);
$tot_num_rows=mysql_num_rows($ptr_sel_sms);
$i=0;
while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
{
	"<br/>".$sel_act="select contact_phone,email from site_setting where admin_id='".$data_sel_cnt['staff_id']."' ".$_SESSION['where']."";
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
"<br/>".$sel_mail_text="select email_text from previleges where privilege_id='40'";
$ptr_mail_text=mysql_query($sel_mail_text);
if($tot_mail_text=mysql_num_rows($ptr_mail_text))
{
	$data_mail_text=mysql_fetch_array($ptr_mail_text);
	?>
	email_text_msg='<?php echo  urlencode($data_mail_text['email_text']);?>';
	<?php
}
?>
function send()
{
	branch =document.getElementById('branch_name');
	var branch_name=branch.options[branch.selectedIndex].text; 
	var admission_date =document.getElementById('admission_date').value;
	var inst_student_id =document.getElementById('inst_student_id').value;
	var name=document.getElementById('name').value;
	var contact =document.getElementById('contact').value;
	var mail =document.getElementById('mail').value;
	quali =document.getElementById('qualification');
	var qualification=quali.options[quali.selectedIndex].text;
	var username =document.getElementById('username').value;
	var pass =document.getElementById('pass').value;
	var photo =document.getElementById('photo').value;
	var address =document.getElementById('address').value;
	var per_address =document.getElementById('per_address').value;
	var dob =document.getElementById('dob').value;
	src =document.getElementById('source');
	var source=src.options[src.selectedIndex].text;
	var admission_remark =document.getElementById('admission_remark').value;
	course=document.getElementById('course_id');
	var course_id=course.options[course.selectedIndex].text; 
	var paid_type = $("input[id='paid_type']:checked").val();
	toal_fees=document.getElementById('toal_fees').value;
	var concession =document.getElementById('concession').value;
	var discount_coupon =document.getElementById('discount_coupon').value;
	var net_fees =document.getElementById('net_fees').value;
	//var service_tax =document.getElementById('service_tax').value;
	var fees =document.getElementById('fees').value;
	var down_payment=document.getElementById('down_payment').value;
	//var down_payment_tax =document.getElementById('down_payment_tax').value;
	var down_payment_wo_tax =document.getElementById('down_payment_wo_tax').value;
	var installment_on =document.getElementById('installment_on').value;
	drop =document.getElementById('dropdown');
	var dropdown=drop.options[drop.selectedIndex].text;
	var credit_card_no=document.getElementById('credit_card_no').value;
	var chaque_date=document.getElementById('chaque_date').value;
	var chaque_no =document.getElementById('chaque_no').value;
	var account_no =document.getElementById('account_no').value;
	var cust_bank_name =document.getElementById('cust_bank_name').value;
	drop =document.getElementById('payment_type');
	var payment_type=drop.options[drop.selectedIndex].text;
	var final_amt =document.getElementById('final_amt').value;
	var total_amt =document.getElementById('total_amt').value;
	concat_string='';
	//alert(dropdown);
	if(dropdown)
	{
		dates_array= new Array();
		for(t=1;t<=dropdown;t++)
		{
			var inst_val=parseInt($(".installment_inp_"+t).val());
			var inst_date=$(".date_class"+t).val();
			concat_string +='&inst_val'+t+'='+inst_val+'&inst_date'+t+'='+inst_date;
		}
	}
	
	var users_mail=mail1;		
    data1='action=enroll&branch_name='+branch_name+'&admission_date='+admission_date+'&inst_student_id='+inst_student_id+'&name='+name+'&contact='+contact+'&mail='+mail+'&qualification='+qualification+'&username='+username+'&pass='+pass+'&photo='+photo+'&address='+address+'&per_address='+per_address+'&dob='+dob+'&source='+source+'&admission_remark='+admission_remark+'&course_id='+course_id+'&paid_type='+paid_type+'&toal_fees='+toal_fees+'&concession='+concession+'&discount_coupon='+discount_coupon+'&net_fees='+net_fees+'&fees='+fees+'&down_payment='+down_payment+'&down_payment_wo_tax='+down_payment_wo_tax+'&installment_on='+installment_on+'&dropdown='+dropdown+'&cust_bank_name='+cust_bank_name+'&account_no='+account_no+'&chaque_no='+chaque_no+'&chaque_date='+chaque_date+'&credit_card_no='+credit_card_no+'&final_amt='+final_amt+'&total_amt='+total_amt+'&payment_type='+payment_type+"&users_mail="+users_mail+"&email_text_msg="+email_text_msg+concat_string;
	//alert(data1);
	$.ajax({
	url:'send_email.php',type:"post",data:data1,cache:false,async:false,
	 success: function(response)
		{
		   return true;
		}
	});
									  
	data1='action=verify_enroll&branch_name='+branch_name+'&name='+name+'&course_id='+course_id;
	///alert(data1);
	$.ajax({
	url:'send_email.php',type:"post",data:data1,cache:false,async:false,
	success: function(response)
	{
		//alert(response);
	   return true;
	}
	});
}
</script>
<script>
function counter_check(id)
{
	total_prices='total_prices';
	fee_id = 'fees_'+id;
	id= '#'+id;
	previous = parseInt($('#total_checked_questions').val());
	total_qution=document.getElementById('trotot').value;
	fees_value= parseInt(document.getElementById(fee_id).value);
	sub_fee= parseInt(document.getElementById('sub_fee').value);
	if($(id).is(':checked'))
	{
		previous=	previous+1;
		sub_fee = (sub_fee)+(fees_value);
	}
	else
	{
		previous= previous-1;
		sub_fee = (sub_fee)-(fees_value);
	}
	//}
	$('#total_checked_questions').val(previous);
	total_counter=($('#total_checked_questions').val());
	$('#total_checked_question').val(previous);
	$('#sub_fee').val(sub_fee);
	 //alert(total_counter);
	toal_fees=$('#sub_fee').val();
	total_pricess= parseInt(document.getElementById(total_prices).value);
	if(total_pricess > toal_fees)
	{
		$('#toal_fees').val(toal_fees);
	}
	else
	{
		$('#toal_fees').val(total_pricess);
	}
}
</script>
<script>
//var sep_disc=0;
/*function show_discount()
{
	var discount_coupon = document.getElementById('discount_coupon').value;
	var data12="discount_coupon="+discount_coupon;
	//alert(data12);
	$.ajax({
            url: "get_discount_coupon.php", type: "post", data: data12, cache: false,
            success: function (retrive_func)
            {
				sep_disc=retrive_func
				show_record();
			}
		});
}*/
var sep_disc=0;
function show_discount()
{
	var discount_coupon = document.getElementById('discount_coupon').value;
	var data12="discount_coupon="+discount_coupon;
	//alert(data12);
	$.ajax({
		url: "get_discount_coupon.php", type: "post", data: data12, cache: false,
		success: function (retrive_func)
		{
			sep= retrive_func.split('##');
			var msgs=sep[0];
			var sep_disc=sep[1];
			document.getElementById("discount_coupon_per").value=sep_disc;
			setTimeout(show_record(),500);
			if(msgs!='')
				alert(msgs);
		}
	});
}
function show_record(valss,no)
{    
	frm = document.jqueryForm;    
	concession=0; 
	totals_fees=0;
	balance=0;
	//================================PAID TYPE==========================
	paid_type =frm.paid_type.value;
	var course_exist=document.getElementById("course_id").value;
	if(course_exist !='')
	{
		if(paid_type=='installments')
		{
			var discount_inst=document.getElementById('discount_inst').value;
			document.getElementById('concession').value=discount_inst;
		
			if(document.getElementById('toal_fees') && valss !='' && no==1)
			{
				courses_fees=roundNumber(document.getElementById('toal_fees').value,3);
				document.getElementById('course_only_fee').value=courses_fees;
				
				totals_fees =courses_fees;
				document.getElementById("dropdown").disabled=false;
				down_fees=roundNumber(document.getElementById('down_payment').value,3);
			}
			else
			{
				toatl_one_time=roundNumber(document.getElementById('course_only_fee').value,3);
				inst_tax=roundNumber(document.getElementById('inst_taxes').value,3);
				installment_charge=  roundNumber(toatl_one_time*inst_tax/100,3);
				totals_charge=roundNumber(installment_charge+toatl_one_time,3);
				document.getElementById('toal_fees').value=totals_charge;
				 
				totals_fees = roundNumber(document.getElementById('toal_fees').value,3);
				document.getElementById("dropdown").disabled  = false;
				down_fees=roundNumber(document.getElementById('down_payment').value,3);
			}
		}
		else if(paid_type=='installments_zero')
		{
			var discount_inst=document.getElementById('discount_inst').value;
			document.getElementById('concession').value=discount_inst;
			
			if(document.getElementById('toal_fees') && valss !='' && no==1)
			{
				courses_fees=roundNumber(document.getElementById('toal_fees').value,3);
				document.getElementById('course_only_fee').value=courses_fees;
				totals_fees =courses_fees;
				document.getElementById("dropdown").disabled  = true;
				down_fees=roundNumber(document.getElementById('down_payment').value,3);
			}
			else
			{
				totals_fees = parroundNumberseInt(document.getElementById('course_only_fee').value,3);
				//alert(totals_fees);
				document.getElementById('toal_fees').value=totals_fees;
				document.getElementById("dropdown").disabled  = true;
				down_fees=roundNumber(document.getElementById('down_payment').value,3);
			}
		}
		else
		{
			var discount_otp=document.getElementById('discount_otp').value;
			document.getElementById('concession').value=discount_otp;
			
			//alert(discount_otp);
			if(document.getElementById('toal_fees') && valss !='' && no==1)
			{
				courses_fees=roundNumber(document.getElementById('toal_fees').value,3);
				//alert("course_fee "+courses_fees);
				document.getElementById('course_only_fee').value=courses_fees;
				
				totals_fees =courses_fees;
				document.getElementById("dropdown").disabled  = true;
				var inst1 = document.getElementById("dropdown").disabled  = true;
				$('#dropdown').removeClass("obrderclass");
			}
			else
			{
				document.getElementById("dropdown").disabled  = true;
				var inst1 = document.getElementById("dropdown").disabled  = true;
				$('#dropdown').removeClass("obrderclass");  
				
				courses_fees=roundNumber(document.getElementById('toal_fees').value,3);
				document.getElementById('course_only_fee').value=courses_fees;
				
				totals_fees = parseInt(document.getElementById('course_only_fee').value);
				document.getElementById('toal_fees').value=totals_fees;
			}
		 }
		//===================================================================
		// paid = document.getElementById('paid').value;
		concession = roundNumber(document.getElementById('concession').value,3);
		/*$('#dropdown').prop('selectedIndex',0);
		$("#textboxDiv").html('');*/
		disc_type =frm.discount_type.value;
		if(disc_type!='cash')
		{
			if(concession !='' || concession !=0 || concession<=100 )
			concession=  roundNumber(totals_fees*concession/100,3);
		}
		if(concession !='' || concession<=totals_fees)
		{
			total_bal_ava= roundNumber(totals_fees - concession,3);
		}
		else
		{
			concession=0;
			total_bal_ava= roundNumber(totals_fees - concession,3);
		}
		document.getElementById('disc_pr').innerHTML=concession;
		
		document.getElementById('net_fees').value=total_bal_ava;
		
		var coupon_disc=document.getElementById("discount_coupon_per").value;
		var local = coupon_disc;
		if(local !='' || local !=0)
		{
			var disc_perc= roundNumber(local*total_bal_ava/100,3);
			var total_disc_coupon= roundNumber(total_bal_ava - disc_perc,3);
			document.getElementById('disc_coupon_pr').innerHTML=disc_perc;
			document.getElementById('discount_coupon_price').value=disc_perc;
			document.getElementById('net_fees').value=total_disc_coupon;
		}
	  	var net_fees=roundNumber(document.getElementById('net_fees').value,3);
		
		//=========================For Service Tax==================================
		/*var service_tax=parseFloat(document.getElementById('service_taxes').value);
		var new_tax=parseFloat((service_tax+100)/100);
		var taxable_value = parseInt(net_fees / new_tax);
		var tax =parseInt(net_fees - taxable_value);
		document.getElementById('service_tax').value=tax;*/
		//==============================-------------===============================
		//==============================TOTAL GST ==================================
		// CHhange on 8-5-20- comment code for new GST calculation
		/*var cgsttax=roundNumber(document.getElementById('cgst_taxes').value,3);
		var sgsttax=roundNumber(document.getElementById('sgst_taxes').value,3);
		var totalgst=cgsttax+sgsttax;
		
		var new_total_tax=roundNumber((totalgst+100)/100,3);
		var total_taxable_value = roundNumber(net_fees / new_total_tax,3);
		var total_gst =roundNumber(net_fees - total_taxable_value,3);
		document.getElementById('total_gst').value=total_gst;
		//==========================================================================
		//==============================For CGST====================================
		//var cgst=parseFloat(document.getElementById('cgst_taxes').value); //Changes on 14/11/17 by kiran
		//var new_cgst_tax=parseFloat((cgst+100)/100);
		//var cgst_taxable_value = parseInt(net_fees / new_cgst_tax);
		//var cgast_tax =parseInt(net_fees - cgst_taxable_value);
		cgast_tax=roundNumber(total_gst/2,3)
		document.getElementById('cgst_tax').value=cgast_tax;
		//==========================================================================
		//==============================For SGST====================================
		//var sgst=parseFloat(document.getElementById('sgst_taxes').value);  ////Changes on 14/11/17 by kiran
		//var new_sgst_tax=parseFloat((sgst+100)/100);
		//var sgst_taxable_value = parseInt(net_fees / new_sgst_tax);
		//var sgast_tax =parseInt(net_fees - sgst_taxable_value);
		sgast_tax=parseInt(total_gst/2)
		document.getElementById('sgst_tax').value=sgast_tax;
		//=========================================================================
		//var new_tax=parseFloat(new_cgst_tax)+parseFloat(new_sgst_tax);
		//total_taxes=cgast_tax+sgast_tax;*/
		//===================== FOR GST CALCULATION - 07-05-2020 by kiran ======================
		var cgst=roundNumber(document.getElementById('cgst_taxes').value,3);
		var sgst=roundNumber(document.getElementById('sgst_taxes').value,3);
		var total_gst_per = roundNumber(cgst + sgst,3);
		
		var GST_Amount = roundNumber(net_fees * total_gst_per /(100 + total_gst_per),3);
		var Original_Cost = roundNumber( net_fees * 100/(100 + total_gst_per) ,3);
		
		var total_gst_tax= roundNumber(GST_Amount / 2,3);
		//alert(roundNumber(total_gst_tax , 2));
		document.getElementById('cgst_tax').value=roundNumber(total_gst_tax,3);
		document.getElementById('sgst_tax').value=roundNumber(total_gst_tax,3);
		//======================================================================
		document.getElementById('fees').value=Original_Cost;
		
		if(paid_type=='installments' || paid_type=='installments_zero')
		{
		}
		else
		{
			document.getElementById('down_payment').value=net_fees;
		}
		document.getElementById('total_amt').value=net_fees;
		var fee1 = roundNumber(document.getElementById('fees').value,3);
	    var down_payment =roundNumber(document.getElementById('down_payment').value,3);
		//alert (total_f);
		//==============================TOTAL GST ================================== new development 14/11/17
		//Change on code 8-5-20 -CHanges in code, comment on code for add new GST calcultion
		/*var cgsttax=parseFloat(document.getElementById('cgst_taxes').value);
		var sgsttax=parseFloat(document.getElementById('sgst_taxes').value);
		var totalgst=cgsttax+sgsttax;
		
		var new_total_tax=parseFloat((totalgst+100)/100);
		var total_taxable_value = parseInt(down_payment / new_total_tax);
		var total_down_gst =parseInt(down_payment - total_taxable_value);
		//document.getElementById('total_down_gst').value=total_down_gst;
		//==========================================================================
		//23-9-17**=======================For Down Payment CGST==============================
		//var down_cgst_taxable_value = parseInt(down_payment / new_cgst_tax); // changes 14-11-17
		//var down_cgast_tax =parseInt(down_payment - down_cgst_taxable_value);
		down_cgast_tax=parseInt(total_down_gst/2);
		document.getElementById('down_cgst_tax').value=down_cgast_tax;
		//==========================================================================
		//=========================For Down Payment SGST============================
		//var down_sgst_taxable_value = parseInt(down_payment / new_sgst_tax); // changes 14-11-17
		//var down_sgast_tax =parseInt(down_payment - down_sgst_taxable_value);
		down_sgast_tax=parseInt(total_down_gst/2);
		document.getElementById('down_sgst_tax').value=down_sgast_tax;*/
		//=========================================================================**
		//var dp_taxable_value = parseInt(down_payment / new_tax);
		//var dp_tax =parseInt(down_payment - dp_taxable_value);
		//var total_f= fee1 - dp_taxable_value;
		//================ FOR GST CALCULATION - 07-05-2020 by kiran ===============
		var Down_GST_Amount = roundNumber(down_payment * total_gst_per /(100 + total_gst_per),3);
		var Down_Pay_Original_Cost = roundNumber(down_payment * 100/(100 + total_gst_per),3);
		
		var total_down_gst_tax=roundNumber(Down_GST_Amount / 2,3);
		document.getElementById('down_cgst_tax').value=total_down_gst_tax;
		document.getElementById('down_sgst_tax').value=total_down_gst_tax;
		//=========================================================
		total_f= roundNumber(net_fees - down_payment,3);
		//document.getElementById('down_payment_tax').value=dp_tax;
		//dp_taxable_value=parseInt(down_cgst_taxable_value+down_sgst_taxable_value);
		//down_total_taxes=down_cgast_tax+down_sgast_tax;////23-9-17
		//var total_downpay = parseInt(down_payment - down_total_taxes);
		document.getElementById('down_payment_wo_tax').value=Down_Pay_Original_Cost;
		var pre_inst=document.getElementById('prev_total_inst').value;
		total_f=roundNumber(total_f-pre_inst,3);
		document.getElementById('installment_on').value=total_f;
		//alert(total_f+"="+fee1+" - "+dp_taxable_value);
		document.getElementById('final_amt').value=total_f;
		//alert(total_f);
		if(total_f==0 || paid_type =='one_time')
		{
			var inst1 = document.getElementById("dropdown").disabled  = true;
			$('#dropdown').removeClass("obrderclass");  
			//alert(total_f);
		}
		else if(total_f !=0 && paid_type =='installment_zero')
		{
			var inst1 = document.getElementById("dropdown").disabled  = true;
			$('#dropdown').removeClass("obrderclass");  
			//alert(total_f);
		}
		else{document.getElementById("dropdown").disabled  = false;}
		//total11=parseInt(document.getElementById('fees').value);
		total11=net_fees;
		down_fees11=roundNumber(document.getElementById('down_payment').value,3);
		if(down_fees11 > total11)
		{
			alert('Down Payment is not greater than Net Fees  \n');
			$("#down_payment").val("");
		}
	}
	else
	{
		alert("Please Select Course Name First");
		$('#course_id').addClass("obrderclass"); 
	}
}
</script>
<script>
function show_fees(course_id)
{
	var data1="show_fees=1&course_id="+course_id;
	$.ajax({
            url: "show_fees1.php", type: "post", data: data1, cache: false,
            success: function (retrive_func)
            {
				 document.getElementById('total_fees').innerHTML=retrive_func;
				 show_record();
			}
		});
}
function show_bank(branch_id,vals)
{
	record_id= document.getElementById("record_id").value;
//============================================================
	var res = branch_id.substring(0, 3);
	var d = new Date();
	var n = d.getFullYear();
	var branch=res.toUpperCase();
	var add =branch;
	var display_id=document.getElementById("inst_student_id").value;
	var res_str = display_id.substring(5, 8);
	stud_id=display_id.replace(res_str,add);
	//alert(stud_id);
	document.getElementById("inst_student_id").value=stud_id;
//=============================================================
	var bank_data="action=enroll&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
	//alert(bank_data);
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
		document.getElementById("inst_tax_id").innerHTML=installment_tax;
		document.getElementById("cgst_id").innerHTML=cgst;
		document.getElementById("sgst_id").innerHTML=sgst;
		document.getElementById("down_cgst_id").innerHTML=cgst;
		document.getElementById("down_sgst_id").innerHTML=sgst;
		
		//document.getElementById("service_taxes").value=service_tax;
		document.getElementById("inst_taxes").value=installment_tax;
		document.getElementById("cgst_taxes").value=cgst;
		document.getElementById("sgst_taxes").value=sgst;
		document.getElementById("down_cgst_taxes").value=cgst;
		document.getElementById("down_sgst_taxes").value=sgst;
		//alert("service tax- "+service_tax);
		course_id1 =document.getElementById("course_id").value;
		//alert(document.getElementById("service_taxes").value);
		if(course_id1 !='')
		{
			show_course(course_id1);
		}
	}
	});
	show_staff(branch_id,admin_id);
}
function show_bank_for_payment_mode(branch_id,vals)
{
	record_id= document.getElementById("record_id").value;
	var bank_data="action=enroll&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
	//alert(bank_data);
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
		document.getElementById("inst_tax_id").innerHTML=installment_tax;
		document.getElementById("cgst_id").innerHTML=cgst;
		document.getElementById("sgst_id").innerHTML=sgst;
		document.getElementById("down_cgst_id").innerHTML=cgst;
		document.getElementById("down_sgst_id").innerHTML=sgst;
		
		//document.getElementById("service_taxes").value=service_tax;
		document.getElementById("inst_taxes").value=installment_tax;
		document.getElementById("cgst_taxes").value=cgst;
		document.getElementById("sgst_taxes").value=sgst;
		document.getElementById("down_cgst_taxes").value=cgst;
		document.getElementById("down_sgst_taxes").value=sgst;
		//alert("service tax- "+service_tax);
		//course_id1 =document.getElementById("course_id").value;
		//alert(document.getElementById("service_taxes").value);
		/*if(course_id1 !='')
		{
			show_course(course_id1);
		}*/

	}
	});
	
}
function show_staff(branch_id)
{
	var record_id= document.getElementById("record_id").value;
	var bank_data="action=enrollment&branch_id="+branch_id+"&record_id="+record_id+"&admin_id="+admin_id;
	//alert(bank_data);
	$.ajax({
	url: "show_councellor.php",type:"post", data: bank_data,cache: false,
	success: function(retbank)
	{
		//alert(retbank);
		document.getElementById("employee_id").innerHTML=retbank;
	}
	}); 
}
$(document).ready(function() {

    $("#course_id").change(function() {
        var selVal = $(this).val();
        $("#customise").html('');
        if(selVal == 'custome') 
		{
            $("#customise").append('<table width="100%"><tr><td width="23%" class="heading">Customize Course</span></td><td width="40%" colspan=2"><input type="text" class="input_text" name="costomize_courses"/></td></tr></table>');
		}
		else{}
    });
});


function select_state(country_id)
{
	var state_data="action=state&country_id="+country_id;
	$.ajax({
	url: "ajax_state_city.php",type:"post", data: state_data,cache: false,
	success: function(retstate)
	{
		//alert(retbank);
		document.getElementById("show_states").innerHTML=retstate;
		document.getElementById("city").innerHTML='';
		
		$("#state").chosen({allow_single_deselect:true});
		$("#city").chosen({allow_single_deselect:true});

	}
	});
}
function select_city(state_id)
{
	var city_data="action=city&state_id="+state_id;
	$.ajax({
	url: "ajax_state_city.php",type:"post", data: city_data,cache: false,
	success: function(retcity)
	{
		//alert(retbank);
		document.getElementById("show_cities").innerHTML=retcity;
		$("#city").chosen({allow_single_deselect:true});
	}
	});
}


</script>
<script type="text/javascript">
function show() { document.getElementById('payment').style.display = 'block'; $('#pay_type').removeClass("obrderclass");  }
function hide() { document.getElementById('payment').style.display = 'none'; $('#pay_type').removeClass("obrderclass");  }
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
		
		show_bank_for_payment_mode(branch_name,"cheque")
	}
	else if(payment_mode[0]=="Credit Card")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'block';
		document.getElementById("bank_ref_no").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"credit_card")
		
	}
	else if(payment_mode[0]=="paytm")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		document.getElementById("bank_ref_no").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"paytm")
	}
	else if(payment_mode[0]=="online")
	{
		document.getElementById("bank_ref_no").style.display = 'block';
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"online")
	}
	else if(payment_mode[0]=="CF Loan")
	{
		document.getElementById("bank_ref_no").style.display = 'block';
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"CF Loan")
	}
	else
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'none';
		document.getElementById("credit_details").style.display = 'none';
		document.getElementById("bank_ref_no").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"")
	}
}
function show_acc_no(bank_id)
{
	var data1="action=show_account&bank_id="+bank_id;
	$.ajax({
	url: "ajax.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		document.getElementById('account_no').value=html;
	}
	});
}
</script> 

<script type="text/javascript">
$(document).ready(function() {
    $("#dropdown").change(function() 
	{
        var selVal = $(this).val();
        $("#textboxDiv").html('');
		var inst =parseInt (document.getElementById('installment_on').value);
		var no_inst = inst/selVal ;
		document.getElementById('final_amt').value=inst;
		//alert (no_inst);
        if(selVal > 0)
		{
            for(var i = 1; i<= selVal; i++) 
			{
                $("#textboxDiv").append('<table width="100%"><tr><td width="23%" class="heading">Installment '+i+' </span></td><td width="40%" colspan="2"><input type="text" class="input_text installment_input installment_inp_'+i+'" alt="'+i+'" name="installments[]" id="date_class1'+i+'" value="'+parseFloat(no_inst).toFixed(2)+'" /></td><td><input type="text" name="installment_date[]" class="datepicker date_class'+i+'" id="date_class'+i+'" placeholder="installment date " ></td></tr></table>');
            }
			$('#dropdown').removeClass("obrderclass"); 
			$(".installment_input").blur(function()
            {
                var installment_on = $("#installment_on").val();
                if(installment_on)
                installment_on = parseInt(installment_on);
                var installments = $("#dropdown").val();
                var current_number = parseInt($(this).attr('alt'));
                var current_value = parseInt($(this).val());
                var prev_total = 0;
                for(var p=1;p<current_number;p++)
                {
                    var input_value = parseInt($(".installment_inp_"+p).val());
                    prev_total = prev_total + input_value;
                }
                if(current_value<=installment_on-prev_total)
                {
                    prev_total = prev_total + current_value;
                    if(prev_total<installment_on)
                    {
                        var final_total_installment = installment_on-prev_total;
                        var final_installment_term = parseFloat((final_total_installment/(installments-current_number)).toFixed(2));
                    }
                    else
                        final_installment_term=0;
                    for(var u=current_number+1;u<=installments;u++)
                    {
                        $(".installment_inp_"+u).val(final_installment_term);
                    }
                    var last_vale_select = $("#dropdown option:last-child").val();
                    if(current_number==last_vale_select-1)
                    {
                        $(".installment_inp_"+last_vale_select).prop('disabled',true);
                    }
           		}
            	else
            	{
            		$(this).val('');
                	for(var u=current_number+1;u<=installments;u++)
                	{
                		$(".installment_inp_"+u).val('');
                	}
                	alert("Invalid input.");
            	}
        	}); 
        }
		else
		$('#dropdown').addClass("obrderclass"); 
		$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
    });
});
</script>
<style type = "text/css">
	#feedback
	{
    	line-height:;
    }
	.obrderclass{ border:1px solid #f00}
</style>  
<script type = "text/javascript">
function validme()
{
	frm = document.jqueryForm;
	error='';
	disp_error = 'Clear The Following Errors : \n\n';
	document.getElementById('hide_btns').style.display ='none';
	/*if(frm.admission_date.value=='')
	{
		disp_error +='Enter Admission date\n';
		document.getElementById('admission_date').style.border = '1px solid #f00';
		frm.admission_date.focus();
		error='yes';
	}*/
	if(frm.name.value=='')
	{
		disp_error +='Enter  Name\n';
		document.getElementById('name').style.border = '1px solid #f00';
		frm.name.focus();
		error='yes';
	}
	if(frm.dob.value=='')
	{
		disp_error +='Enter Date Of Birth\n';
		document.getElementById('dob').style.border = '1px solid #f00';
		frm.dob.focus();
		error='yes';
	}
	else
	{
		if(isPastDate(frm.dob.value))
		{
			var date1 = new Date(frm.dob.value);
			var date2 = new Date();
			var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24)); 
			if(diffDays<5475)
			{
				 disp_error +='Your Age is not valid for admission. need more than 15 year age\n';
				 document.getElementById('dob').style.border = '1px solid #f00';
				 frm.dob.focus();
				 error='yes';
			}
		}
		else
		{
			disp_error +='Enter Valid Date Of Birth\n';
			document.getElementById('dob').style.border = '1px solid #f00';
			frm.dob.focus();
			error='yes';
		}
	}
	if(frm.contact.value=='')
	{
		disp_error +='Enter Mobile Number \n';
		document.getElementById('contact').style.border = '1px solid #f00';
		frm.contact.focus();
		error='yes';
	}
	else 
	{	
		var text = frm.contact.value;
		if(text.length <10)
		{
			disp_error +='Enter Valid Mobile Number \n';
			document.getElementById('contact').style.border = '1px solid #f00';
			error='yes';
		}
	}
	if(frm.home_contact.value=='')
	{
		disp_error +='Enter Parents Mobile Number \n';
		document.getElementById('home_contact').style.border = '1px solid #f00';
		frm.home_contact.focus();
		error='yes';
	}
	else
	{
		var text = frm.home_contact.value;
		if(text.length <10)
		{
			disp_error +='Enter Valid Mobile Number \n';
			document.getElementById('home_contact').style.border = '1px solid #f00';
			error='yes';
		}
	}
	/*  if(frm.contact.value)
	 {
		user_mobile= document.getElementById("user_mobile").innerHTML;
		if(user_mobile == "Mobile No already taken.")
		{
			disp_error +='Mobile No. already Exist. Please try other no.\n';
			document.getElementById('contact').style.border = '1px solid #f00';
			frm.contact.focus();
			error='yes';
		}
	} */
	
	if(frm.mail.value=='')
	{
		disp_error +='Enter Email ID\n';
		document.getElementById('mail').style.border = '1px solid #f00';
		frm.mail.focus();
		error='yes';
	
	}
	else 
	{
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if (reg.test(document.getElementById("mail").value) == false) 
		{
			disp_error +='Invalid Email Address\n';
			document.getElementById('mail').style.border = '1px solid #f00';
			frm.mail.focus();
			error='yes';
		}
	}
	if(frm.mail.value)
	{
		user_email= document.getElementById("user_email").innerHTML;
		if(user_email == "Email already taken.")
		{
			
			disp_error +='Email already Exist. Please try other Email\n';
			document.getElementById('mail').style.border = '1px solid #f00';
			frm.mail.focus();
			error='yes';
		}
	}
	if(frm.username.value=='')
	{
		disp_error +='Enter User Name \n';
		document.getElementById('username').style.border = '1px solid #f00';
		frm.username.focus();
		error='yes';
	}
	else
	{
		var text = frm.username.value;
		text = text.split(' '); //we split the string in an array of strings using     whitespace as separator
		if(text.length > 1)
		{
			disp_error +='Enter Valid User Name\n';
			document.getElementById('username').style.border = '1px solid #f00';
			frm.username.focus();
			error='yes';
		}
		else if(frm.username.value)
		{
			spl = isSpclChar('username');	
			if(spl =='yes')
			{
				disp_error +='Special Character Not Allowed in Uesr Name\n';
				document.getElementById('username').style.border = '1px solid #f00';
				frm.username.focus();
				error='yes';
			}
			else
			{
				user_text= document.getElementById("user_text").innerHTML;
				if(user_text == "Username already taken.")
				{
					disp_error +='Uesr Name already Exist. Please try other username\n';
					document.getElementById('username').style.border = '1px solid #f00';
					frm.username.focus();
					error='yes';
				}
			}
		} 
	}
	if(frm.pass.value=='')
	{
		disp_error +='Enter Password \n';
		document.getElementById('pass').style.border = '1px solid #f00';
		frm.pass.focus();
		error='yes';
	}
	if(frm.address.value=='')
	{
		disp_error +='Enter address \n';
		document.getElementById('address').style.border = '1px solid #f00';
		frm.pass.focus();
		error='yes';
	}
	if(frm.country.value=='')
	{
		disp_error +='Select Country \n';
		document.getElementById('country').style.border = '1px solid #f00';
		frm.country.focus();
		error='yes';
	}
	if(frm.state.value=='')
	{
		disp_error +='Select State \n';
		document.getElementById('state').style.border = '1px solid #f00';
		frm.state.focus();
		error='yes';
	}
	if(frm.city.value=='')
	{
		disp_error +='Select City \n';
		document.getElementById('city').style.border = '1px solid #f00';
		frm.city.focus();
		error='yes';
	}
	if(frm.course_id.value=='')
	{
		disp_error +='Select Course Name \n';
		document.getElementById('course_id').style.border = '1px solid #f00';
		frm.course_id.focus();
		error='yes';
	}
	if(frm.source.value=='')
	{
		disp_error +='Select Enquiry Source \n';
		document.getElementById('source').style.border = '1px solid #f00';
		frm.source.focus();
		error='yes';
	}
	if(frm.down_payment.value==0 && frm.net_fees.value >0)
	{
		//alert(down_payment);
		disp_error +='Add Down Payment\n';
		$("#down_payment").addClass("obrderclass");
		error='yes';
	}
	else
	{
		$("#down_payment").removeClass("obrderclass");
	}
	total11=parseInt(document.getElementById('net_fees').value);
	//total11=parseInt(document.getElementById('fees').value);
	down_fees11=parseInt(document.getElementById('down_payment').value);
		if(down_fees11 > total11)
	{
		disp_error +='Down Payment is not greater than Total Fees  \n';
		$("#down_payment").addClass("obrderclass");
		frm.down_payment.focus();
		error='yes';
	}
	//================= Installment Date Validation===================
	no_of_installments = $("#dropdown").val();
	if(no_of_installments)
	{
		x=0;
		dates_array= new Array();
		//alert(no_of_installments);
		for(t=1;t<=no_of_installments;t++)
		{
			//alert($("#date_class"+t).val());
			if($(".date_class"+t).val()=='')
			{
				disp_error += t+' Installment date  is not added \n'; 
				error='yes';	
				//(".date_class"+t).addClass("obrderclass");
			}
			else
			{
				var new_inst_date=$(".date_class"+t).val().split("/");
				inst_date=new_inst_date[2]+"-"+new_inst_date[1]+"-"+new_inst_date[0];
				//alert("inst date-  "+inst_date);
				var targets = Date.parse(inst_date);
				now = new Date;
				today_date = now.getTime();
				admission_date= document.getElementById("admission_date").value;
				//new_ad_date= admission_date.getTime(); 
				var new_add_date=admission_date.split("/");
				add_date=new_add_date[2]+"-"+new_add_date[1]+"-"+new_add_date[0];
				//alert("add_date-  "+add_date);		
				var milliseconds = Date.parse(add_date); // some mock date
				//var milliseconds = date.getTime(); 
				//alert(targets +"   "+milliseconds);
				if(targets <milliseconds)//targets.getTime()<=milliseconds
				{
					disp_error += t+' Installment date should be greate than Admission date\n'; 
					$(".date_class"+t).addClass("obrderclass"); 
					error='yes';
				}
				else
				{
					dates_array[x]=targets;
					$(".date_class"+t).removeClass("obrderclass");
					x++;
				}
			}
		}
		///=========== Installemnt date less than greater than validation
		error_found_asc = '';
		s=0
		for(j=0;j<dates_array.length;j++)
		{
			for(k=j+1;k<dates_array.length;k++)
			{
				if(dates_array[j]>dates_array[k])//dates_array[j]>=dates_array[k]
				{
					error_found_asc ='yes';
					s=k;
					break;
				}
			}
		}
		if(error_found_asc=='yes')
		{
			disp_error +='Installment date not in incresing order \n'; 
			$(".date_class"+s).addClass("obrderclass"); 
			error='yes';
		}
	}
	if($('#installment_on').val() !=0 && $('#dropdown').val()==0)
	{
		disp_error +='Installment is not selected Or Paid type is wrong \n'; 
		error='yes';
		$('#dropdown').addClass("obrderclass"); 
		frm.numDep.focus();
	}
	else
		$('#dropdown').removeClass("obrderclass"); 
	//================= END Installmetn Dat4 Validation=========================
	if($('#payment_type').val() =="select")
	{
		disp_error +='Payment mode not selected \n'; 
		$('#payment_type').addClass("obrderclass"); 
		error='yes';
	}
	else
	{
		pay_value=$('#payment_type').val();
		pay_type=pay_value.split('-');
		payment_types=pay_type[0];
		/*$('#pay_type').removeClass("obrderclass"); 
		var selected = $($($('#payment_type').val() =="select");
		if (selected.length > 0) {
		selectedVal = selected.val();*/
		if(payment_types =='cheque')
		{
			if(frm.cust_bank_name.value=='')
			{
				disp_error +='Select Customer  bank name \n';
				error='yes';
				document.getElementById('cust_bank_name').style.border = '1px solid #f00';
				frm.cust_bank_name.focus();
			}
			if(frm.bank_name.value=='select')
			{
				disp_error +='Select ISAS bank name \n';
				error='yes';
				document.getElementById('bank_name').style.border = '1px solid #f00';
				frm.bank_name.focus();
			}
			if(frm.account_no.value=='')
			{
				disp_error +='Enter Account Number of ISAS bank \n';
				error='yes';
				document.getElementById('account_no').style.border = '1px solid #f00';
				frm.account_no.focus();
			}
			if(frm.chaque_no.value=='')
			{
				disp_error +='Cheque Number is blank \n';
				error='yes';
				document.getElementById('chaque_no').style.border = '1px solid #f00';
				frm.chaque_no.focus();
			}
			if(frm.chaque_date.value=='')
			{
				disp_error +='Cheque date is blank \n';
				error='yes';
				$('#chaque_date').addClass("obrderclass"); 
				frm.chaque_date.focus();
			}
		}
		else if(payment_types =='Credit Card')
		{
			if(frm.cust_bank_name.value=='')
			{
				disp_error +='Select Customer  bank name \n';
				error='yes';
				document.getElementById('cust_bank_name').style.border = '1px solid #f00';
				frm.cust_bank_name.focus();
			}
			if(frm.bank_name.value=='select')
			{
				disp_error +='Select ISAS bank name \n';
				error='yes';
				document.getElementById('bank_name').style.border = '1px solid #f00';
				frm.bank_name.focus();
			}
			if(frm.account_no.value=='')
			{
				disp_error +='Enter Account Number of ISAS bank \n';
				error='yes';
				document.getElementById('account_no').style.border = '1px solid #f00';
				frm.account_no.focus();
			}
			if(frm.credit_card_no.value=='')
			{
				disp_error +='Enter Credit Card Number \n';
				error='yes';
				document.getElementById('credit_card_no').style.border = '1px solid #f00';
				frm.credit_card_no.focus();
			}
		}
	}
	if(error=='yes')
	{
		alert(disp_error);
		document.getElementById('hide_btns').style.display ='block';
		return false;
	}
	else
	{
		return send();
	}		
	return true;
}
	function isPastDate(value) {
        var now = new Date;
        var target = new Date(value);
		var new_date=value.split("/");
		
        if (new_date[2] < now.getFullYear()) {
            return true;
        } else if (new_date[1] < now.getMonth()) {
            return true;
        } else if (new_date[0] < now.getDate()) {
            return true;
        }
        return false;
    }
	 function isFeatureDate(value) {
        var now = new Date;
        var target = new Date(value);
        var new_date=value.split("/");
        if (new_date[2] > now.getFullYear()) {
            return true;
        } else if (new_date[1] > now.getMonth()) {
            return true;
        } else if (new_date[0]  >= now.getDate()) {
            return true;
        }
        return false;
    }
	function isNumber(evt) 
	{
    	evt = (evt) ? evt : window.event;
    	var charCode = (evt.which) ? evt.which : evt.keyCode;
    	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
/*function validateEmail(emailField)
{
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if (reg.test(document.getElementById(emailField).value) == false) 
    {
    	alert('Invalid Email Address');
		document.getElementById('mail').style.border = '1px solid #f00';
		document.getElementById(emailField).focus();
      return false;
    }
    return true;
}*/
function isSpclChar(id)
{
	var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>? ";
	vals = document.getElementById(id).value;
	for (var i = 0; i < vals.length; i++) 
	{
		if (iChars.indexOf(vals.charAt(i)) != -1) 
		{
			return 'yes';
		}
    }
}  
</script>
<script type="text/javascript">
function submitform()
{
	document.customerData.submit();
}
function user_credential(val)
{
	if(val=="auto")
	{
		var contact=document.getElementById('contact').value;	
		document.getElementById('username').value=contact;
		document.getElementById('pass').value=contact;
	}
	else
	{
		document.getElementById('username').value='';
		document.getElementById('pass').value='';
	}
}
</script>
</head>
<body>
<?php include "include/header.php";?>
<!--info start-->
<div id="info">
<!--left start-->
<?php include "include/menuLeft.php"; ?>
</div>
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
        <table width="100%" cellspacing="0" cellpadding="0">            
        <?php
        	$errors=array(); $i=0;
            $success=0;
			if($_POST['save_records'] && $_POST['randcheck']==$_SESSION['rand'])
            {
				$sac_code=($_POST['sac_code']) ? $_POST['sac_code'] : "";
				$name=( ($_POST['name'])) ? $_POST['name'] : "";
				$username=( ($_POST['username'])) ? $_POST['username'] : "";
				$pass=( ($_POST['pass'])) ? $_POST['pass'] : "";
				$tan_date=explode('/',$_POST['dob'],3);
				$dob=$tan_date[2].'-'.$tan_date[1].'-'.$tan_date[0];
				$dob1=( ($_POST['dob'])) ? $_POST['dob'] : "";
				$batch_id=( ($_POST['batch_id'])) ? $_POST['batch_id'] : "0";
				$address=( ($_POST['address'])) ? $_POST['address'] : "";
				$per_address=( ($_POST['per_address'])) ? $_POST['per_address'] : "";
				$country=(true== isset($_POST['country'])) ? $_POST['country'] : "";
				$state=(true== isset($_POST['state'])) ? $_POST['state'] : "";
				$city=(true== isset($_POST['city'])) ? $_POST['city'] : "";
				$contact=( ($_POST['contact'])) ? $_POST['contact'] : "";
				$contact_home=(true== isset($_POST['home_contact'])) ? $_POST['home_contact'] : "";
				$mail=( ($_POST['mail'])) ? $_POST['mail'] : "";
				$qualification=( ($_POST['qualification'])) ? $_POST['qualification'] : "";
				$photo=( ($_POST['photo'])) ? $_POST['photo'] : "";
				$invoice_no=( ($_POST['invoice_no'])) ? $_POST['invoice_no'] : "0";
				/*if($_POST['inquiry_date'] !='') {
					$inquiry_date=( ($_POST['inquiry_date'])) ? $_POST['inquiry_date'] : "";
					$inqtan_date=explode('/',$_POST['inquiry_date'],3);
					$inquiry_date=$inqtan_date[2].'-'.$inqtan_date[1].'-'.$inqtan_date[0];
				}
				else
					$inquiry_date='';*/
				$paid_type=( ($_POST['paid_type'])) ? $_POST['paid_type'] : "";
				$source=( ($_POST['source'])) ? $_POST['source'] : "";
				$admission_remark=( ($_POST['admission_remark'])) ? $_POST['admission_remark'] : "";
				$course=( ($_POST['course_id'])) ? $_POST['course_id'] : "0";
				$customised_course=( ($_POST['customised_course'])) ? $_POST['customised_course'] : "0";
				/*if($course =='custome')
					$course=$customised_course;*/
				if($_POST['admission_date'] !='') {
					$admission_date=( ($_POST['admission_date'])) ? $_POST['admission_date'] : "";
					$adtan_date = explode('/',$admission_date);
					$admission_date=$adtan_date[2].'-'.$adtan_date[1].'-'.$adtan_date[0];
				}
				else
					$admission_date='';
				$course_fees=( ($_POST['total_fees'])) ? $_POST['total_fees'] : "0";
				$discount_coupon_code=( ($_POST['discount_coupon'])) ? $_POST['discount_coupon'] : "";
				$discount_coupon_per=( true== isset($_POST['discount_coupon_per'])) ? $_POST['discount_coupon_per'] : "";
				$discount_coupon_price=(($_POST['discount_coupon_price'])) ? $_POST['discount_coupon_price'] : "";
				$discount=( ($_POST['concession'])) ? $_POST['concession'] : "0";	
				$discount_type=( ($_POST['discount_type'])) ? $_POST['discount_type'] : "";	
				
				$paid=( ($_POST['down_payment'])) ? $_POST['down_payment'] : "0";	
				//$down_payment_tax=( ($_POST['down_payment_tax'])) ? $_POST['down_payment_tax'] : "";	
				$down_payment_wo_tax=( ($_POST['down_payment_wo_tax'])) ? $_POST['down_payment_wo_tax'] : "";
				
				$cust_bank_name="";		
				$bank_name="0";	
				$chaque_no="0";	
				$cust_gst_no="0";	
				$chaque_date="";
				$credit_card_no="";		
				$bank_ref_no="";		
				if($_POST['payment_type'] !='')
				{
					$payment_mode=( ($_POST['payment_type'])) ? $_POST['payment_type'] : "";
					$sep=explode("-",$payment_mode);
					$payment_type=$sep[1];
					$payment_type_val=$sep[0];
					
					if($payment_type_val !="cash")
					{
						$cust_bank_name=( ($_POST['cust_bank_name'])) ? $_POST['cust_bank_name'] : "";		
						$bank_name=( ($_POST['bank_name'])) ? $_POST['bank_name'] : "0";	
						$chaque_no=( ($_POST['chaque_no'])) ? $_POST['chaque_no'] : "0";	
						$cust_gst_no=( ($_POST['cust_gst_no'])) ? $_POST['cust_gst_no'] : "0";	
						$chaque_date= $_POST['chaque_date'];
						$tan_date = explode('/',$chaque_date);
						$chaque_date=$tan_date[2].'-'.$tan_date[1].'-'.$tan_date[0];
						$chaque_date=( ($chaque_date)) ? $chaque_date : "";	
						$credit_card_no=( ($_POST['credit_card_no'])) ? $_POST['credit_card_no'] : "";		
						$bank_ref_no=($_POST['bank_ref_no']) ? $_POST['bank_ref_no'] : "";	
					}
				}
				$installment_on=( ($_POST['installment_on'])) ? $_POST['installment_on'] : "0";
				$net_fees=( ($_POST['net_fees'])) ? $_POST['net_fees'] : "0";
				$total_fees=( ($_POST['total_fees'])) ? $_POST['total_fees'] : "0";
				$cust_gst_no=( ($_POST['cust_gst_no'])) ? $_POST['cust_gst_no'] : "";
				
				$down_payment=( ($_POST['down_payment'])) ? $_POST['down_payment'] : "0";
				//$down_payment_tax=( ($_POST['down_payment_tax'])) ? $_POST['down_payment_tax'] : "0";
				$down_payment_wo_tax=( ($_POST['down_payment_wo_tax'])) ? $_POST['down_payment_wo_tax'] : "0";
				$first_installment=( ($_POST['numDep'])) ? $_POST['numDep'] : "0";
				$branch_name=( ($_POST['branch_name'])) ? $_POST['branch_name'] : "";
				$final_amt=( ($_POST['final_amt'])) ? $_POST['final_amt'] : "0";
				$inst_student_id=( ($_POST['inst_student_id'])) ? $_POST['inst_student_id'] : "";
				
				$added_date=$admission_date;
				$employee_id=($_POST['employee_id']) ? $_POST['employee_id'] : '' ;			
				$cgst_tax= ($_POST['cgst_tax']) ? $_POST['cgst_tax'] : '0' ;
				$cgst_tax_in_per= ($_POST['cgst_taxes']) ? $_POST['cgst_taxes'] : "0";
				
				$sgst_tax=( $_POST['sgst_tax'] ) ? $_POST['sgst_tax'] : "0";
				$sgst_tax_in_per= ( $_POST['sgst_taxes'] ) ? $_POST['sgst_taxes'] : "0";
				
				$down_cgst_tax= ($_POST['down_cgst_tax']) ? $_POST['down_cgst_tax'] : '0' ;
				$down_cgst_tax_in_per= ($_POST['down_cgst_taxes']) ? $_POST['down_cgst_taxes'] : "0";
				
				$down_sgst_tax=( $_POST['down_sgst_tax'] ) ? $_POST['down_sgst_tax'] : "0";
				$down_sgst_tax_in_per= ( $_POST['down_sgst_taxes'] ) ? $_POST['down_sgst_taxes'] : "0";

				if(!$record_id)
				{
					$chk_exist = " select enroll_id from enrollment where username='$username' ";
					$ptr_chk_exit = mysql_query($chk_exist);
					if(mysql_num_rows($ptr_chk_exit))
					{
						if(mysql_num_rows($ptr_chk_exit)==1 )
                        {   
							$data_fetch = mysql_fetch_array($ptr_chk_exit);
							if($record_id!=$data_fetch['enroll_id'])
							{
								$success=0;
								$errors[$i++]="Username Already Exist. Choose Other username ";
							}
						}
						else
						{
							$success=0;
							$errors[$i++]="Username Already Exist. Choose Other username ";
						}
					}
				}
				if($name =="")
                {
					$success=0;
					$errors[$i++]="Enter Student Name";
				}
				if($username =='')
				{
					$success=0;
					$errors[$i++]="Enter Username";	
				}
				else
				{
					if (!preg_match('/^([a-z0-9])+$/iD',$username))
					{
						$success=0;
						$errors[$i++]="Invalid Username. Only Letter and Number allowed";
					}
				}
				if($pass =="")
				{
					$success=0;
					$errors[$i++]="Enter Password";
				}
				if($address =="")
				{
					$success=0;
					$errors[$i++]="Enter Address";
				}
				if($dob1 =="")
				{
					$success=0;
					$errors[$i++]="Enter Date Of Birth";
				}
				else
				{
					$tan_date=explode('/',$_POST['dob'],3);
					$dob=$tan_date[2].'-'.$tan_date[1].'-'.$tan_date[0];
				}
				if($admission_date =="")
				{
					$success=0;
					$errors[$i++]="Enter Admission Date";
				}
				else
				{
					$ad_date=explode('/',$_POST['admission_date'],3);
					$admission_date=$ad_date[2].'-'.$ad_date[1].'-'.$ad_date[0];
				}
				if($contact =="")
				{
					$success=0;
					$errors[$i++]="Enter Student Contact Number";
				}else
				{
					if(!preg_match('/^([0-9]{10,12})+$/iD',$contact))
					{
						$success=0;
						$errors[$i++]="Invalid Contact No. 10 to 12 digit allowed";
					}
				}
				if($mail =="")
				{
					$success=0;
					$errors[$i++]="Enter Student Email Id";
				}
				else
				{
					if(!filter_var($mail, FILTER_VALIDATE_EMAIL))
					{
						$success=0;
						$errors[$i++]="Invalid Email ID ";
					}
				}
				if($payment_type =="select")
				{
					$success=0;
					$errors[$i++]="".$payment_type." Please Select Payment mode";
				}
                       $uploaded_url="";
                            if(count($errors)==0 && $_FILES['photo']["name"])
                            {
                                if($record_id)
                                {
                                   $update_news="update enrollment set photo='' where enroll_id='".$record_id."'";
                                    $db->query($update_news);
                                    if($row_record['photo'] && file_exists("../student_photos/".$row_record['photo']))
                                        unlink("../student_photos/".$row_record['photo']);
                                    if($row_record['photo'] && file_exists("../student_photos/".$row_record['photo']))
                                        unlink("../student_photos/".$row_record['photo']);
                                }
                                $uploaded_url=time().basename($_FILES['photo']["name"]);
                                $newfile = "../student_photos/";
                                $filename = $_FILES['photo']['tmp_name']; // File being uploaded.
                                $filetype = $_FILES['photo']['type'];// type of file being uploaded
                                $filesize = filesize($filename); // File size of the file being uploaded.
                                $source1 = $_FILES['photo']['tmp_name'];
                                $target_path1 = $newfile.$uploaded_url;
                                list($width1, $height1, $type1, $attr1) = getimagesize($source1);
                                if(strtolower($filetype) == "image/jpeg" || strtolower($filetype) == "image/pjpeg" || strtolower($filetype) == "image/GIF" || strtolower($filetype) == "image/gif" || strtolower($filetype) == "image/png")
                                {
                                    if(move_uploaded_file($source1, $target_path1))
                                    {
                                        $thump_target_path="../student_photos/".$uploaded_url;
                                        copy($target_path1,$thump_target_path);
                                        list($width, $height, $type, $attr) = getimagesize($thump_target_path);
                                        if($width<=170 && $height<=170)
                                        {
                                            $file_uploaded=1;
                                        }
                                        else
                                        {
                                            //------------resize the image----------------
                                            $obj_img1 = new thumbnail_images();
                                            $obj_img1->PathImgOld = $thump_target_path;
                                            $obj_img1->PathImgNew = $thump_target_path;
                                            $obj_img1->NewWidth = 150;
                                            $obj_img1->NewHeight = 171;
                                            if (!$obj_img1->create_thumbnail_images())
                                            {
                                                $file_uploaded=0;
                                                unlink($target_path1);
                                                $success=0;
                                                $errors[$i++]="There are some errors while uploading image, please try again";
                                            }
                                            else
                                            {
                                                $file_uploaded=1;
                                               /* list($width, $height, $type, $attr) = getimagesize($thump_target_path);
                                                //echo $width.$height;
                                                if($height>100)
                                                {
                                                    $obj_img1 = new thumbnail_images();
                                                    $obj_img1->PathImgOld = $thump_target_path;
                                                    $obj_img1->PathImgNew = $thump_target_path;
                                                    $obj_img1->NewHeight = 100;
                                                    if (!$obj_img1->create_thumbnail_images())
                                                    {
                                                        $file_uploaded=0;
                                                        unlink($target_path1);
                                                        $uploaded_url="";
                                                    }                                                    
                                                }
                                                */
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $file_uploaded=0;
                                        $success=0;
                                        $errors[$i++]="There are some errors while uploading image, please try again";
                                    }
                                }
                                else
                                {
                                    $file_uploaded=0;
                                    $success=0;
                                    $errors[$i++]="Location image: Only image files allowed";
                                }
                        }
                        if(count($errors))
                        {
                                ?>
                        <tr><td> <br></br>
                                <table align="left" style="text-align:left;" class="alert">
                                <tr><td ><strong>Please correct the following errors</strong><ul>
                                        <?php
                                        for($k=0;$k<count($errors);$k++)
                                                echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>
                                        </ul>
                                </td></tr>
                                </table>
                         </td></tr>   <br></br>  
                    <?php
                        }
                        else
                        {
                            $success=1;
							$data_record['sac_code']=$sac_code;
							$data_record['name']=$name;
                            $data_record['username'] =$username;
                            $data_record['pass'] =$pass;
                            $data_record['dob'] =$dob;
							$data_record['address'] =$address;
							$data_record['permanant_address'] =$per_address;
							$data_record['country_id'] =$country;
							$data_record['state_id'] =$state;
							$data_record['city_id'] =$city;
                            $data_record['contact'] =$contact;
							$data_record['contact_home'] =$contact_home;
                            $data_record['mail'] = $mail;
						    $data_record['qualification']=$qualification;
							$data_record['admission_date']=$admission_date;
							$data_record['batch_id'] =$_POST['batch_id'];
							$data_record['cust_gst_no'] =$cust_gst_no;
							if($_REQUEST['record_id'])
							{
								$data_record['student_id']=$_POST['record_id'];
								//$data_record['invoice_no']=$_REQUEST['record_id'];
							}
							else
							{

								$data_record['student_id']=$largestInvoiceNumber;
								$data_record['invoice_no']=$largestInvoiceNumber;
							}
							//$data_record['inquiry_date']=$inquiry_date;
							$data_record['paid_type']=$paid_type;
							//$data_record['id_card']=$id_card;
							$data_record['source']=$source;
							$data_record['admission_remark']=$admission_remark;
                            $data_record['course_id']=$course; 
                            //$data_record['costomize_courses']=$costomize_courses;
                            $data_record['course_fees']=$course_fees;
							$data_record['discount_coupon_code']=$discount_coupon_code;
							$data_record['discount_coupon_per']=$discount_coupon_per;
							$data_record['discount_coupon_price']=$discount_coupon_price;
							$data_record['discount']=$discount;
							$data_record['discount_type']=$discount_type;
                            //$data_record['final_fees']=$final_fees;
							$data_record['paid']=$paid;
							$data_record['installment_on']=$installment_on;
                            $data_record['net_fees']=$net_fees;
							$data_record['total_fees']=$total_fees;
						    $data_record['service_tax']=0;
							$data_record['service_taxes_in_percent']=0;
							$data_record['cgst_tax']=$cgst_tax;
							$data_record['sgst_tax']=$sgst_tax;
							$data_record['cgst_tax_in_percent']=$cgst_tax_in_per;
							$data_record['sgst_tax_in_percent']=$sgst_tax_in_per;
							
                            $data_record['down_payment']=$down_payment;
							//$data_record['down_payment_tax'] = $down_payment_tax;
							$data_record['down_payment_wo_tax'] =$down_payment_wo_tax;
							$data_record['no_of_installment']=$first_installment;
							$data_record['admin_id']=$_SESSION['admin_id'];
							$data_record['balance_amt']=$final_amt;
							$data_record['status']='Enrolled';
							$data_record['added_date'] = $added_date;
							$data_record['assigned_to']= $employee_id;
							$data_record_en['status']='Enrolled';
							//===============================CM ID for Super Admin===============
							if($_SESSION['type']=='S')
							{
								$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
								$cm_id=$data_branch['cm_id'];
								$branch_name1=$branch_name;
								$data_record['cm_id']=$cm_id;
								$data_record_invoice['cm_id']=$cm_id;
							}	
							else
							{
								$data_record['cm_id']=$_SESSION['cm_id'];
								$branch_name1=$_SESSION['branch_name'];
								$data_record_invoice['cm_id']=$_SESSION['cm_id'];
							}
							//====================================================================
							$data_record_invoice['course_id']=$course;
							$data_record_invoice['admin_id']=$_SESSION['admin_id'];
							$data_record_invoice['bank_name']=$bank_name;
							$data_record_invoice['cheque_detail']=$chaque_no;
							$data_record_invoice['chaque_date']=$chaque_date;	
							$data_record_invoice['credit_card_no']=$credit_card_no;
							$data_record_invoice['bank_ref_no']=$bank_ref_no;
							$data_record_invoice['online_transc_details']='';
							$data_record_invoice['amount']=$down_payment;
							$data_record_invoice['paid_type']=$payment_type;
							//$data_record_invoice['added_date']=date('y-m-d h:i:s');
							$timestamp=date('Y-m-d H:i:s');
							$sep_tp=explode(" ",$timestamp);
							$data_record_invoice['added_date'] = $admission_date." 00:00:00";
							$data_record_invoice['cust_bank_name']=$cust_bank_name;
							$data_record_invoice['balance_amt']=$final_amt;
							$data_record_invoice['type']="down_payment";
							$data_record_invoice['service_tax']=0;
							$data_record_invoice['service_taxes_in_percent']=0;
							$data_record_invoice['cgst_tax']=$down_cgst_tax;
							$data_record_invoice['sgst_tax']=$down_sgst_tax;
							$data_record_invoice['total_paid_gst']=intval($down_cgst_tax+$down_sgst_tax);
							$data_record_invoice['cgst_tax_in_per']=$down_cgst_tax_in_per;
							$data_record_invoice['sgst_tax_in_per']=$down_sgst_tax_in_per;
							$data_record_invoice['assigned_to']= $employee_id;
							if($file_uploaded)
								$data_record['photo'] = $uploaded_url;
                            if($record_id)
                            {
								/*$data_record['added_date'] = date('Y-m-d H:i:s');
                                $courses_id=$db->query_insert("enrollment", $data_record);  
							    $student_id= mysql_insert_id();*/
								$where_record="enroll_id='".$record_id."'";       
								$where_record_inv="invoice_id in ((select * from (select invoice_id from invoice where enroll_id = '".$record_id."' order by invoice_id limit 0, 1) as t))";   
								$data_record['installment_display_id']= $inst_student_id;
								$data_record['action_status']= "not_verify";
                                $db->query_update("enrollment", $data_record,$where_record); 
								//=====================================17-9-17====================================================
								$amnt=0;
								$sel_invs="select * from invoice where enroll_id='".$record_id."' and amount > 0 order by invoice_id asc";
								$ptr_invs=mysql_query($sel_invs);
								if(mysql_num_rows($ptr_invs))
								{
									$invoice_id='0';
									while($data_invs=mysql_fetch_array($ptr_invs))
									{
										$bal_amnt=0;
										if ($data_invs['type']=="down_payment")
										{
											$amnt +=$data_record_invoice['amount'];
											$bal_amnt=$net_fees- $amnt;
											$data_record_invoice['balance_amt']=$bal_amnt;
											
											//echo "<br/>".$update_invs="update invoice set balance_amt='".$bal_amnt."' where invoice_id='".$data_invs['invoice_id']."'";
											//$ptr_updatess=mysql_query($update_invs);
											$where_inv="invoice_id='".$data_invs['invoice_id']."'";
											$student_id_in=$db->query_update("invoice", $data_record_invoice,$where_inv); 
											$invoice_id=$data_invs['invoice_id'];
										}
										else
										{
											$amnt +=$data_invs['amount'];
											$bal_amnt=$net_fees- $amnt;
											$data_record_invoice['balance_amt']=$bal_amnt;
											$invoice_id=$data_invs['invoice_id'];
											
											"<br/>".$update_invs="update invoice set balance_amt='".$bal_amnt."',course_id='".$course."' where invoice_id='".$data_invs['invoice_id']."'";
											$ptr_updatess=mysql_query($update_invs);
										}
									}
									
									//==================================
									/*$invoice_id='0';
									if($row_record['no_of_installment']==$data_record['no_of_installment'])
									{
										$student_id_in=$db->query_update("invoice", $data_record_invoice,$where_record_inv); 
										$invoice_id=$data_invoice['invoice_id'];
									}
									else
									{
										$data_record_invoice['amount']='';
										$data_record_invoice['balance_amt']='';
										$data_record_invoice['enroll_id']=$record_id;
										$data_record_invoice['status']="";
										$student_id_in=$db->query_insert("invoice", $data_record_invoice); 
										$invoice_id=$student_id_in;
									}*/
									//====================================
								}
								else
								{
									$data_record_invoice['amount']='';
									$data_record_invoice['balance_amt']='';
									$data_record_invoice['enroll_id']=$record_id;
									$data_record_invoice['status']="";
									$student_id_in=$db->query_insert("invoice", $data_record_invoice); 
									$invoice_id=$student_id_in;
								}
								if($discount_coupon_code!='' && $discount_coupon_price)
								{
									$update_code="update discount_coupon set redeme_date='".date('Y-m-d')."', redeme_to='".$record_id."',status='Inactive' where code='".trim($discount_coupon_code)."'";
									$ptr_update=mysql_query($update_code);
								}
								//=============================================================================================
								$update_bnk=" update bank_records set amount='".$down_payment."',bank_id='".$bank_name."' where ".$where_record_inv." ";
	                            $upade_bk=mysql_query($update_bnk);
								
								$delete_inst="DELETE FROM `installment` WHERE ".$where_record."  ";
								$del_query=mysql_query($delete_inst);
								$delete_inst1="DELETE FROM `installment_history` WHERE ".$where_record."  ";
								$del_query=mysql_query($delete_inst1);
								
								$sel_invoice="select invoice_id from invoice where ".$where_record." ";
								$ptr_in=mysql_query($sel_invoice);
								$datat_invoice=mysql_fetch_array($ptr_in);
								
								if($data_record['no_of_installment'] !=0)
							   	{
									for($i=1;$i<=$data_record['no_of_installment'];$i++)
									{
										$installment_date='';

										if($_POST['installments'][$i-1] !='')
										{
											$sep_date =  explode('/',$_POST['installment_date'][$i-1]);
											$installment_date = $sep_date[2].'-'.$sep_date[1].'-'.$sep_date[0];
											$insert_query = "insert into installment(enroll_id, course_id, installment_amount, installment_date, status, invoice_id) values('$record_id','".$data_record['course_id']."','".$_POST['installments'][$i-1]."','$installment_date','not paid','".$invoice_id."' ) ";
									    	$insert_ptr = mysql_query($insert_query);
											
									    	$insert_query1 = "insert into installment_history(enroll_id, course_id, installment_amount, installment_date, status, invoice_id) values('".$record_id."','".$data_record['course_id']."','".$_POST['installments'][$i-1]."','".$installment_date."','not paid','".$invoice_id."') ";
									   	$insert_ptr1 = mysql_query($insert_query1);
										}
									}   
								}

								//$update_enroll_id=" update enrollment set installment_display_id='".$inst_student_id."' where ".$where_record." ";
	                            //$upade=mysql_query($update_enroll_id);
								
								"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('enrollment','Edit','".$name."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
								$query=mysql_query($insert); 
								
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
								?>
								<script>
								<?php unset($_SESSION['rand']);?>
								setTimeout('document.location.href="manage_enroll.php";',1000);
								</script>
								<?php
                            }
                            else
                            {
								$total_sub=$_POST['total_checked_question'];
								$concat="";
								for($i=1;$i<=$total_sub;$i++)
								{
									$comma="";
								    $subject_id =$_POST['subject_id'.$i];
								  	if($i < $total_sub)
                                    	$comma= ",";
									$concat.=$subject_id.$comma;
								}
								$course_status="not_started";
								$data_record['course_status']=$course_status;
								$data_record['subject_id']= $concat;
								$data_record['action_status']= "not_verify";
								$data_record['installment_display_id']=$inst_student_id;
                                $courses_id=$db->query_insert("enrollment", $data_record);
								$student_id= mysql_insert_id();
								$year= date('Y');
								$month=date('M');
								$array = array('ISAS', $year,$month,$student_id);
                                $comma_separated = implode("/",$array);
						        $update_enroll_id=" update enrollment set installment_display_id='".$inst_student_id."' where enroll_id='".$student_id."' ";
	                            $updt_id=mysql_query($update_enroll_id);  
								// $student_id= mysql_insert_id();
								$data_record_invoice['enroll_id']=$student_id;
								$data_record_invoice['status']='paid';
								
								$sel_recpt="select receipt_no from invoice where cm_id='".$data_record_invoice['cm_id']."' and receipt_no IS NOT NULL order by invoice_id desc limit 0,1";
								$ptr_recpt=mysql_query($sel_recpt);
								$data_receipt=mysql_fetch_array($ptr_recpt);
								
								$recp=explode("-",$data_receipt['receipt_no']);
								$recpt_no=intval($recp[1])+1;
								$pre='';
								if($data_record_invoice['cm_id']=='2')
								{
									$pre="PUN-";
								}
								else if($data_record_invoice['cm_id']=='60')
								{
									$pre="AHM-";
								}
								else if($data_record_invoice['cm_id']=='115')
								{
									$pre="PCMC-";
								}
								$data_record_invoice['receipt_no']=$pre.$recpt_no;
								$student_id_in=$db->query_insert("invoice", $data_record_invoice);  
								
								if($payment_type=='2' || $payment_type=='4' || $payment_type=='5')
							    {
							   $bank="INSERT INTO `bank_records`(`bank_id`, `type`, `record_id`,`invoice_id`, `amount`, `added_date`, `cm_id`, `admin_id`) VALUES ('".$bank_name."','enrollment','".$student_id."','".$student_id_in."','".$down_payment."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							   $bank_query=mysql_query($bank);  
								}
								if($data_record['no_of_installment'] !=0)
								{
									for($i=1;$i<=$data_record['no_of_installment'];$i++)
									{
										$installment_date='';
										if($_POST['installments'][$i-1] !='')
										{
											$sep_date =  explode('/',$_POST['installment_date'][$i-1]);
											$installment_date = $sep_date[2].'-'.$sep_date[1].'-'.$sep_date[0];
											"<br />".  $insert_query = "  insert into installment(enroll_id, course_id, installment_amount, installment_date, status, invoice_id) values('".$student_id."','".$data_record['course_id']."','".$_POST['installments'][$i-1]."','".$installment_date."','not paid','".$student_id_in."' ) ";
											$insert_ptr = mysql_query($insert_query);

											$insert_query1 = "  insert into installment_history(enroll_id, course_id, installment_amount, installment_date, status, invoice_id) values('".$student_id."','".$data_record['course_id']."','".$_POST['installments'][$i-1]."','".$installment_date."','not paid','".$student_id_in."') ";
											$insert_ptr1 = mysql_query($insert_query1);
										}
									}   
								}
								$where_record_invs="enroll_id='". $courses_id."'";
								$data_record_invs['invoice_no']=$student_id_in;
								$db->query_update("enrollment", $data_record_invs,$where_record_invs);
								
								"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('enrollment','Add','".$name."','".$student_id."','".date('Y-m-d')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
								$query=mysql_query($insert);  

                                echo '<br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
								$sele_course_name="select course_name,course_description from courses where course_id='$course'";
								$ptr_course_name=mysql_query($sele_course_name);
								$data_course_name=mysql_fetch_array($ptr_course_name);
								$course_name=$data_course_name['course_name'];
								$duration_studies=$data_course_name['course_description'];
								//================================================MAIL SENT==========================================
								/*------------send a mail to admin about this---------------------*/
								$subject = "Enrollment from ".$name." on ".$GLOBALS['domainName']."";
								$message .= '
								<table cellpadding="3" align="left" cellspacing="3" width="75%">
								 <tr>
									<td width="35%"><strong>Name</strong></td>
									<td>:</td>
									<td width="65%">'.$name.'</td>
								</tr>';
								if($dob)
								$message.= '
								<tr>
									<td><strong>Birth Date</strong></td>
									<td>:</td>
									<td>'.$dob.'<td>
								</tr>';
								if($address)
								$message.= '
								<tr>
									<td><strong>Address</strong></td>
									<td>:</td>
									<td>'.$address.'</td>
								</tr>';
								if($contact)
								$message.= '
								<tr>
									<td><strong>Mobile1</strong></td>
									<td>:</td>
									<td>'.$contact.'</td>
								</tr>';
								if($mail)
								$message.= '
								<tr>
									<td><strong>Email</strong></td>
									<td>:</td>
									<td>'.$mail.'</td>
								</tr>';
								 if($qualification)
								$message.= '
								<tr>
									<td><strong>Education</strong></td>
									<td>:</td>
									<td>'.$qualification.'</td>
								</tr>';
								 if($course_name)
								$message.= '
								<tr>
									<td><strong>Course Interested</strong></td>
									<td>:</td>
									<td>'.$course_name.'</td>
								</tr>';
								 if($data_record['added_date'])
								$message.= '
								<tr>
									<td><strong>Enquiry Date</strong></td>
									<td>:</td>
									<td>'.$data_record['added_date'].'</td>
								</tr>';
								if($duration_studies)
								$message.= '
								<tr>
									<td><strong>Duration For Studies</strong></td>
									<td>:</td>
									<td>'.$duration_studies.'</td>
								</tr>';
								if($course_fees)
								$message.= '
								<tr>
									<td><strong>Course Fees</strong></td>
									<td>:</td>
									<td>'.$course_fees.'</td>
								</tr>';
								if($discount)
								$message.= '
								<tr>
									<td><strong>Discount in '.$discount_type.' </strong></td>
									<td>:</td>
									<td>'.$discount.'</td>
								</tr>';
								/*if($service_tax)
								$message.= '
								<tr>
									<td><strong>Service Tax</strong></td>
									<td>:</td>
									<td>'.$service_tax.'</td>
								</tr>';*/
								if($total_fees)
								$message.= '
								<tr>
									<td><strong>Total Fees</strong></td>
									<td>:</td>
									<td>'.$total_fees.'</td>
								</tr>';
								if($down_payment)
								$message.= '
								<tr>
									<td><strong>Down payment</strong></td>
									<td>:</td>
									<td>'.$down_payment.'</td>
								</tr>';
								if($installment_on)
								$message.= '
								<tr>
									<td><strong>Total Installment</strong></td>
									<td>:</td>
									<td>'.$installment_on.'</td>
								</tr>';
								if($payment_type)
								$message.= '
								<tr>
									<td><strong>Payment Mode</strong></td>
									<td>:</td>
									<td>'.$payment_type.'</td>
								</tr>';
								$message.='<tr><td>Enrolled  from  </td><td>:</td><td>Admin Panel(Offline)<td></tr>
								</table>';
									$sendMessage=$GLOBALS['box_message_top'];
									$sendMessage.=$message;
									$sendMessage.=$GLOBALS['box_message_bottom'];
									$from_id='support<support@'.$GLOBALS['domainName'].'>';
									$headers= 'MIME-Version: 1.0' . "\n";
									$headers.='Content-type: text/html; charset=utf-8' . "\n";
									$headers.='From:'.$from_id;
									//echo $to.$sendMessage;
									if($_SERVER['HTTP_HOST']!="localhost" && $_SERVER['HTTP_HOST']!="localhost:81")//|| $_SERVER['HTTP_HOST']=="hindavi-1"
									{
										$select_email_id = " select email from site_setting where (cm_id='".$_SESSION['cm_id']."' or admin_id='".$_SESSION['admin_id']."' or branch_name='".$branch_name1."') and (type='A' or type='C' or type='B') and email !='' ";
										$ptr_emails = mysql_query($select_email_id);
										while($data_emails = mysql_fetch_array($ptr_emails))
										{
											//mail($data_emails['email'], $subject, $sendMessage, $headers);
										}
										//==================== EMAIL to councellor======================================
										/*$select_counc_email_id = " select email from site_setting where cm_id='".$_SESSION['cm_id']."' and type='C' and email !='' ";
										$ptr_counc_emails = mysql_query($select_counc_email_id);
										while($data_counc_emails = mysql_fetch_array($ptr_counc_emails))
										{
											mail($data_counc_emails['email_id'], $subject, $sendMessage, $headers);
										}*/
										
									}

									//====================================Send Message=============================================
													
									$sel_course_name="select course_name from courses where course_id='".$data_record['course_id']."'";
									$ptr_course_sel=mysql_query($sel_course_name);
									$data_course_name=mysql_fetch_array($ptr_course_sel);
									
									
									$sel_inq="select sms_text from previleges where privilege_id='40'";
									$ptr_inq=mysql_query($sel_inq);
									$txt_msg='';
									if(mysql_num_rows($ptr_inq))
									{
										$dta_msg=mysql_fetch_array($ptr_inq);
										$txt_msg=$dta_msg['sms_text']." ";
									}
									$messagessss=$txt_msg;
									
									$sel_cnt="select contact_phone from site_setting where type='C' and other_type='inquiry' and branch_name='".$branch_name1."' ";
									$ptr_cnt=mysql_query($sel_cnt);
									if(mysql_num_rows($ptr_cnt))
									{
										$data_cnt=mysql_fetch_array($ptr_cnt);
										$staff_contact=$data_cnt['contact_phone'];
									}
									else
									{
										$staff_contact="9158985007";
									}
									$address='';
									if($branch_name1=="Pune")
									{
										$address="International School of Aesthetics and Spa, 2nd Floor, The Greens,North Main Road, Koregoan Park, Pune-411001. Location:  https://bit.ly/2yOhji6";
									}
									else if($branch_name1=="Ahmedabad")
									{
										$address="International School of Aesthetics and Spa, First Floor, Zodiac Plaza,Near Nabard Flat, H.L. Comm. College Road, Navrangpura, Ahmedabad- 380 009.Tel No-:079-26300007. Location: https://bit.ly/2N28vbw";
									}
									else if($branch_name1=="ISAS PCMC")
									{
										$address="Hari A1,Next to ABS Gym, Pimple Nilakh, Pune 411027. Location: https://bit.ly/2Ke26fQ";
									}
									$search_by= array("student_name", "course_name", "branch_name", "mobile_no","address");
									$replace_by = array($name, $data_course_name['course_name'], $branch_name1, $staff_contact,$address);
									"<br/>".$messagessss = str_replace($search_by, $replace_by, $messagessss);
									$messagessss =urlencode($messagessss);
									"<br/>".$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='40' ".$_SESSION['where']."";
									$ptr_sel_sms=mysql_query($sel_sms_cnt);
									while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
									{
										"<br/>".$sel_act="select contact_phone from site_setting where admin_id='".$data_sel_cnt['staff_id']."' ".$_SESSION['where']." ";
										$ptr_cnt=mysql_query($sel_act);
										if(mysql_num_rows($ptr_cnt))
										{
											$data_cnt=mysql_fetch_array($ptr_cnt);
											//send_sms_function($data_cnt['contact_phone'],$messagessss);
										}
									}
									if($_SESSION['type']!='S')
									{
										"<br/>".$sel_act="select contact_phone from site_setting where type='S' ";
										$ptr_cnt=mysql_query($sel_act);
										if(mysql_num_rows($ptr_cnt))
										{
											while($data_cnt=mysql_fetch_array($ptr_cnt))
											{
												//send_sms_function($data_cnt['contact_phone'],$messagessss);
											}
										}
									}
									send_sms_function($contact,$messagessss);
									$insert_sms="insert into sms_log_history (`name`,`mobile_no`,`sms_text`,`sms_type`,`admin_id`,`cm_id`,`added_date`) values('".$name."','".$contact."','".$messagessss."','enrollment','".$_SESSION['admin_id']."','".$_SESSION['cm_id']."','".date('Y-m-d H:i:s')."')";
									$ptr_sms=mysql_query($insert_sms);
									//-----------------------------------END SMS---------------------------------------*/

									//------send notification on inquiry addition-----
										$notification_args['reference_id'] = $student_id;
										$notification_args['on_action'] = 'enroll';
										$notification_status = addNotifications($notification_args);
									//-----------------------------------------------

								
								?>
								<script>
								<?php unset($_SESSION['rand']);?>
								setTimeout('document.location.href="manage_enroll.php";',1000);
								</script>
								<?php
                            }
                          }
                    }
                    if($success==0)
                    {
                    ?>
            <tr><td>
        <form name="jqueryForm" method="post" id="jqueryForm" enctype="multipart/form-data"  onsubmit="return validme();">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
            <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
            <input type="hidden" name="record_id" id="record_id" value="<?php if($_REQUEST['record_id']) { echo $record_id ;} ?>"  />
			<tr>
				<td width="20%"class="orange_font">* Date Format should be [ DD/MM/YYYY ]</td>
            </tr>
            			<?php
							$sub_branch='';
							if($_SESSION['type']=="S")
							{
								$sub_branch='AHM';
							}
							else
							{
								$branch_name=$_SESSION['branch_name'];
								$sub_branch=substr($branch_name, 0, 3);
							}
							$year= date('Y');
							$month=date('M');
							$array = array('ISAS',$sub_branch,$year,$month);
							$comma_separated = implode("/",$array);
							if($_SESSION['type']=='S')
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
						<? } else { ?>
                       <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                       
                       <?php }
					   
					  	//=========================For prevent to save multiple entries================
							$rand=rand();
							$_SESSION['rand']=$rand;
						//=============================================================================
					   ?>
					   
							<!--<tr>
                                <td width="20%">Date<span class="orange_font">*</span></td>
                                <td width="49%"><input type="text" id="added_date" name="added_date" class="input_text datepicker" value="<?php //if($_POST['added_date']) echo $_POST['added_date']; else if($row_record['added_date']!=''){$arrage_date= explode('-',$row_record['added_date'],3);echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];}else{echo date("d/m/Y");}?>" />
                                </td>
                            </tr> -->
                            <tr>
                                <td width="20%">Admission date<span class="orange_font">*</span></td>
                                <td width="49%">
								<?php 
								if($_SESSION['type']=='S')
								{
									?>
									<input type="text" id="admission_date" class="input_text datepicker" name="admission_date" value="<?php if($_POST['admission_date']) echo $_POST['admission_date']; else if($row_record['admission_date']!='') {$arrage_date= explode('-',$row_record['admission_date'],3); echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];} else {echo date("d/m/Y");} ?>" />
    	                            <?php
								}
								else
								{
									if($_POST['admission_date']) echo $_POST['admission_date']; else if($row_record['admission_date']!='')
									{
										$arrage_date= explode('-',$row_record['admission_date'],3);     
										echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0]; 
									}
									else {echo date("d/m/Y");}
									?>
                                     <input type="hidden" id="admission_date" name="admission_date" value="<?php if($_POST['admission_date']) echo $_POST['admission_date']; else if($row_record['admission_date']!='') {$arrage_date= explode('-',$row_record['admission_date'],3); echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];} else {echo date("d/m/Y");} ?>" />
	                                <?php
								}
								?>
	                            </td>
                            </tr> 
                            <tr>
								<td width="20%" >Enrollment No.<span class="orange_font">*</span></td>
								<td width="49%"><input type="text" name="inst_student_id" id="inst_student_id" class="input_text" value="<?php if($_POST['inst_student_id']) echo $_POST['inst_student_id']; elseif($record_id==''){ echo trim($comma_separated.'/'.$largestNumber) ;} else echo $row_record['installment_display_id']; ?>"  />
								</td>
                           	</tr>
							<tr>
								<td width="20%" >SAC No.<span class="orange_font"></span></td>
								<td width="49%"><input type="text" name="sac_code" id="sac_code" class="input_text" value="<?php if($_POST['sac_code']) echo $_POST['sac_code']; else echo $data_sac_code['sac_code']; ?>"  />
								</td>
                            </tr>							
                            <tr>
                            	<td width="20%">Student Name<span class="orange_font">*</span></td>
                            	<td width="49%">
                            	<input type="text" class="validate[required] input_text" name="name"  id="name" value="<?php if($_POST['name']) echo $_POST['name']; else echo $row_record['name'];?>" />
                            	</td> 
                            </tr> 
                            <tr>
                				<td width="20%">Contact No<span class="orange_font">*</span></td>
               					<td width="49%">
                   				<input type="text" class="validate[required] input_text" name="contact" id="contact" value="<?php if($_POST['contact']) echo $_POST['contact']; else echo $row_record['contact'];?>"onKeyPress="return isNumber(event)" maxlength="12" />
                				</td> 
                				<td width="31%"><div id="feedback_contact"></div> </td>
           					 </tr> 
                             <tr>
                             	<td width="20%">Parents Contact No<span class="orange_font">*</span></td>
                                <td width="40%"><input type="text" class="validate[required] input_text" name="home_contact" id="home_contact" value="<?php if($_POST['home_contact']) echo $_POST['home_contact']; else echo $row_record['contact_home']; ?>" onKeyPress="return isNumber(event)" maxlength="12"/></td> 
                                <td width="40%"><b>Note-</b> Should be 10-12 digit allowed. </td>
                             </tr>  
           					 <tr>
               				 	<td width="20%">Email Id<span class="orange_font">*</span></td>
                				<td width="49%">
                    			<input type="text" class="validate[required] input_text" name="mail" id="mail" value="<?php if($_POST['mail']) echo $_POST['mail']; else echo $row_record['mail'];?>"  />
								<!--onBlur="validateEmail('mail');"-->
          						</td> 
           						<td width="31%"><div id="feedback_email"></div></td>
            				</tr>
                            <tr>
                            	<td width="20%">Current Address<span class="orange_font">*</span></td>
                                <td width="49%">
                    			<textarea  name="address" style="width: 510px; height: 62px;" id="address" ><?php if($_POST['address']) echo $_POST['address']; else echo $row_record['address'];?></textarea>
                				</td> 
                            </tr> 
                            <tr>
                            	<td width="20%">Permanant Address<span class="orange_font"></span></td>
                                <td width="40%"><textarea  name="per_address" style="width: 510px; height: 62px;" id="per_address" ><?php if($_POST['per_address']) echo $_POST['per_address']; else echo $row_record['permanant_address'];?></textarea></td> 
                            </tr> 
                            <!--<tr>
                            	<td width="20%">Identity card No.<span class="orange_font">*</span></td>
                                <td width="40%"><input type="text" class="input_text" name="id_card" id="id_card" value="<?php// if($_POST['save_changes']) echo $_POST['id_card']; else echo $row_record['enroll_id'];?>" /></td>  <?php// echo $row_record1['id_card']; ?>
                            </tr>-->
                            
                            <tr>
                                <td width="20%">Select Country<span class="orange_font">*</span></td>
                                <td><select id="country" name="country" onchange="select_state(this.value)" style="width:460px">
                                <option value="">Select Country</option>
                                <?php 
                                $sel_countries="select * from countries where 1";
                                $ptr_countries=mysql_query($sel_countries);
                                while($data_countries=mysql_fetch_array($ptr_countries))
                                {
									$sel='';
									if($record_id!='' && $row_record['country_id']==$data_countries['id'])
									{
										$sel='selected="selected"';
									}
                                    ?>
                                    <option value="<?php echo $data_countries['id'];?>"  <?php echo $sel; ?>> <?php echo $data_countries['name'];?> </option>
                                    <?php						
                                }?>
                                </select>
                               </td>
                            </tr>  
                            <tr>
                                <td width="20%">Select State<span class="orange_font">*</span></td>
                                <td>
                                    <div id="show_states">
                                        <?php 
										$where_country_id='';
										if($row_record['country_id']!='')
										{
											$where_country_id=" and country_id='".$row_record['country_id']."'";
										}
										$sel_state ="select * from states where 1 ".$where_country_id." ";
										$ptr_states =mysql_query($sel_state);
										echo '<table width="100%"><tr><td>';
										echo '<select id="state" name="state" onchange="select_city(this.value)" style="width:460px"><option value="">Select State</option>';
										while($state_data= mysql_fetch_array($ptr_states))
										{
											$sel='';
											if($row_record['state_id']==$state_data['id'])
											{
												$sel='selected="selected"';
											}
											echo '<option value="'.$state_data['id'].'" '.$sel.'>'.$state_data['name'].'</option>';
										}
										echo '</select></td></tr></table>';
										?>
                                     </div>
                                 </td>
                            </tr>
                            <tr>
                                <td width="20%">Select City<span class="orange_font">*</span></td>
                                <td>
                                    <div id="show_cities">
                                        <?php 
										
										$where_state_id='';
										if($row_record['state_id']!='')
										{
											$where_state_id=" and state_id='".$row_record['state_id']."'";
										}
										$sel_city = "select * from cities where 1 ".$where_state_id."" ;
										$ptr_city = mysql_query($sel_city);
										echo '<table width="100%"><tr><td>';
										echo '<select id="city" name="city" style="width:460px"><option value="">Select City</option>';
										while($city_data= mysql_fetch_array($ptr_city))
										{
											$sel='';
											if($row_record['city_id']==$city_data['id'])
											{
												$sel='selected="selected"';
											}
											echo '<option value="'.$city_data['id'].'" '.$sel.'>'.$city_data['name'].'</option>';
										}
										echo '</select></td></tr></table>';
										
										?>
                                    </div>
                                </td>
                            </tr> 
                            <tr>
                            	<td width="20%">Date Of Birth<span class="orange_font">*</span></td>
                                <td width="49%">
                                <input type="text" class="validate[required] input_text datepicker" name="dob" id="dob" value="<?php if($_POST['dob']) echo $_POST['dob']; else if($row_record['dob']!=''){ $arrage_date= explode('-',$row_record['dob'],3); echo $arrage_date[1].'/'.$arrage_date[2].'/'.$arrage_date[0];	} ?>" />
       							</td> 
       							<td width="31%"></td>
   							</tr> 
             				<tr>
	                            <td width="20%">Qualification<span class="orange_font"></span></td>
                                <td width="49%">
                                <select name="qualification" id="qualification" class="input_text" style="width:460px">
    	                            <option  value="">----Select----</option>
                                    <option value="SSC" <? if (isset($qualification) && $qualification == "SSC") echo "selected"; elseif( 'SSC' == $row_record['qualification']) echo "selected";?> >SSC</option>
                                    <option  value="HSC" <? if (isset($qualification) && $qualification == "HSC") echo "selected";elseif( 'HSC' == $row_record['qualification']) echo "selected";?> >HSC</option>
                                    <option value="Under Graduation" <? if (isset($qualification) && $qualification == "Under Graduation") echo "selected";elseif( 'Under Graduation' == $row_record['qualification']) echo "selected";?> >Under Graduation</option>
                                    <option value="Graduation" <? if (isset($qualification) && $qualification == "Graduation") echo "selected";elseif( 'Graduation' == $row_record['qualification']) echo "selected";?> >Graduation</option>
                                    <option value="Post Graduation" <? if (isset($qualification) && $qualification == "Post Graduation") echo "selected";elseif( 'Post Graduation' == $row_record['qualification']) echo "selected";?> >Post Graduation</option>
                                </select>
                                </td> 
                                <td width="31%"></td>
            				</tr>
                            <tr>
                                <td width="20%">Create Username & Password</td>
                                <td width="40%"><input type="radio" style="width:20px" class="input_radio" name="auto_credential" id="auto_credential" onclick="user_credential(this.value)" value="auto" /> Auto &nbsp;&nbsp;&nbsp;<input type="radio" style="width:20px" class="input_radio" name="auto_credential" id="auto_credential" onclick="user_credential(this.value)" value="mannual" /> Mannual</td>
                            </tr>
                            <tr>
                            	<td width="20%"> User Name<span class="orange_font">*</span> </td>
                            	<td width="49%">
                				<input type="text" class="validate[required] input_text" name="username" id="username" value="<?php if($_POST['username']) echo $_POST['username']; else echo $row_record['username'];?>" />
                				</td> 
              					<td width="31%"><div id="feedback"></div>Only Characters and Number allowed</td>
            				</tr>
            				<tr>
                                <td width="20%">Password<span class="orange_font">*</span></td>
                                <td width="49%"><input type="password" class="validate[required] input_text" name="pass" id="pass" value="<?php if($_POST['pass']) echo $_POST['pass']; else echo $row_record['pass'];?>" />
 								</td> 
                				<td width="31%"></td>
                            </tr>
                            <tr>
                            	<td width="20%">Photo</td>
                                <td width="49%"><?php
                    			if($record_id && $row_record['photo'] && file_exists("../student_photos/".$row_record['photo']))
                        			echo '<img height="77px" width="77px" src="../student_photos/'.$row_record['photo'].'"><br><a href="'.$_SERVER['PHP_SELF'].'?deleteThumbnail=1&record_id='.$record_id.'">Delete / Upload new</a></td><td width="40%"></td>';
                    			else
                        			echo '<input type="file" name="photo" id="photo" class="input_text"></td>';?></td> 
            					<td width="31%"></td>
            				</tr>
                             
   							<tr>
	   							<td width="20%">Source<span class="orange_font">*</span></td>
      							<td>
    	   							<select id="source" name="source" style="width:460px">
        	      						<option value="">----Select----</option>
    	           						<?php 
										/*$sel_source="SELECT * FROM campaign where 1 ".$_SESSION['where']." ";
										$ptr_src=mysql_query($sel_source);
										while($data_src=mysql_fetch_array($ptr_src))
										{
											?>
											<option value = "<?php echo $data_src['campaign_id']?>" <? if($_POST['source'] == $data_src['campaign_id']) echo "selected"; else if ( $data_src['campaign_id'] == $row_record['source']) echo "selected";?> > <?php echo $data_src['campaign_name'] ?> </option>
											<?
										}*/
										?>
                                        <?php 
										echo $course_category = " select DISTINCT(cm_id),branch_name from site_setting where type='A' ".$_SESSION['where']." ";
										$ptr_course_cat = mysql_query($course_category);
										while($data_cat = mysql_fetch_array($ptr_course_cat))
										{
											echo " <optgroup label='".$data_cat['branch_name']."'>";
											$sel_source="SELECT * FROM campaign where 1 and cm_id='".$data_cat['cm_id']."' and campaign_for='institute' ";
											$ptr_src=mysql_query($sel_source);
											while($data_src=mysql_fetch_array($ptr_src))
											{
												?>
												<option value = "<?php echo $data_src['campaign_id']?>" <? if($_POST['source'] == $data_src['campaign_id']) echo "selected"; else if ( $data_src['campaign_id'] == $row_record['source']) echo "selected";?> > <?php echo $data_src['campaign_name'] ?> </option>
												<?
											}
											echo "</optgroup>";
										}?>
                          			</select>
                  				</td>
            				</tr>             
            				<tr>
                   				<td width="20%">Admission remark<span class="orange_font"></span></td>
                   				<td>
									<textarea class="validate[required] input_text" name="admission_remark"id="admission_remark" ><?php if($_POST['admission_remark']) echo $_POST['admission_remark']; else echo $row_record['admission_remark'];?></textarea></td>
            				</tr>                                         
            				<tr>
            					<td width="20%">Select Course (With Service tax)<span class="orange_font">*</span></td>
            					<td width="49%" class="customized_select_box">
                    			<select name="course_id" id="course_id" class="validate[required] input_select customized_select_box" onChange="show_course(this.value);" style="width:460px" >  
                        			<option value=""> Select Course </option>
									<?php
                                    $course_category = " select category_name,category_id from course_category ";
                                    $ptr_course_cat = mysql_query($course_category);
                                    while($data_cat = mysql_fetch_array($ptr_course_cat))
                                    {
                                    	echo "<optgroup label='".$data_cat['category_name']."'>";
                                        $get="SELECT course_name,course_id FROM courses where category_id='".$data_cat['category_id']."' order by course_id";
                                        $myQuery=mysql_query($get);
                                        while($row1 = mysql_fetch_assoc($myQuery))
                                        {
                                        	$selected= '';
                                            if($row_record['course_id']==$row1['course_id'] || $_POST['course_id']==$row1['course_id'] )
                                            {
                                            	$selected= ' selected="selected" ';
                                            }		
                                        	?>
                                            <option value = "<?php echo $row1['course_id']?>" <?php echo $selected;  ?> > <?php echo $row1['course_name'] ?> </option>
                                        	<?php	
										}
                                        echo " </optgroup>";
                                    }
                                    ?>
                            		<option value="custome" >New Course</option> 
                    			</select>
            					</td> 
            				</tr>
            				<tr>
                        		<td colspan="3"><div id="custome_div" style="display:none">
                            		<table width="100%">
                            			<tr>
                                			<td width="26%">Customised Course<span class="orange_font">*</span></td>
                                			<td width="40%"><input type="text" class="inputText" name="costomize_courses" id="costomize_courses" value="<?php if($_POST['costomize_courses']) echo $_POST['costomize_courses']; else echo $row_record['customised_course'];?>"/></td>
                                			<td width="20%">&nbsp;</td>
                              			</tr>
                          			</table>
                          			</div>
                                </td>
                      		</tr>
            				<!--<tr>
                				<td width="20%"> Select Subject </td>
                                <td width="40%" ><div id="show_subject"></div>   
                                	<input type="hidden"  name="total_checked_question" id="total_checked_question"  value="" /> </td> 
                                <td width="40%"></td>
                            </tr>
                            <tr>
                            	<td width="20%"> Select Batch </td>
                                <td width="40%" ><div id="batches"></div> </td> 
                                <td width="40%"></td>
                            </tr>-->
							<!--<tr>
                            	<td colspan="2"> <div id="customise"></div></td> 
                            </tr>-->
                            <!--<tr>
                            	<td width="20%" class="heading">Costomize Courses<span class="orange_font">*</span></td>
                                <td><input type="text"  name="costomize_courses"  id="costomize_courses" value="<?php //if($_POST['save_changes']) echo $_POST['costomize_courses']; else echo $row_record['costomize_courses'];?>" style='display:none' /></td>
                            </tr>-->
                            <!-- <tr>
                            	<td width="20%" class="heading"><div id="coursess" class="coursess">Fees</div><span class="orange_font">*</span></td>
                                <td><div id="coursess" class="coursess" ><input type="text" class="validate[required] input_text" name="fees" id="fees" value="<?php// if($_POST['save_changes']) echo $_POST['fees']; else echo $row_record['fees'];?>" />  </div>
                                </td>
                            </tr>  
                            <tr>
                            	<td width="20%" class="heading"><div id="coursess" class="coursess" >Discount</div><span class="orange_font">*</span></td>
                            	<td><div id="coursess" class="coursess" ><input type="text" class="validate[required] input_text" name="discount" value="<?php// if($_POST['save_changes']) echo $_POST['discount']; else echo $row_record['discount'];?>" /></div></td>
                            </tr>   
                            <tr>
								<td width="20%" class="heading"><div id="coursess" class="coursess" >Final Fees</div><span class="orange_font">*</span></td>
                               	<td><div id="coursess" class="coursess" ><input type="text" class="validate[required] input_text" name="final_fees" value="<?php// if($_POST['save_changes']) echo $_POST['final_fees']; else echo $row_record['final_fees'];?>" /></div></td>
							</tr>  -->
                            <tr>
	                            <td width="20%">Paid Type</td>
                                <td width="49%">
                                <input type="radio" checked="checked" name='paid_type' id="paid_type" value="one_time" <?php if($_POST['paid_type'] =="one_time")  echo 'checked="checked"'; else if($row_record['paid_type'] == "one_time") echo 'checked="checked"'; ?> onChange="show_record()" />One Time <input type="radio" name='paid_type' id="paid_type" value="installments" <?php if($_POST['paid_type'] =="installments")  echo 'checked="checked"'; else if($row_record['paid_type'] == "installments") echo 'checked="checked"'; ?> onChange="show_record()" />Installment <span id="inst_tax_id"><?php if($_SESSION['type']!='S'){ echo $_SESSION['installment_tax'];} ?></span>% add
    							<input type="hidden" id="inst_taxes" value="<?php if($_SESSION['type']!='S'){ echo $_SESSION['installment_tax'];} ?>"  />
                                <input type="radio" name='paid_type' id="paid_type" value="installments_zero"  <?php if($_POST['paid_type'] =="installments_zero")  echo 'checked="checked"'; else if($row_record['paid_type'] == "installments_zero") echo 'checked="checked"';  ?> onChange="show_record()" />Installment 0% add
                                </td>             
                                <td width="31%"></td>
                            </tr>                             
                            <!--==========================================================================================================================-->
                            <?php
							if($_SESSION['type']!='S')
							{
								$readonly='readonly="readonly"';
								$bg='style="background-color:#DEDEDE;background:lightgray"';
							}
							else
							{
								$readonly='';
								$bg='';
							}
							?>
                            <tr>                              
                            	<td width="20%">Course Fees</td>
                                <td width="49%"><div id=total_fees>
                                <input type="text" class="input_text" name="total_fees" <?php echo $readonly; echo $bg;?> id="toal_fees"  onblur="show_record(this.value,1)"  value="<?php if($_POST['total_fees']) echo $_POST['total_fees']; else echo $row_record['course_fees'];?>" />
                                </div>
                                </td>                
                                <td width="31%">
                                <input type="hidden" name="discount_otp" id="discount_otp" value="" />
                    			<input type="hidden" name="discount_inst" id="discount_inst" value="" />
                                </td>
                           	</tr>
                            <tr>
                            	<td width="20%">Discount in <input type="radio" name='discount_type' value="percent" <?php if($_POST['discount_type']=="percent") echo 'checked="checked"'; else if($row_record['discount_type']=="percent") echo 'checked="checked"'; else echo 'checked="checked"';?>  onChange="show_record()" />% or <input type="radio" name='discount_type' value="cash" <?php if($_POST['discount_type']=="cash") echo 'checked="checked"'; else if($row_record['discount_type']=="cash") echo 'checked="checked"'; ?> onChange="show_record()" />Cash</td>
                                <td width="49%">
                                <input type="text" class="input_text" <?php echo $readonly; echo $bg;?> name="concession" id="concession" value="<?php if($_POST['concession']) echo $_POST['concession']; else if($row_record['discount'] !=0) echo $row_record['discount']; else echo 0; ?>" onBlur="show_record()"/></td>                
                                <td width="31%">-<span id="disc_pr" style="color:red"></span></td>
                           	</tr>
                            <tr>
                            	<td width="20%">Discount Coupon Code</td>
                            	<td width="49%">
                                	<input type="text" class="input_text" name="discount_coupon" id="discount_coupon" value="<?php if($_POST['discount_coupon']) echo $_POST['discount_coupon']; else echo $row_record['discount_coupon_code'];?>" onBlur="show_discount()" />
                              	</td>                
                                <td width="31%"><input type="hidden" name="discount_coupon_per" id="discount_coupon_per" value="<?php if($_POST['discount_coupon_per']) echo $_POST['discount_coupon_per']; else echo $row_record['discount_coupon_per'];?>" /><div id="coupon"></div><input type="hidden" name="discount_coupon_price" id="discount_coupon_price" value="<?php if($_POST['discount_coupon_price']) echo $_POST['discount_coupon_price']; else echo $row_record['discount_coupon_price'];?>" />&nbsp; -<span id="disc_coupon_pr" style="color:red"></span></td>
                           	</tr>
                            <!--<tr>
                            	<td width="22%">Paid Fees</td>
                            	<td width="38%">
                                <input type="text" class="validate[required] input_text" name="paid" id="paid" value="<?php// if($_POST['save_changes']) echo $_POST['paid']; else echo $row_record['paid'];?>" onblur="show_record()" />
                                </td>                
                                <td width="40%"></td>
                            </tr>-->
                            <!-- <tr>
                            	<td width="22%"><div id="coursess" class="coursess" >Available Fees</div></td>
                                <td width="38%"><div id="coursess" class="coursess" >
                                <input type="text" class="input_text" name="balance" readonly="readonly" id="balance" value="<?php// if($_POST['save_changes']) echo $_POST['balance']; else echo $row_record['final_fees'];?>" />
                                </div>
                                </td>                
                                <td width="40%"></td>
                            </tr>-->
   <!--============================================================================================================================================================-->
                            <tr>
                            	<th width="20%" class="heading">Fee breakup </th>
                            </tr>  
                            <tr>    
                                <td width="20%" class="heading">Net Fees (with Tax)<span class="orange_font">*</span></td>
                                <td><input type="text" class="validate[required] input_text" readonly="readonly" name="net_fees" id="net_fees" value="<?php if($_POST['net_fees']) echo $_POST['net_fees']; else echo $row_record['net_fees'];?>" /></td>
                            </tr>
                            <!--<tr>      
                                <td width="20%" class="heading">Service Tax <span id="service_tax_id"><?php //if($_SESSION['type']!='S'){ echo $_SESSION['service_tax'];} ?></span>%<span class="orange_font">*</span></td><input type="hidden" id="service_taxes" name="service_taxes" value="<?php //if($_SESSION['type']!='S'){ echo $_SESSION['service_tax'];} ?>"  />
                                <td><input type="text" class="validate[required] input_text" readonly="readonly" name="service_tax" id="service_tax"  value="<?php if($_POST['service_tax']) echo $_POST['service_tax']; else echo $row_record['service_tax'];?>" /></td>
                            </tr>-->
                            <tr>      
                                <td width="20%" class="heading">Total GST</td>
                                <td><input type="text" class="validate[required] input_text" readonly="readonly" name="total_gst" id="total_gst"  value="<?php if($_POST['total_gst']) echo $_POST['total_gst']; else echo $row_record['total_gst'];?>" /></td>
                            </tr>
                            <tr>      
                            	<td width="20%" class="heading">CGST <span id="cgst_id"><?php if($_SESSION['type']!='S'){ echo $_SESSION['cgst'];} ?></span>%<span class="orange_font">*</span></td><input type="hidden" id="cgst_taxes" name="cgst_taxes" value="<?php if($_SESSION['type']!='S'){ echo $_SESSION['cgst'];} ?>"  />
                                <td><input type="text" class="validate[required] input_text" readonly="readonly" name="cgst_tax" id="cgst_tax"  value="<?php if($_POST['cgst_tax']) echo $_POST['cgst_tax']; else echo $row_record['cgst_tax'];?>" /></td>
                            </tr>
                            <tr>      
                                <td width="20%" class="heading">SGST <span id="sgst_id"><?php if($_SESSION['type']!='S'){ echo $_SESSION['sgst'];} ?></span>%<span class="orange_font">*</span></td><input type="hidden" id="sgst_taxes" name="sgst_taxes" value="<?php if($_SESSION['type']!='S'){ echo $_SESSION['sgst'];} ?>"  />
                                <td><input type="text" class="validate[required] input_text" readonly="readonly" name="sgst_tax" id="sgst_tax"  value="<?php if($_POST['sgst_tax']) echo $_POST['sgst_tax']; else echo $row_record['sgst_tax'];?>" /></td>
                            </tr>
                            <tr>      
                            	<td width="20%" class="heading">Total Fees <span class="orange_font">*</span></td>
                                <td><input type="text" class="validate[required] input_text" readonly="readonly" name="fees" id="fees"  value="<?php if($_POST['fees']) echo $_POST['fees']; else echo $row_record['total_fees'];?>" /></td> 
                            </tr>
                            <tr>
                            	<td width="20%" class="heading">Down Payment(Including tax)<span class="orange_font">*</span></td>
                                <td><input type="text" class="validate[required] input_text" name="down_payment" id="down_payment" onKeyUp="show_record(this.value,1)" value="<?php if($_POST['down_payment']) echo $_POST['down_payment']; else if($row_record['down_payment']!=0) echo $row_record['down_payment']; else echo 0;?>" /></td>
                            </tr> 
							<tr>      
                            	<td width="20%" class="heading">CGST <span id="down_cgst_id"> on down payment<?php if($_SESSION['type']!='S'){ echo $_SESSION['cgst'];} ?></span>%<span class="orange_font">*</span></td><input type="hidden" id="down_cgst_taxes" name="down_cgst_taxes" value="<?php if($_SESSION['type']!='S'){ echo $_SESSION['cgst'];} ?>"  />
                                <td><input type="text" class="validate[required] input_text" readonly="readonly" name="down_cgst_tax" id="down_cgst_tax"  value="<?php if($_POST['down_cgst_tax']) echo $_POST['down_cgst_tax']; else echo $row_record['cgst_tax'];?>" /></td>
                            </tr>
                            <tr>      
                            	<td width="20%" class="heading">SGST <span id="down_sgst_id"> on down payment<?php if($_SESSION['type']!='S'){ echo $_SESSION['sgst'];} ?></span>%<span class="orange_font">*</span></td><input type="hidden" id="down_sgst_taxes" name="down_sgst_taxes" value="<?php if($_SESSION['type']!='S'){ echo $_SESSION['sgst'];} ?>"  />
                                <td><input type="text" class="validate[required] input_text" readonly="readonly" name="down_sgst_tax" id="down_sgst_tax"  value="<?php if($_POST['down_sgst_tax']) echo $_POST['down_sgst_tax']; else echo $row_record['sgst_tax'];?>" /></td>
                           	</tr>
                            <!--<tr>
                            	<td width="20%" class="heading">Service Tax in Down Payment<span class="orange_font">*</span></td>
                                <td><input type="text" class="validate[required] input_text" readonly="readonly" name="down_payment_tax" id="down_payment_tax" onKeyUp="show_record()" value="<?php //if($_POST['down_payment_tax']) echo $_POST['down_payment_tax']; else if($row_record['down_payment_tax']!=0) echo $row_record['down_payment_tax']; else echo 0;?>" /></td>
                            </tr>-->
                            <tr>
                            	<td width="20%" class="heading">Down Payment(Without tax)<span class="orange_font">*</span></td>
                                <td><input type="text" class="validate[required] input_text" readonly="readonly" name="down_payment_wo_tax" id="down_payment_wo_tax" onKeyUp="show_record()" value="<?php if($_POST['down_payment_wo_tax']) echo $_POST['down_payment_wo_tax']; else if($row_record['down_payment_wo_tax']!=0) echo $row_record['down_payment_wo_tax']; else echo 0;?>" /></td>
		                   	</tr>
							<tr>
								<td><strong>Paid Installment</strong></td>
							</tr>
							<tr>
                            	<td colspan="3"> <div >
                                <?php if($record_id)
								{
									?>
									<table width="100%">
									<?php
									$tots_amnt=0;
									$selec_installemnt = "select * from invoice where enroll_id='".$record_id."' and amount>0 and (type !='down_payment' or  type IS NULL) order by invoice_id asc";
									$ptr_installment= mysql_query($selec_installemnt);
									$j=1;
									while($dat_installment = mysql_fetch_array($ptr_installment))
									{
										$dates = $dat_installment['added_date'];
										$date_sep=explode(" ",$dat_installment['added_date']);
										
										$sep_da = explode('-',$date_sep[0]);
										$dates=$sep_da[2].'/'.$sep_da[1].'/'.$sep_da[0];
										/*$display='style="display:block"';
										if($j==1)
										{
											$display='style="display:none"';
										}*/
										$tots_amnt +=$dat_installment['amount'];
										?>
										<tr <?php //echo $display; ?>><td width="23%" class="heading">Installment <?php echo $j; ?> </span></td><td width="25%" ><?php echo $dat_installment['amount'];  ?></td><td><?php echo $dat_installment['added_date'] ;?></td></tr>
										<?php 
										$j++;

									}?>
                                    </table>
                                    <?php
                                }
								?>
                                </div><input type="hidden" name="prev_total_inst" id="prev_total_inst" value="<?php echo $tots_amnt; ?>"  /></td> 
                            </tr>
                            <tr>
                                <td class="heading">Installment on</td>
                                <td colspan="2"> <input type="text" name="installment_on" readOnly  id="installment_on" value="<?php if($_POST['installment_on']) echo $_POST['installment_on']; else if($row_record['balance_amt']!=0) echo $row_record['balance_amt']; else echo 0;?>"/>
                                </td> 
                            </tr>
                            <tr>
                            <tr><td class="heading"> Number of Installment</td>
                            <td colspan="2">
                                  <select name="numDep" id="dropdown" >
                                     <?php 
                                     for ($i = 0; $i <= 24; $i++)
                                     {
                                        $selc = '';
                                        if($row_record['no_of_installment']== $i || $_POST['numDep']== $i)
                                        {
                                            $selc ='selected="selected" ';
                                        }
                                            echo '<option value="'.$i.'" '.$selc.'>'.$i.'</option>';
                                     }
                                        //endfor;
                                      ?>
                                  </select></td>
                            </tr>
                            <tr>
                                <td colspan="3"> <div id="textboxDiv">
                                <?php if($record_id && $row_record['no_of_installment'] !=0)
                                {
                                    ?>
                                    <table width="100%">
                                    <?php
                                    $selec_installemnt = " select * from installment where enroll_id='$record_id' and course_id='".$row_record['course_id']."' ";
                                    $ptr_installment= mysql_query($selec_installemnt);
                                    $i=1;
                                    while($dat_installment = mysql_fetch_array($ptr_installment))
                                    {
                                        $dates = $dat_installment['installment_date'];
                                        $sep_da = explode('-',$dates);
                                        $dates=$sep_da[2].'/'.$sep_da[1].'/'.$sep_da[0];
                                    ?>
                                    <tr><td width="40%" class="heading">Installment <?php echo $i; ?> </span></td><td width="40%" colspan=2""><input type="text" class="input_text" name="installments[]" id="ins_price" value='<?php if($_POST['installments']) echo $_POST['installments']; else echo $dat_installment['installment_amount'];  ?>' /></td><td><input type="text" name="installment_date[]" class="datepicker" placeholder="installment date" id="ins_date" value="<?php if($_POST['installment_date']) echo $_POST['installment_date']; else echo $dates ;?>"  ></td></tr>
                                    <?php 
                                    $i++;
                                    }?>
                                    </table>
                                    <?php
                                }
                                 ?>
                                </div></td> 
                            </tr>
							<?php
                            $sql_invoice="select * from invoice where enroll_id='".$row_record['enroll_id']."' and course_id='".$row_record['course_id']."' 
                            and installment_id='0' ";
                            $my_query_invoice=mysql_query($sql_invoice);
                            if(mysql_num_rows($my_query_invoice))
                            {
                                $row_invoice= mysql_fetch_array($my_query_invoice);
                                if($chaque_date  !='//')
                                {
                                    $chaque_date = $data_invoice['chaque_date'];
                                    $sep_chk_dt = explode('-',$chaque_date);
                                    $chaque_date=$sep_chk_dt[1].'/'.$sep_chk_dt[2].'/'.$sep_chk_dt[0];
                                }
                            }
                            ?>
                            <tr>
                                <td width="20%" class="heading">Select Payment Mode</td>
                                <td>
                                <select name="payment_type" id="payment_type" onChange="show_payment(this.value)">
                                <option value="select">--Select--</option>
                                <?php
                                $sel_payment_mode="select payment_mode,payment_mode_id from payment_mode";
                                $ptr_payment_mode=mysql_query($sel_payment_mode);
                                $selctds='';
                                while($data_payment=mysql_fetch_array($ptr_payment_mode))
                                {
                                    $selected='';
                                    if(($data_payment['payment_mode_id'] == $data_invoice['paid_type']) || ($payment_type == $data_payment['payment_mode_id']))
                                    {
                                        $selected='selected="selected"';
                                        $selctds = $data_payment['payment_mode'].'-'.$data_payment['payment_mode_id'];
                                    }
                                    echo '<option '.$selected.' value="'.$data_payment['payment_mode'].'-'.$data_payment['payment_mode_id'].'">'.$data_payment['payment_mode'].'</option>';

                                }
                                ?>
                                </select></td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                <div id="bank_ref_no" <?php if($_POST['payment_type'] =='online-5') echo 'style="display:block"'; else if($data_invoice['paid_type'] =='5') echo 'style="display:block"';  else echo 'style="display:none"'; ?>>
                                    <table width="100%">
                                        <tr>
                                            <td width="10%" class="tr-header" align="">Ref. no</td>
                                            <td width="35%"><input type="text" name="bank_ref_no" id="bank_ref_no" value="<?php if($_POST['bank_ref_no']) echo $_POST['bank_ref_no']; else echo $data_invoice['bank_ref_no']; ?>"/></td>
                                        </tr>
                                    </table>
                                </div>
                                <div id="bank_details"  <?php if($_POST['payment_type'] =='cheque-2') echo 'style="display:block"'; else if($data_invoice['paid_type'] =='2') echo 'style="display:block"';  else echo 'style="display:none"'; ?>>
                                <table width="100%">
                                    <tr>
                                        <td width="21%" class="tr-header" align="">Customer Bank Name</td>
                                        <td width="22%"><input type="text" name="cust_bank_name" id="cust_bank_name" value="<?php if($_POST['cust_bank_name']) echo $_POST['cust_bank_name']; else echo $data_invoice['cust_bank_name']; ?>"/></td>
                                        <td width="22%" class="tr-header" align=""> ISAS Bank Name : &nbsp; 
                                            <?php 
                                            //echo $row_invoice['bank_name'];
                                            /*if($row_invoice['bank_name'] !='')
                                            {
                                                $_SESSION['selected_bank']=$row_invoice['bank_name'];	
                                            }
                                            if($_SESSION['type'] !="S")
                                            {
                                            ?>
                                                <select name="bank_name" id="bank_name" onChange="show_acc_no(this.value)">
                                                <option value="select">--Select--</option>
                                                <?php
                                                $sle_bank_name="select bank_id,bank_name from bank"; 
                                                $ptr_bank_name=mysql_query($sle_bank_name);
                                                while($data_bank=mysql_fetch_array($ptr_bank_name))
                                                {
                                                    $selected='';
                                                    if($data_bank['bank_id'] == $row_invoice['bank_name'])
                                                    {
                                                        $selected='selected="selected"';
                                                    }
    
                                                    echo '<option '.$selected.' value="'.$data_bank['bank_id'].'">'.$data_bank['bank_name'].'</option>';
                                                }
                                                ?>
                                                </select>
                                            <?php }*/ ?>
                                            <div id="bank_id"></div>
                                        </td>
                                        <td width="24%" class="tr-header" align=""> ISAS Account No : &nbsp; 
                                  			<input type="text" name="account_no" readonly="readonly" id="account_no" value="<?php if($_POST['account_no']) echo $_POST['account_no']; else echo $data_account['account_no']; ?>"/>
                                 		</td>
                                    </tr>
                                </table>
                                </div>
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="2">
                                	<div id="chaque_details" <?php if($_POST['payment_type']=='cheque-2') echo 'style="display:block"'; else if($data_invoice['paid_type']=='2') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
                                    	<table width="99%">
                                        	<tr>
                                            	<td width="28%">Customer Cheque No.</td>
                                                <td width="72%"><input type="text" name="chaque_no" id="chaque_no"  class="validate[required] input_text"  value="<?php if($_POST['chaque_no']) echo $_POST['chaque_no']; else echo $data_invoice['cheque_detail'];?>" onKeyPress="return isNumber(event)" maxlength="15	"/></td>
                                            </tr>
                                            <tr>
                                            	<td>Customer Cheque Date</td>
                                                <td><input type="text" name="chaque_date" id="chaque_date"  class="datepicker" placeholder="cheque date " value="<?php if($_POST['save_records']) echo $_POST['chaque_date']; else echo $chaque_date ;?>" /></td>
                                            </tr>
                                        </table>
                                   	</div>
                                    <div id="credit_details" style="display:none">
                                    	<table width="99%">
                                        	<tr>
                                            	<td width="51%" class="tr-header" align="">Enter Credit Card No</td>
                                             	<td><input type="text" name="credit_card_no" id="credit_card_no" maxlength="4" value="<?php if($_POST['credit_card_no']) echo $_POST['credit_card_no']; else echo $data_invoice['credit_card_no']; ?>" /></td>
                                            </tr>
                                        </table>
                                   	</div>
    	                        </td>
	                        </tr>
                            <!--<tr>
                                 <td width="20%" class="heading">Payment Mode<span class="orange_font">*</span></td>
                                 <td ><div id="pay_type"> <input type="radio" class="validate[required] input_radio" name="payment_type" id="payment_type" value="cash" onClick="hide();" <?php //if($data_invoice['paid_type']=='cash'|| $_POST['payment_type']=='cash') echo 'checked="checked"'; ?> /> Cash
                                   <input type="radio" class="validate[required] input_radio" name="payment_type"  id="payment_type" value="cheque" onClick="show();" <?php //if($data_invoice['paid_type']=='cheque'|| $_POST['payment_type']=='cheque') echo 'checked="checked"'; ?> />By Cheque
                                   <input type="radio" class="validate[required] input_radio" name="payment_type" id="payment_type" value="online" onClick="hide();"<?php //if($data_invoice['paid_type']=='online'|| $_POST['payment_type']=='online') echo 'checked="checked"'; ?> />Online
                                 </div> </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">
                                <div id="payment" <?php  //if($data_invoice['paid_type']=='cheque' || $_POST['payment_type'] =='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>> 
                                <table>
                                	<tr>
                                    	<td>Bank Name</td>
                                        <td><input type="text" name="bank_name" id="bank_name"  class="validate[required] input_text" 
                                        value="<?php //if($_POST['bank_name']) echo $_POST['bank_name']; else echo $data_invoice['bank_name'];?>"/></td>
                                        <td>Cheque No.</td>
                                        <td><input type="text" name="chaque_no" id="chaque_no"  class="validate[required] input_text"  value="<?php //if($_POST['chaque_no']) echo $_POST['chaque_no']; else echo $data_invoice['chaque_no'];?>" onKeyPress="return isNumber(event)" maxlength="6"/></td>
                                        <td>Cheque Date</td>
                                        <td><input type="text" name="chaque_date" id="chaque_date"  class="datepicker" placeholder="cheque date " value="<?php //if($_POST['save_changes']) echo $_POST['chaque_date']; else echo $chaque_date ;?>"/></td>
                                    </tr>
                                </table>
                                </div>
                               	</td> 
                            </tr>-->
                            <tr>
                            	<td width="20%" class="heading">Customer GST no.(if availale)<span class="orange_font">*</span></td>
                              	<td><input type="text" class="input_text" name="cust_gst_no" id="cust_gst_no" value="<?php if($_POST['cust_gst_no']) echo $_POST['cust_gst_no']; else if($row_record['cust_gst_no']!=0) echo $row_record['cust_gst_no']; else echo '';?>" /></td>
                        	</tr>
                        	<tr>
                              	<td width="20%" class="heading">Total Balance Amount<span class="orange_font">*</span></td>
                              	<td><input type="text" class="validate[required] input_text" readOnly name="final_amt" id="final_amt" value="<?php  if($_POST['final_amt']) echo $_POST['final_amt']; else if($row_record['balance_amt']!=0) echo $row_record['balance_amt']; else echo 0;?>" /></td>
                        	</tr>
                         	<tr>
                              	<td width="20%" class="heading">Final Amount<span class="orange_font">*</span></td>
                              	<td><input type="text" class="validate[required] input_text" readOnly name="total_amt" id="total_amt" value="<?php  if($_POST['total_amt']) echo $_POST['total_amt']; else echo $row_record['net_fees'];?>" /></td>
                        	</tr>
							<tr>
                                <td width="22%">Assigned to<span class="orange_font"></span></td>
                                <td width="44%"><select id="employee_id" name="employee_id">
                                <option value="">--Select Staff--</option>
                                <?php 
                                 /* $sel_staff="SELECT * FROM site_setting where type='C' ";
                                $ptr_staff=mysql_query($sel_staff);
                                while($data_staff=mysql_fetch_array($ptr_staff))
                                {
                                    $sele_staff="";
                                    if($data_staff['admin_id'] == $row_record['employee_id'] || $_POST['employee_id']== $data_staff['admin_id'] )
                                    {
                                        $sele_staff='selected="selected"';
                                    } */
                                    ?>
                                    <!--<option <?php //echo $sele_staff?> value = "<?php //echo $data_staff['admin_id']?>" <?php //if (isset($employee_id) && $employee_id == $data_staff['admin_id']) echo "selected";?> > <?php echo $data_staff['name'] ?> </option>-->
                                    <?
                                //}
                                ?>
                                </select></td>
                                <td width="34%"></td>
                            </tr>
        				</table>
        				<center>
        				<input type="hidden" name="course_only_fee" id="course_only_fee" value="" />
       				<table>
        				<tr>
            				<td align="right">
                            	<input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
            					<input type="hidden" value="save" name="save_records" id="save_records" /> 
            					<div id="hide_btns">
									<?php
                                    if($record_id !='')
                                    { 
                                    	?>
                                        <input type="submit" value="Update Record" name="save_changes" /> 
                                    	<?
                                    }
                                    else
                                    {
										?>
										<input type="submit" value="Save Record" name="save_changes"  /> 
										<?php 
                                    }?>
            					</div>	
            				</td>
        				</tr>
        			</table>
        			</center>   
        		</form>
        		<script type="text/javascript">
            	$(function() 
            	{
                	$(".custom_cuorse_submit").click(function(){
                    var course_name = $("#course_name").val();
                    var category_id = $("#category_id").val();
                    var course_duration = $("#course_duration").val();
                    var course_desc = $("#course_desc").val();
                    var course_fee = $("#course_fee").val();				
					var cgst_taxes = $("#cgst_taxes").val();
					var sgst_taxes = $("#sgst_taxes").val();
                    if(course_name == "" || course_name == undefined)
                    {
                        alert("Eneter the course name.");
                        return false;
                    }
                    if(category_id == "" || category_id == undefined)
                    {
                 	   alert("Select the category.");
                       return false;

                    }

                    if(course_duration == "" || course_duration == undefined)

                    {

                        alert("Eneter the course duration.");

                        return false;

                    }
                    var data1 = 'action=custome_course_submit&course_name='+course_name+'&course_duration='+course_duration+'&course_desc='+course_desc+'&course_fee='+course_fee+'&category_id='+category_id
                    $.ajax({
                        url: "ajax.php", type: "post", data: data1, cache: false,
                        success: function (html)
                        {
                            $(".customized_select_box").html(html);

                            //$("#duration_studies").val(course_duration);
							
							//var tax=(service_taxes * course_fee)/100;
							var cgst_tax=(cgst_taxes * course_fee)/100;
							var sgst_tax=(sgst_taxes * course_fee)/100;
							var course_with_tax=Number(course_fee)+Number(cgst_tax)+Number(sgst_tax);
                            $("#course_only_fee").val(course_with_tax);

                            $('.new_custom_course').dialog( 'close');

                            show_record();



                        }



                    });



                });
            });
        </script>
        <div class="new_custom_course" style="display: none;">
            <form method="post" id="jqueryForm" enctype="multipart/form-data">
                <table border="0" cellspacing="15" cellpadding="0" width="100%">
                    <tr>
                        <td colspan="3" class="orange_font">* Mandatory Fields</td>
                    </tr>
                    <tr>

                        <td width="20%">Course Name<span class="orange_font">*</span></td>
                        <td width="40%"><input type="text" class="inputText" name="course_name" id="course_name"/></td>
                    </tr>
                    <tr>
                        <td>Course Category<span class="orange_font">*</span></td>
                        <td>
                            <select name="category_id" id="category_id" class="validate[required] input_select" >  
                                <option value=""> Select Category</option>
                                <?php
                                    $select_category = "select * from course_category  order by category_id asc";
                                    $ptr_category = mysql_query($select_category);
                                    while($data_category = mysql_fetch_array($ptr_category))
                                    {
                                        if($data_category['category_id'] == $row_record['category_id'])
                                            echo '<option value='.$data_category['category_id'].' selected="selected">'.$data_category['category_name'].'</option>';
                                        else
                                            echo '<option value='.$data_category['category_id'].'>'.$data_category['category_name'].'</option>';
                                    }
                                    ?>        
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Course Duration<span class="orange_font">*</span></td>
                        <td><input type="text" class="inputText" name="course_duration" id="course_duration"></td>
                    </tr>
                    <tr>
                        <td>Course Description<span class="orange_font"></span></td>
                        <td><textarea name="course_desc" id="course_desc"></textarea></td>
                    </tr>
                    <tr>
                        <td>Course Fee<span class="orange_font"></span></td>
                        <td><input type="text" class="inputText" name="course_fee" id="course_fee"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="button" class="inputButton custom_cuorse_submit" value="Submit" name="submit"/>&nbsp;
                            <input type="reset" class="inputButton" value="Close" onClick="$('.new_custom_course').dialog( 'close');"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>            
        </td></tr>
<?php
 } ?>
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
<div class="clearit"> </div>
<!--footer start-->
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
<script>
/*vals= document.getElementById("payment_type").value;
show_payment(vals);*/

if(document.getElementById("branch_name"))
{
	branch_id= document.getElementById("branch_name").value;
	admin_id=<?php echo $_SESSION['admin_id']; ?>;
	///alert(admin_id);
	show_staff(branch_id,admin_id)
}
<?php
if($record_id || $_SESSION['type']=="S")
{
	?>
	if(document.getElementById("payment_type"))
	{
	vals= document.getElementById("payment_type").value;
	show_payment(vals);
	}
	<?php
}
?>
<?php
if($record_id)
{
	?>
	var toal_fees =document.getElementById("toal_fees").value;
	var course_id=document.getElementById("course_id").value;
	get_course_discount(course_id,<?php echo $record_id; ?>);
	
	setTimeout(show_record,1000,toal_fees,'1')
	<?php
	if($row_record['balance_amt']!=0) 
	{
		?>
		//alert("<?php //echo $row_record['balance_amt']; ?>");
		setTimeout(show_downpayment,1500);
		<?php
	}
 }
 ?>
function show_downpayment()
{
	//alert("hi");
	document.getElementById("installment_on").value="<?php echo $row_record['balance_amt']; ?>";
	document.getElementById("final_amt").value="<?php echo $row_record['balance_amt']; ?>";
}
</script>
<script>
branch='';
if(document.getElementById("branch_name"))
{
	var branch_name =document.getElementById("branch_name").value;
	var res = branch_name.substring(0, 3);
	var branch=res.toUpperCase();
}
<?php
if($record_id='')
{
	?>
	var display_id=document.getElementById("inst_student_id").value;
	stud_id=display_id.replace("ISAS","ISAS/"+branch);
	//alert(stud_id);
	document.getElementById("inst_student_id").value=stud_id;
	<?php 
} ?>
</script>
</body>
</html>
<?php $db->close();?>