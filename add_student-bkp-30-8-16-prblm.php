<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM stud_regi where student_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
	
}
if($record_id && $_REQUEST['deleteThumbnail'])
{
    $update_news="update stud_regi set photo='' where student_id='".$record_id."'";
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
<?php if($record_id) echo "Edit"; else echo "Add";?> student</title>
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
	total_prices='total_prices';
	fee_id = 'fees_'+id;
	id= '#'+id;
	//$(id).attr('checked',true);
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
	$('#total_checked_questions').val(previous);
	total_counter=($('#total_checked_questions').val());
	$('#total_checked_question').val(previous);
	$('#sub_fee').val(sub_fee);

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
				sep_disc=retrive_func
				show_record();
				 //alert(sep_disc);
			}
		});
}

function show_record()
{    
  frm = document.jqueryForm; 
      concession=0; 
	  //paid=0;
	  totals_fees=0;
	  balance=0;
	  //================================PAID TYPE==========================
		paid_type =frm.paid_type.value;
		//alert(paid_type);
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
			document.getElementById('toal_fees').value=totals_fees;
			document.getElementById("dropdown").disabled  = true;
			down_fees=document.getElementById('down_payment').value;
		 }
		 else
		 {
			document.getElementById("dropdown").disabled  = true;
			var inst1 = document.getElementById("dropdown").disabled  = true;
			$('#dropdown').removeClass("obrderclass");  
			totals_fees = parseInt(document.getElementById('course_only_fee').value);
			document.getElementById('toal_fees').value=totals_fees;
		 }
	//===================================================================
	 // paid = document.getElementById('paid').value;
	concession = parseInt(document.getElementById('concession').value);
	$('#dropdown').prop('selectedIndex',0);
	$("#textboxDiv").html('');
	disc_type =frm.discount_type.value;
	//alert(disc_type);
	if(disc_type!='cash')
	{
		if(concession !='' || concession !=0 || concession<=100 )
		concession=  parseInt(totals_fees*concession/100);
	}
	if(concession !='' || concession <= totals_fees)
	{
		total_bal_ava= parseInt(totals_fees)- parseInt(concession);
	}
	else
	{
		concession=0;
		total_bal_ava= parseInt(totals_fees)- parseInt(concession);
	}
	 document.getElementById('net_fees').value=total_bal_ava;
	//alert(total_bal_ava);
	//document.getElementById('balance').value=total_bal_ava;
	 var local = sep_disc
  	 //alert(local);
	 //disc_amount=disc_amt;
	if(local !='' || local !=0)
	{
		var disc_perc= parseInt(local*total_bal_ava/100);
		var total_disc_coupon= parseInt(total_bal_ava - disc_perc);
		document.getElementById('net_fees').value=total_disc_coupon;
		document.getElementById('discount_coupon_price').value=local;
	}
	var net_fees=parseInt(document.getElementById('net_fees').value);
	var service_tax=parseInt(document.getElementById('service_taxes').value);
	var tax =parseInt(net_fees*service_tax/100);
	//alert (service_tax)
	document.getElementById('service_tax').value=tax;
	var total = parseInt(net_fees + tax);
	document.getElementById('fees').value=total;
	if(paid_type=='installments' || paid_type=='installments_zero')
	{
	}
	else
	{
		document.getElementById('down_payment').value=total;
	}
	document.getElementById('total_amt').value=total;
	var fee1 = parseInt(document.getElementById('fees').value);
	var down_payment =parseInt( document.getElementById('down_payment').value);
	var total_f= fee1- down_payment;
	//alert (total_f);
	document.getElementById('installment_on').value=total_f;
	document.getElementById('final_amt').value=total_f;
	if(total_f==0 || paid_type =='one_time')
	{
		var inst1 = document.getElementById("dropdown").disabled  = true;
		$('#dropdown').removeClass("obrderclass");  
	}
	else if(total_f !=0 && paid_type =='installment_zero')
	{
		var inst1 = document.getElementById("dropdown").disabled  = true;
		$('#dropdown').removeClass("obrderclass");  
	}
		else{document.getElementById("dropdown").disabled  = false;}
}
</script>
<script>
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
/*function show_fees(course_id)
{
	var data1="show_fees=1&course_id="+course_id;
	$.ajax({
	url: "show_fees1.php", type: "post", data: data1, cache: false,
	success: function (retnc)
	{
		document.getElementById('total_fees').innerHTML=retrive_func;
		show_record();
	}
	});
}
*/
function show_bank(branch_id)
{
	var bank_data="show_bnk=1&branch_id="+branch_id;
	$.ajax({
		url: "show_bank.php",type:"post", data: bank_data,cache: false,
		success: function(retbank)
		{
			document.getElementById("bank_id").innerHTML=retbank;
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
		}
		});
}
$(document).ready(function() 
{

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
	if(payment_mode[0]=="cheque")
	{
		 document.getElementById("chaque_details").style.display = 'block';
		 document.getElementById("bank_details").style.display = 'block';
		 document.getElementById("credit_details").style.display = 'none';
	}
	else if(payment_mode[0]=="Credit Card")
	{
		 document.getElementById("chaque_details").style.display = 'none';
		 document.getElementById("bank_details").style.display = 'block';
		 document.getElementById("credit_details").style.display = 'block';
	}
	else
	{
		 document.getElementById("chaque_details").style.display = 'none';
		 document.getElementById("bank_details").style.display = 'none';
		 document.getElementById("credit_details").style.display = 'none';
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
        document.getElementById('final_amt').value=inst;
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
                if(current_value<installment_on-prev_total)
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
                //alert(current_number);
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
    $(document).ready(function(){ 
        $('#feedback').load('check.php').show();
        $('#username').keyup(function(){
            $.post('check.php', { username: jqueryForm.username.value },
            function(result){
                $('#feedback').html(result).show();
            });
        });
    });
	 $(document).ready(function(){ 
        $('#coupon').load('coupon_check.php').show();
        $('#discount_coupon').keyup(function(){
            $.post('coupon_check.php', { discount_coupon: jqueryForm.discount_coupon.value },
            function(result){
                $('#coupon').html(result).show();
            });
        });

		$('#discount_coupon').blur(function(){
            $.post('coupon_check.php', { discount_coupon: jqueryForm.discount_coupon.value },
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
	{
		var text = frm.contact.value;
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

			 disp_error +='Add Down Payment  \n';

			 $("#down_payment").addClass("obrderclass");

			 frm.down_payment.focus();

			 error='yes';

	     }

		 else

		 {

			 $("#down_payment").removeClass("obrderclass");

		 }

		 

		/* totals_fees = parseInt(document.getElementById('toal_fees').value);*/

	  	 total11=parseInt(document.getElementById('fees').value);

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

					  if(targets.getTime()<=today_date)

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

					if(dates_array[j]>=dates_array[k])

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

			{

			$('#dropdown').removeClass("obrderclass"); 

			}

			

			

			

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

			/*$('#pay_type').removeClass("obrderclass"); 

			var selected = $("input[name=payment_type]:checked");

			if (selected.length > 0) 

			{

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

					else

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

				

			//}

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

        } else if (target.getDate() >= now.getDate()) {

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

	 /*function validateEmail(emailField){

		

        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

		if(document.getElementById('mail').value !='')

		{

			if (reg.test(document.getElementById('mail').value) == false) 

			{

				alert('Invalid Email Address');

				document.getElementById('mail').style.border = '1px solid #f00';

				document.getElementById('mail').focus();

				return false;

			}

		}

        return true;



}*/

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

                    if(isset($_POST['save_changes']))

                    {

						$name= $_POST['name'];

						$username=$_POST['username'];

                        $pass=$_POST['pass'];

						$tan_date=explode('/',$_POST['dob'],3);

						$dob=$tan_date[2].'-'.$tan_date[0].'-'.$tan_date[1];

						$dob1=$_POST['dob'];

						$batch_id=$_POST['batch_id'];

                        $address=$_POST['address']; 

					    $contact=$_POST['contact'];

					    $mail=$_POST['mail'];

					    $qualification=$_POST['qualification'];

						$photo=$_POST['photo'];

                        $invoice_no= $_POST['invoice_no'];

						$inquiry_date= $_POST['inquiry_date'];

						$paid_type=$_POST['paid_type'];

						$source= $_POST['source'];

						$admission_remark= $_POST['admission_remark'];

						//$course= $_POST['course_id'];

						

						$course=trim($_POST['course_id']);

						$customised_course=trim($_POST['customised_course']);

						if($course =='custome')

						$course=$customised_course;

						

						

						$admission_date=$_POST['admission_date'];

						

						$course_fees= $_POST['total_fees'];

						$discount_coupon_code = $_POST['discount_coupon'];

						$discount_coupon_price = $_POST['discount_coupon_price'];

						$discount= $_POST['concession'];

						$discount_type= $_POST['discount_type'];

						$paid= $_POST['down_payment'];

						$bank_name= $_POST['bank_name'];

						$chaque_no= $_POST['chaque_no'];

						$chaque_date= $_POST['chaque_date'];

						$credit_card_no=$_POST['credit_card_no'];

						//$payment_type11= $_POST['payment_type'];

						$cust_bank_name=$_POST['cust_bank_name'];

						$payment_mode=$_POST['payment_type'];

						$sep=explode("-",$payment_mode);

						$payment_type=$sep[1];

						$payment_type_val=$sep[0];

						

						$installment_on= $_POST['installment_on'];

						$net_fees= $_POST['net_fees'];

						$total_fees= $_POST['fees'];

						$service_tax= $_POST['service_tax'];

						$down_payment= $_POST['down_payment'];

						$first_installment= $_POST['numDep'];

						$branch_name=$_POST['branch_name'];

						$final_amt= $_POST['final_amt'];

						$cm_id=$_POST['cm_id'];

						//exit();

						//$dob=$tan_date[2].'-'.$tan_date[0].'-'.$tan_date[1];

                       

						//$added_date=date('Y-m-d H:i:s');                    

                        

						

						$chk_exist = " select enroll_id from enrollment where username='".$username."' ";

						$ptr_chk_exit = mysql_query($chk_exist);

						if(mysql_num_rows($ptr_chk_exit) !=0)

						{

							 $success=0;

                             $errors[$i++]="Username Already Exist. Choose Other username ";

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

							$dob=$tan_date[2].'-'.$tan_date[0].'-'.$tan_date[1];

						}

						if($admission_date =="")

                        {

                           $success=0;

                           $errors[$i++]="Enter Admission Date";

                        }

						

						if($contact == "")

                        {

                                $success=0;

                                $errors[$i++]="Enter Student Contact Number";

                        }

						else

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

						

					

                       $uploaded_url="";

                            if(count($errors)==0 && $_FILES['photo']["name"])

                            {

                                if($record_id)

                                {

                                    $update_news="update stud_regi set photo='' where student_id='".$record_id."'";

                                    $db->query($update_news);

                                    if($row_record['photo'] && file_exists("../student_photos/".$row_record['photo']))

                                        unlink("../student_photos/".$row_record['photo']);

                                    if($row_record['photo'] && file_exists("../student_photos/".$row_record['photo']))

                                        unlink("../student_photos/".$row_record['photo']);

                                }

                                $uploaded_url=time().basename($_FILES['photo']["name"]);

                                $newfile = "../teacher_photo/";



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

                                        $thump_target_path="../teacher_photo/".$uploaded_url;

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

                        <tr><td> 

                                <table align="left" style="text-align:left;" class="alert">

                                <tr><td ><strong>Please correct the following errors</strong><ul>

                                        <?php

                                        for($k=0;$k<count($errors);$k++)

                                                echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>

                                        </ul>

                                </td></tr>

                                </table>

                         </td></tr>    

                    <?php

                        }

                        else

                        {

                            $success=1;

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

							$data_record['student_id']=$_REQUEST['record_id'];

							$data_record['invoice_no']=$_REQUEST['record_id'];

							$data_record['inquiry_date']=$inquiry_date;

							$data_record['paid_type']=$paid_type;

							$data_record['source']=$source;

							$data_record['admission_remark']=$admission_remark;

                            $data_record['course_id']=$course;

                           // $data_record['costomize_courses']=$costomize_courses;

                            $data_record['course_fees']=$course_fees;

							$data_record['discount_coupon_code']=$discount_coupon_code;

							$data_record['discount_coupon_price']=$discount_coupon_price;

							$data_record['discount']=$discount;

                            $data_record['discount_type']=$discount_type;

							$data_record['paid']=$paid;

							$data_record['installment_on']=$installment_on;

                            $data_record['net_fees']=$net_fees;

							$data_record['total_fees']=$total_fees;

						    $data_record['service_tax']=$service_tax;

                            $data_record['down_payment']=$down_payment;

							$data_record['no_of_installment']=$first_installment;

							//$data_record['installments']=$second_installment;

							$data_record['balance_amt']=$final_amt;

							$data_record['status']='Enrolled';

							$data_record_en['status']='Enrolled';

							$data_record['admin_id']=$_SESSION['admin_id'];

							//$data_record['branch_name']=$branch_name;

							//===============================CM ID for Super Admin===============

							

							if($_SESSION['type']=='S')

							{

								$data_record['cm_id']=$cm_id;

								$branch_name1=$branch_name;

								$data_record_invoice['cm_id']=$cm_id;

							}	

							else

							{

								$data_record['cm_id']=$_SESSION['cm_id'];

								$branch_name1=$_SESSION['branch_name'];

								$data_record_invoice['cm_id']=$_SESSION['cm_id'];

							}

							//====================================================================

							//$data_record['cm_id']=$_SESSION['cm_id'];

							

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

                                $data_record['added_date'] = date('Y-m-d H:i:s');

								$select_exit_rec = " select enroll_id from enrollment where name='".$data_record['name']."' and username='$username' and course_id='$course'  ";

								$ptr_exist = mysql_query($select_exit_rec);

								if(!mysql_num_rows($ptr_exist))

								{

									

								$chk_exist_student_logn = " select stud_login_id from stud_login where   username='$username' and pass='$pass' ";

								$ptr_chk_exists = mysql_query($chk_exist_student_logn);

								if(mysql_num_rows($ptr_chk_exists))

								{

									$data_login = mysql_fetch_array($ptr_chk_exists);

									$stud_login_id = $data_login['stud_login_id'];

								}

								else

								{

										$data_record_login['username'] =$username;

										$data_record_login['pass'] =$pass;

										//$data_record_login['enroll_id'] =$student_id;

										$stud_login_id=$db->query_insert("stud_login", $data_record_login); 

									

								}	

								$data_record['stud_login_id']=$stud_login_id;

                                $courses_id=$db->query_insert("enrollment", $data_record);  

							    $student_id= mysql_insert_id();

								

								 $year= date('Y');

										

								 $month=date('M');

										

								 $array = array('ISAS', $year,$month,$student_id);

                                 $comma_separated = implode("/", $array);

									   

						        $update_enroll_id=" update enrollment set installment_display_id='".$comma_separated."' where enroll_id='".$student_id."' ";

	                            $updt_id=mysql_query($update_enroll_id);	

								

								$data_record_invoice['enroll_id']=$student_id;

								if($payment_type_val=="online")

								$data_record_invoice['status']='pending';

								else

								$data_record_invoice['status']='paid';

								

								$student_id_in=$db->query_insert("invoice", $data_record_invoice); 

								

								$where_record="student_id='".$record_id."'";                                

                                $db->query_update("stud_regi", $data_record_en,$where_record); 

								

								if($data_record['no_of_installment'] !=0)

							   	{

									

								 for($i=1;$i<=$data_record['no_of_installment'];$i++)

								 {

									 $installment_date='';

									if($_POST['installments'][$i-1] !='')

									{

										$sep_date =  explode('/',$_POST['installment_date'][$i-1]);

												$installment_date = $sep_date[2].'-'.$sep_date[0].'-'.$sep_date[1];

												

												

									 $insert_query = "  insert into installment(enroll_id, course_id, installment_amount, installment_date, status,installment_display_id, invoice_id,cm_id) values('$student_id ','".$data_record['course_id']."','".$_POST['installments'][$i-1]."','$installment_date','not paid','".$comma_separated."',$student_id_in,'".$data_record['cm_id']."') ";

									   

									   $insert_ptr = mysql_query($insert_query);

									   

									   ///============ Installment Histroy insert

									    $insert_query2 = "  insert into installment_history(enroll_id, course_id, installment_amount, installment_date, status,installment_display_id, invoice_id,cm_id) values('$student_id ','".$data_record['course_id']."','".$_POST['installments'][$i-1]."','$installment_date','not paid','".$comma_separated."',$student_id_in,'".$data_record['cm_id']."') ";

									   

									   $insert_ptr2 = mysql_query($insert_query2);

									   

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

								  

                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';

								

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

													//================================== CODE for Invoice Email =======================================\\

													

													

													$invoice_subject = " Invoice for the course '$course_name' enrollment  at isasbeautyschool.com on date('d/m/Y H:i:s') ";

													

													$invoice_to = $mail;

													

													$msg_body = file_get_contents('http://www.isasbeautyschool.com/faculty_login/invoice-generate.php?record_id='.$student_id_in);

													$sendMessage=$GLOBALS['box_message_top'];

													$sendMessage.=$invoice_subject;

													$sendMessage.=$GLOBALS['box_message_bottom'];

													$from_id='support<support@'.$GLOBALS['domainName'].'>';

													$headers= 'MIME-Version: 1.0' . "\n";

													$headers.='Content-type: text/html; charset=utf-8' . "\n";

													$headers.='From:'.$from_id;

													mail($invoice_to, $invoice_subject, $sendMessage, $headers);

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

   		                                          /* $select_mobno = " select name,contact_phone,designation from site_setting where (cm_id='".$_SESSION['cm_id']."' or admin_id='".$_SESSION['admin_id']."' or branch_name='".$branch_name1."') and (type='A' or type='C' ) and contact_phone !='' ";

													$ptr_mob = mysql_query($select_mobno);

													while($data_mob = mysql_fetch_array($ptr_mob))

													{

														//================for Faculty==============

														$insert_sms="insert into sms_log_history (`sent_name`,`sent_mobile`,`sent_desc`,`user_type`,`sms_type`,`cm_id`,`added_date`) values('".$data_mob['name']."','".$data_mob['contact_phone']."','".$desc."','".$data_mob['designation']."','enqiry','".$cm_id."','".date('Y-m-d H:i:s')."')";

														$ptr_sms=mysql_query($insert_sms);

														send_sms($data_mob['contact_phone'],$message);

														//=========================================

													}

													//=================For Student=============

													$insert_sms="insert into sms_log_history (`sent_name`,`sent_mobile`,`sent_desc`,`user_type`,`sms_type`,`cm_id`,`added_date`) values('".$firstname.' '.$lastname."','".$contact."','".$desc1."','Student','enqiry','".$cm_id."','".date('Y-m-d H:i:s')."')";

													$ptr_sms=mysql_query($insert_sms);

													send_sms($contact,$message);*/

													//==========================================

								//=================================================END MAIL SENT======================================

								

								

								if($payment_type_val !="online")

								{

									?>

                                <script>

                                window.open('invoice-generate.php?record_id=<?php echo $student_id_in; ?>', 'win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900,height=600,directories=no,location=no');

								</script>

                                <?php

								?><script>

								setTimeout('document.location.href="manage_enroll.php";',2000);

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

												<td>Shipping Name	:</td><td><input type="hidden" name="delivery_name" value="<?php echo $name; ?>"/></td>

											</tr>

											<tr>

												<td>Shipping Address	:</td><td><input type="hidden" name="delivery_address" value="<?php echo $address; ?>"/></td>

											</tr>

											<tr>

												<td>shipping City	:</td><td><input type="hidden" name="delivery_city" value="<?php echo $branch_name1; ?>"/></td>

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

												<td>Shipping Tel	:</td><td><input type="hidden" name="delivery_tel" value="<?php echo $contact; ?>"/></td>

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

												</script>

												

											</tr>

										</table>

									  </form>

                                      </div>

                                      <?

								}

								

								

							}

								

                            }

							

                          }

                    }

							

							

                    if($success==0)

                    {

                        ?>

            <tr><td>

        <form name="jqueryForm" method="post" id="jqueryForm"  enctype="multipart/form-data" onSubmit="return validme();">

	<table border="0" cellspacing="15" cellpadding="0" width="100%" >

            <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
            <?php
				$sql_sub_cat = "select * from inquiry where inquiry_id='".$row_record['student_id']."' ";
				$my_query=mysql_query($sql_sub_cat);
				$row= mysql_fetch_array($my_query);
				
            	if($_SESSION['type']=='S')
                {
                ?>
                      <tr>
                      	<td>Select Branch</td>
                        <td>
                        <?php
						$sel_cm_id="select branch_name from site_setting where cm_id=".$row['cm_id']." ";
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
       <?php } ?>
                <tr>
                	<td width="20%">Addmission date<span class="orange_font">*</span></td>
                    <td width="40%"><input type="text" class="input_text datepicker" name="admission_date" value="<?php if($_POST['admission_date']) echo $_POST['admission_date']; else echo date('Y-m-d'); ?>" />
                    <input type="hidden" name="cm_id" value="<? echo $row['cm_id']; ?>" /></td>
                </tr> 
                <tr>
                	<td width="20%" >Invoice No.<span class="orange_font">*</span></td>
                    <td width="40%"><input type="text" class="validate[required] input_text" name="invoice_no" disabled="disabled"  value="<?php if($_POST['invoice_no']) echo $_POST['invoice_no']; else echo $row_record['student_id']; ?>" /> </td>
                </tr>
                <tr>
                	<td width="20%">Enquiry date<span class="orange_font">*</span></td>
                    <td 40%><input type="text" class="validate[required] input_text" name="inquiry_date"  value="<?PHP if($_POST['inquiry_date']) echo $_POST['inquiry_date']; else echo $row_record['added_date'];?>" /><br />(yyyy-mm-dd)</td>
                </tr>
                <tr>
                	<td width="20%">Student Name<span class="orange_font">*</span></td>
                    <td width="40%"><input type="text" class="validate[required] input_text" name="name"  id="name" value="<?php if($_POST['name']) echo $_POST['name']; else echo $row_record['name'];?>" /></td> 
                </tr> 
                <tr>
                	<td width="20%">Contact No<span class="orange_font">*</span></td>
                    <td width="40%"><input type="text" class="validate[required] input_text" name="contact" id="contact" value="<?php if($_POST['contact']) echo $_POST['contact']; else echo $row_record['contact'];?>" onKeyPress="return isNumber(event)" maxlength="12"/></td> 
                    <td width="40%"><b>Note-</b> Should be 10-12 digit allowed. </td>
                </tr>
                <tr>
                	<td width="20%">Email Id<span class="orange_font">*</span></td>
                    <td width="40%"><input type="text" class="input_text" name="mail" id="mail" value="<?php if($_POST['mail']) echo $_POST['mail']; else echo $row_record['mail'];?>" onBlur="validateEmail(this.value);" /></td> 
                    <td width="40%"></td>
                </tr>
                <tr>
                	<td width="20%">Qualification<span class="orange_font"></span></td>
                    <td width="40%"><select name="qualification" id="qualification" class="input_text" >
                    <option  value="">----Select----</option>
                    <option  value="SSC" <?php if (isset($qualification) && $qualification == "SSC") echo "selected"; elseif( 'SSC' == $row_record['qualification']) echo "selected";?> >SSC</option>
                    <option  value="HSC" <?php if (isset($qualification) && $qualification == "HSC") echo "selected";elseif( 'HSC' == $row_record['qualification']) echo "selected";?> >HSC</option>
                    <option value="Under Graduation" <? if (isset($qualification) && $qualification == "Under Graduation") echo "selected";elseif( 'Under Graduation' == $row_record['qualification']) echo "selected";?> >Under Graduation</option>
                    <option value="Graduation" <? if (isset($qualification) && $qualification == "Graduation") echo "selected";elseif( 'Graduation' == $row_record['qualification']) echo "selected";?> >Graduation</option>
                     <option value="Post Graduation" <? if (isset($qualification) && $qualification == "Post Graduation") echo "selected";elseif( 'Post Graduation' == $row_record['qualification']) echo "selected";?> >Post Graduation</option>
                     </select>
                     </td>
                     <td width="40%"></td>
                 </tr>
                 <tr>
                 	<td width="20%"> User Name<span class="orange_font">*</span> </td>
                    <td width="40%"><input type="text" class="validate[required] input_text" name="username" id="username" value="<?php if($_POST['username']) echo $_POST['username']; else echo $row_record['username'];?>" /></td>
                    <td width="40%"><div id="feedback"></div>Only Characters and Number allowed</td>
                 </tr>
                 <tr>
                 	<td width="20%">Password<span class="orange_font">*</span></td>
                    <td width="40%"><input type="text" class="validate[required] input_text" name="pass" id="pass" value="<?php if($_POST['pass']) echo $_POST['pass']; else echo $row_record['pass'];?>" /></td> 
                    <td width="40%"></td>
                 </tr>
                 <tr>
                 	<td width="20%">Photo</td>
                 	<td width="40%"><?php if($record_id && $row_record['photo'] && file_exists("../student_photos/".$row_record['photo']))
				 	echo '<img height="77px" width="77px" src="../student_photos/'.$row_record['photo'].'"><br><a href="'.$_SERVER['PHP_SELF'].'?deleteThumbnail=1&record_id='.$record_id.'">Delete / Upload new</a></td><td width="40%"></td>';else echo '<input type="file" name="photo" id="photo" class="input_text"></td>';?></td> 
                 	<td width="40%"></td>
                 </tr>
                 <tr>
                 	<td width="20%">Address<span class="orange_font">*</span></td>
                    <td width="40%"><textarea  name="address" id="address" ><?php if($_POST['address']) echo $_POST['address']; else echo $row_record['address'];?></textarea></td> 
                 </tr> 
                 <tr>
                 	<td width="20%">Date Of Birth<span class="orange_font">*</span></td>
                    <td width="40%"><input type="text" class="input_text datepicker" name="dob" id="dob" value="
					<?php if($_POST['dob']) 
								echo $_POST['dob']; 
						else 
						{
							$arrage_date= explode('-',$row_record['dob'],3);
							echo $arrage_date[1].'/'.$arrage_date[2].'/'.$arrage_date[0]; 
						}
					?>" />
               		</td> 
                	<td width="40%"></td>
            	</tr>   
            	<tr>
                	<td width="20%">Source<span class="orange_font"></span></td>
                  	<td><select id="source" name="source">
                    <option value="">----Select----</option>
					<?php 
						$sel_source="SELECT * FROM source";
						$ptr_src=mysql_query($sel_source);
						while($data_src=mysql_fetch_array($ptr_src))
						{
							$selected= '';
							if($row['enquiry_source']==$data_src['source_id'])
							$selected= ' selected="selected" ';
							echo '<option value="'.$data_src['source_id'].'" '.$selected.'>'.$data_src['source_name'].'</option>';
						}
						?>
                          </select>
                   </td>
            	</tr>             
            	<tr>
                   <td width="20%">Admission remark<span class="orange_font"></span></td>
                   <td><input type="text" class="validate[required] input_text" name="admission_remark"  value="<?php if($_POST['admission_remark']) echo $_POST['admission_remark']; else echo $row['remark'];?>" /></td>
            	</tr>                                         
            	<tr>
            		<td width="20%">Select Course<span class="orange_font">*</span></td>
            		<td width="40%" >
                    <select name="course_id" id="course_id" class="validate[required] input_select customized_select_box" onChange="show_course(this.value);" >  
                    <option value=""> Select Course </option>
                    <?php
                    $course_category = " select category_name,category_id from course_category ";
					$ptr_course_cat = mysql_query($course_category);
					while($data_cat = mysql_fetch_array($ptr_course_cat))
					{
						echo " <optgroup label='".$data_cat['category_name']."'>";
						$get="SELECT course_name,course_id FROM courses where category_id='".$data_cat['category_id']."' order by course_id";
						$myQuery=mysql_query($get);
						while($rows = mysql_fetch_assoc($myQuery))
						{
							$selected= '';
							if($row['course_id']==$rows['course_id'] || $_POST['course_id']==$rows['course_id'] )
							$selected= ' selected="selected" ';
							?>
                            <option value = "<?php echo $rows['course_id']?>" <?php echo $selected;  ?> > <?php echo $rows['course_name'] ?> </option>
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
                	<td colspan="3" width="100%"><div id="custome_div" style="display:none">
                    	<table width="100%">
                        	<tr>
                            	<td width="26%">Customised Course<span class="orange_font">*</span></td>
                                <td width="40%"><input type="text" class="inputText" name="costomize_courses" id="costomize_courses" value="<?php if($_POST['costomize_courses']) echo $_POST['costomize_courses']; else echo $row_record['customised_course'];?>"/></td>
                                <td width="20%">&nbsp;</td>
                            </tr>
                        </table>
                    </div></td>
                </tr>
                <tr>
                	<td width="22%">Paid Type </td>
                    <td width="38%">
                    <input type="radio" name='paid_type' id="paid_type" value="one_time" <?php if($_POST['paid_type'] =="one_time")  echo 'checked="checked"'; ?>  checked="checked" onChange="show_record()" />One Time <input type="radio" name='paid_type' id="paid_type" value="installments" <?php if($_POST['paid_type'] =="installments")  echo 'checked="checked"'; ?> onChange="show_record()" />Installment <?php if($_SESSION['type']!='S'){ echo $_SESSION['installment_tax'];}else echo '<span id="inst_tax_id"></span>'; ?>% add
                	<input type="hidden" id="inst_taxes" value="<?php if($_SESSION['type']!='S'){ echo $_SESSION['installment_tax'];} ?>"  />
                	<input type="radio" name='paid_type' id="paid_type" value="installments_zero"  <?php if($_POST['paid_type'] =="installments_zero")  echo 'checked="checked"'; ?> onChange="show_record()" />Installment 0% add
                    </td>                
                	<td width="40%"></td>
                </tr>
  <!--==========================================================================================================================-->                                           
                <tr>
                	<td width="22%">Course Fees</td>
                	<td width="38%">
                    <div id=total_fees>
                    
                	<input type="text" class="input_text" name="total_fees" id="toal_fees" readonly="readonly" value="<?php if($_POST['total_fees']) echo $_POST['total_fees']; else echo $row['total_fees'];?>" />
                    </div>
                    </td>                
                    <td width="40%"></td>
                </tr>
            	<tr>
                	<td width="22%">Discount in <input type="radio" name='discount_type' value="<?php if($_POST['discount_type']) echo $_POST['discount_type']; else echo percent; ?>" checked="checked" onChange="show_record()" />% or <input type="radio" name='discount_type' value="<?php if($_POST['discount_type']) echo $_POST['discount_type']; else echo cash; ?>" onChange="show_record()" />Cash</td>
                	<td width="38%"><input type="text" class="input_text" name="concession" id="concession" value="<?php if($_POST['concession']) echo $_POST['concession']; else if($row_record['discount'] !=0) echo $row_record['discount']; else echo 0; ?>" onblur="show_record()"/>
                    </td>
                    <td width="40%"></td>
                </tr>
                <tr>
                	<td width="22%">Discount Coupon Code</td>
                    <td width="38%">
                    <input type="text" class="input_text" name="discount_coupon" id="discount_coupon" value="<?php if($_POST['discount_coupon']) echo $_POST['discount_coupon']; else echo $row_record['code'];?>" onBlur="show_discount()" /></td>
                    <td width="40%"><div id="coupon"></div><input type="hidden" name="discount_coupon_price" id="discount_coupon_price" value="<?php if($_POST['discount_coupon_price']) echo $_POST['discount_coupon_price']; else echo $row_record['discount_coupon_price'];?>" /></td>
                    </tr>

            <!--<tr>

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

                                                  <td width="20%" class="heading"> Service Tax <?php if($_SESSION['type']!='S'){ echo $_SESSION['service_tax'];} else echo '<span id="service_tax_id"></span>';  ?>%<span class="orange_font">*</span></td><input type="hidden" id="service_taxes" value="<?php if($_SESSION['type']!='S'){ echo $_SESSION['service_tax'];} ?>"  />

                                                  

                                                  <td><input type="text" class="validate[required] input_text" name="service_tax" id="service_tax"  value="<?php if($_POST['service_tax']) echo $_POST['service_tax']; else echo $row_record['service_tax'];?>" /></td>

                                            </tr>

                                            <tr>      

                                                  <td width="20%" class="heading">Total Fees<span class="orange_font">*</span></td>

                                                  <td><input type="text" class="validate[required] input_text" name="fees" id="fees"  value="<?php if($_POST['fees']) echo $_POST['fees']; else echo $row_record['total_fees'];?>" /></td> 

                                                  

                                             </tr>

                                              <tr>

                                                  <td width="20%" class="heading">Down Payment(Including tax)<span class="orange_font">*</span></td>

                                                  <td><input type="text" class="validate[required] input_text" name="down_payment" id="down_payment" onKeyUp="show_record()" value="<?php if($_POST['down_payment']) echo $_POST['down_payment']; else if($row_record['down_payment']!=0) echo $row_record[                                                    'down_payment']; else echo 0;?>" /></td>

                                            </tr> 

                                            <tr>

												<td class="heading">Installment on</td>

                                            	<td colspan="2"> <input type="text" name="installment_on" readOnly  id="installment_on" value="<?php if($_POST['installment_on']) echo $_POST['installment_on']; else if($row_record['installment_on']!=0) echo $row_record['installment_on']; else echo 0;?>"/>

                                                

                                                </td> 

                                            </tr>

                                                <script language="javascript">show_course(<?php echo $row['course_id']; ?>)</script>

                                             <tr><td class="heading"> Number of Installment</td>

                                            <td colspan="2">

                                            	  <select name="numDep" id="dropdown" >

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

													?>

                                                    <tr><td width="23%" class="heading">Installment <?php echo $i; ?> </span></td><td width="40%" colspan=2""><input type="text" class="input_text" name="installments[]" value='<?php if($_POST['installments']) echo $_POST['installments']; else echo $dat_installment['installment_amount'];  ?>' /></td><td><input type="text" name="installment_date[]" class="datepicker" placeholder="installment date" value="<?php if($_POST['installment_date']) echo $_POST['installment_date']; else echo $sep_da[1].'/'.$sep_da[2].'/'.$sep_da[0]; ?>"  ></td></tr>

                                                    <?php 

													$i++;

													}?>

                                                    </table>

                                                    <?php

												}

												 ?>

                                                </div></td> 

                                            </tr>

                                            <!--<tr>

                                                  <td width="20%" class="heading">Down Payment(Including tax)<span class="orange_font">*</span></td>

                                                  <td><input type="text" class="validate[required] input_text" name="down_payment" /><?php //if ($_post['down_payment'])

												  //echo $_POST['down_payment'];?></td>

                                            </tr> -->        

                                                 <?php

											$sql_invoice="select * from invoice where enroll_id='".$row_record['enroll_id']."' and course_id='".$row_record['course_id']."' and installment_id='0' ";

											$my_query_invoice=mysql_query($sql_invoice);

											

											if(mysql_num_rows($my_query_invoice))

											{

											$row_invoice= mysql_fetch_array($my_query_invoice);

											$chaque_date = $row_invoice['chaque_date'];

											$sep_chk_dt = explode('-',$chaque_date);

											$chaque_date=$sep_chk_dt[1].'/'.$sep_chk_dt[2].'/'.$sep_chk_dt[0];

											}

											?>

                                            <!-- <tr>

                                                  <td width="20%" class="heading">Payment Mode<span class="orange_font">*</span></td>

                                                 <td ><div id="pay_type"> <input type="radio" class="validate[required] input_radio" name="payment_type" id="payment_type" value="cash" onClick="hide();" <?php if($row_invoice['paid_type']=='cash'|| $_POST['payment_type']=='cash') echo 'checked="checked"'; ?> /> Cash

                                                 

                                                   <input type="radio" class="validate[required] input_radio" name="payment_type"  id="payment_type" value="cheque" onClick="show();" <?php if($row_invoice['paid_type']=='cheque'|| $_POST['payment_type']=='cheque') echo 'checked="checked"'; ?> />By Cheque

                                                   

                                                  <input type="radio" class="validate[required] input_radio" name="payment_type" id="payment_type" value="online" onClick="hide();"   <?php if($row_invoice['paid_type']=='online'|| $_POST['payment_type']=='online') echo 'checked="checked"'; ?> />Online

                                                 </div> </td>

                                            </tr>-->

                                            <tr>

                                                <td width="20%" class="heading">Select Payment Mode</td>

                                                <td><select name="payment_type" id="payment_type" onChange="show_payment(this.value)">

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

											  if($_SESSION['type'] !="S")

											  {

											  ?>

                                              <select name="bank_name" id="bank_name" onChange="show_acc_no(this.value)">

                                             <option value="select">--Select--</option>

                                             <?php

                                             $sle_bank_name="select bank_id,bank_name from bank ".$_SESSION['where_cm_id'].""; 

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

                                             <?php

                                             }

											 ?>

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

                                             <td><input type="text" name="credit_card_no" id="credit_card_no" value="<?php if($_POST['credit_card_no']) echo $_POST['credit_card_no']; else echo $row_invoice['credit_card_no']; ?>" /></td>

                                             </tr>

                                             </table>

                                             </div>

                                            </td>

                                                 </tr>

                                            <!--<tr>

												<td></td>

                                            	<td colspan="2">

                                                <div id="payment" <?php  //if($row_invoice=='cheque' || $_POST['payment_type'] =='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>> 

                                                <table>

                                                	<tr>

                                                    	<td>Bank Name</td>

                                                        <td><input type="text" name="bank_name" id="bank_name"  class="validate[required] input_text" 

                                                        value="<?php //if($_POST['bank_name']) echo $_POST['bank_name']; else echo $row_invoice['bank_name'];?>"/></td>

                                                        <td>Cheque No.</td>

                                                        <td><input type="text" name="chaque_no" id="chaque_no"  class="validate[required] input_text"  value="<?php //if($_POST['chaque_no']) echo $_POST['chaque_no']; else echo $row_invoice['chaque_no'];?>" onKeyPress="return isNumber(event)" maxlength="6"/></td>

                                                        <td>Cheque Date</td>

                                                        <td><input type="text" name="chaque_date" id="chaque_date"  class="datepicker" placeholder="cheque date " value="<?php //if($_POST['save_changes']) echo $_POST['chaque_date']; else echo $chaque_date ;?>"/></td>

                                                    </tr>

                                                </table>

                                                </div>

                                               </td> 

                                            </tr>-->

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
        <input type="submit" value="Save Record" name="save_changes" /></center> 
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

                            $("#course_only_fee").val(course_fee);

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
<div class="clearit"></div>
<!--footer start-->
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
<?php
if($_SESSION['type']=="S")
{
	?>
    <script>
	branch_name =document.getElementById("branch_name").value;
	//alert(branch_name);
	show_bank(branch_name);
	</script>
    <?php
}
?>
</body>
</html>
<?php $db->close();?>