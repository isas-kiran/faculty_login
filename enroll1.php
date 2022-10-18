<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
     $sql_record= "SELECT * FROM enrollment where enroll_id='".$record_id."'";
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
<!--End multiselect -->
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            $("#user_id").multiselect().multiselectfilter();
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
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
function show_record()
{       
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
			 installment_charge=  parseInt(toatl_one_time*<?php echo $_SESSION['installment_tax']; ?>/100);
			 totals_charge=installment_charge+toatl_one_time;
			 document.getElementById('toal_fees').value=totals_charge;
			 
			 totals_fees = parseInt(document.getElementById('toal_fees').value);
	  		 
			 document.getElementById("dropdown").disabled  = false;
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
	  		 concession = parseInt(document.getElementById('concession').value);
		 }
		 
	//===================================================================
	 // paid = document.getElementById('paid').value;
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
	//document.getElementById('balance').value=total_bal_ava;
	document.getElementById('net_fees').value=total_bal_ava;
	//alert(total_bal_ava);
	//document.getElementById('balance').value=total_bal_ava;
	 var local = sep_disc

  	 //alert(local);
	 //disc_amount=disc_amt;
	if(local !='' || local !=0)
	{
		//alert("yahoo");
		var total_disc_coupon= parseInt(total_bal_ava - local);
		document.getElementById('net_fees').value=total_disc_coupon;
		document.getElementById('discount_coupon_price').value=local;
	}
	  
	  
	  var net_fees=parseInt(document.getElementById('net_fees').value);
		var tax =parseInt(net_fees*<?php echo $_SESSION['service_tax']; ?>/100);
	 	//alert (tax)
		document.getElementById('service_tax').value=tax;
		
		
	  	var total = parseInt(net_fees + tax);
		//alert (total)
		document.getElementById('fees').value=total;
		document.getElementById('total_amt').value=total;
		var fee1 = parseInt(document.getElementById('fees').value);
	    var down_payment =parseInt( document.getElementById('down_payment').value);
		var total_f= fee1- down_payment;
		//alert (total_f);
		document.getElementById('installment_on').value=total_f;
		document.getElementById('final_amt').value=total_f;
		if(total_f==0)
		{
			var inst1 = document.getElementById("dropdown").disabled  = true;
			$('#dropdown').removeClass("obrderclass");  
			//alert(total_f);
		}
		else{document.getElementById("dropdown").disabled  = false;}
	
}
</script>
    <script>
/*function show_subject(subject)
		{
			//alert(subject);
			var data1="show_subject=1&subject="+subject;
				 $.ajax({
            url: "show_subject_multiple.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				
				 document.getElementById('show_subject').innerHTML=html;
			}
			});
		}*/
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
		
        if(selVal == 'new_course') 
		{
            $("#customise").append('<table width="100%"><tr><td width="23%" class="heading">Customize Course</span></td><td width="40%" colspan=2"><input type="text"            class="input_text" name="costomize_courses"/></td></tr></table>');
		}
		else{}
    });
});


</script>
   <script type="text/javascript">
        function show() { document.getElementById('payment').style.display = 'block'; }
        function hide() { document.getElementById('payment').style.display = 'none'; }
      </script> 
    
    <script type="text/javascript">
$(document).ready(function() {
    $("#dropdown").change(function() {
        var selVal = $(this).val();
        $("#textboxDiv").html('');
		
		var inst =parseInt (document.getElementById('installment_on').value);
		var no_inst = inst/selVal ;
		document.getElementById('final_amt').value=inst;
		//alert (no_inst);
		
        if(selVal > 0) {
            for(var i = 1; i<= selVal; i++) {
                $("#textboxDiv").append('<table width="100%"><tr><td width="23%" class="heading">Installment '+i+' </span></td><td width="40%" colspan="2"><input type="text" class="input_text" name="installments[]" value='+Math.round(no_inst)+' /></td><td><input type="text" name="installment_date[]" class="datepicker" placeholder="installment date " ></td></tr></table>');
            }
			$('#dropdown').removeClass("obrderclass"); 
			 
        }
		else
		$('#dropdown').addClass("obrderclass"); 
		$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
           
    });
});
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
			 disp_error +='Add Down Payment  \n';
			 document.getElementById('down_payment').style.border = '1px solid #f00';
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
					disp_error +='Installment date not in ascending order \n'; 
					$(".date_class"+s).addClass("obrderclass"); 
					
				}
				
				
				//=================================================================
					
			}
		  
			if($('#installment_on').val() !=0 && $('#dropdown').val()==0)
			{
				
				disp_error +='Installment is not selected \n'; 
				 error='yes';
				$('#dropdown').addClass("obrderclass"); 
				frm.numDep.focus();
			}
			else
			$('#dropdown').removeClass("obrderclass"); 
			
		 ///================= END Installmetn Dat4 Validation  ===
		 
		if($('input[name=payment_type]:checked').length<=0)
		{
		 disp_error +='Payment mode not selected \n'; 
		 document.getElementById('payment_type').style.border = '1px solid #f00';
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
	 
	 
	 function isPastDate(value) {
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
						$dob1=$_POST['dob'];
						$tan_date=explode('/',$_POST['dob'],3);
						$dob=$tan_date[2].'-'.$tan_date[0].'-'.$tan_date[1];
						
						$batch_id=$_POST['batch_id'];  
                        $address=$_POST['address']; 
					    $contact=$_POST['contact'];
					    $mail=$_POST['mail'];
					    $qualification=$_POST['qualification'];
						$photo=$_POST['photo'];
                        $invoice_no= $_POST['invoice_no'];
						$inquiry_date= $_POST['inquiry_date'];
						$paid_type=$_POST['paid_type'];
						//$id_card= $_POST['id_card'];
						$source= $_POST['source'];
						$admission_remark= $_POST['admission_remark'];
						$course= $_POST['course_id'];
						$costomize_courses= $_POST['costomize_courses'];
						$course_fees= $_POST['total_fees'];
						$discount_coupon_code = $_POST['discount_coupon'];
						$discount_coupon_price = $_POST['discount_coupon_price'];
						$discount= $_POST['concession'];
						
						//$final_fees= $_POST['balance'];
						$paid= $_POST['down_payment'];
						$bank_name= $_POST['bank_name'];
						$chaque_no= $_POST['chaque_no'];
						$chaque_date= $_POST['chaque_date'];
						$tan_date = explode('/',$chaque_date);
						$chaque_date=$tan_date[2].'-'.$tan_date[0].'-'.$tan_date[1];
						$payment_type= $_POST['payment_type'];

						$installment_on= $_POST['installment_on'];
						$net_fees= $_POST['net_fees'];
						$total_fees= $_POST['fees'];
						$service_tax= $_POST['service_tax'];
						$down_payment= $_POST['down_payment'];
						$first_installment= $_POST['numDep'];
						$branch_name=$_POST['branch_name'];
						$final_amt= $_POST['final_amt'];
						//$dob=$tan_date[2].'-'.$tan_date[0].'-'.$tan_date[1];
                       
						//$added_date=date('Y-m-d H:i:s'); 
					               
								$chk_exist = " select enroll_id from enrollment where username='$username' ";
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
						 if($payment_type =="")
                        {
                                $success=0;
                                $errors[$i++]="Please Select Payment mode";
                        }
						
						
						
						if($_SESSION['captcha']=="")
											{
												$success=0;
                                                $errors[$i++]="Enter sequirty code";
											}
											elseif((trim(strtolower($_POST['captcha'])) != $_SESSION['captcha']))
											{
												 $success=0;
                                                $errors[$i++]="Enter Correct Sequirty code";
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
							$data_record['name']=$name;
                            $data_record['username'] =$username;
                            $data_record['pass'] =$pass;
                            $data_record['dob'] =$dob;
							$data_record['address'] =$address;
                            $data_record['contact'] =$contact;
                            $data_record['mail'] = $mail;
						    $data_record['qualification']=$qualification;
							
							$data_record['batch_id'] =$_POST['batch_id'];
							
							if($_REQUEST['record_id'])
							{
								$data_record['student_id']=$_REQUEST['record_id'];
								$data_record['invoice_no']=$_REQUEST['record_id'];
							}else
							{
								$data_record['student_id']=$largestInvoiceNumber;
								$data_record['invoice_no']=$largestInvoiceNumber;
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
                            //$data_record['final_fees']=$final_fees;
							$data_record['paid']=$paid;
							$data_record['installment_on']=$installment_on;
                            $data_record['net_fees']=$net_fees;
							$data_record['total_fees']=$total_fees;
						    $data_record['service_tax']=$service_tax;
                            $data_record['down_payment']=$down_payment;
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
								
							}	
							else
							{
								$data_record['cm_id']=$_SESSION['cm_id'];
								$branch_name1=$_SESSION['branch_name'];
							}
							//====================================================================
							
							
							$data_record_invoice['course_id']=$course;
							$data_record_invoice['admin_id']=$_SESSION['admin_id'];
							$data_record_invoice['bank_name']=$bank_name;
							$data_record_invoice['cheque_detail']=$chaque_no;
							$data_record_invoice['chaque_date']=$chaque_date;	
							$data_record_invoice['online_transc_details']='';
							$data_record_invoice['amount']=$down_payment;
							$data_record_invoice['paid_type']=$payment_type;
							$data_record_invoice['added_date']=date('y-m-d h:i:s');
							
							 if($file_uploaded)
							$data_record['photo'] = $uploaded_url;
							
                            if($record_id)
                            {
                               /* $data_record['added_date'] = date('Y-m-d H:i:s');
                                $courses_id=$db->query_insert("enrollment", $data_record);  
							    $student_id= mysql_insert_id();*/
								
								$where_record="enroll_id='".$record_id."'";                                
                                $db->query_update("enrollment", $data_record,$where_record); 
								$db->query_update("invoice", $data_record_invoice,$where_record); 
								
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
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
								$data_record['course_status']='processing';
								$data_record['subject_id']= $concat;
								
								$data_record['added_date'] = date('Y-m-d H:i:s');
                                $student_id=$db->query_insert("enrollment", $data_record);  
								//echo $db;
							   // $student_id= mysql_insert_id();
							   $data_record_invoice['enroll_id']=$student_id;
							   $student_id_in=$db->query_insert("invoice", $data_record_invoice);  
							   
							   if($data_record['no_of_installment'] !=0)
							   {
								 for($i=1;$i<=$data_record['no_of_installment'];$i++)
								 {
									 $installment_date='';
									if($_POST['installments'][$i-1] !='')
									{
										$sep_date =  explode('/',$_POST['installment_date'][$i-1]);
												$installment_date = $sep_date[2].'-'.$sep_date[0].'-'.$sep_date[1];
									"<br />".  $insert_query = "  insert into installment(enroll_id, course_id, installment_amount, installment_date, status, invoice_id) values('$student_id','".$data_record['course_id']."','".$_POST['installments'][$i-1]."','$installment_date','not paid','$student_id_in' ) ";
									   
									   $insert_ptr = mysql_query($insert_query);
									   
									    $insert_query1 = "  insert into installment_history(enroll_id, course_id, installment_amount, installment_date, status, invoice_id) values('$student_id','".$data_record['course_id']."','".$_POST['installments'][$i-1]."','$installment_date','not paid','$student_id_in') ";
									   
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
							            
                                echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
								?>
                               <script> window.open('invoice-generate.php?record_id=<?php echo $student_id?>','win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900,height=600,directories=no,location=no');
							   </script>
                                <?php
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
													date_default_timezone_set('Etc/UTC');

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
													}
													
													///=== END Code for Invoice email sent
													
													}
   		                                           
								//=================================================END MAIL SENT======================================
								
								
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
                                       $comma_separated = implode("/", $array);
									  
				
            ?>
            
            				 <? if($_SESSION['type']=='S')
								{
							?>
							  <tr>
								<td>Select Branch</td>
								<td>
								<? 
								
								
								$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
								$query_branch = mysql_query($sel_branch);
								$total_Branch = mysql_num_rows($query_branch);
								echo '<table width="100%"><tr><td>';
								echo ' <select id="branch_name" name="branch_name">';
								
								while($row_branch = mysql_fetch_array($query_branch))
								{
									?>
									<option value="<? if ($_POST['branch_name']) echo $_POST['branch_name']; else echo $row_branch['branch_name'];?>"><? echo $row_branch['branch_name']; ?> 
									</option>
									<?
								
								}
									echo '</select>';
									echo "</td></tr></table>";
									?>
							</td>
						</tr>
						<? } ?>
            
                            <tr>
                                          <td width="20%">Admission date<span class="orange_font">*</span></td>
                                          <td width="40%"><?php echo date('d-m-Y'); ?></td>
                            </tr> 
                            <tr>
                                          <td width="20%" >Enrollment No.<span class="orange_font">*</span></td>
                                          <td width="40%"><?php if($_POST['student_id']) echo $_POST['student_id']; elseif($record_id==''){ echo $comma_separated. '/'.$largestNumber ;} else echo $row_record['installment_display_id']; ?> </td>
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
                   						 <input type="text" class="validate[required] input_text" name="contact" id="contact" value="<?php if($_POST['contact']) echo $_POST['contact']; else echo $row_record['contact'];?>" />
                						</td> 
                						<td width="40%"><b>Note-</b> Should be 10-12 digit allowed. </td>
           					 </tr>   
           					 <tr>
               							 <td width="20%">Email Id<span class="orange_font">*</span></td>
                						 <td width="40%">
                    					 <input type="text" class="validate[required] input_text" name="mail" id="mail" value="<?php if($_POST['mail']) echo $_POST['mail']; else echo $row_record['mail'];?>" />
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
                        				echo '<img height="77px" width="77px" src="../student_photos/'.$row_record['photo'].'"><br><a href="'.$_SERVER['PHP_SELF'].'?deleteThumbnail=1&record_id='.$record_id.'">Delete / Upload new</a></td><td width="40%"></td>';
                    else
                        				echo '<input type="file" name="photo" id="photo" class="input_text"></td>';?></td> 
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
							<option value = "<?php echo $data_src['source_name']?>" <? if ( $data_src['source_name'] == $row_record['source']) echo "selected";?> > <?php echo $data_src['source_name'] ?> </option>
						
						<?
						}
							
						?>
                          </select>
                   </td>
            </tr>             
            <tr>
                   <td width="20%">Admission remark<span class="orange_font"></span></td>
                                            
                   <td><input type="text" class="validate[required] input_text" name="admission_remark"  value="<?php if($_POST['admission_remark']) echo $_POST['admission_remark']; else echo $row_record['admission_remark'];?>" /></td>
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
                               
                            <option value="new_course" >New Course</option>     
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
                <input type="radio" name='paid_type' id="paid_type" value="one_time" checked="checked" onChange="show_record()" />One Time <input type="radio" name='paid_type' id="paid_type" value="installments" onChange="show_record()" />Installment <?php echo $_SESSION['installment_tax']; ?>% add
                
                </td>                
                <td width="40%"></td>
            </tr>                             
       <!--==========================================================================================================================-->                                           
                                            <tr>
                <td width="22%">Course Fees</td>
                <td width="38%"><div id=total_fees>
                <input type="text" class="input_text" name="total_fees" id="toal_fees" readonly="readonly" value="<?php if($_POST['total_fees']) echo $_POST['total_fees']; else echo $row_record['course_fees'];?>" />
                </div>
                </td>                
                <td width="40%"></td>
            </tr>
           <!-- <tr>
                                             
                  <td width="20%" class="heading">Discount<span class="orange_font">*</span></td>
                 <td> <input type="radio" class="validate[required] input_radio" name="discount_type" id="discount_type" value="percentage" onClick="percentage();"/ <?php// if($row_invoice['discount_type']=='percentage' || $_POST['discount_type']=='percentage') echo 'checked="checked"'; ?> > In Percentage
                   <input type="radio" class="validate[required] input_radio" name="discount_type"  id="discount_type" value="cash" onClick="cash();" <?php//  if($row_invoice['discount_type']=='cash'|| $_POST['discount_type']=='cash') echo 'checked="checked"'; ?> />In Cash
                  </td>
            </tr>-->
            <tr>
                <td width="22%">Discount</td>
                <td width="38%">
                <input type="text" class="input_text" name="concession" id="concession" value="<?php if($_POST['concession']) echo $_POST['concession']; else if($row_record['discount'] !=0) echo $row_record['discount']; else echo 0; ?>" 
                onblur="show_record()"/>
                
                </td>                
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="22%">Discount Coupon Code</td>
                <td width="38%">
                <input type="text" class="validate[required] input_text" name="discount_coupon" id="discount_coupon" value="<?php if($_POST['discount_coupon']) echo $_POST['discount_coupon']; else echo $row_record['discount_coupon_code'];?>" onblur="show_discount()" />
                </td>                
                <td width="40%"><div id="coupon"></div><input type="hidden" name="discount_coupon_price" id="discount_coupon_price" value="<?php if($_POST['discount_coupon_price']) echo $_POST['discount_coupon_price']; else echo $row_record['discount_coupon_price'];?>" /></td>
            </tr>s
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
                                                  <td width="20%" class="heading">Excluding <?php echo $_SESSION['service_tax']; ?>% Service Tax <span class="orange_font">*</span></td>
                                                  <td><input type="text" class="validate[required] input_text" name="service_tax" id="service_tax"  value="<?php if($_POST['service_tax']) echo $_POST['service_tax']; else echo $row_record['service_tax'];?>" /></td>
                                            </tr>
                                            <tr>      
                                                  <td width="20%" class="heading">Total Fees<span class="orange_font">*</span></td>
                                                  <td><input type="text" class="validate[required] input_text" name="fees" id="fees"  value="<?php if($_POST['fees']) echo $_POST['fees']; else echo $row_record['total_fees'];?>" /></td>
                                            </tr>      
                                             <!-- <tr>
                                                  <th width="20%" class="heading">Installment</th>
                                             </tr>
                                            <tr>     
                                                  <td width="20%" class="validate[required]">Number of Installment </td>
                                                  <td width="20%" class="validate[required]">  
                                                  <select name="installment" id="installment" class="validate[required] input_select">  
                                                	 <option value=""> Select Installlment </option>
                                                     <option value="1"> 1 </option>
                                                     <option value="2"> 2 </option>
                                                     <option value="3"> 3 </option>
                                                     <option value="4"> 4 </option>
                                                     <option value="5"> 5 </option>
                                                   </select></td>
                                                  
                                            </tr>  -->
                                            <tr>
                                                  <td width="20%" class="heading">Down Payment(Including tax)<span class="orange_font">*</span></td>
                                                  <td><input type="text" class="validate[required] input_text" name="down_payment" id="down_payment" onKeyUp="show_record()" value="<?php if($_POST['save_changes']) echo $_POST['down_payment']; else if($row_record['down_payment']!=0) echo $row_record[                                                    'down_payment']; else echo 0;?>" /></td>
                                            </tr> 
                                            <tr>
												<td class="heading">Installment on</td>
                                            	<td colspan="2"> <input type="text" name="installment_on" readOnly  id="installment_on" value="<?php if($_POST['installment_on']) echo $_POST['installment_on']; else if($row_record['installment_on']!=0) echo $row_record['installment_on']; else echo 0;?>"/>
                                                
                                                </td> 
                                            </tr>
                                                    
                                            <tr>
                                           <?php 
										   //$inst="SELECT * from installment WHERE course_id='".$row_record['course_id']."'";
										   ?>
                                            <tr><td class="heading"> Number of Installment</td>
                                            <td colspan="2">
                                            	  <select name="numDep" id="dropdown" >
                                                     <?php for ($i = 0; $i <= 5; $i++) :
													 	$selc = '';
                                                		if($row_record['no_of_installment']==$i || $_POST['numDep']== $i)
														$selc =' selected="selected" ';
															echo '<option value='.$i.' '.$selc.'>'.$i.'</option>';
														
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
                                             <tr>
                                             
                                                  <td width="20%" class="heading">Payment Mode<span class="orange_font">*</span></td>
                                                 <td> <input type="radio" class="validate[required] input_radio" name="payment_type" id="payment_type" value="cash" onClick="hide();"/ <?php if($row_invoice['paid_type']=='cash' || $_POST['payment_type']=='cash') echo 'checked="checked"'; ?> > Cash
                                                   <input type="radio" class="validate[required] input_radio" name="payment_type"  id="payment_type" value="cheque" onClick="show();" <?php  if($row_invoice['paid_type']=='cheque'|| $_POST['payment_type']=='cheque') echo 'checked="checked"'; ?> />By Cheque
                                                  <input type="radio" class="validate[required] input_radio" name="payment_type" id="payment_type" value="online" <?php if($row_invoice['paid_type']=='online'|| $_POST['payment_type']=='online') echo 'checked="checked"'; ?> />Online
                                                  </td>
                                            </tr>
                                            <tr>
												<td></td>
                                            	<td colspan="2">
                                                <div id="payment" <?php  if($row_invoice['paid_type']=='cheque' || $_POST['payment_type'] =='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>> 
                                                <table>
                                                	<tr>
                                                    	<td>Bank Name</td>
                                                        <td><input type="text" name="bank_name"  class="validate[required] input_text" 
                                                        value="<?php if($_POST['bank_name']) echo $_POST['bank_name']; else echo $row_invoice['bank_name'];?>"/></td>
                                                        <td>Cheque No.</td>
                                                        <td><input type="text" name="chaque_no"  class="validate[required] input_text"  value="<?php if($_POST['chaque_no']) echo $_POST['chaque_no']; else echo $row_invoice['cheque_detail'];?>"/></td>
                                                        <td>Cheque Date</td>
                                                        <td><input type="text" name="chaque_date"  class="datepicker" placeholder="cheque date " value="<?php if($_POST['chaque_date']) echo $_POST['chaque_date']; elseif($chaque_date !='//') echo $chaque_date ;?>"/></td>
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
                                      
                                      
                        <tr>
                            <td height="50"><span class="text-form"><font color="#333333" size="2"> Security Code:</font></span></td>
                             <td><label> <input type="text" class="validate[required] inputText" name="captcha" id="captcha-form"/>
                               </label> </td>
                              <input type="hidden" name="captcha_code" id="captcha_code" value="<?php echo $_SESSION['captcha']; ?>" />
                            <td height="50" ><span class="text-form"><font color="#333333" size="2"> </font></span> 
                              <label> <img  src="captcha/captcha.php" id="captcha" height="35px"/>
                                                <img src="captcha/refresh.png" id="change-image" style="cursor: pointer; padding: 8px 26px;" onClick=			"document.getElementById('captcha').src='captcha/captcha.php?'+Math.random();">
                                </label>
                            </td>
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
            	<input type="submit" value="Update Record" name="save_changes" /> 
            <?
			}
			else
			{
			?>
				<input type="submit" value="Save Record" name="save_changes" /> 
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
                            $("#toal_fees").val(course_fee);
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
</body>
</html>
<?php $db->close();?>