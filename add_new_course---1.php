<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT enroll_id,student_id,name,contact,mail,dob,address,qualification,username,pass,admission_date,source,admission_remark,added_date,photo,admin_id,installment_display_id,status,stud_login_id,cm_id FROM enrollment where enroll_id='".$record_id."'";
	$_SESSION['sql_articles']=$sql_record;
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
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
/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php if($record_id) echo "Edit"; else echo "Enrollment ";?>Form</title>
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
<!--End multiselect -->
<script type="text/javascript">
/* jQuery(document).ready( function() 
{
   // $("#user_id").multiselect().multiselectfilter();
	// binds form submission and fields to the validation engine
	jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
});*/
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
<!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
<link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
<script src="js/development-bundle/ui/jquery.ui.core.js"></script>
<script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript">
$(document).ready(function()
{            
	$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear',minDate: '-50Y',
maxDate: '+2Y',});
	
//             $('input:radio[name=free_course][value=N]').click();
//             $('input:radio[name=discount_course][value=Y]').click();
//             $('input:radio[name=status][value=Inactive]').click();
});
</script>
<script>
function counter_check(id)
{
	//alert(id);
	total_prices='total_prices';
	fee_id = 'fees_'+id;
	id= '#'+id;
	//$(id).attr('checked',true);
	previous = parseInt($('#total_checked_questions').val());
	//alert(previous);
	total_qution=document.getElementById('trotot').value;
	fees_value= parseInt(document.getElementById(fee_id).value);
	sub_fee= parseInt(document.getElementById('sub_fee').value);
	/*if(previous>=total_qution)
	$(id).removeAttr('checked');	
	else
	{	*/
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
	// document.getElementById(
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
function send1()
	{
		alert('hi');
		var name =document.getElementById('name').value;
		var username =document.getElementById('username').value;
		var dob =document.getElementById('dob').value;
		
		var address =document.getElementById('address').value;
		var contact =document.getElementById('contact').value;
		var mail =document.getElementById('mail').value;
		var qualification =document.getElementById('qualification').value;
		var photo =document.getElementById('photo').value;
		
		var paid_type =document.getElementById('paid_type').value;
		var source =document.getElementById('source').value;
		var admission_remark =document.getElementById('admission_remark').value;
		var course_id =document.getElementById('course_id').value;
		
		var admission_date =document.getElementById('admission_date').value;
		var costomize_courses =document.getElementById('costomize_courses').value;
		var total_fees =document.getElementById('total_fees').value;
		var discount_coupon =document.getElementById('discount_coupon').value;
		
		var concession =document.getElementById('concession').value;
		var discount_type =document.getElementById('discount_type').value;
		var down_payment =document.getElementById('down_payment').value;
		
		var chaque_no =document.getElementById('chaque_no').value;
		var chaque_date =document.getElementById('chaque_date').value;
		var credit_card_no =document.getElementById('credit_card_no').value;
		var cust_bank_name =document.getElementById('cust_bank_name').value;
		var payment_type =document.getElementById('payment_type').value;
		var installment_on =document.getElementById('installment_on').value;
		var net_fees =document.getElementById('net_fees').value;	
		var fees =document.getElementById('fees').value;
		var down_payment =document.getElementById('down_payment').value;
		var down_payment_tax =document.getElementById('down_payment_tax').value;
		var down_payment_wo_tax =document.getElementById('down_payment_wo_tax').value;
		var dropdown =document.getElementById('dropdown').value;
		var branch_name =document.getElementById('branch_name').value;
		var final_amt =document.getElementById('final_amt').value;
	
		data1='action=add_new_course&name='+name+'&username='+username+'&dob='+dob+'&address='+address+'&contact='+contact+'&mail='+mail+'&qualification='+qualification+'&photo='+photo+'&paid_type='+paid_type+'&source='+source+'&admission_remark='+admission_remark+'&course_id='+course_id+'&admission_date='+admission_date+'&costomize_courses='+costomize_courses+'&total_fees='+total_fees+'&discount_coupon='+discount_coupon+'&concession='+concession+'&discount_type='+discount_type+'&down_payment='+down_payment+'&chaque_no='+chaque_no+'&chaque_date='+chaque_date+'&credit_card_no='+credit_card_no+'&cust_bank_name='+cust_bank_name+'&payment_type='+payment_type+'&installment_on='+installment_on+'&net_fees='+net_fees+'&fees='+fees+'&down_payment='+down_payment+'&down_payment_tax='+down_payment_tax+'&down_payment_wo_tax='+down_payment_wo_tax+'&dropdown='+dropdown+'&branch_name='+branch_name+'&final_amt='+final_amt;
		alert(data1);
		$.ajax({
		url:'http://www.htdpt.in/tracking/send_email.php',type:"post",data:data1,cache:false,
		 success: function (html)
            {
				//alert("success");
				  alert(html);
            }
              });
			  
	
return false;
		   
	   }
</script>
<script>
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
				//alert(retrive_func);
				 sep_disc=retrive_func
					show_record();
				 //alert(sep_disc);
				 
			}
		});
}
function show_record(vals,no)
{    

	frm = document.jqueryForm; 
    concession=0; 
	//paid=0;
	totals_fees=0;
	balance=0;
	//================================PAID TYPE==========================
	paid_type =frm.paid_type.value;
	//alert(paid_type);
	var course_exist=document.getElementById("course_id").value;
	if(course_exist !='')
	{
		if(document.getElementById('toal_fees') && vals !='' && no==1)
		{
			courses_fees=document.getElementById('toal_fees').value;
			document.getElementById('course_only_fee').value=courses_fees;
		}
		if(paid_type=='installments')
		 {
			 toatl_one_time=parseInt(document.getElementById('course_only_fee').value);
			 inst_tax=parseInt(document.getElementById('inst_taxes').value);
			 installment_charge=  parseInt(toatl_one_time*inst_tax/100);
			 totals_charge=installment_charge+toatl_one_time;
			 document.getElementById('toal_fees').value=totals_charge;
			 totals_fees = parseInt(document.getElementById('toal_fees').value);
			 document.getElementById("dropdown").disabled  = false;
			 down_fees=document.getElementById('down_payment').value;
		 }
		 else if(paid_type=='installments_zero')
		 {
			totals_fees = parseInt(document.getElementById('course_only_fee').value);
			//alert(totals_fees);
			document.getElementById('toal_fees').value=totals_fees;
			document.getElementById("dropdown").disabled  = true;
			down_fees=document.getElementById('down_payment').value;
		 }
		 else
		 {
			/*disp_error +='Select Correct Paid Type Or Paid full Amount as a Down Payment \n'; 
			error='yes';*/
			document.getElementById("dropdown").disabled  = true;
			var inst1 = document.getElementById("dropdown").disabled  = true;
			$('#dropdown').removeClass("obrderclass");  
			//alert(total_f);
			totals_fees = parseInt(document.getElementById('course_only_fee').value);
			document.getElementById('toal_fees').value=totals_fees;
		 }
		//===================================================================
		// paid = document.getElementById('paid').value;
		concession = parseInt(document.getElementById('concession').value);
		$('#dropdown').prop('selectedIndex',0);
		$("#textboxDiv").html('');
		disc_type =frm.discount_type.value;
		if(disc_type!='cash')
		{
			if(concession !='' || concession !=0 || concession<=100 )
			concession=  parseInt(totals_fees*concession/100);
		}
		if(concession !='' || concession<=totals_fees)
		{
			total_bal_ava= parseInt(totals_fees)- parseInt(concession);
		}
		else
		{
			concession=0;
			total_bal_ava= parseInt(totals_fees)- parseInt(concession);
		}
		//alert(total_bal_ava);
		document.getElementById('net_fees').value=total_bal_ava;
		//alert(total_bal_ava);
		var local = sep_disc
  		 //alert(local);
		if(local !='' || local !=0)
		{
		//alert("yahoo");
			var total_disc_coupon= parseInt(total_bal_ava - local);
			document.getElementById('net_fees').value=total_disc_coupon;
			document.getElementById('discount_coupon_price').value=local;
		}
	  	var net_fees=parseInt(document.getElementById('net_fees').value);
		var service_tax=parseFloat(document.getElementById('service_taxes').value);
		var new_tax=parseFloat((service_tax+100)/100);
		//alert("(service_tax+100)/100= "+new_tax);
		var taxable_value = parseInt(net_fees / new_tax);
		//alert(taxable_value+"="+net_fees+"/"+new_tax);
		var tax =parseInt(net_fees - taxable_value);
		//alert("net_fees - taxable_value= "+tax);
	 	//alert (tax)
		document.getElementById('service_tax').value=tax;
	  	var total = parseInt(net_fees - tax);
		//alert (total)
		document.getElementById('fees').value=total;
		if(paid_type=='installments' || paid_type=='installments_zero')
		{
		}
		else
		{
			document.getElementById('down_payment').value=net_fees;
		}
		document.getElementById('total_amt').value=net_fees;
		var fee1 = parseInt(document.getElementById('fees').value);
	    var down_payment =parseInt( document.getElementById('down_payment').value);
		//alert (total_f);
		var dp_taxable_value = parseInt(down_payment / new_tax);
		var dp_tax =parseInt(down_payment - dp_taxable_value);
		//var total_f= fee1 - dp_taxable_value;
		total_f= net_fees - down_payment;
		document.getElementById('down_payment_tax').value=dp_tax;
		document.getElementById('down_payment_wo_tax').value=dp_taxable_value;
		document.getElementById('installment_on').value=total_f;
		//alert(total_f+"="+fee1+" - "+dp_taxable_value);
		document.getElementById('final_amt').value=total_f;
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
		down_fees11=parseInt(document.getElementById('down_payment').value);
		if(down_fees11 > total11)
		{
			alert('Down Payment is not greater than Total Fees  \n');
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
		
		function show_bank(branch_id,vals)
		{
			//alert(branch_id);
			//============================================================
				var res = branch_id.substring(0, 3);
				var branch=res.toUpperCase();
				var display_id=document.getElementById("inst_student_id").value;
				//alert(display_id);
				var res_str = display_id.substring(5, 8);
				stud_id=display_id.replace(res_str,branch);
				//alert(stud_id);
				document.getElementById("inst_student_id").value=stud_id;
			//=============================================================
			var bank_data="show_bnk=1&branch_id="+branch_id+"&payment_type="+vals;
			
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
				document.getElementById("service_tax_id").innerHTML=service_tax;
				document.getElementById("inst_tax_id").innerHTML=installment_tax;
				
				document.getElementById("service_taxes").value=service_tax;
				document.getElementById("inst_taxes").value=installment_tax;
				//alert("service tax- "+service_tax);
			}
			
			});
		}
		
		function show_bank_for_payment_mode(branch_id,vals)
		{
			//alert(branch_id);
			
			var bank_data="show_bnk=1&branch_id="+branch_id+"&payment_type="+vals;
			
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
				document.getElementById("service_tax_id").innerHTML=service_tax;
				document.getElementById("inst_tax_id").innerHTML=installment_tax;
				
				document.getElementById("service_taxes").value=service_tax;
				document.getElementById("inst_taxes").value=installment_tax;
				//alert("service tax- "+service_tax);
			}
			
			});
		}
		//function show_batch(course_id)
		//{
		//	var data1="show_batch=1&course_id="+course_id;
		//		 $.ajax({
        //    url: "show_batch.php", type: "post", data: data1, cache: false,
        //    success: function (html)
        //    {
		//		 document.getElementById('batches').innerHTML=html;
		//	}
		//	});
		//}
		
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
		
		show_bank_for_payment_mode(branch_name,"cheque")
	}
	else if(payment_mode[0]=="Credit Card")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'block';
		show_bank_for_payment_mode(branch_name,"credit_card")
		
	}
	else if(payment_mode[0]=="paytm")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"paytm")
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
<script type="text/javascript">
$(document).ready(function() {
    $("#dropdown").change(function()
    {
        var selVal = $(this).val();
        $("#textboxDiv").html('');
        //alert (selVal);
        var inst =parseInt (document.getElementById('installment_on').value);
        //alert (inst);
        var no_inst = inst/selVal ;
		//alert(no_inst);
        document.getElementById('final_amt').value=inst;
        //alert (no_inst);
       
        if(selVal > 0)
        {
            for(var i = 1; i<= selVal; i++)
            {
                $("#textboxDiv").append('<table width="100%"><tr><td width="23%" class="heading">Installment '+i+' </span></td><td width="40%" colspan="2"><input type="text" class="input_text installment_input installment_inp_'+i+'" alt="'+i+'" name="installments[]" value="'+parseFloat(no_inst).toFixed(2)+'" /></td><td><input type="text" name="installment_date[]" class="datepicker date_class'+i+'" placeholder="installment date " ></td></tr></table>');
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
                        //var temp_var = current_number+1;
                        //$(".installment_inp_"+temp_var).prop('disabled',true);
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
                //alert(current_number);
            });
        }
        else
            $('#dropdown').addClass("obrderclass");
        $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
    });
});

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
</script>
 <script>
	//function service_tax1()
   	//{
		//document.getElementById('net_fees').value=total_bal_ava;
	  
	  //var net_fees=parseInt(document.getElementById('net_fees').value);
		//var tax =parseInt(net_fees*14/100);
	 	//alert (tax)
		//document.getElementById('service_tax').value=tax;
		
		
	  	//var total = net_fees + tax ;
		//alert (total)
		//document.getElementById('fees').value=total;
	//}
	
</script>
	
    <style type = "text/css">
        #feedback{
            line-height:;
        }
		.obrderclass{ border:1px solid #f00}
    </style>  
     
<script type = "text/javascript">
    //this script will be triggered once the 
    //user type in the textbox 
 
    //when the document is ready, run the function
    $(document).ready(function(){ 
        $('#feedback').load('check.php').show();
        //we use keyup so that everytime the 
        //user type in the keyboard, it'll check
        //the database and get results
        //however, you can change this to a button click
        //which is I think, more advisable. 
        //Sometimes, your server response is slow
        //but just for this demo, we'll use 'keyup' 
        $('#username').keyup(function(){
            //this will pass the form input
            $.post('check.php', { username: jqueryForm.username.value },
            //then print the result
            function(result){
                $('#feedback').html(result).show();
            });
        });
    });
	
	 $(document).ready(function(){ 
        $('#coupon').load('coupon_check.php').show();
        //we use keyup so that everytime the 
        //user type in the keyboard, it'll check
        //the database and get results
        //however, you can change this to a button click
        //which is I think, more advisable. 
        //Sometimes, your server response is slow
        //but just for this demo, we'll use 'keyup' 
        $('#discount_coupon').keyup(function(){
            //this will pass the form input
            $.post('coupon_check.php', { discount_coupon: jqueryForm.discount_coupon.value },
            //then print the result
            function(result){
                $('#coupon').html(result).show();
            });
        });
		$('#discount_coupon').blur(function(){
            //this will pass the form input
            $.post('coupon_check.php', { discount_coupon: jqueryForm.discount_coupon.value },
            //then print the result
            function(result){
                $('#coupon').html(result).show();
            });
        });
    });
	
	 function validme()
	 {
		 frm = document.jqueryForm;
		 error='';
		 disp_error = 'Clear The Following Errors : \n\n';
		 
		 
		
		 
		 if(frm.name.value=='')
		 {
			 disp_error +='Enter  Name\n';
			 document.getElementById('name').style.border = '1px solid #f00';
			 frm.name.focus();
			 error='yes';
	     }
		 
		
		  if(frm.dob.value!='')
		  {
		  	if(isPastDate(frm.dob.value))
	 	 		{
					var date1 = new Date(frm.dob.value);
					var date2 = new Date();
					var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24)); 
					
					if(diffDays<5475)
					{
						 disp_error +='Your Age is not valid for admission. need more than 15 year age';
						 document.getElementById('dob').style.border = '1px solid #f00';
						 error='yes';
					}


		 		}
			 else
			 {
				 disp_error +='Enter Valid Date Of Birth\n';
				 document.getElementById('dob').style.border = '1px solid #f00';
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
		 {	 var text = frm.contact.value;
			 if(text.length <10)
				{
					 disp_error +='Enter Valid Mobile Number \n';
					 document.getElementById('contact').style.border = '1px solid #f00';
					 error='yes';
				}
		 }
		 if(frm.mail.value=='')
		 {
			 disp_error +='Enter Email ID\n';
			 document.getElementById('mail').style.border = '1px solid #f00';
			 frm.name.focus();
			 error='yes';
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
				else
				{
					spl = isSpclChar('username');	
					
					if(spl =='yes')
					{
						disp_error +='Special Character Not Allowed in Uesr Name\n';
						document.getElementById('username').style.border = '1px solid #f00';
						frm.username.focus();
						error='yes';
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
		
		if(frm.course_id.value=='')
		{
			 disp_error +='Select Interested Course \n';
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
		if(frm.down_payment.value==0)
		{
			net_fees=document.getElementById("net_fees").value;
			if(net_fees !=0)
			{
				disp_error +='Add Down Payment  \n';
				$("#down_payment").addClass("obrderclass");
				frm.down_payment.focus();
				error='yes';
			}
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
		 ///================= Installment Date Validation      ===
		 
		 	no_of_installments = $("#dropdown").val();
			//alert(no_of_installments);
			
			if(no_of_installments)
			{
				x=0;
				dates_array= new Array();
			   for(t=1;t<=no_of_installments;t++)
			   {
				  //alert($(".date_class"+t).val());
				  
				  if($(".date_class"+t).val()=='')
				  {
					 disp_error += t+' Installment date  is not added \n'; 
					 error='yes';
					 $(".date_class"+t).addClass("obrderclass");
				  }
				  else
				  {
					  var targets = new Date($(".date_class"+t).val());
					  now = new Date;
					  today_date = now.getTime();
					  if(targets.getTime()<today_date)//targets.getTime()<=today_date
					  {
						  disp_error += t+' Installment date should be greate than todays date \n'; 
						  $(".date_class"+t).addClass("obrderclass"); 
						  error='yes';
					   }
					   else
					 {
					 	dates_array[x]=targets.getTime();
				   		$(".date_class"+t).removeClass("obrderclass");
				   		x++;
					 }
				  }
				}
				
				///=========== Installemnt date less than greater than validation
			//	alert(dates_array[0]);
				//alert(dates_array.length);
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
				
				
				//=================================================================
					
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
			
			
			
			
		 ///================= END Installmetn Dat4 Validation  ===
		 
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
			
			 /* $('#pay_type').removeClass("obrderclass"); 
			var selected = $("input[name=payment_type]:checked");
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
						/*else
						{
							if(isFeatureDate(frm.chaque_date.value))
							{
								
							}
							else
							{
								 disp_error +='Enter Valid Chaque Date. Chaque date is greater than toddays date\n';
								 error='yes';
								 $('#chaque_date').addClass("obrderclass"); 
								 frm.chaque_date.focus();
							}
						}*/
						
						
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
					
				//}
		}
					
		 
			
	//}
		
		/* if(frm.captcha.value=='')
		 {
			 disp_error +='Enter Security code \n';
			 document.getElementById('captcha-form').style.border = '1px solid #f00';
			 frm.captcha.focus();
			 error='yes';
			 
	     }*/
		// alert(error);
		 if(error=='yes')
		 {
			 alert(disp_error);
			 return false;
		 }
		 else
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
	 
	function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
	 function validateEmail(emailField){
		
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        if (reg.test(document.getElementById(emailField).value) == false) 
        {
            alert('Invalid Email Address');
			document.getElementById('mail').style.border = '1px solid #f00';
			document.getElementById(emailField).focus();
            return false;
        }

        return true;

}
function isSpclChar(id){
var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>? ";

 vals = document.getElementById(id).value;
for (var i = 0; i < vals.length; i++) {
    if (iChars.indexOf(vals.charAt(i)) != -1) {
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

                    if($_POST['save_changes'])

                    {

						$name= $_POST['name'];

						$username=$_POST['username'];

                       	$pass=$_POST['pass'];
						
						$ref_id=$record_id;
						
						$dob1=$_POST['dob'];

						$tan_date=explode('/',$_POST['dob'],3);

						$dob=$tan_date[2].'-'.$tan_date[1].'-'.$tan_date[0];

						

						$batch_id=$_POST['batch_id'];  

                        $address=$_POST['address']; 

					    $contact=$_POST['contact'];

					    $mail=$_POST['mail'];

					    $qualification=$_POST['qualification'];

						$photo=$_POST['photo'];

                       // $invoice_no= $_POST['invoice_no'];

						$inquiry_date= $_POST['inquiry_date'];

						$paid_type=$_POST['paid_type'];

						//$id_card= $_POST['id_card'];

						$source= $_POST['source'];

						$admission_remark= $_POST['admission_remark'];

						$course=trim($_POST['course_id']);

						$customised_course=trim($_POST['customised_course']);
		
						if($course =='custome')
		
						$course=$customised_course;

						$admission_date=$_POST['admission_date'];

						

						$costomize_courses= $_POST['costomize_courses'];

						$course_fees= $_POST['total_fees'];

						$discount_coupon_code = $_POST['discount_coupon'];

						$discount_coupon_price = $_POST['discount_coupon_price'];

						$discount= $_POST['concession'];

						$discount_type= $_POST['discount_type'];

						

						//$final_fees= $_POST['balance'];

						$paid= $_POST['down_payment'];

						$bank_name= $_POST['bank_name'];

						$chaque_no= $_POST['chaque_no'];

						$chaque_date= $_POST['chaque_date'];

						$tan_date = explode('/',$chaque_date);

						$chaque_date=$tan_date[2].'-'.$tan_date[1].'-'.$tan_date[0];
						
						$credit_card_no=$_POST['credit_card_no'];
						
						//$payment_type= $_POST['payment_type'];
						$cust_bank_name=$_POST['cust_bank_name'];
						$payment_mode=$_POST['payment_type'];
						$sep=explode("-",$payment_mode);
						$payment_type=$sep[1];
						"<br />".$payment_type_val=$sep[0];


						$installment_on= $_POST['installment_on'];

						$net_fees= $_POST['net_fees'];

						$total_fees= $_POST['fees'];

						$service_tax= $_POST['service_tax'];

						$down_payment= $_POST['down_payment'];
						$down_payment_tax= $_POST['down_payment_tax'];
						$down_payment_wo_tax = $_POST['down_payment_wo_tax'];

						$first_installment= $_POST['numDep'];

						$branch_name=$_POST['branch_name'];

						$final_amt= $_POST['final_amt'];

						

						$inst_student_id=stripslashes($_POST['inst_student_id']);

						//$dob=$tan_date[2].'-'.$tan_date[0].'-'.$tan_date[1];

                       

						//$added_date=date('Y-m-d H:i:s'); 

					               

								/*$chk_exist = " select enroll_id from enrollment where username='$username' ";

								$ptr_chk_exit = mysql_query($chk_exist);

								 

								if(mysql_num_rows($ptr_chk_exit))

								{

								

									if($record_id && mysql_num_rows($ptr_chk_exit)==1 )

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

								}*/

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

                        }else

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

                                $errors[$i++]="Please Select Payment mode";

                        }

						/*if($first_installment > 0 )

						{

							if($installment_date =="")

							{

									$success=0;

									$errors[$i++]=" Please Select Installment Date";

							}

						}*/

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

                                        //echo $width.$height;

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

                                                    //------------resize the image----------------

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
							$data_record['ref_id']=$ref_id;
							
							$data_record['name']=$name;

                            $data_record['username'] =$username;

                            $data_record['pass'] =$pass;

                            $data_record['dob'] =$dob;

							$data_record['address'] =$address;

                            $data_record['contact'] =$contact;

                            $data_record['mail'] = $mail;

						    $data_record['qualification']=$qualification;

							$data_record['admission_date']=$admission_date;

							$data_record['batch_id'] =$_POST['batch_id'];

							

							if($_REQUEST['record_id'])
							{

								$data_record['student_id']=$_POST['record_id'];

								//$data_record['invoice_no']=$_REQUEST['record_id'];

							}else

							{

								$data_record['student_id']=$largestInvoiceNumber;

								//$data_record['invoice_no']=$largestInvoiceNumber;

							}

							

							$data_record['inquiry_date']=$inquiry_date;

							$data_record['paid_type']=$paid_type;

							//$data_record['id_card']=$id_card;

							$data_record['source']=$source;

							$data_record['admission_remark']=$admission_remark;

                            $data_record['course_id']=$course;

                            //$data_record['costomize_courses']=$costomize_courses;

                            $data_record['course_fees']=$course_fees;

							$data_record['discount_coupon_code']=$discount_coupon_code;

							$data_record['discount_coupon_price']=$discount_coupon_price;

							$data_record['discount']=$discount;

							$data_record['discount_type']=$discount_type;

                            //$data_record['final_fees']=$final_fees;

							$data_record['paid']=$paid;

							$data_record['installment_on']=$installment_on;

                            $data_record['net_fees']=$net_fees;

							$data_record['total_fees']=$total_fees;

						    $data_record['service_tax']=$service_tax;

                            $data_record['down_payment']=$down_payment;
							
							$data_record['down_payment_tax'] = $down_payment_tax;
							
							$data_record['down_payment_wo_tax'] =$down_payment_wo_tax;

							$data_record['no_of_installment']=$first_installment;

							$data_record['admin_id']=$_SESSION['admin_id'];

							

							$data_record['balance_amt']=$final_amt;

							$data_record['status']='Enrolled';

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
							
							$data_record_invoice['credit_card_no']=$credit_card_no;

							$data_record_invoice['chaque_date']=$chaque_date;	

							$data_record_invoice['online_transc_details']='';

							$data_record_invoice['amount']=$down_payment;
							
							$data_record_invoice['balance_amt']=$final_amt;
							
							$data_record_invoice['paid_type']=$payment_type;

							$data_record_invoice['added_date']=date('y-m-d h:i:s');

							$data_record_invoice['cust_bank_name']=$cust_bank_name;

							if($file_uploaded)
							$data_record['photo'] = $uploaded_url;
							
							

                            if($record_id)
                            {

                               /* $data_record['added_date'] = date('Y-m-d H:i:s');

                                $courses_id=$db->query_insert("enrollment", $data_record);  

							    $student_id= mysql_insert_id();*/

								

								/*$where_record="enroll_id='".$record_id."'";                                

                                $db->query_update("enrollment", $data_record,$where_record); 
								
								$student_id_in=$db->query_update("invoice", $data_record_invoice,$where_record); 
								
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

												$installment_date = $sep_date[2].'-'.$sep_date[0].'-'.$sep_date[1];

									"<br />".  $insert_query = "  insert into installment(enroll_id, course_id, installment_amount, installment_date, status, invoice_id) values('$record_id','".$data_record['course_id']."','".$_POST['installments'][$i-1]."','$installment_date','not paid','".$datat_invoice['invoice_id']."' ) ";

									   $insert_ptr = mysql_query($insert_query);

									    $insert_query1 = "  insert into installment_history(enroll_id, course_id, installment_amount, installment_date, status, invoice_id) values('$record_id','".$data_record['course_id']."','".$_POST['installments'][$i-1]."','$installment_date','not paid','".$datat_invoice['invoice_id']."') ";

									   $insert_ptr1 = mysql_query($insert_query1);
									 
									}

								 }   

								}
								
								
								$update_enroll_id=" update enrollment set installment_display_id='".$inst_student_id."' where ".$where_record." ";
	                            $upade=mysql_query($update_enroll_id);
								
								
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';*/
								
								$data_record['photo']=$_POST['photo'];

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

								$data_record['course_status']='processing';

								$data_record['subject_id']= $concat;

								

								$data_record['added_date'] = date('Y-m-d H:i:s');

                                $courses_id=$db->query_insert("enrollment", $data_record);

								

								 $year= date('Y');

								 $month=date('M');

								 $array = array('ISAS', $year,$month,$student_id);

                                 $comma_separated = implode("/",$array);

						        $update_enroll_id=" update enrollment set installment_display_id='".$inst_student_id."' where enroll_id='".$courses_id."' ";
	                            $updt_id=mysql_query($update_enroll_id);  
								
								/*$update_ref_id=" update enrollment set ref_id='".$record_id."' where enroll_id='".$record_id."' ";
	                            $updt_ref_id=mysql_query($update_ref_id); */

								//echo $db;

							   // $student_id= mysql_insert_id();

							   $data_record_invoice['enroll_id']=$courses_id;

							    if($payment_type_val=="online")
								$data_record_invoice['status']='pending';
								else
								$data_record_invoice['status']='paid';

								

							   $student_id_in=$db->query_insert("invoice", $data_record_invoice);  
							   
								$where_record_invs="enroll_id='". $courses_id."'";
								$data_record_invs['invoice_no']=$student_id_in;
								$db->query_update("enrollment", $data_record_invs,$where_record_invs);

							   if($data_record['no_of_installment'] !=0)

							   {

								 for($i=1;$i<=$data_record['no_of_installment'];$i++)

								 {

									 $installment_date='';

									if($_POST['installments'][$i-1] !='')

									{

										$sep_date =  explode('/',$_POST['installment_date'][$i-1]);

												$installment_date = $sep_date[2].'-'.$sep_date[0].'-'.$sep_date[1];

									"<br />".  $insert_query = "  insert into installment(enroll_id, course_id, installment_amount, installment_date, status, invoice_id) values('".$courses_id."','".$data_record['course_id']."','".$_POST['installments'][$i-1]."','$installment_date','not paid','$student_id_in' ) ";

									   

									   $insert_ptr = mysql_query($insert_query);

									   

									    $insert_query1 = "  insert into installment_history(enroll_id, course_id, installment_amount, installment_date, status, invoice_id) values('$courses_id','".$data_record['course_id']."','".$_POST['installments'][$i-1]."','$installment_date','not paid','$student_id_in') ";

									   

									   $insert_ptr1 = mysql_query($insert_query1);

									  /* $sel= "select * from invoice";

									   $ptr_sql=mysql_query($sel);

									   $sql_fetch=mysql_fetch_array($ptr_sql);	

									    $where_record=$sql_fetch['enroll_id']=$student_id;

									    //$data_record_invoice_up['installment_id']=$insert_ptr;

									    $inst_id=$db->query_update("invoice", $data_record_invoice_up,$where_record); 

										*/

									}

									 

								 }   

								}

							            

                              //  echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';

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

												if($service_tax)

                                                $message.= '

                                                <tr>

                                                    <td><strong>Service Tax</strong></td>

                                                    <td>:</td>

                                                    <td>'.$service_tax.'</td>

                                                </tr>';

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

														mail($data_emails['email'], $subject, $sendMessage, $headers);

													}

													//==================== EMAIL to councellor======================================

													/*$select_counc_email_id = " select email from site_setting where cm_id='".$_SESSION['cm_id']."' and type='C' and email !='' ";

													$ptr_counc_emails = mysql_query($select_counc_email_id);

													while($data_counc_emails = mysql_fetch_array($ptr_counc_emails))

													{

														mail($data_counc_emails['email_id'], $subject, $sendMessage, $headers);

													}*/

													//==============================================================================

													

													$subject_thanks =" Congratulatation! your enrollment with isasbeautyschool is successful. ";

													$thanks_msg = " Thannk you $name for choosing ".$GLOBALS['domainName']." <br />Enrollment successfully. <br /><br /> ";

													

													$thanks_msg =$GLOBALS['box_message_top'].$thanks_msg.$GLOBALS['box_message_bottom'];

													mail($mail,$subject_thanks,$thanks_msg,$headers);

													$email_ =$mail;

													//====== CODE for Invoice Email ==\\

													/*date_default_timezone_set('Etc/UTC');



													require 'PHPMailer-master/PHPMailerAutoload.php';

													//Create a new PHPMailer instance

													$mail = new PHPMailer;

													//Tell PHPMailer to use SMTP

													$mail->isSMTP();

													//Enable SMTP debugging

													// 0 = off (for production use)

													// 1 = client messages

													// 2 = client and server messages

													$mail->SMTPDebug = 0;

													//Ask for HTML-friendly debug output

													$mail->Debugoutput = 'html';

													//Set the hostname of the mail server

													$mail->Host = "198.38.82.115";

													//Set the SMTP port number - likely to be 25, 465 or 587

													$mail->Port = 25;

													//Whether to use SMTP authentication

													$mail->SMTPAuth = false;

													//Username to use for SMTP authentication

													$mail->Username = "info@isasbeautyschool.com";

													//Password to use for SMTP authentication

													$mail->Password = "isas@2015";

													//Set who the message is to be sent from

													$mail->setFrom('info@isasbeautyschool.com', 'SeventyPercent Off');

													//Set an alternative reply-to address

													$mail->addReplyTo('info@isasbeautyschool.com', 'SeventyPercent Off');

													//Set who the message is to be sent to

													

													//$mail->addAddress('alkeshrtripathi@gmail.com', 'Alkesh Tripathi');

													$mail->addAddress($email_, $name);

													$mail->Subject = 'Course registration Invoice of www.isasbeautyschool.com';

													//Read an HTML message body from an external file, convert referenced images to embedded,

													//convert HTML into a basic plain-text alternative body

											$mail->msgHTML(file_get_contents('http://www.isasbeautyschool.com/faculty_login/invoice-generate.php?record_id='.$student_id_in), dirname(__FILE__));

													//Replace the plain text body with one created manually

													$mail->AltBody = 'This is a plain-text message body';

													//Attach an image file

													//$mail->addAttachment('images/phpmailer_mini.png');

													

													//send the message, check for errors

													if (!$mail->send()) {

														echo "Mailer Error: " . $mail->ErrorInfo;

													} else {

														echo "Message sent!";

													}*/

													

													///=== END Code for Invoice email sent

													

													}

													

													$select_mobno = " select name,contact_phone,designation from site_setting where (cm_id='".$_SESSION['cm_id']."' or admin_id='".$_SESSION['admin_id']."' or branch_name='".$branch_name1."') and (type='A' or type='C' ) and contact_phone !='' ";

													$ptr_mob = mysql_query($select_mobno);

													while($data_mob = mysql_fetch_array($ptr_mob))

													{

														//================for Faculty==============

													/*	$insert_sms="insert into sms_log_history (`sent_name`,`sent_mobile`,`sent_desc`,`user_type`,`sms_type`,`cm_id`,`added_date`) values('".$data_mob['name']."','".$data_mob['contact_phone']."','".$desc."','".$data_mob['designation']."','enqiry','".$cm_id."','".date('Y-m-d H:i:s')."')";

														$ptr_sms=mysql_query($insert_sms);

														send_sms($data_mob['contact_phone'],$message);
*/
														//=========================================

													}

													//=================For Student=============

													/*$insert_sms="insert into sms_log_history (`sent_name`,`sent_mobile`,`sent_desc`,`user_type`,`sms_type`,`cm_id`,`added_date`) values('".$firstname.' '.$lastname."','".$contact."','".$desc1."','Student','enqiry','".$cm_id."','".date('Y-m-d H:i:s')."')";

													$ptr_sms=mysql_query($insert_sms);

													send_sms($contact,$message);*/

													//==========================================

   		                                           

								//=================================================END MAIL SENT======================================
									echo $payment_type_val;
								if($payment_type_val !="online")
								{
									?>

                                <script>

                                window.open('invoice-generate.php?record_id=<?php echo $student_id_in; ?>', 'win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900,height=600,directories=no,location=no');

								</script>

                                <?php
$sep_url_string='manage_enroll.php';
$sep_url= explode("?",$_SERVER['REQUEST_URI']);
if($sep_url[1] !='')
{
$sep_url_string="manage_enroll_student.php?".$sep_url[1];
}
								?>
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
								setTimeout('document.location.href="<?php echo $sep_url_string; ?>";',1000);
                            </script>

                                <?php

								}

								if($payment_type_val=="online")
								{

									?>

                                    <div style="display:none">

									<form method="post" name="customerData" action="ccavRequestHandler1.php">

									<table width="40%" height="100" border='1' align="center" >

									

									</table>

										<table width="40%" height="100" border='1' align="center">

											<tr>

												<td>Parameter Name:</td><td>Parameter Value:</td>

											</tr>

											<tr>

												<td colspan="2"> Compulsory information*</td>

											</tr>

											<tr>

												<td>TID	:</td><td><input type="hidden" name="tid" id="tid" value=" <? echo rand(0, 9999999999); ?>" readonly/></td>

											</tr>

											<tr>

												<td>Merchant Id	:</td><td><input type="hidden" name="merchant_id" value="73035"/></td>

											</tr>

											<tr>

												<td>Order Id	:</td><td><input type="hidden" name="order_id" value="<? echo $student_id_in; ?>"/></td>

											</tr>

											<tr>

												<td>Amount	:</td><td><input type="hidden" name="amount" value="<? echo $down_payment; ?>"/></td>

											</tr>

											<tr>

												<td>Currency	:</td><td><input type="hidden" name="currency" value="INR"/></td>

											</tr>

											<tr>

												<td>Redirect URL	:</td><td><input type="hidden" name="redirect_url" value="http://www.isasbeautyschool.com/faculty_login/ccavResponseHandler.php"/></td>

											</tr><!--//http://wwww.isasbeautyschool.com/faculty_login/-->

											<tr>

												<td>Cancel URL	:</td><td><input type="hidden" name="cancel_url" value="http://www.isasbeautyschool.com/faculty_login/ccavResponseHandler.php"/></td>

											</tr>

											<tr>

												<td>Language	:</td><td><input type="hidden" name="language" value="EN"/></td>

											</tr>

											<tr>

												<td colspan="2">Billing information(optional):</td>

											</tr>

											<tr>

												<td>Billing Name	:</td><td><input type="hidden" name="billing_name" value="<?php echo $name; ?>"/></td>

											</tr>

											<tr>

												<td>Billing Address	:</td><td><input type="hidden" name="billing_address" value="<?php echo $address; ?>"/></td>

											</tr>

											<tr>

												<td>Billing City	:</td><td><input type="hidden" name="billing_city" value="<?php echo $branch_name1; ?>"/></td>

											</tr>

											<tr>

												<td>Billing State	:</td><td><input type="hidden" name="billing_state" value="MH"/></td>

											</tr>

											<tr>

												<td>Billing Zip	:</td><td><input type="hidden" name="billing_zip" value="412207"/></td>

											</tr>

											<tr>

												<td>Billing Country	:</td><td><input type="hidden" name="billing_country" value="India"/></td>

											</tr>

											<tr>

												<td>Billing Tel	:</td><td><input type="hidden" name="billing_tel" value="<?php echo $contact; ?>"/></td>

											</tr>

											<tr>

												<td>Billing Email	:</td><td><input type="hidden" name="billing_email" value="<?php echo $mail; ?>"/></td>

											</tr>

											<tr>

												<td colspan="2">Shipping information(optional)</td>

											</tr>

											<tr>

												<td>Shipping Name	:</td><td><input type="hidden" name="delivery_name" value="<? echo $name; ?>"/></td>

											</tr>

											<tr>

												<td>Shipping Address	:</td><td><input type="hidden" name="delivery_address" value="<? echo $address; ?>"/></td>

											</tr>

											<tr>

												<td>shipping City	:</td><td><input type="hidden" name="delivery_city" value="<? echo $branch_name1; ?>"/></td>

											</tr>

											<tr>

												<td>shipping State	:</td><td><input type="hidden" name="delivery_state" value="Andhra"/></td>

											</tr>

											<tr>

												<td>shipping Zip	:</td><td><input type="hidden" name="delivery_zip" value="425001"/></td>

											</tr>

											<tr>

												<td>shipping Country	:</td><td><input type="hidden" name="delivery_country" value="India"/></td>

											</tr>

											<tr>

												<td>Shipping Tel	:</td><td><input type="hidden" name="delivery_tel" value="<? echo $contact; ?>"/></td>

											</tr>

											

											<tr>

												<td>Vault Info.	:</td><td><input type="hidden" name="customer_identifier" value=""/></td>

											</tr>

											<tr>

												<td>Integration Type:</td><td><input type="hidden" name="integration_type" value="iframe_normal"/></td>

											</tr>

											<tr>

												<td></td>

                                                <script>

												document.customerData.submit();

												</script>>

												

											</tr>

										</table>

									  </form>

                                      </div>

                                      <?php

								}

                            }

                            else
                            {
							
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

           

            <?php

                                       $year= date('Y ');

									   $month=date('M ');

									   $array = array('ISAS', $year,$month);

                                       $comma_separated = implode("/",$array);

            ?>

            

            				 <? if($_SESSION['type']=='S')

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

									<option value="<?php if ($_POST['branch_name']) echo $_POST['branch_name']; else echo $row_branch['branch_name'];?>" <?php if($row_branch['branch_name']==$data_branch_nmae['branch_name']) echo 'selected="selected"' ?> /><?php echo $row_branch['branch_name']; ?> 

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

                                          <td width="20%">Admission date<span class="orange_font">*</span></td>

                                          <td width="40%"><input type="text" name="admission_date" id="admission_date" class="input_text datepicker" value="<?php if($_POST['admission_date']) echo $_POST['admission_date']; else if($row_record['admission_date']!='')

									{$arrage_date= explode('-',$row_record['admission_date'],3);     

									echo $arrage_date[1].'/'.$arrage_date[2].'/'.$arrage_date[0]; 

									}
										?>"/></td>

                            </tr> 

                            <tr>

                                          <td width="20%" >Enrollment No.<span class="orange_font">*</span></td>

                                          <td width="40%"><input type="text" name="inst_student_id" id="inst_student_id" class="input_text" value="<?php if($_POST['inst_student_id']) echo $_POST['inst_student_id']; elseif($record_id==''){ echo trim($comma_separated.'/'.$largestNumber) ;} else echo $row_record['installment_display_id']; ?>"  />

										   </td>

                            </tr>            

                              

                            <tr>

                                          <td width="20%">Student Name<span class="orange_font">*</span></td>

                                          <td width="40%">

                                          <input type="text" class="validate[required] input_text" name="name"  id="name" value="<?php if($_POST['name']) echo $_POST['name']; else echo $row_record['name'];?>" />

										  </td> 

                            </tr> 

                            

                             <tr>

                						<td width="20%">Contact No<span class="orange_font">*</span></td>

               							 <td width="40%">

                   						 <input type="text" class="validate[required] input_text" name="contact" id="contact" value="<?php if($_POST['contact']) echo $_POST['contact']; else echo $row_record['contact'];?>"onKeyPress="return isNumber(event)" maxlength="12" />

                						</td> 

                						<td width="40%"><b>Note-</b> Should be 10-12 digit allowed. </td>

           					 </tr>   

           					 <tr>

               							 <td width="20%">Email Id<span class="orange_font">*</span></td>

                						 <td width="40%">

                    					 <input type="text" class="validate[required] input_text" name="mail" id="mail" value="<?php if($_POST['mail']) echo $_POST['mail']; else echo $row_record['mail'];?>" onBlur="validateEmail('mail');" />

                						</td> 

                						<td width="40%"></td>

            				</tr>  

            				             

             				<tr>

                                        <td width="20%">Qualification<span class="orange_font"></span></td>

                                        <td width="40%">

                                        <select name="qualification" id="qualification" class="input_text" >

                                        <option  value="">----Select----</option>

                                        <option  value="SSC" <? if (isset($qualification) && $qualification == "SSC") echo "selected"; elseif( 'SSC' == $row_record['qualification']) echo "selected";?> >SSC</option>

                                        <option  value="HSC" <? if (isset($qualification) && $qualification == "HSC") echo "selected";elseif( 'HSC' == $row_record['qualification']) echo "selected";?> >HSC</option>

                                        <option value="Under Graduation" <? if (isset($qualification) && $qualification == "Under Graduation") echo "selected";elseif( 'Under Graduation' == $row_record['qualification']) echo "selected";?> >Under Graduation</option>

                                        <option value="Graduation" <? if (isset($qualification) && $qualification == "Graduation") echo "selected";elseif( 'Graduation' == $row_record['qualification']) echo "selected";?> >Graduation</option>

                                        <option value="Post Graduation" <? if (isset($qualification) && $qualification == "Post Graduation") echo "selected";elseif( 'Post Graduation' == $row_record['qualification']) echo "selected";?> >Post Graduation</option>

                                      </select>

                                        </td> 

                                        <td width="40%"></td>

            				</tr>

            

                             <tr>

                              			<td width="20%"> User Name<span class="orange_font">*</span> </td>

                            			<td width="40%">

                						<input type="text" class="validate[required] input_text" name="username" id="username" value="<?php if($_POST['username']) echo $_POST['username']; else echo $row_record['username'];?>" />

                						</td> 

              							<td width="40%"><div id="feedback"></div>Only Characters and Number allowed</td>

            				</tr>

            				<tr>

                                        <td width="20%">Password<span class="orange_font">*</span></td>

                                        <td width="40%"><input type="password" class="validate[required] input_text" name="pass" id="pass" value="<?php if($_POST['pass']) echo $_POST['pass']; else echo $row_record['pass'];?>" />

 										</td> 

                						<td width="40%"></td>

                            </tr>

                                        <tr>

                                        <td width="20%">Photo</td>

                                        <td width="40%"><?php

                    					if($record_id && $row_record['photo'] && file_exists("../student_photos/".$row_record['photo']))

                        				echo '<img height="77px" width="77px" src="../student_photos/'.$row_record['photo'].'"><br><a href="'.$_SERVER['PHP_SELF'].'?deleteThumbnail=1&record_id='.$record_id.'">Delete / Upload new</a></td><td width="40%"><input type="hidden" name="photo" id="photo" class="input_text" value="'.$row_record['photo'].'"></td>';
                    					else

                        				echo '<input type="file" name="photo" id="photo" class="input_text" ></td>';?></td> 

            							<td width="40%"></td>

            				</tr>

                             <tr>

                                        <td width="20%">Address<span class="orange_font">*</span></td>

                                        <td width="40%">
                    					<input type="text" class="validate[required] input_text" name="address" id="address" value="<?php if($_POST['address']) echo $_POST['address']; else echo $row_record['address'];?>" />   

                						</td> 

                

                              </tr> 

                              <!--<tr>

                                     <td width="20%">Identity card No.<span class="orange_font">*</span></td>

                                     <td width="40%"><input type="text" class="input_text" name="id_card" id="id_card" value="<?php// if($_POST['save_changes']) echo $_POST['id_card']; else echo $row_record['enroll_id'];?>" /></td>  <?php// echo $row_record1['id_card']; ?>

                              </tr>-->

                              <tr>

                                    <td width="20%">Date Of Birth<span class="orange_font">*</span></td>

                                    <td width="40%">

                                    <input type="text" class="validate[required] input_text datepicker" name="dob" id="dob" 

                                    value="<?php if($_POST['dob']) echo $_POST['dob']; else if($row_record['dob']!='')

									{$arrage_date= explode('-',$row_record['dob'],3);     

									echo $arrage_date[1].'/'.$arrage_date[2].'/'.$arrage_date[0]; 

									}

										// $row_record['staff_dob'];

										?>" />

                </td> 

                <td width="40%"></td>

            </tr>   

            <tr>

                   <td width="20%">Source<span class="orange_font"></span></td>

                   <td>

                   <select id="source" name="source">

                        <option value="">----Select----</option>

                        <?php 

						$sel_source="SELECT * FROM source";

						$ptr_src=mysql_query($sel_source);

						while($data_src=mysql_fetch_array($ptr_src))

						{

						?>

							<option value = "<?php echo $data_src['source_id']?>" <? if ( $data_src['source_id'] == $row_record['source']) echo "selected";?> > <?php echo $data_src['source_name'] ?> </option>

						

						<?

						}

							

						?>

                          </select>

                   </td>

            </tr>             

            <tr>

                   <td width="20%">Admission remark<span class="orange_font"></span></td>

                                            

                   <td><input type="text" class="validate[required] input_text" name="admission_remark" id="admission_remark"  value="<?php if($_POST['admission_remark']) echo $_POST['admission_remark']; else echo $row_record['admission_remark'];?>" /></td>

            </tr>                                         

            <tr>

            <td width="20%">Select Course<span class="orange_font">*</span></td>

            <td width="40%" class="customized_select_box">

                    <select name="course_id" id="course_id" class="validate[required] input_select" onChange="show_course(this.value);" >  

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

									$selected= ' selected="selected" ';

								?>

                            <option value = "<?php echo $row1['course_id']?>" <?php echo $selected;  ?> > <?php echo $row1['course_name'] ?> </option>

                            <?php }

													echo " </optgroup>";

														   }

													?>

                               

                            <option value="custome" >New Course</option>     

                    </select>

             </td> 

            </tr>

            			<tr>

                        <td colspan="3" width="100%"><div id="custome_div" style="display:none">

                            <table width="100%">

                            <tr>

                                <td width="26%">Customised Course<span class="orange_font">*</span></td>

                                <td width="40%"><input type="text" class="inputText" name="costomize_courses" id="costomize_courses" 			                                                     value="<?php if($_POST['costomize_courses']) echo $_POST['costomize_courses']; else echo $row_record['customised_course'];?>"/>		                                </td>

                                <td width="20%">&nbsp;</td>

                              </tr>

                          </table>

                          </div></td>

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

                <td width="22%">Paid Type </td>

                <td width="38%">

                <input type="radio" checked="checked" name='paid_type' id="paid_type" value="one_time" <?php if($_POST['paid_type'] =="one_time")  echo 'checked="checked"'; else if($row_record['paid_type'] == "one_time") echo 'checked="checked"'; ?> onChange="show_record()" />One Time <input type="radio" name='paid_type' id="paid_type" value="installments" <?php if($_POST['paid_type'] =="installments")  echo 'checked="checked"'; else if($row_record['paid_type'] == "installments") echo 'checked="checked"'; ?> onChange="show_record()" />Installment <span id="inst_tax_id"><?php if($_SESSION['type']!='S'){ echo $_SESSION['installment_tax'];} ?></span>% add
  <input type="hidden" id="inst_taxes" value="<?php if($_SESSION['type']!='S'){ echo $_SESSION['installment_tax'];} ?>"  />
<input type="radio" name='paid_type' id="paid_type" value="installments_zero"  <?php if($_POST['paid_type'] =="installments_zero")  echo 'checked="checked"'; else if($row_record['paid_type'] == "installments_zero") echo 'checked="checked"';  ?> onChange="show_record()" />Installment 0% add

                </td>             

                <td width="40%"></td>

            </tr>                             

       <!--==========================================================================================================================-->                                           

                                            <tr>

                <td width="22%">Course Fees</td>

                <td width="38%"><div id=total_fees>

                <input type="text" class="input_text" name="total_fees" id="total_fees"  onblur="show_record(this.value,1)" value="<?php if($_POST['total_fees']) echo $_POST['total_fees']; else echo $row_record['course_fees'];?>" />

                </div>

                </td>                

                <td width="40%"></td>

            </tr>

          <tr>

                <td width="22%">Discount in <input type="radio" name='discount_type'  id='discount_type' value="<?php if($_POST['discount_type']) echo $_POST['discount_type']; else echo percent; ?>" checked="checked" onChange="show_record()" />% or <input type="radio" name='discount_type' id='discount_type' value="<?php if($_POST['discount_type']) echo $_POST['discount_type']; else echo cash; ?>" onChange="show_record()" />Cash</td>

                <td width="38%">

                <input type="text" class="input_text" name="concession" id="concession" value="<?php if($_POST['concession']) echo $_POST['concession']; else if($row_record['discount'] !=0) echo $row_record['discount']; else echo 0; ?>" 

                onblur="show_record()"/>

                

                </td>                

                <td width="40%"></td>

            </tr>

            

            <tr>

                <td width="22%">Discount Coupon Code</td>

                <td width="38%">

                <input type="text" class="input_text" name="discount_coupon" id="discount_coupon" value="<?php if($_POST['discount_coupon']) echo $_POST['discount_coupon']; else echo $row_record['discount_coupon_code'];?>" onBlur="show_discount()" />

                </td>                

                <td width="40%"><div id="coupon"></div><input type="hidden" name="discount_coupon_price" id="discount_coupon_price" value="<?php if($_POST['discount_coupon_price']) echo $_POST['discount_coupon_price']; else echo $row_record['discount_coupon_price'];?>" /></td>

            </tr>

            <!--<tr>

                <td width="22%">Paid Fees</td>

                <td width="38%">

                <input type="text" class="validate[required] input_text" name="paid" id="paid" value="<?php// if($_POST['save_changes']) echo $_POST['paid']; else echo $row_record['paid'];?>"

                onblur="show_record()" />

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
                                                  <td width="20%" class="heading">Net Fees<span class="orange_font">*</span></td>
                                                  <td><input type="text" class="validate[required] input_text" name="net_fees" id="net_fees" value="<?php if($_POST['net_fees']) echo $_POST['net_fees']; else echo $row_record['net_fees'];?>" /></td>
                                            </tr>
                                            <tr>      

                                                  <td width="20%" class="heading">Service Tax <span id="service_tax_id"><?php if($_SESSION['type']!='S'){ echo $_SESSION['service_tax'];} ?></span> %<span class="orange_font">*</span></td><input type="hidden" id="service_taxes" value="<?php if($_SESSION['type']!='S'){ echo $_SESSION['service_tax'];} ?>"  />

                                                  <td><input type="text" class="validate[required] input_text" name="service_tax" id="service_tax"  value="<?php if($_POST['service_tax']) echo $_POST['service_tax']; else echo $row_record['service_tax'];?>" /></td>

                                            </tr>

                                            <tr>      

                                                  <td width="20%" class="heading">Total Fees <span class="orange_font">*</span></td>

                                                  <td><input type="text" class="validate[required] input_text" name="fees" id="fees"  value="<?php if($_POST['fees']) echo $_POST['fees']; else echo $row_record['total_fees'];?>" /></td> 
                                             </tr>

                                            <tr>

                                                  <td width="20%" class="heading">Down Payment(Including tax)<span class="orange_font">*</span></td>

                                                  <td><input type="text" class="validate[required] input_text" name="down_payment" id="down_payment" onKeyUp="show_record()" value="<?php if($_POST['down_payment']) echo $_POST['down_payment']; else if($row_record['down_payment']!=0) echo $row_record['down_payment']; else echo 0;?>" /></td>

                                            </tr> 
                                            <tr>

                                                  <td width="20%" class="heading">Service Tax in Down Payment<span class="orange_font">*</span></td>

                                                  <td><input type="text" class="validate[required] input_text" name="down_payment_tax" id="down_payment_tax" onKeyUp="show_record()" value="<?php if($_POST['down_payment_tax']) echo $_POST['down_payment_tax']; else if($row_record['down_payment_tax']!=0) echo $row_record['down_payment_tax']; else echo 0;?>" /></td>

                                            </tr>
                                            <tr>

                                                  <td width="20%" class="heading">Down Payment(Without tax)<span class="orange_font">*</span></td>

                                                  <td><input type="text" class="validate[required] input_text" name="down_payment_wo_tax" id="down_payment_wo_tax" onKeyUp="show_record()" value="<?php if($_POST['down_payment_wo_tax']) echo $_POST['down_payment_wo_tax']; else if($row_record['down_payment_wo_tax']!=0) echo $row_record['down_payment_wo_tax']; else echo 0;?>" /></td>

                                            </tr>

                                            <tr>

												<td class="heading">Installment on</td>

                                            	<td colspan="2"> <input type="text" name="installment_on" readOnly  id="installment_on" value="<?php if($_POST['installment_on']) echo $_POST['installment_on']; else if($row_record['installment_on']!=0) echo $row_record['installment_on']; else echo 0;?>"/>

                                                

                                                </td> 

                                            </tr>

                                                    

                                            <tr>

                                             <tr><td class="heading"> Number of Installment</td>

                                            <td colspan="2">

                                            	  <select name="numDep"  id="dropdown" >

                                                     <?php for ($i = 0; $i <= 24; $i++) :

													 	$selc = '';

                                                		if($row_record['no_of_installment']==$i || $_POST['numDep']== $i)

														$selc =' selected="selected" ';

															echo '<option value="'.$i.'" '.$selc.'>'.$i.'</option>';

														

													  	endfor;

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

														$dates=$sep_da[1].'/'.$sep_da[2].'/'.$sep_da[0];

													?>

                                                    

                                                    <tr><td width="23%" class="heading">Installment <?php echo $i; ?> </span></td><td width="40%" colspan=2""><input type="text" class="input_text" name="installments[]" value='<?php if($_POST['installments']) echo $_POST['installments']; else echo $dat_installment['installment_amount'];  ?>' /></td><td><input type="text" name="installment_date[]" class="datepicker" placeholder="installment date" value="<?php if($_POST['installment_date']) echo $_POST['installment_date']; else echo $dates ;?>"  ></td></tr>

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

													$chaque_date = $row_invoice['chaque_date'];

													$sep_chk_dt = explode('-',$chaque_date);

													$chaque_date=$sep_chk_dt[1].'/'.$sep_chk_dt[2].'/'.$sep_chk_dt[0];

												}

											}

											//echo $row_invoice['paid_type'];

											?>

                                             <!--<tr>

                                                  <td width="20%" class="heading">Payment Mode<span class="orange_font">*</span></td>

                                                 <td ><div id="pay_type"> <input type="radio" class="validate[required] input_radio" name="payment_type" id="payment_type" value="cash" onClick="hide();" <?php if($row_invoice['paid_type']=='cash'|| $_POST['payment_type']=='cash') echo 'checked="checked"'; ?> /> Cash

                                                 

                                                   <input type="radio" class="validate[required] input_radio" name="payment_type"  id="payment_type" value="cheque" onClick="show();" <?php if($row_invoice['paid_type']=='cheque'|| $_POST['payment_type']=='cheque') echo 'checked="checked"'; ?> />By Cheque

                                                   

                                                  <input type="radio" class="validate[required] input_radio" name="payment_type" id="payment_type" value="online" onClick="hide();"   <?php if($row_invoice['paid_type']=='online'|| $_POST['payment_type']=='online') echo 'checked="checked"'; ?> />Online

                                                 </div> </td>

                                            </tr>

                                            <tr>

												<td></td>

                                            	<td colspan="2">

                                                <div id="payment" <?php  if($row_invoice['paid_type']=='cheque' || $_POST['payment_type'] =='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>> 

                                                 <table>

                                                	<tr>

                                                    	<td>Bank Name</td>

                                                        <td><input type="text" name="bank_name" id="bank_name"  class="validate[required] input_text" 

                                                        value="<?php if($_POST['bank_name']) echo $_POST['bank_name']; else echo $row_invoice['bank_name'];?>"/></td>

                                                        <td>Cheque No.</td>

                                                        <td><input type="text" name="chaque_no" id="chaque_no"  class="validate[required] input_text"  value="<?php if($_POST['chaque_no']) echo $_POST['chaque_no']; else echo $row_invoice['chaque_no'];?>" onKeyPress="return isNumber(event)" maxlength="6"/></td>

                                                        <td>Cheque Date</td>

                                                        <td><input type="text" name="chaque_date" id="chaque_date"  class="datepicker" placeholder="cheque date " value="<?php if($_POST['save_changes']) echo $_POST['chaque_date']; else echo $chaque_date ;?>"/></td>

                                                    </tr>

                                                </table>

                                                </div>

                                               </td> 

                                            </tr>-->

                                             <tr>
                                                <td width="20%" class="heading">Select Payment Mode</td>
                                                <td><select name="payment_type" id="payment_type" onchange="show_payment(this.value)">
                                                <option value="select">--Select--</option>
                                                <?php
                                                $sel_payment_mode="select payment_mode,payment_mode_id from payment_mode";
                                                $ptr_payment_mode=mysql_query($sel_payment_mode);
                                                while($data_payment=mysql_fetch_array($ptr_payment_mode))
                                                {
                                                    $selected='';
                                                    if($data_payment['payment_mode_id'] == $row_expense['payment_mode_id'])
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
                                             <div id="bank_details" style="display:none">
                                             <table width="100%">
                                             <tr>
                                             <td width="20%" class="tr-header" align="">Customer Bank Name</td>
                                             <td width="20%">
                                              <input type="text" name="cust_bank_name" id="cust_bank_name" value="<?php if($_POST['cust_bank_name']) echo $_POST['cust_bank_name']; else echo $row_record['cust_bank_name']; ?>"/>
                                            
                                             </td>
                                              <td width="25%" class="tr-header" align=""> ISAS Bank Name : &nbsp; 
                                               <?php 
											  /*if($_SESSION['type'] !="S")
											  {
											  ?>
                                              <select name="bank_name" id="bank_name" onchange="show_acc_no(this.value)">
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
                                             <?php } */?>
                                             <div id="bank_id"></div>
                                             </td>
                                             <td width="25%" class="tr-header" align=""> ISAS Account No : &nbsp; 
                                              <input type="text" name="account_no" readonly="readonly" id="account_no" value="<?php if($_POST['account_no']) echo $_POST['account_no']; else echo $row_record['account_no']; ?>"/>
                                             </td>
                                             </tr>
                                             
                                             </table>
                                             </div>
                                             </td>
                                             </tr>
                                             <tr>
                                             <td colspan="2">
                                              <div id="chaque_details" style="display:none" <?php  //if($row_invoice=='cheque' || $_POST['payment_type'] =='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
                                                 
                                                 <table width="100%">
                                                
                                                 <tr>
                                                <td width="36%">Customer Cheque No.</td>
                                                        <td><input type="text" name="chaque_no" id="chaque_no"  class="validate[required] input_text"  value="<?php if($_POST['chaque_no']) echo $_POST['chaque_no']; else echo $row_invoice['chaque_no'];?>" onKeyPress="return isNumber(event)" maxlength="6"/></td>
                                                 </tr>
                                                 <tr>
                                                 <td>Customer Cheque Date</td>
                                                 <td><input type="text" name="chaque_date" id="chaque_date"  class="datepicker" placeholder="cheque date " value="<?php if($_POST['save_changes']) echo $_POST['chaque_date']; else echo $chaque_date ;?>"/></td>
                                                 </tr>
                                                 </table>
                                                 
                                            </div>
                                            <div id="credit_details" style="display:none">
                                             <table width="100%">
                                             
                                             <tr>
                                             <td width="36%" class="tr-header" align="">Enter Credit Card No</td>
                                             <td><input type="text" name="credit_card_no" maxlength="4" id="credit_card_no" value="<?php if($_POST['credit_card_no']) echo $_POST['credit_card_no']; else echo $row_invoice['credit_card_no']; ?>" /></td>
                                             </tr>
                                             </table>
                                             </div>
                                            </td>
                                                 </tr>   

                                            <tr>

                                                  <td width="20%" class="heading">Total Balance Amount<span class="orange_font">*</span></td>

                                                  <td><input type="text" class="validate[required] input_text" name="final_amt" id="final_amt" value="<?php  if($_POST['final_amt']) echo $_POST['final_amt']; else echo $row_record['balance_amt'];?>" /></td>

                                            </tr>

                                             <tr>

                                                  <td width="20%" class="heading">Final Amount<span class="orange_font">*</span></td>

                                                  <td><input type="text" class="validate[required] input_text" name="total_amt" id="total_amt" value="<?php  if($_POST['total_amt']) echo $_POST['total_amt']; else echo $row_record['total_fees'];?>" /></td>

                                            </tr>

                                      

                                            

                                            

        </table>

        <center>

        <input type="hidden" name="course_only_fee" id="course_only_fee" value="" />

        <table>

        <tr>

      

            <td align="right">

            <?php

			if($record_id !='')

			{ 

			?>

            	<input type="submit" value="Update Record" name="save_changes" onclick="return send1();" /> 

            <?

			}

			else

			{

			?>

				<input type="submit" value="Save Record" name="save_changes" onclick="return send1();" /> 

			<?php }?>			

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
					
					var service_taxes = $("#service_taxes").val();

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
							
							var tax=(service_taxes * course_fee)/100;
							var course_with_tax=Number(course_fee)+Number(tax);
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



                                                                /*$data_c=mysql_fetch_array($ptr_category);



                                                                $corse_name=$data_c['category_id'];*/



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



                        <td><input type="button" class="inputButton custom_cuorse_submit" value="Submit" name="submit" />&nbsp;



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

<div class="clearit"></div>

<!--footer start-->

<div id="footer"><? require("include/footer.php");?></div>

<!--footer end-->
<?php
/*if($_SESSION['type']=="S")
{
	?>
    <script>
	branch_name =document.getElementById("branch_name").value;
	//alert(branch_name);
	show_bank(branch_name);
	</script>
    <?php
}*/
if($record_id || $_SESSION['type']=="S")
{
	?>
	vals= document.getElementById("payment_type").value;
	show_payment(vals);
	<?php
}
?>
<?php
if($record_id !='')
{
	?>
<script>
	course_id1 =document.getElementById("course_id").value;
	//alert(document.getElementById("service_taxes").value);
	
	if(course_id1 !='')
	{
		show_course(course_id1);
		
	}
    </script>
    <?php
	//exit();
}
?>
<script>
branch_name =document.getElementById("branch_name").value;
var res = branch_name.substring(0, 3);
var branch=res.toUpperCase();
var display_id=document.getElementById("inst_student_id").value;
stud_id=display_id.replace("ISAS","ISAS/"+branch);
document.getElementById("inst_student_id").value=stud_id;
</script>
<?php
?>
</body>

</html>

<?php $db->close();?>