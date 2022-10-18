<?php include 'inc_classes.php';
//==============Change Note==============
/*Changes on 7-5-20 by kiran - Changes is on GST Calculation, change GST Calculation formula for main and down payment GST*/
/*Changes on 29/10/20 for updating bank inactive status in payment mode*/
 
include "admin_authentication.php";
include "../classes/thumbnail_images.class.php";
$page_name = "enrollment";
$sele_sac_code="select sac_code from sac_code_config where page_name='".$page_name."'";
$ptr_sac_code=mysql_query( $sele_sac_code);
$data_sac_code=mysql_fetch_array($ptr_sac_code);
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM inquiry where inquiry_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
}
if($record_id && $_REQUEST['deleteThumbnail'])
{
    $update_news="update stud_regi set photo='' where student_id='".$record_id."'";
    $db->query($update_news);
	
	$update_photos="update inquiry set photo='' where inquiry_id='".$record_id."'";
    $db->query($update_photos);
	
    if($row_record['photo'] && file_exists("../student_photos/".$row_record['photo']))
        unlink("../student_photos/".$row_record['photo']);
    $row_record=$db->fetch_array($db->query($sql_record));
}
$rowSQL = mysql_query("SELECT MAX(enroll_id) as max FROM `enrollment`" );
$row = mysql_fetch_array( $rowSQL );
$largestNumber = $row['max']+1;

$rowSQL_invoice= mysql_query("SELECT MAX(invoice_id) as max FROM `invoice`" );
$row_invoice = mysql_fetch_array( $rowSQL_invoice );
$largestInvoiceNumber = $row_invoice['max']+1;
/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php if($record_id) echo "Edit"; else echo "Add";?> student</title>
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
           // $("#user_id").multiselect().multiselectfilter();
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });*/
		$(document).ready(function()
		{            
			$("#country").chosen({allow_single_deselect:true});
			$("#state").chosen({allow_single_deselect:true});
			$("#city").chosen({allow_single_deselect:true});
			$("#area").chosen({allow_single_deselect:true});
			$("#religion").chosen({allow_single_deselect:true});
			$("#course_id").chosen({allow_single_deselect:true});
			$("#current_offer").chosen({allow_single_deselect:true});
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
        $('.datepicker').datepicker({ changeMonth: true,changeYear: true,dateFormat:'dd/mm/yy', showButtonPanel: true, closeText: 'Clear',minDate: '-50Y',
        maxDate: '+2Y',});
//             $('input:radio[name=free_course][value=N]').click();
//             $('input:radio[name=discount_course][value=Y]').click();
//             $('input:radio[name=status][value=Inactive]').click();
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
	"<br/>".$sel_act="select contact_phone,email from site_setting where admin_id='".$data_sel_cnt['staff_id']."'  and email!='' ".$_SESSION['where']."";
	$ptr_cnt=mysql_query($sel_act);
	if(mysql_num_rows($ptr_cnt))
	{
		$data_cnt=mysql_fetch_array($ptr_cnt);
		?>
		mail1[<?php echo $i; ?>]='<?php echo $data_cnt['email'];?>';
		<?php
		$i++;
	}
}		
if($_SESSION['type']!='S'  && $_SESSION['type']!='Z' && $_SESSION['type']!='LD')
{
	"<br/>".$sel_act="select contact_phone,email from site_setting where type='S' and email!='' ";
	$ptr_cnt=mysql_query($sel_act);
	if(mysql_num_rows($ptr_cnt))
	{
		$j=0;
		while($data_cnt=mysql_fetch_array($ptr_cnt))
		{
			?>
			mail1[<?php echo $j; ?>]='<?php echo $data_cnt['email'];?>';
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
//alert(mail1);
function send()
{
	<?php
	if($_SESSION['']=="S")
	{
		?>
		if(document.getElementById('branch_name'))
		{
			branch =document.getElementById('branch_name');
			var branch_name=branch.options[branch.selectedIndex].text; 
		}
		else
		{
			var branch_name='';
		}
		<?php
	}
	else
	{
		?>
		var branch_name='<?php echo $_SESSION['branch_name'] ?>';
		<?php
	}
	?>
	if(document.getElementById('admission_date'))
		var admission_date =document.getElementById('admission_date').value;
	else
		var admission_date ='';
	if(document.getElementById('inst_student_id'))
		var inst_student_id =document.getElementById('inst_student_id').value;
	else
		var inst_student_id ='';
	//alert("1");
	if(document.getElementById('inquiry_date'))
		var inquiry_date=document.getElementById('inquiry_date').value;
	else
		var inquiry_date='';
	if(document.getElementById('firstname'))
		var firstname =document.getElementById('firstname').value;
	else
		var firstname ='';
	//alert('2');
	if(document.getElementById('middlename'))
		var middlename =document.getElementById('middlename').value;
	else
		var middlename ='';
	if(document.getElementById('lastname'))
		var lastname =document.getElementById('lastname').value;
	var name =firstname+" "+middlename+" "+lastname;
	if(document.getElementById('contact'))
		var contact =document.getElementById('contact').value;
	else
		var contact ='';
	if(document.getElementById('mail'))
		var mail =document.getElementById('mail').value;
	else
		var mail ='';
	if(document.getElementById('qualification'))
	{
		var m =document.getElementById('qualification');
		var qualification=m.options[m.selectedIndex].text;
	}
	else
		var qualification='';
	//alert("2");
	if(document.getElementById('username'))
		var username =document.getElementById('username').value;
	else
		var username ='';
	if(document.getElementById('pass'))
		var pass =document.getElementById('pass').value;
	else
		var pass ='';
	if(document.getElementById('photo'))
		var photo =document.getElementById('photo').value;
	else
		var photo ='';
	if(document.getElementById('address'))
		var address =document.getElementById('address').value;
	else
		var address ='';
	if(document.getElementById('per_address'))
		var per_address =document.getElementById('per_address').value;
	else
		var per_address ='';
	//alert("3");
	if(document.getElementById('dob'))
		var dob =document.getElementById('dob').value;
	else
		var dob ='';
	if(document.getElementById('source'))
	{
		src =document.getElementById('source');
		var source=src.options[src.selectedIndex].text;
	}
	else
		var source='';
	if(document.getElementById('admission_remark'))
		var admission_remark =document.getElementById('admission_remark').value;
	else 
		var admission_remark ='';
	//alert("4");
	if(document.getElementById('course_id'))
	{
		course=document.getElementById('course_id');
		var course_id=course.options[course.selectedIndex].text; 
	}
	else
		course_id='';
	var paid_type = $("input[id='paid_type']:checked").val();
	if(document.getElementById('toal_fees'))
		var toal_fees=document.getElementById('toal_fees').value;
	else
		var toal_fees='';
	if(document.getElementById('concession'))
		var concession =document.getElementById('concession').value;
	else
		var concession ='';	
	if(document.getElementById('discount_coupon'))
		var discount_coupon =document.getElementById('discount_coupon').value;
	else
		var discount_coupon ='';
	//alert("5");
	if(document.getElementById('discount_coupon_price'))
		var discount_coupon_price =document.getElementById('discount_coupon_price').value;
	else
		var discount_coupon_price ='';
	if(document.getElementById('net_fees'))
		var net_fees =document.getElementById('net_fees').value;
	else
		var net_fees ='';
	//var service_tax =document.getElementById('service_tax').value;
	if(document.getElementById('fees'))
		var fees =document.getElementById('fees').value;
	else
		var fees ='';
	//alert("6");
	if(document.getElementById('down_payment'))
		var down_payment=document.getElementById('down_payment').value;
	else
		var down_payment='';
	if(document.getElementById('down_payment_tax'))
		var down_payment_tax =document.getElementById('down_payment_tax').value;
	else
		var down_payment_tax ='';
	if(document.getElementById('down_payment_wo_tax'))
		var down_payment_wo_tax =document.getElementById('down_payment_wo_tax').value;
	else
		var down_payment_wo_tax ='';
	//alert("7");
	if(document.getElementById('installment_on'))
		var installment_on =document.getElementById('installment_on').value;
	else
		var installment_on ='';
	//alert("7");
	if(document.getElementById('dropdown'))
	{
		drop =document.getElementById('dropdown');
		var dropdown=parseInt(drop.options[drop.selectedIndex].text);
	}
	else dropdown=0;
	//alert("8");
	if(document.getElementById('credit_card_no'))
	{	
		var credit_card_no=document.getElementById('credit_card_no').value;
	}
	else credit_card_no='';
	if(document.getElementById('chaque_date'))
	{
		var chaque_date=document.getElementById('chaque_date').value;
	}
	else chaque_date='';
	//alert("9");
	if(document.getElementById('chaque_no'))
		var chaque_no =document.getElementById('chaque_no').value;
	else var chaque_no ='';
	
	if(document.getElementById('account_no'))
		var account_no =document.getElementById('account_no').value;
	else var account_no ='';
	
	if(document.getElementById('cust_bank_name'))
		var cust_bank_name =document.getElementById('cust_bank_name').value;
	else var cust_bank_name ='';
	
	if(document.getElementById('payment_type'))
	{
		drop =document.getElementById('payment_type');
		var payment_type=drop.options[drop.selectedIndex].text;
	}
	else var payment_type='';
	//alert("10");
	if(document.getElementById('final_amt'))
		var final_amt =document.getElementById('final_amt').value;
	else
		var final_amt ='';
	
	if(document.getElementById('total_amt'))
		var total_amt =document.getElementById('total_amt').value;
	else
		var total_amt ='';
	//alert("11");
	concat_string='';
	if(dropdown >0)
	{
		dates_array= new Array();
		for(t=1;t<=dropdown;t++)
		{
			var inst_val=parseInt($(".installment_inp_"+t).val());
			var inst_date=$(".date_class"+t).val();
			concat_string +='&inst_val'+t+'='+inst_val+'&inst_date'+t+'='+inst_date;
		}
	}
	//alert(concat_string);
	var users_mail=mail1;
	data1='action=enroll&branch_name='+branch_name+'&admission_date='+admission_date+'&inst_student_id='+inst_student_id+'&inquiry_date='+inquiry_date+'&name='+name+'&contact='+contact+'&mail='+mail+'&qualification='+qualification+'&username='+username+'&pass='+pass+'&photo='+photo+'&address='+address+'&per_address='+per_address+'&dob='+dob+'&source='+source+'&admission_remark='+admission_remark+'&course_id='+course_id+'&toal_fees='+toal_fees+'&concession='+concession+'&discount_coupon='+discount_coupon+'&discount_coupon_price='+discount_coupon_price+'&net_fees='+net_fees+'&fees='+fees+'&down_payment='+down_payment+'&down_payment_tax='+down_payment_tax+'&down_payment_wo_tax='+down_payment_wo_tax+'&installment_on='+installment_on+'&dropdown='+dropdown+'&cust_bank_name='+cust_bank_name+'&account_no='+account_no+'&chaque_no='+chaque_no+'&chaque_date='+chaque_date+'&credit_card_no='+credit_card_no+'&final_amt='+final_amt+'&total_amt='+total_amt+'&payment_type='+payment_type+"&users_mail="+users_mail+"&email_text_msg="+email_text_msg+concat_string;
	//alert(data1);
	$.ajax({
	url:'send_email.php',type:"post",data:data1,cache:false,crossDomain:true,async:false,
	success: function(response)
	{
		//alert(response);//http://www.htdpt.in/tracking/send_email.php
		return true;
	}
	});

	data1='action=verify_enroll&branch_name='+branch_name+'&name='+name+'&course_id='+course_id;
	$.ajax({
	url:'send_email.php',type:"post",data:data1,cache:false,async:false,
	success: function(response)
	{
	   return true;
	}
	});
}

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
			sep= retrive_func.split('##');
			var msgs=sep[0];
			var sep_disc=sep[1];
			document.getElementById("discount_coupon_per").value=sep_disc;
			setTimeout(show_record(),500);
			alert(msgs);
		}
	});
}
function show_offer_discount()
{
	frm = document.jqueryForm; 
	current_offer =frm.current_offer.value;
	if(frm.current_offer[0].checked == true) //Normal Discount
	{
	}
	if(frm.current_offer[1].checked == true) // Now Discount
	{
		var studs_id=document.getElementById('record_id').value;
		var data12="action=enroll_offer_countdown&apply_disc=now_disc&studs_id="+studs_id;
		//alert(data12);
		$.ajax({
			url: "ajax.php", type: "post", data: data12, cache: false,
			success: function (datacnt)
			{
				var countdate=datacnt.trim();
				var countd = new Date(countdate);
				var countDownDate = countd.getTime();
				// Update the count down every 1 second
				var x = setInterval(function() {
			  	// Get today's date and time
			 	var now = new Date().getTime();
			 	// Find the distance between now and the count down date
			  	var distance = countDownDate - now;		
			  	// Time calculations for days, hours, minutes and seconds
			  	var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			  	var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			  	var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			  	var seconds = Math.floor((distance % (1000 * 60)) / 1000);
			  	// Output the result in an element with id="demo"
			  	document.getElementById("countdown_offer").innerHTML = hours + " Hour "
			  	+ minutes + " Min " + seconds + " Sec "; //days + " Days " + 
			  	// If the count down is over, write some text 
			  	if (distance < 0) {
					clearInterval(x);
					document.getElementById("kit_offer").disabled = true;
					$('#reg_offer').prop('checked', true); // Checks it
					$('#kit_offer').prop('checked', false); 
					document.getElementById("countdown_offer").innerHTML = "Kit Offer is Expired";
			  	}
			}, 1000);
			//setTimeout(show_record(),500);
			//alert(msgs);
			}
		});
	}
	//var paid_type = document.getElementById('paid_type').value;
	//setTimeout(show_record(),200);
}
function show_now_discount()
{
	frm = document.jqueryForm; 
	paid_type =frm.paid_type.value;
	now_disc_type =frm.now_disc.value;
	
	var discount_otp=document.getElementById('discount_otp').value;
	var discount_inst=document.getElementById('discount_inst').value;
	var discount_now_otp=document.getElementById('discount_now_otp').value;
	var discount_now_inst=document.getElementById('discount_now_inst').value;
	var discount_otp_inst=document.getElementById('discount_otp_inst').value;
	var discount_now_otp_inst=document.getElementById('discount_now_otp_inst').value;
	
	if(frm.now_disc[0].checked == true) //Normal Discount
	{
		if(paid_type=='one_time')
		{
			document.getElementById('concession').value=discount_otp;
		}
		if(paid_type=='installments') //OTP with Installment
		{
			document.getElementById('concession').value=discount_otp_inst;
		}
		if(paid_type=='installments_zero')
		{
			document.getElementById('concession').value=discount_inst;
		}
	}
	if(frm.now_disc[1].checked == true) // Now Discount
	{
		if(paid_type=='one_time')
		{
			document.getElementById('concession').value=discount_now_otp;
		}
		if(paid_type=='installments')
		{
			document.getElementById('concession').value=discount_now_otp_inst;
		}
		if(paid_type=='installments_zero')
		{
			document.getElementById('concession').value=discount_now_inst;
		}
		var studs_id=document.getElementById('record_id').value;
		var data12="action=enrollment_disc_countdown&apply_disc=now_disc&studs_id="+studs_id;
		//alert(data12);
		$.ajax({
			url: "ajax.php", type: "post", data: data12, cache: false,
			success: function (datacnt)
			{
				var countdate=datacnt.trim();
				var countd = new Date(countdate);
				var countDownDate = countd.getTime();
				// Update the count down every 1 second
				var x = setInterval(function() {
				  // Get today's date and time
				  var now = new Date().getTime();
				  // Find the distance between now and the count down date
				  var distance = countDownDate - now;		
				  // Time calculations for days, hours, minutes and seconds
				  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
				  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
				  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
				  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
				  // Output the result in an element with id="demo"
				  document.getElementById("countdown").innerHTML = hours + " Hour "
				  + minutes + " Min " + seconds + " Sec "; //days + " Days " + 
				  // If the count down is over, write some text 
				  if (distance < 0) {
					clearInterval(x);
					 document.getElementById("now_disc").disabled = true;
					$('#normal_disc').prop('checked', true); // Checks it
					$('#now_disc').prop('checked', false); 
					document.getElementById("countdown").innerHTML = "Now Discount is Expired";
				  }
				}, 1000);
				//setTimeout(show_record(),500);
				//alert(msgs);
			}
		});
		
		
	}
	//var paid_type = document.getElementById('paid_type').value;
	setTimeout(show_record(),200);
}

function show_record(vals,no)
{    
	//alert("hi");
	frm = document.jqueryForm; 
    concession=0; 
	//paid=0;
	totals_fees=0;
	balance=0;
	//================================PAID TYPE==========================
	paid_type =frm.paid_type.value;
	now_disc_type =frm.now_disc.value;
	//alert(now_disc_type);
	
	if(document.getElementById('toal_fees') && vals !='' && no==1)
	{
		courses_fees=roundNumber(document.getElementById('toal_fees').value,3);
		document.getElementById('course_only_fee').value=courses_fees;
	}
	
	if(frm.now_disc[1].checked == true) //Now Discount
	{
		if(paid_type=='installments')
		{
			//- changes on 1/12/20
			/*var discount_inst=document.getElementById('discount_now_otp_inst').value;
			document.getElementById('concession').value=discount_inst;
			
			toatl_one_time=roundNumber(document.getElementById('course_only_fee').value,3);
			inst_tax=roundNumber(document.getElementById('inst_taxes').value,3);
			installment_charge=roundNumber(toatl_one_time*inst_tax/100,3);
			totals_charge=roundNumber(installment_charge+toatl_one_time,3);
			document.getElementById('toal_fees').value=totals_charge;
			totals_fees=roundNumber(document.getElementById('toal_fees').value,3);
			document.getElementById("dropdown").disabled  = false;
			down_fees=document.getElementById('down_payment').value;*/
			
		  	var discount_inst=document.getElementById('discount_now_otp_inst').value;
			document.getElementById('concession').value=discount_inst;
			
			totals_fees = roundNumber(document.getElementById('course_only_fee').value,3);
			document.getElementById('toal_fees').value=totals_fees;
			document.getElementById("dropdown").disabled  = true;
			down_fees=roundNumber(document.getElementById('down_payment').value,3);
			
			$("#dropdown option[value]").filter(function() {
				return +$(this).val() > 1;
		  	}).hide();
		}
		else if(paid_type=='installments_zero')
		{
			var discount_inst=document.getElementById('discount_now_inst').value;
			document.getElementById('concession').value=discount_inst;
			
			totals_fees = roundNumber(document.getElementById('course_only_fee').value,3);
			document.getElementById('toal_fees').value=totals_fees;
			document.getElementById("dropdown").disabled  = true;
			down_fees=roundNumber(document.getElementById('down_payment').value,3);
			$("#dropdown option[value]").filter(function() {
				return +$(this).val() > 1;
		  	}).show();
		}
		else
		{
			var discount_otp=document.getElementById('discount_now_otp').value;
			document.getElementById('concession').value=discount_otp;
			
			document.getElementById("dropdown").disabled  = true;
			var inst1 = document.getElementById("dropdown").disabled  = true;
			$('#dropdown').removeClass("obrderclass");  
			totals_fees = roundNumber(document.getElementById('course_only_fee').value,3);
			document.getElementById('toal_fees').value=totals_fees;
		}
	}
	else //Normal Discount
	{
		if(paid_type=='installments')
		{
			//-Changes on 1/12/20
			/*var discount_inst=document.getElementById('discount_otp_inst').value;
			document.getElementById('concession').value=discount_inst;
			
			toatl_one_time=roundNumber(document.getElementById('course_only_fee').value,3);
			inst_tax=roundNumber(document.getElementById('inst_taxes').value,3);
			installment_charge=  roundNumber(toatl_one_time*inst_tax/100,3);
			totals_charge=roundNumber(installment_charge+toatl_one_time,3);
			document.getElementById('toal_fees').value=totals_charge;
			totals_fees = roundNumber(document.getElementById('toal_fees').value,3);
			document.getElementById("dropdown").disabled  = false;
			down_fees=document.getElementById('down_payment').value;*/
			var discount_inst=document.getElementById('discount_otp_inst').value;
			document.getElementById('concession').value=discount_inst;
			
			totals_fees = roundNumber(document.getElementById('course_only_fee').value,3);
			document.getElementById('toal_fees').value=totals_fees;
			document.getElementById("dropdown").disabled  = true;
			down_fees=roundNumber(document.getElementById('down_payment').value,3);
			
			$("#dropdown option[value]").filter(function() {
				return +$(this).val() > 1;
		  	}).hide();
		}
		else if(paid_type=='installments_zero')
		{
			var discount_inst=document.getElementById('discount_inst').value;
			document.getElementById('concession').value=discount_inst;
			
			totals_fees = roundNumber(document.getElementById('course_only_fee').value,3);
			document.getElementById('toal_fees').value=totals_fees;
			document.getElementById("dropdown").disabled  = true;
			down_fees=roundNumber(document.getElementById('down_payment').value,3);
			$("#dropdown option[value]").filter(function() {
				return +$(this).val() > 1;
		  	}).show();
		}
		else
		{
			var discount_otp=document.getElementById('discount_otp').value;
			document.getElementById('concession').value=discount_otp;
			
			document.getElementById("dropdown").disabled  = true;
			var inst1 = document.getElementById("dropdown").disabled  = true;
			$('#dropdown').removeClass("obrderclass");  
			totals_fees = roundNumber(document.getElementById('course_only_fee').value,3);
			document.getElementById('toal_fees').value=totals_fees;
		}
	}
	//alert("Total Fees - "+totals_fees);
	//===================================================================
	 // paid = document.getElementById('paid').value;
	concession = roundNumber(document.getElementById('concession').value,3);
	//$('#dropdown').prop('selectedIndex',0);
	//$("#textboxDiv").html('');
	//alert("concession - "+concession);
	disc_type =frm.discount_type.value;
	//alert(disc_type);
	if(disc_type!='cash')
	{
		if(concession !='' || concession !=0 || concession<=100 )
		concession=  roundNumber(totals_fees * concession/100,3);
	}
	if(concession !='' || concession <= totals_fees)
	{
		total_bal_ava= roundNumber(totals_fees - concession,3);
	}
	else
	{
		concession=0;
		total_bal_ava= roundNumber(totals_fees - concession,3);
	}
	document.getElementById('net_fees').value=total_bal_ava;
	//alert("net fees- "+total_bal_ava);
	//document.getElementById('balance').value=total_bal_ava;
	var coupon_disc=document.getElementById("discount_coupon_per").value;
	var local = coupon_disc;
  	//alert(local);
	//disc_amount=disc_amt;
	if(local > 0)
	{
		var disc_perc= roundNumber(local*total_bal_ava/100,3);
		var total_disc_coupon= roundNumber(total_bal_ava - disc_perc,3);
		document.getElementById('net_fees').value=total_disc_coupon;
		document.getElementById('discount_coupon_price').value=local;
		//alert(total_disc_coupon);
	}
	var net_fees=roundNumber(document.getElementById('net_fees').value,3);
	
	/*var service_tax=parseFloat(document.getElementById('service_taxes').value);
	var new_tax=parseFloat((service_tax+100)/100);
	var taxable_value = parseInt(net_fees / new_tax);
	var tax =parseInt(net_fees - taxable_value);
	document.getElementById('service_tax').value=tax;*/
	
	//=========================For Service Tax==================================
	/*var service_tax=parseFloat(document.getElementById('service_taxes').value);
	var new_tax=parseFloat((service_tax+100)/100);
	var taxable_value = parseInt(net_fees / new_tax);
	var tax =parseInt(net_fees - taxable_value);
	document.getElementById('service_tax').value=tax;*/
	//==============================-------------===============================
	//==============================For CGST==================================== 
	//07/05/2020 kiran change GST calculation Formulae
	/*var cgst=parseFloat(document.getElementById('cgst_taxes').value);
	var new_cgst_tax=parseFloat((cgst+100)/100);
	var cgst_taxable_value = parseInt(net_fees / new_cgst_tax);
	var cgast_tax =parseInt(net_fees - cgst_taxable_value);
	document.getElementById('cgst_tax').value=cgast_tax;
	
	//==============================For SGST====================================
	var sgst=parseFloat(document.getElementById('sgst_taxes').value);
	var new_sgst_tax=parseFloat((sgst+100)/100);
	var sgst_taxable_value = parseInt(net_fees / new_sgst_tax);
	var sgast_tax =parseInt(net_fees - sgst_taxable_value);
	document.getElementById('sgst_tax').value=sgast_tax;*/
	
	//===================== FOR GST CALCULATION - 07-05-2020 by kiran ======================
	<?php
	if($_SESSION['tax_type']=='GST')
	{
		?>
		var cgst=roundNumber(document.getElementById('cgst_taxes').value,3);
		var sgst=roundNumber(document.getElementById('sgst_taxes').value,3);
		var total_gst_per = roundNumber(cgst + sgst,2);
		
		var GST_Amount = roundNumber(net_fees * total_gst_per /(100 + total_gst_per),3);
		var Original_Cost = roundNumber( net_fees * 100/(100 + total_gst_per) ,3);
		
		var total_gst_tax= roundNumber(GST_Amount / 2,3);
		//alert(roundNumber(total_gst_tax , 2));
		document.getElementById('cgst_tax').value=roundNumber(total_gst_tax,3);
		document.getElementById('sgst_tax').value=roundNumber(total_gst_tax,3);
		<?php
	}
	else
	{
		?>
		var service_tax=roundNumber(document.getElementById('service_taxes').value,3);
		var total_gst_per = service_tax;
		//alert("Serv Tax - "+service_tax);
		var GST_Amount = roundNumber(net_fees * total_gst_per /(100 + total_gst_per),3);
		var Original_Cost = roundNumber( net_fees * 100/(100 + total_gst_per) ,3);
		var total_gst_tax= GST_Amount;
		
		document.getElementById('service_tax').value=total_gst_tax;
		<?php
	}
	?>
	//=========================================================================
	//var new_tax=parseFloat(new_cgst_tax)+parseFloat(new_sgst_tax);
	//total_taxes=cgast_tax+sgast_tax;
	
	//var total = parseInt(net_fees - total_taxes);
	
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
	var down_payment =roundNumber( document.getElementById('down_payment').value,3);

	//=======================For Down Payment CGST==============================
	/*var down_cgst_taxable_value = parseInt(down_payment / new_cgst_tax);
	var down_cgast_tax =parseInt(down_payment - down_cgst_taxable_value);
	document.getElementById('down_cgst_tax').value=down_cgast_tax;
	//=========================For Down Payment SGST============================
	var down_sgst_taxable_value = parseInt(down_payment / new_sgst_tax);
	var down_sgast_tax =parseInt(down_payment - down_sgst_taxable_value);
	document.getElementById('down_sgst_tax').value=down_sgast_tax;*/
	
	//================ FOR GST CALCULATION - 07-05-2020 by kiran ===============
	var Down_GST_Amount = roundNumber(down_payment * total_gst_per /(100 + total_gst_per),3);
    var Down_Pay_Original_Cost = roundNumber(down_payment * 100/(100 + total_gst_per),3);
	
	var total_down_gst_tax=roundNumber(Down_GST_Amount / 2,3);
	
	<?php
	if($_SESSION['tax_type']=='GST')
	{
		?>
		document.getElementById('down_cgst_tax').value=total_down_gst_tax;
		document.getElementById('down_sgst_tax').value=total_down_gst_tax;
		<?php
	}
	else
	{
		?>
		document.getElementById('down_payment_tax').value=total_down_gst_tax;
		<?php
	}
	?>	
	
	//=========================================================
	total_f= roundNumber(net_fees - down_payment,3);
	//document.getElementById('down_payment_tax').value=dp_tax;
	/*down_total_taxes=down_cgast_tax+down_sgast_tax;////23-9-17
	var total_downpay = parseInt(down_payment - down_total_taxes);*/
	document.getElementById('down_payment_wo_tax').value=Down_Pay_Original_Cost;
	document.getElementById('installment_on').value=total_f;

	document.getElementById('final_amt').value=total_f;
	if(total_f==0 || paid_type =='one_time')
	{
		var inst1 = document.getElementById("dropdown").disabled  = true;
		$('#dropdown').removeClass("obrderclass");
		$("#textboxDiv").html('');
		//alert(total_f);
	}
	else if(total_f !=0 && (paid_type =='installment_zero' || paid_type =='installment'))
	{
		var inst1 = document.getElementById("dropdown").disabled  = true;
		$('#dropdown').removeClass("obrderclass");  
		$("#textboxDiv").html('');
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
function show_bank(branch_id,vals)
{
	//============================================================
	var res = branch_id.substring(0, 3);
	var d = new Date();
	var n = d.getFullYear();
	var branch=res.toUpperCase();
	var add =branch;
	var display_id=document.getElementById("inst_student_id").value;
	var res_str = display_id.substring(5,8);
	stud_id=display_id.replace(res_str,add);
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
			cgst=taxes[2];
			sgst=taxes[3];
			
			<?php
			if($_SESSION['tax_type']=='GST')
			{
				?>
				document.getElementById("cgst_id").innerHTML=cgst;
				document.getElementById("sgst_id").innerHTML=sgst;
				document.getElementById("down_cgst_id").innerHTML=cgst;
				document.getElementById("down_sgst_id").innerHTML=sgst;
				
				document.getElementById("cgst_taxes").value=cgst;
				document.getElementById("sgst_taxes").value=sgst;
				document.getElementById("down_cgst_taxes").value=cgst;
				document.getElementById("down_sgst_taxes").value=sgst;
				<?php
			}
			else
			{
				?>
				//alert(service_tax);
				document.getElementById("down_service_id").innerHTML=service_tax;
				document.getElementById("service_tax_id").innerHTML=service_tax;
				document.getElementById("service_taxes").value=service_tax;
				document.getElementById("down_service_taxes").value=service_tax;
				//document.getElementById("inst_tax_id").innerHTML=installment_tax;
				<?php
			}
			?>
			document.getElementById("inst_taxes").value=installment_tax;
			
			
			//course_id1 =document.getElementById("course_id").value;
			//alert(document.getElementById("service_taxes").value);
			
			/*if(course_id1 !='')
			{
				show_course(course_id1);
				
			}*/
		}
	});
	show_staff(branch_id,admin_id);
}
function show_staff(branch_id,admin_id)
{
	var record_id= document.getElementById("record_id").value;
	var bank_data="action=enrollment&branch_id="+branch_id+"&record_id="+record_id+"&admin_id="+admin_id;
	$.ajax({
	url: "show_councellor.php",type:"post", data: bank_data,cache: false,
	success: function(retbank)
	{
		//alert(retbank);
		document.getElementById("employee_id").innerHTML=retbank;
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
	var branch_name=document.getElementById("branch_name").value;
	if(payment_mode[0]=="cheque")
	{
		document.getElementById("bank_ref_no").style.display = 'none';
		document.getElementById("chaque_details").style.display = 'block';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		
		show_bank(branch_name,"cheque")
	}
	else if(payment_mode[0]=="Credit Card")
	{
		document.getElementById("bank_ref_no").style.display = 'none';
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'block';
		show_bank(branch_name,"credit_card")
		
	}
	else if(payment_mode[0]=="paytm")
	{
		document.getElementById("bank_ref_no").style.display = 'none';
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
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
	else if(payment_mode[0]=="CF Loan")
	{
		document.getElementById("bank_ref_no").style.display = 'block';
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		show_bank(branch_name,"CF Loan")
	}
	else
	{
		document.getElementById("bank_ref_no").style.display = 'none';
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'none';
		document.getElementById("credit_details").style.display = 'none';
		show_bank(branch_name,"")
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
            $.post('coupon_check.php', { discount_coupon: document.getElementById("discount_coupon").value },
            function(result){
                $('#coupon').html(result).show();
            });
        });
		//jqueryForm.discount_coupon.value 
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
	document.getElementById('hide_btns').style.display ='none';
	/*if(frm.admission_date.value=='')
	{
		disp_error +='Enter Admission date\n';
		document.getElementById('admission_date').style.border = '1px solid #f00';
		frm.admission_date.focus();
		error='yes';
	}*/
	if(frm.firstname.value=='')
	{
		disp_error +='Enter Firstname\n';
		document.getElementById('firstname').style.border = '1px solid #f00';
		frm.firstname.focus();
		error='yes';
	}
	if(frm.lastname.value=='')
	{
		disp_error +='Enter lastname\n';
		document.getElementById('lastname').style.border = '1px solid #f00';
		frm.lastname.focus();
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
	//total11=parseInt(document.getElementById('fees').value);
	total11=parseInt(document.getElementById('net_fees').value);
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
			else if(payment_types =='online')
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
				if(frm.ref_no_bank.value=='')
				{
					disp_error +='Enter Reference no. \n';
					error='yes';
					document.getElementById('ref_no_bank').style.border = '1px solid #f00';
					frm.ref_no_bank.focus();
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
function select_area(city_id)
{
	//alert('hi');
	var state_id=document.getElementById("state").value;
	//alert(state_id);
	var area_data="action=area&city_id="+city_id+"&state_id="+state_id;
	$.ajax({
	url: "ajax_state_city.php",type:"post", data: area_data,cache: false,
	success: function(retcity)
	{
		//alert(retbank);
		document.getElementById("show_area").innerHTML=retcity;
		$("#area").chosen({allow_single_deselect:true});
	}
	});
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
                if(isset($_POST['save_changes']) && $_POST['randcheck']==$_SESSION['rand'])
                {
					$sac_code=($_POST['sac_code']) ? $_POST['sac_code'] : "";
					$firstname=(true== isset($_POST['firstname'])) ? $_POST['firstname'] : "";
					$middlename=(true== isset($_POST['middlename'])) ? $_POST['middlename'] : "";
					$lastname=(true== isset($_POST['lastname'])) ? $_POST['lastname'] : "";
					$name=$firstname." ".$middlename." ".$lastname;
					$country=(true== isset($_POST['country'])) ? $_POST['country'] : "";
					$state=(true== isset($_POST['state'])) ? $_POST['state'] : "";
					$city=(true== isset($_POST['city'])) ? $_POST['city'] : "";
					$area=(true== isset($_POST['area'])) ? $_POST['area'] : "";
					$religion=(true== isset($_POST['religion'])) ? $_POST['religion'] : "";
					$username=(true== isset($_POST['username'])) ? $_POST['username'] : "";
					$pass=(true== isset($_POST['pass'])) ? $_POST['pass'] : "";
					$tan_date=explode('/',$_POST['dob'],3);
					$dob=$tan_date[2].'-'.$tan_date[1].'-'.$tan_date[0];
					$dob1=(true== isset($_POST['dob'])) ? $_POST['dob'] : "";
					$batch_id=(true== isset($_POST['batch_id'])) ? $_POST['batch_id'] : "0";
					$address=(true== isset($_POST['address'])) ? $_POST['address'] : "";
					$per_address=(true== isset($_POST['per_address'])) ? $_POST['per_address'] : "";
					$contact=(true== isset($_POST['contact'])) ? $_POST['contact'] : "";
					$contact_home=(true== isset($_POST['home_contact'])) ? $_POST['home_contact'] : "";
					$mail=(true== isset($_POST['mail'])) ? $_POST['mail'] : "";
					$qualification=(true== isset($_POST['qualification'])) ? $_POST['qualification'] : "";
					$photo=(true== isset($_POST['photo'])) ? $_POST['photo'] : "";
					$inst_student_id=(true== isset($_POST['inst_student_id'])) ? $_POST['inst_student_id'] : "0";
					if($_POST['inquiry_date'] !='') {
						$inquiry_date=(true== isset($_POST['inquiry_date'])) ? $_POST['inquiry_date'] : "";
						$inqtan_date=explode('/',$_POST['inquiry_date'],3);
						$inquiry_date=$inqtan_date[2].'-'.$inqtan_date[1].'-'.$inqtan_date[0];
					}
					else
						$inquiry_date='';
					$paid_type=( true== isset($_POST['paid_type'])) ? $_POST['paid_type'] : "";
					$source=( true== isset($_POST['source'])) ? $_POST['source'] : "";
					$admission_remark=( true== isset($_POST['admission_remark'])) ? $_POST['admission_remark'] : "";
					$course=( true== isset($_POST['course_id'])) ? $_POST['course_id'] : "0";
					$customised_course=( true== isset($_POST['customised_course'])) ? $_POST['customised_course'] : "0";
					if($course =='custome')
						$course=$customised_course;
					if($_POST['admission_date'] !='') 
					{
						$admission_date=( true== isset($_POST['admission_date'])) ? $_POST['admission_date'] : "";
						$adtan_date = explode('/',$admission_date);
						$admission_date=$adtan_date[2].'-'.$adtan_date[1].'-'.$adtan_date[0];
					}
					else
						$admission_date='';
					$course_fees=( true== isset($_POST['total_fees'])) ? $_POST['total_fees'] : "0";
					$discount_coupon_code=( true== isset($_POST['discount_coupon'])) ? $_POST['discount_coupon'] : "";
					$discount_coupon_price=( true== isset($_POST['discount_coupon_price'])) ? $_POST['discount_coupon_price'] : "0";
					$current_discount_type=( true== isset($_POST['now_disc'])) ? $_POST['now_disc'] : "";
					$discount=( true== isset($_POST['concession'])) ? $_POST['concession'] : "0";	
					$discount_type=( true== isset($_POST['discount_type'])) ? $_POST['discount_type'] : "";	
					$paid=( true== isset($_POST['down_payment'])) ? $_POST['down_payment'] : "0";	
					$down_payment_tax=( true== isset($_POST['down_payment_tax'])) ? $_POST['down_payment_tax'] : "";	
					$down_payment_wo_tax=( true== isset($_POST['down_payment_wo_tax'])) ? $_POST['down_payment_wo_tax'] : "";	
					
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
							$chaque_date= $_POST['chaque_date'];
							$tan_date = explode('/',$chaque_date);
							$chaque_date=$tan_date[2].'-'.$tan_date[1].'-'.$tan_date[0];
							$chaque_date=( ($chaque_date)) ? $chaque_date : "";	
							$credit_card_no=( ($_POST['credit_card_no'])) ? $_POST['credit_card_no'] : "";		
							$bank_ref_no=($_POST['bank_ref_no']) ? $_POST['bank_ref_no'] : "";	
						}
					}
					
					$installment_on=( true== isset($_POST['installment_on'])) ? $_POST['installment_on'] : "0";
					$net_fees=( true== isset($_POST['net_fees'])) ? $_POST['net_fees'] : "0";
					$total_fees=( true== isset($_POST['total_fees'])) ? $_POST['total_fees'] : "0";
					$cust_gst_no=( true== isset($_POST['cust_gst_no'])) ? $_POST['cust_gst_no'] : "0";	
					$cgst_tax= ($_POST['cgst_tax']) ? $_POST['cgst_tax'] : '0' ;
					$cgst_tax_in_per= ($_POST['cgst_taxes']) ? $_POST['cgst_taxes'] : "0";
					$sgst_tax=( $_POST['sgst_tax'] ) ? $_POST['sgst_tax'] : "";
					$sgst_tax_in_per= ( $_POST['sgst_taxes'] ) ? $_POST['sgst_taxes'] : "0";
					$down_cgst_tax= ($_POST['down_cgst_tax']) ? $_POST['down_cgst_tax'] : '0' ;
					$down_cgst_tax_in_per= ($_POST['down_cgst_taxes']) ? $_POST['down_cgst_taxes'] : "0";
					$down_sgst_tax=( $_POST['down_sgst_tax'] ) ? $_POST['down_sgst_tax'] : "";
					$down_sgst_tax_in_per= ( $_POST['down_sgst_taxes'] ) ? $_POST['down_sgst_taxes'] : "0";
					$service_tax=( true== isset($_POST['service_tax'])) ? $_POST['service_tax'] : "0";
					$service_taxes_in_per=( true== isset($_POST['service_taxes'])) ? $_POST['service_taxes'] : "0";
					$down_payment=( true== isset($_POST['down_payment'])) ? $_POST['down_payment'] : "0";
					$down_service_taxes=( true== isset($_POST['down_service_tax'])) ? $_POST['down_service_tax'] : "0";
					$down_payment_tax=( true== isset($_POST['down_payment_tax'])) ? $_POST['down_payment_tax'] : "0";
					$down_payment_wo_tax=( true== isset($_POST['down_payment_wo_tax'])) ? $_POST['down_payment_wo_tax'] : "0";
					$first_installment=( true== isset($_POST['numDep'])) ? $_POST['numDep'] : "0";
					$branch_name=( true== isset($_POST['branch_name'])) ? $_POST['branch_name'] : "";
					$final_amt=( true== isset($_POST['final_amt'])) ? $_POST['final_amt'] : "";
					$cm_id=( true== isset($_POST['cm_id'])) ? $_POST['cm_id'] : "";
					$employee_id=($_POST['employee_id']) ? $_POST['employee_id'] : '' ;
					$current_offer = ($_POST['current_offer']) ? $_POST['current_offer'] : '' ;
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
						$dob=$tan_date[2].'-'.$tan_date[1].'-'.$tan_date[0];
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
						if(!preg_match('/^([0-9]{8,15})+$/iD',$contact))
						{
							$success=0;
                          	$errors[$i++]="Invalid Contact No. 8 to 15 digit allowed";
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
							$data_record['sac_code']=$sac_code;
							$data_record['name']=ucwords(strtolower($name));
                            $data_record['username'] =$username;
                            $data_record['pass'] =$pass;
                            $data_record['dob'] =$dob;
							$data_record['address'] =$address;
							$data_record['permanant_address'] =$per_address;
							$data_record['country_id'] =$country;
							$data_record['state_id'] =$state;
							$data_record['city_id'] =$city;
							$data_record['area_id'] =$area;
							$data_record['religion'] =$religion;
                            $data_record['contact'] =$contact;
							$data_record['contact_home'] =$contact_home;
                            $data_record['mail'] = $mail;
						    $data_record['qualification']=$qualification;
							$data_record['admission_date']=$admission_date;
							$data_record['batch_id'] =$_POST['batch_id'];
							$data_record['student_id']=$_REQUEST['record_id'];
							$data_record['invoice_no']=$largestInvoiceNumber;
							$data_record['inquiry_date']=$inquiry_date;
							$data_record['paid_type']=$paid_type;
							$data_record['source']=$source;
							$data_record['admission_remark']=$admission_remark;
                            $data_record['course_id']=$course;
                            $data_record['course_fees']=$course_fees;
							$data_record['discount_coupon_code']=$discount_coupon_code;
							$data_record['discount_coupon_price']=$discount_coupon_price;
							$data_record['current_discount_type']=$current_discount_type;
							$data_record['discount']=$discount;
                            $data_record['discount_type']=$discount_type;
							$data_record['paid']=$paid;
							$data_record['installment_on']=$installment_on;
                            $data_record['net_fees']=$net_fees;
							$data_record['total_fees']=$total_fees;
							$data_record['service_taxes_in_percent']=$service_taxes_in_per;
							$data_record['service_tax']=$service_taxes_in_per;
						    $data_record['service_tax']=$service_tax;
						   	$data_record['cgst_tax']=$cgst_tax;
							$data_record['sgst_tax']=$sgst_tax;
							$data_record['cgst_tax_in_percent']=$cgst_tax_in_per;
							$data_record['sgst_tax_in_percent']=$sgst_tax_in_per;
							
                            $data_record['down_payment']=$down_payment;
							$data_record['down_payment_tax'] = $down_payment_tax;
							$data_record['down_payment_wo_tax'] =$down_payment_wo_tax;
							$data_record['no_of_installment']=$first_installment;
							$data_record['balance_amt']=$final_amt;
							$data_record['status']='Enrolled';
							$data_record['course_status']='not_started';
							$data_record_en['status']='Enrolled';
							$data_record['admin_id']=$_SESSION['admin_id'];
							$data_record['inquiry_added_by']=$row_record['admin_id'];
							$data_record['assigned_to']= $employee_id;
							$data_record['current_offer']=$current_offer;
							
							//===============================CM ID for Super Admin===============
							
							if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
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
							$data_record_invoice['bank_ref_no']=$bank_ref_no;
							$data_record_invoice['chaque_date']=$chaque_date;	
							$data_record_invoice['online_transc_details']='';
							$data_record_invoice['amount']=$down_payment;
							$data_record_invoice['balance_amt']=$final_amt;
							$data_record_invoice['paid_type']=$payment_type;
							$data_record_invoice['added_date']=$admission_date;
							$data_record_invoice['cust_bank_name']=$cust_bank_name;
							$data_record_invoice['type']="down_payment";
							$data_record_invoice['cgst_tax']=$down_cgst_tax;
							$data_record_invoice['sgst_tax']=$down_sgst_tax;
							$data_record_invoice['service_taxes_in_percent']=$down_service_taxes;
							$data_record_invoice['service_tax']=$down_payment_tax;
							$data_record_invoice['total_paid_gst']=intval($down_cgst_tax+$down_sgst_tax);
							$data_record_invoice['cgst_tax_in_per']=$down_cgst_tax_in_per;
							$data_record_invoice['sgst_tax_in_per']=$down_sgst_tax_in_per;
							if($file_uploaded)
							$data_record['photo'] = $uploaded_url;
							$data_record_invoice['assigned_to']= $employee_id;
                            if($record_id)
                            {
                                $data_record['added_date'] = $admission_date;
								$select_exit_rec = " select enroll_id from enrollment where name='".$data_record['name']."' and username='$username' and course_id='$course'  ";
								$ptr_exist = mysql_query($select_exit_rec);
								if(!mysql_num_rows($ptr_exist))
								{
									$chk_exist_student_logn = " select stud_login_id from stud_login where username='$username' and pass='$pass' ";
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
									$data_record['action_status']= "not_verify";
									$data_record['installment_display_id']=$inst_student_id;
								
									//==============Update Invoice No.=====================
									$sel_inv="select ext_invoice_no from enrollment where cm_id='".$data_record_invoice['cm_id']."' and ext_invoice_no IS NOT NULL order by enroll_id desc limit 0,1";
									$ptr_inv=mysql_query($sel_inv);
									$data_inv=mysql_fetch_array($ptr_inv);
									
									$recp=explode("/",$data_inv['ext_invoice_no']);
									$inv_no=intval($recp[2])+1;
									$preinv=$recp[0].'/'.$recp[1].'/'.$inv_no;
									$data_record['ext_invoice_no']=$preinv;
									//======================================================
									
									$courses_id=$db->query_insert("enrollment", $data_record);  
									$student_id= mysql_insert_id();
									
									$year= date('Y');
									$month=date('M');
									$array = array('ISAS', $year,$month,$student_id);
									$comma_separated = implode("/", $array);
									
									$update_enroll_id=" update enrollment set installment_display_id='".$inst_student_id."' where enroll_id='".$student_id."' ";
									$updt_id=mysql_query($update_enroll_id);	
									$data_record_invoice['enroll_id']=$student_id;
									/*if($payment_type_val=="online")
									$data_record_invoice['status']='pending';
									else*/
									$data_record_invoice['status']='paid';
									//======================Update Receipt no===========
									$sel_recpt="select receipt_no from invoice where cm_id='".$data_record_invoice['cm_id']."' and receipt_no IS NOT NULL order by invoice_id desc limit 0,1";
									$ptr_recpt=mysql_query($sel_recpt);
									$data_receipt=mysql_fetch_array($ptr_recpt);
									
									$recp=explode("-",$data_receipt['receipt_no']);
									$recpt_no=intval($recp[1])+1;
									$pre=$recp[0].'-';
									$data_record_invoice['receipt_no']=$pre.$recpt_no;
									//==================================================
									$student_id_in=$db->query_insert("invoice", $data_record_invoice); 
									
									if($payment_type=='2' || $payment_type=='4' || $payment_type=='5')
									{
										$bank="INSERT INTO `bank_records`(`bank_id`, `type`, `record_id`,`invoice_id`, `amount`, `added_date`, `cm_id`, `admin_id`) VALUES ('".$bank_name."','enrollment','".$student_id."','".$student_id_in."','".$down_payment."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
										$bank_query=mysql_query($bank);  
									}
									
									$where_record="student_id='".$record_id."'";                                
									$db->query_update("stud_regi", $data_record_en,$where_record); 
									
									$data_record_enq['status']='Enrolled';
									$where_recordq="inquiry_id='".$row_record['inquiry_id']."'"; 
									$db->query_update("inquiry", $data_record_enq,$where_recordq); 
									
									$where_record_inv="enroll_id='". $student_id."'";
									$data_record_inv['invoice_no']=$student_id_in;
									$db->query_update("enrollment", $data_record_inv,$where_record_inv);
									
									if($data_record['no_of_installment'] !=0)
									{
										for($i=1;$i<=$data_record['no_of_installment'];$i++)
										{
											$installment_date='';
											if($_POST['installments'][$i-1] !='')
											{
												$sep_date =  explode('/',$_POST['installment_date'][$i-1]);
												
												$installment_date = $sep_date[2].'-'.$sep_date[1].'-'.$sep_date[0];
												$insert_query = "insert into installment(enroll_id, course_id, installment_amount, installment_date, status,installment_display_id, invoice_id,cm_id) values('".$student_id."','".$data_record['course_id']."','".$_POST['installments'][$i-1]."','".$installment_date."','not paid','".$inst_student_id."','".$student_id_in."','".$data_record['cm_id']."') ";
												$insert_ptr = mysql_query($insert_query);
												///============ Installment Histroy insert====================
	
												$insert_query2 = "insert into installment_history(enroll_id, course_id, installment_amount, installment_date, status,installment_display_id, invoice_id,cm_id) values('".$student_id."','".$data_record['course_id']."','".$_POST['installments'][$i-1]."','".$installment_date."','not paid','".$inst_student_id."','".$student_id_in."','".$data_record['cm_id']."') ";
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
								"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('enrollment','Add','".$name."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
								$query=mysql_query($insert);
								
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
								$sele_course_name="select course_name,course_description from courses where course_id='$course'";
								$ptr_course_name=mysql_query($sele_course_name);
								$data_course_name=mysql_fetch_array($ptr_course_name);
								$course_name=$data_course_name['course_name'];
								$duration_studies=$data_course_name['course_description'];
								//================================================MAIL SENT==========================================
								/*------------send a mail to admin about this---------------------*/
                                               /* $subject = "Enrollment from ".$name." on ".$GLOBALS['domainName']."";
                                                $message .= '
                                                <table cellpadding="3" align="left" cellspacing="3" width="75%">
												 <tr>
                                                    <td width="35%"><strong>Name</strong></td>
                                                    <td>:</td>
                                                    <td width="65%">'.$name.'</td>
                                                </tr>';
												if($dob)
												{
													$message.= '
													<tr>
														<td><strong>Birth Date</strong></td>
														<td>:</td>
														<td>'.$dob.'<td>
													</tr>';
												}
												if($address)
												{
													$message.= '
													<tr>
														<td><strong>Address</strong></td>
														<td>:</td>
														<td>'.$address.'</td>
													</tr>';
												}
												if($per_address)
												{
                                                $message.= '
                                                <tr>
                                                    <td><strong>Permanant Address</strong></td>
                                                    <td>:</td>
                                                    <td>'.$per_address.'</td>
                                                </tr>';
												}
												if($contact)
												{
													$message.= '
													<tr>
														<td><strong>Mobile1</strong></td>
														<td>:</td>
														<td>'.$contact.'</td>
													</tr>';
												}
												if($mail)
												{
													$message.= '
													<tr>
														<td><strong>Email</strong></td>
														<td>:</td>
														<td>'.$mail.'</td>
													</tr>';
												}
												if($qualification)
												{
													$message.= '
													<tr>
														<td><strong>Education</strong></td>
														<td>:</td>
														<td>'.$qualification.'</td>
													</tr>';
												}
												if($course_name)
												{
													$message.= '
													<tr>
														<td><strong>Course Interested</strong></td>
														<td>:</td>
														<td>'.$course_name.'</td>
													</tr>';
												}
												if($data_record['added_date'])
												{
													$message.= '
													<tr>
														<td><strong>Enquiry Date</strong></td>
														<td>:</td>
														<td>'.$data_record['added_date'].'</td>
													</tr>';
												}
												if($duration_studies)
												{
													$message.= '
													<tr>
														<td><strong>Duration For Studies</strong></td>
														<td>:</td>
														<td>'.$duration_studies.'</td>
													</tr>';
												}
												if($course_fees)
												{
													$message.= '
													<tr>
														<td><strong>Course Fees</strong></td>
														<td>:</td>
														<td>'.$course_fees.'</td>
													</tr>';
												}
												if($discount)
												{
													$message.= '
													<tr>
														<td><strong>Discount in '.$discount_type.' </strong></td>
														<td>:</td>
														<td>'.$discount.'</td>
													</tr>';
												}
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
												*/
													/*$sendMessage=$GLOBALS['box_message_top'];
													$sendMessage.=$message;
													$sendMessage.=$GLOBALS['box_message_bottom'];
													$from_id='support<support@'.$GLOBALS['domainName'].'>';
													$headers= 'MIME-Version: 1.0' . "\n";
													$headers.='Content-type: text/html; charset=utf-8' . "\n";
													$headers.='From:'.$from_id;
													//echo $to.$sendMessage;
													if($_SERVER['HTTP_HOST']!="localhost" && $_SERVER['HTTP_HOST']!="localhost:81")//|| $_SERVER['HTTP_HOST']=="hindavi-1"
   													{*/
														/*$select_email_id = " select email from site_setting where (cm_id='".$_SESSION['cm_id']."' or admin_id='".$_SESSION['admin_id']."' or branch_name='".$branch_name1."') and (type='A' or type='C' or type='B') and email !='' ";
														$ptr_emails = mysql_query($select_email_id);
														while($data_emails = mysql_fetch_array($ptr_emails))
														{
															mail($data_emails['email'], $subject, $sendMessage, $headers);
														}
														
														$select_id="select module_type_id,sms_text from module_types where module_types ='Enquiry'";
														$ptr_sel=mysql_query($select_id);*/
														/*if(mysql_num_rows($ptr_sel))
														{
															$data_module=mysql_fetch_array($ptr_sel);
															$select_email_id = " select module_type_id from sms_mail_configuration_map where id !='".$data_module['module_type_id']."' ".$_SESSION['where']."";
															$ptr_emails = mysql_query($select_email_id);
															while($data_emails = mysql_fetch_array($ptr_emails))
															{
																$sel_mail="select email_id from sms_mail_configuration where id='".$data_emails['module_type_id']."' and status='active' ";
																$ptr_mail_id=mysql_query($sel_mail);
																$data_mail_ids=mysql_fetch_array($ptr_mail_id);
																
																$mail->addAddress($data_mail_ids['email_id']); 
																$mail->WordWrap = 50;
																$mail->isHTML(true); 
																 
																$mail->Subject = $subject;
																$mail->Body    = $sendMessage;
																
																/*if($mail->send())
																{
																	echo '<br/>email sent to '.$data_mail_ids['email_id'].'';	
																}
																else
																{ 
																	//echo '<br/>Error in sending email ';
																}*/
																//mail($data_emails['email'], $subject, $sendMessage, $headers);
															/*}
														}*/
														//==============END================
														//==================== EMAIL to councellor======================================
														/*$select_counc_email_id="select email from site_setting where cm_id='".$_SESSION['cm_id']."' and type='C' and email !='' ";
														$ptr_counc_emails = mysql_query($select_counc_email_id);
														while($data_counc_emails = mysql_fetch_array($ptr_counc_emails))
														{
															mail($data_counc_emails['email_id'], $subject, $sendMessage, $headers);
														}*/
														
														//================================Mail Send==============================================
														/*$subject_thanks="Congratulatation! your enrollment with isasbeautyschool is successful. ";
														$thanks_msg ="Thannk you $name for choosing ".$GLOBALS['domainName']." <br />Enrollment successfully. <br /><br /> ";
														$thanks_msg =$GLOBALS['box_message_top'].$thanks_msg.$GLOBALS['box_message_bottom'];
														//mail($mail,$subject_thanks,$thanks_msg,$headers);
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
														$headers.='From:'.$from_id;*/
														
														//mail($invoice_to, $invoice_subject, $sendMessage, $headers);
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
								//}
 		                         
								//====================================END MAIL SENT======================================

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
									$address="International School of Aesthetics and Spa, 2nd Floor, The Greens,North Main Road, Koregoan Park, Pune-411001";
								}
								else if($branch_name1=="Ahmedabad")
								{
									$address="International School of Aesthetics and Spa, First Floor, Zodiac Plaza,Near Nabard Flat, H.L. Comm. College Road, Navrangpura, Ahmedabad- 380 009.Tel No-:079-26300007.";
								}
								else if($branch_name1=="Baramati")
								{
									$address="International School of Aesthetics and Spa, Baramati, Email :learn@isasbeautyschool.com";
								}
								
								$search_by= array("student_name", "course_name", "branch_name", "mobile_no","address");
								$replace_by = array($name, $data_course_name['course_name'], $branch_name1, $staff_contact,$address);
								"<br/>".$messagessss = str_replace($search_by, $replace_by, $messagessss);
								$messagessss =urlencode($messagessss);
								
								$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='40' ".$_SESSION['where']."";
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
								if($_SESSION['type']!='S'  && $_SESSION['type']!='Z' && $_SESSION['type']!='LD')
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
								
								
								//send_sms_function($contact,$messagessss); //SMS off for student on 15/9/20
								
								$insert_sms="insert into sms_log_history (`name`,`mobile_no`,`sms_text`,`sms_type`,`admin_id`,`cm_id`,`added_date`) values('".$name."','".$contact."','".$messagessss."','enrollment','".$_SESSION['admin_id']."','".$_SESSION['cm_id']."','".date('Y-m-d H:i:s')."')";
								$ptr_sms=mysql_query($insert_sms);
								//-----------------------------------END SMS---------------------------------------*/
								//------send notification on inquiry addition-----
									$notification_args['reference_id'] = $student_id;
									$notification_args['on_action'] = 'enroll';
									$notification_status = addNotifications($notification_args);
								//-----------------------------------------------
								//if($payment_type_val !="online")
								//{
								?>
                                <script>
								//send();
                               // window.open('invoice-generate.php?record_id=<?php //echo $student_id_in; ?>', 'win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900,height=600,directories=no,location=no');
								
								<?php unset($_SESSION['rand']);?>
								//setTimeout('document.location.href="manage_enroll.php";',2000);
								</script>
                                <?php
								//}

								if($payment_type_val=="online")
								{
									?>
                                    <!--<div style="display:none">
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
												<td>TID	:</td><td><input type="hidden" name="tid" id="tid" value=" <?php //echo rand(0, 9999999999); ?>" readonly/></td>
											</tr>
											<tr>
												<td>Merchant Id	:</td><td><input type="hidden" name="merchant_id" value="73035"/></td>
											</tr>
											<tr>
												<td>Order Id	:</td><td><input type="hidden" name="order_id" value="<?php //echo $student_id_in; ?>"/></td>
											</tr>
											<tr>
												<td>Amount	:</td><td><input type="hidden" name="amount" value="<?php //echo $down_payment; ?>"/></td>
											</tr>
											<tr>
												<td>Currency	:</td><td><input type="hidden" name="currency" value="INR"/></td>
											</tr>
											<tr>
												<td>Redirect URL	:</td><td><input type="hidden" name="redirect_url" value="http://www.isasbeautyschool.com/faculty_login/ccavResponseHandler.php"/></td>
											</tr>
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
												<td>Billing Name	:</td><td><input type="hidden" name="billing_name" value="<?php //echo $name; ?>"/></td>
											</tr>
											<tr>
												<td>Billing Address	:</td><td><input type="hidden" name="billing_address" value="<?php //echo $address; ?>"/></td>
											</tr>
											<tr>
												<td>Billing City	:</td><td><input type="hidden" name="billing_city" value="<?php //echo $branch_name1; ?>"/></td>
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
												<td>Billing Tel	:</td><td><input type="hidden" name="billing_tel" value="<?php //echo $contact; ?>"/></td>
											</tr>
											<tr>
												<td>Billing Email	:</td><td><input type="hidden" name="billing_email" value="<?php //echo $mail; ?>"/></td>
											</tr>
											<tr>
												<td colspan="2">Shipping information(optional)</td>
											</tr>
											<tr>
												<td>Shipping Name	:</td><td><input type="hidden" name="delivery_name" value="<?php //echo $name; ?>"/></td>
											</tr>
											<tr>
												<td>Shipping Address	:</td><td><input type="hidden" name="delivery_address" value="<?php //echo $address; ?>"/></td>
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
												<td>Shipping Tel	:</td><td><input type="hidden" name="delivery_tel" value="<?php //echo $contact; ?>"/></td>
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
                                      </div>-->
                                      <?php
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
            <tr><td colspan="3" class="orange_font">* Mandatory Fields <input type="hidden" name="record_id" id="record_id" value="<?php echo $record_id; ?>"></td></tr>
            <?php
				$sql_sub_cat = "select * from inquiry where inquiry_id='".$row_record['inquiry_id']."' ";
				$my_query=mysql_query($sql_sub_cat);
				$row= mysql_fetch_array($my_query);
				$sub_branch='';
				if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
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
				
            	if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
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
       <?php }
	   else { ?>
       <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
       <?php }
	   
	   //=========================For prevent to save multiple entries================
			$rand=rand();
			$_SESSION['rand']=$rand;
		//=============================================================================
	   ?>
       
       			<tr>
                	<?php
					if( $row_record['added_date']!='')
					{
						$ens_date=explode(" ",$row_record['added_date']);
						$enq_date=$ens_date[0];
					}
					if( $row['inquiry_date']!='')
					{
						$ens_date=explode(" ",$row['inquiry_date']);
						$enqs_date=$ens_date[0];
					}
					?>
					<td width="20%">Enquiry date<span class="orange_font">*</span></td>
					<td><?php if($_POST['inquiry_date']) echo $_POST['inquiry_date']; else if($enqs_date !='') {$arrage_date= explode('-',$enqs_date,3);echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];} else echo date('d/m/Y');?>
                    <input type="hidden" class="validate[required] input_text datepicker" name="inquiry_date" id="inquiry_date"  value="<?PHP if($_POST['inquiry_date']) echo $_POST['inquiry_date']; else if($enqs_date !='') {$arrage_date= explode('-',$enqs_date,3);echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];} else echo date('d/m/Y');?>" /><br /></td>
                </tr>
                <tr>
                	<td width="20%">Addmission date<span class="orange_font">*</span></td>
                    <td width="40%">
                    <input type="hidden" name="cm_id" value="<?php echo $row['cm_id']; ?>" />
                    <?php 
					if($_SESSION['type']=='S' || $_SESSION['type']=="A" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
					{
						?>
						<input type="text" id="admission_date" class="input_text datepicker" name="admission_date" value="<?php if($_POST['admission_date']) echo $_POST['admission_date']; else echo date("d/m/Y"); ?>" />
						<?php
					}
					else
					{
						if($_POST['admission_date']) echo $_POST['admission_date']; else echo date('d/m/Y');
						?>
						<input type="hidden" id="admission_date" name="admission_date" value="<?php if($_POST['admission_date']) echo $_POST['admission_date']; else echo date('d/m/Y'); ?>" />
						<?php
					}
					?>
                    </td>
                </tr> 
                <tr>
                	<td width="20%" >Enrollment No.<span class="orange_font">*</span></td>
                    <td width="40%"><input type="text" class="validate[required] input_text" name="inst_student_id"  id="inst_student_id" readonly value="<?php if($_POST['inst_student_id']) echo $_POST['inst_student_id']; else echo trim($comma_separated.'/'.$largestNumber) ;?>" /> </td>
                </tr>
				<tr>
					<td width="20%" >SAC No.<span class="orange_font"></span></td>
					<td width="49%"><input type="text" name="sac_code" id="sac_code" class="input_text" value="<?php if($_POST['sac_code']) echo $_POST['sac_code']; else echo $data_sac_code['sac_code']; ?>"  />
					</td>
				</tr>
                <tr>
                	<td width="20%">First Name<span class="orange_font">*</span></td>
                    <td width="40%"><input type="text" class="validate[required] input_text" name="firstname"  id="firstname" value="<?php if($_POST['firstname']) echo $_POST['firstname']; else echo $row_record['firstname'];?>" /></td> 
                </tr> 
                <tr>
                	<td width="20%">Middle Name<span class="orange_font"></span></td>
                    <td width="40%"><input type="text" class="validate[required] input_text" name="middlename"  id="middlename" value="<?php if($_POST['middlename']) echo $_POST['middlename']; else echo $row_record['middlename']; ?>" /></td> 
                </tr>
                <tr>
                	<td width="20%">Last Name<span class="orange_font">*</span></td>
                    <td width="40%"><input type="text" class="validate[required] input_text" name="lastname"  id="lastname" value="<?php if($_POST['lastname']) echo $_POST['lastname']; else echo $row_record['lastname'];?>" /></td> 
                </tr>
                <tr>
                	<td width="20%">Contact No<span class="orange_font">*</span></td>
                    <td width="40%"><input type="text" class="validate[required] input_text" name="contact" id="contact" value="<?php if($_POST['contact']) echo $_POST['contact']; else echo $row_record['mobile1'];?>" onKeyPress="return isNumber(event)" maxlength="15"/></td> 
                    <td width="40%"><b>Note-</b> Should be 8-15 digit allowed. </td>
                </tr>
                <tr>
                	<td width="20%">Parents Contact No<span class="orange_font">*</span></td>
                    <td width="40%"><input type="text" class="validate[required] input_text" name="home_contact" id="home_contact" value="<?php if($_POST['home_contact']) echo $_POST['home_contact']; ?>" onKeyPress="return isNumber(event)" maxlength="15"/></td> 
                    <td width="40%"><b>Note-</b> Should be 8-12 digit allowed. </td>
                </tr>
                <tr>
                	<td width="20%">Email Id<span class="orange_font">*</span></td>
                    <td width="40%"><input type="text" class="input_text" name="mail" id="mail" value="<?php if($_POST['mail']) echo $_POST['mail']; else echo $row_record['email_id'];?>"  /></td> <!--onBlur="validateEmail(this.value);"-->
                    <td width="40%"></td>
                </tr>
                <tr>
                 	<td width="20%">Current Address<span class="orange_font">*</span></td>
                    <td width="40%"><textarea  name="address" id="address" style="width: 460px; height: 62px;" ><?php if($_POST['address']) echo $_POST['address']; else echo $row_record['address'];?></textarea></td> 
                </tr> 
                <tr>
                 	<td width="20%">Permanant Address<span class="orange_font"></span></td>
                    <td width="40%"><textarea  name="per_address" style="width: 460px; height: 62px;" id="per_address" ><?php if($_POST['per_address']) echo $_POST['per_address']; else echo $row_record['address'];?></textarea></td> 
                </tr>
				<tr>
					<td width="22%">Religion<span class="orange_font"></span></td>
					<td width="44%"><select id="religion" name="religion" class="input_text">
					<option value="">Select Religion</option>
					<option  value="Hindu" <? if ($_POST['religion'] == "Hindu") echo "selected='selected'"; else if($row_record['religion'] == "Hindu") echo "selected='selected'";?> >Hindu</option>
					
					<option  value="Muslim" <? if ($_POST['religion'] == "Muslim") echo "selected='selected'"; else if($row_record['religion'] == "Muslim") echo "selected='selected'";?> >Muslim</option>

					<option  value="Christian" <? if ($_POST['religion'] == "Christian") echo "selected='selected'"; else if($row_record['religion'] == "Christian") echo "selected='selected'";?> >Christian</option>

					<option  value="Sikh" <? if ($_POST['religion'] == "Sikh") echo "selected='selected'"; else if($row_record['religion'] == "Sikh") echo "selected='selected'";?> >Sikh</option>

					<option  value="Buddhist" <? if ($_POST['religion'] == "Buddhist") echo "selected='selected'"; else if($row_record['religion'] == "Buddhist") echo "selected='selected'";?> >Buddhist</option>

					<option  value="Jain" <? if ($_POST['religion'] == "Jain") echo "selected='selected'"; else if($row_record['religion'] == "Jain") echo "selected='selected'";?> >Jain</option>

					<option  value="Other Religion" <? if ($_POST['religion'] == "Other Religion") echo "selected='selected'"; else if($row_record['religion'] == "Other Religion") echo "selected='selected'";?> >Other Religion</option>

					<option  value="Not Stated" <? if ($_POST['religion'] == "Not Stated") echo "selected='selected'"; else if($row_record['religion'] == "Not Stated") echo "selected='selected'";?> >Not Stated</option>
					</select>
					</td>
				</tr>
                <tr>
                	<td width="20%">Select Country<span class="orange_font">*</span></td>
                  	<td><select id="country" name="country" onchange="select_state(this.value)" style="width:460px">
                    <option value="">Select Country</option>
					<?php 
					$sel_countries="select * from countries where 1";
					$ptr_countries=mysql_query($sel_countries);
					while($data_countries=mysql_fetch_array($ptr_countries))
					{
						?>
						<option value ="<?php echo $data_countries['id'];?>"> <?php echo $data_countries['name'];?> </option>
						<?php						
					}?>
                    </select>
                   </td>
            	</tr>  
                <tr>
                	<td width="20%">Select State<span class="orange_font">*</span></td>
                    <td>
                        <div id="show_states">
                            <table width="100%">
                            	<tr>
                  					<td><select id="state" name="state" onchange="select_city(this.value)" style="width:460px">
                    				<option value="">Select State</option>
                    				</select>
                   					</td>
            					</tr>
                            </table>
                         </div>
                     </td>
                </tr>
                <tr>
                	<td width="20%">Select City<span class="orange_font">*</span></td>
                	<td>
                        <div id="show_cities">
                            <table width="100%">
                            	<tr>
                                    <td>
                                    <select id="city" name="city" onchange="select_area(this.value)" style="width:460px">
                                        <option value="">Select City</option>
                                    </select>
                                   </td>
                                </tr>
                            </table>
                        </div>
                    </td>
            	</tr>
				<tr>
					<td width="20%">Select Area<span class="orange_font"></span></td>
					<td>
						<div id="show_area">
							<table width="100%">
								<tr>
									<td>
									<select id="area" name="area" style="width:460px">
										<option value="">Select Area</option>
									</select>
								</td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
                <tr>
                 	<td width="20%">Date Of Birth<span class="orange_font">*</span></td>
                    <td width="40%"><input type="text" class="input_text datepicker" name="dob" id="dob" value="<?php if($_POST['dob'])	echo $_POST['dob'];else if($row_record['birth_date']){$arrage_date= explode('-',$row_record['birth_date'],3);echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];}?>" /></td> 
                	<td width="40%"></td>
            	</tr>  
                <tr>
                	<td width="20%">Qualification<span class="orange_font"></span></td>
                    <td width="40%"><select name="qualification" id="qualification" class="input_text" style="width:460px">
                    <option  value="">----Select----</option>
                    <option  value="SSC" <?php if (isset($qualification) && $qualification == "SSC") echo "selected"; elseif( 'SSC' == $row_record['education']) echo "selected";?> >SSC</option>
                    <option  value="HSC" <?php if (isset($qualification) && $qualification == "HSC") echo "selected";elseif( 'HSC' == $row_record['education']) echo "selected";?> >HSC</option>
                    <option value="Under Graduation" <? if (isset($qualification) && $qualification == "Under Graduation") echo "selected";elseif( 'Under Graduation' == $row_record['education']) echo "selected";?> >Under Graduation</option>
                    <option value="Graduation" <? if (isset($qualification) && $qualification == "Graduation") echo "selected";elseif( 'Graduation' == $row_record['education']) echo "selected";?> >Graduation</option>
                     <option value="Post Graduation" <? if (isset($qualification) && $qualification == "Post Graduation") echo "selected";elseif( 'Post Graduation' == $row_record['education']) echo "selected";?> >Post Graduation</option>
                     </select>
                     </td>
                     <td width="40%"></td>
                 </tr>
                 <tr>
                 	<td width="20%">Create Username & Password</td>
                    <td width="40%"><input type="radio" style="width:20px" class="input_radio" name="auto_credential" id="auto_credential" onclick="user_credential(this.value)" value="auto" /> Auto &nbsp;&nbsp;&nbsp;<input type="radio" style="width:20px" class="input_radio" name="auto_credential" id="auto_credential" onclick="user_credential(this.value)" value="mannual" /> Mannual</td>
                 </tr>
                 <tr>
                 	<td width="20%">User Name<span class="orange_font">*</span> </td>
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
                	<td width="20%">Source<span class="orange_font"></span></td>
                  	<td><select id="source" name="source" style="width:460px">
                    <option value="">----Select----</option>
					<?php 
					$course_category = "select DISTINCT(cm_id),branch_name from site_setting where type='A' ".$_SESSION['where']."";
					$ptr_course_cat = mysql_query($course_category);
					while($data_cat = mysql_fetch_array($ptr_course_cat))
					{
						echo "<optgroup label='".$data_cat['branch_name']."'>";
						$sel_source="SELECT * FROM campaign where 1 and cm_id='".$data_cat['cm_id']."' and campaign_for='institute' and status='Active'";
						$ptr_src=mysql_query($sel_source);
						while($data_src=mysql_fetch_array($ptr_src))
						{	
							$read='';
							if($row_record['enquiry_source']!='')
							{
								$read='readonly';
							}
							?>
							<option value ="<?php echo $data_src['campaign_id']?>" <?php echo $read; ?> <?php if($_POST['source'] == $data_src['campaign_id']) echo "selected"; else if ($data_src['campaign_id'] == $row_record['enquiry_source']) echo "selected";?> > <?php echo $data_src['campaign_name'] ?> </option>
							<?php
						}
						echo "</optgroup>";
					}?>
                    </select>
                   </td>
            	</tr>             
            	<tr>
                   <td width="20%">Admission remark<span class="orange_font"></span></td>
                   <td><input type="text" class="validate[required] input_text" name="admission_remark" id="admission_remark" value="<?php if($_POST['admission_remark']) echo $_POST['admission_remark']; else echo $row['remark'];?>" /></td>
            	</tr>
                                               
            	<tr>
            		<td width="20%">Select Course<span class="orange_font">*</span></td>
            		<td width="40%" class="customized_select_box">
                    <select name="course_id" id="course_id" class="validate[required] input_select " onChange="show_course(this.value);" style="width:460px" >  
                    <option value=""> Select Course </option>
                    <?php
                    $course_category = " select category_name,category_id from course_category ";
					$ptr_course_cat = mysql_query($course_category);
					while($data_cat = mysql_fetch_array($ptr_course_cat))
					{
						echo " <optgroup label='".$data_cat['category_name']."'>";
						$get="SELECT course_name,course_id FROM courses where category_id='".$data_cat['category_id']."' and status='Active' order by course_id";
						$myQuery=mysql_query($get);
						while($rows = mysql_fetch_assoc($myQuery))
						{
							$selected= '';
							if($row['course_id']==$rows['course_id'] || $_POST['course_id']==$rows['course_id'] )
							$selected= ' selected="selected" ';
							?>
                            <option value="<?php echo $rows['course_id']?>" <?php echo $selected;  ?> > <?php echo $rows['course_name'] ?> </option>
							<?php 
						}
						echo " </optgroup>";
					}
					?>
                    <option value="custome">New Course</option>     
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
                	<td width="22%">Current Offer</td>
                    <td width="38%">
                    <input type="radio" name='current_offer' id="reg_offer" <?php if($_POST['current_offer'] =="regular_offer")  echo 'checked="checked"'; else echo 'checked="checked"'; ?> value="regular_offer" onChange="show_offer_discount()" />Regular Offer  <input type="radio" name='current_offer' id="kit_offer" <?php if($_POST['current_offer'] =="kit_offer")  echo 'checked="checked"'; ?> value="kit_offer" onChange="show_offer_discount()" />Kit Offer
                    </td>                
                	<td width="40%"><p id="countdown_offer" style="color:#F00; font-size:15px; font-weight:600"></p></td>
                </tr>
                <?php
  				$readonly='';
				$bg='';
				if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD')
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
                	<td width="22%">Course Fees</td>
                	<td width="38%">
                    <div id=total_fees>
                	<input type="text" class="input_text" name="total_fees" id="toal_fees" <?php echo $readonly; echo $bg;?> onblur="show_record(this.value,1)" value="<?php if($_POST['total_fees']) echo $_POST['total_fees']; else echo $row['total_fees'];?>" />
                    </div>
                    </td>
                    <td width="40%">
                    <input type="hidden" name="discount_otp" id="discount_otp" value="" />
                    <input type="hidden" name="discount_inst" id="discount_inst" value="" />
                    <input type="hidden" name="discount_now_otp" id="discount_now_otp" value="" />
                    <input type="hidden" name="discount_now_inst" id="discount_now_inst" value="" />
                    <input type="hidden" name="discount_otp_inst" id="discount_otp_inst" value="" />
                    <input type="hidden" name="discount_now_otp_inst" id="discount_now_otp_inst" value="" />
                    <input type="hidden" name="duration_studies" id="duration_studies" value="" />
                    </td>
                </tr>
                <tr style="display:none">
                	<td width="22%">Current Discount</td>
                    <td width="38%">
                    <input type="radio" name='now_disc' id="normal_disc" <?php if($_POST['now_disc'] =="normal_disc")  echo 'checked="checked"'; else echo 'checked="checked"'; ?> value="normal_disc" onChange="show_now_discount()" />Normal Discount
                    <input type="radio" name='now_disc' id="now_disc" <?php if($_POST['now_disc'] =="now_disc")  echo 'checked="checked"'; ?> value="now_disc" onChange="show_now_discount()" />Now Discount
                    </td>                
                	<td width="40%"><p id="countdown" style="color:#F00; font-size:15px; font-weight:600"></p></td>
                </tr>
                <tr>
                	<td width="22%">Paid Type </td>
                    <td width="38%">
                    <input type="radio" name='paid_type' id="paid_type" value="one_time" <?php if($_POST['paid_type'] =="one_time")  echo 'checked="checked"'; ?>  checked="checked" onChange="show_record()" />One Time <input type="radio" name='paid_type' id="paid_type" value="installments" <?php if($_POST['paid_type'] =="installments")  echo 'checked="checked"'; ?> onChange="show_record()" />OTP with Installment  <!--<span id="inst_tax_id"><?php //if($_SESSION['type']!='S'){ echo $_SESSION['installment_tax'];} ?></span>% add-->
                	<input type="hidden" id="inst_taxes" value="<?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['installment_tax'];} ?>"  />
                	<input type="radio" name='paid_type' id="paid_type" value="installments_zero"  <?php if($_POST['paid_type'] =="installments_zero")  echo 'checked="checked"'; ?> onChange="show_record()" />Installment 0% add
                    </td>                
                	<td width="40%"></td>
                </tr>
  <!--==========================================================================================================================-->                <?php
  				$en_readonly='';
				if($_SESSION['type']!='S')
				{
					$en_readonly='readonly="readonly"';
				}
				else
				{
					$en_readonly='';
				}
				?>  
            	<tr>
                	<td width="22%">Discount in <input type="radio" name='discount_type' <?php echo $en_readonly; ?> value="<?php if($_POST['discount_type']) echo $_POST['discount_type']; else echo percent; ?>" checked="checked" onChange="show_record()" />% <!--or--> <input type="hidden" name='discount_type' <?php echo $en_readonly; ?> value="<?php //if($_POST['discount_type']) echo $_POST['discount_type']; else echo cash; ?>" onChange="show_record()" /><!--Cash--></td>
                	<td width="38%"><input type="text" class="input_text" <?php echo $en_readonly; ?> name="concession" <?php echo $readonly; echo $bg;?> id="concession" value="<?php if($_POST['concession']) echo $_POST['concession']; else if($row_record['discount'] !=0) echo $row_record['discount']; else echo 0; ?>" onBlur="show_record()"/>
                    </td>
                    <td width="40%">
                    </td>
                </tr>
                <tr>
                	<td width="22%">Discount Coupon Code</td>
                    <td width="38%">
                    <input type="text" class="input_text" name="discount_coupon" id="discount_coupon" value="<?php if($_POST['discount_coupon']) echo $_POST['discount_coupon']; else echo $row_record['code'];?>" onBlur="show_discount()" /></td>
                    <td width="40%"><input type="hidden" name="discount_coupon_per" id="discount_coupon_per" value="<?php if($_POST['discount_coupon_per']) echo $_POST['discount_coupon_per']; else echo $row_record['discount_coupon_per'];?>" /><div id="coupon"></div><input type="hidden" name="discount_coupon_price" id="discount_coupon_price" value="<?php if($_POST['discount_coupon_price']) echo $_POST['discount_coupon_price']; else echo 0;?>" /></td>
                    </tr>

            <!--<tr>

                <td width="22%"><div id="coursess" class="coursess" >Available Fees</div></td>

                

                <td width="38%"><div id="coursess" class="coursess" >

                    <input type="text" class="input_text" name="balance" readonly="readonly" id="balance" value="<?php// if($_POST['save_changes']) echo $_POST['balance']; else echo $row_record['final_fees'];?>" />

                </div>

                </td>                

                <td width="40%"></td>

            </tr>-->
<!--=============================================================================================================-->            
			<tr>
                  <th width="20%" class="heading">Fee breakup </th>
            </tr>  
            <tr>    
               <td width="20%" class="heading">Net Fees<span class="orange_font">*</span></td>
               <td><input type="text" class="validate[required] input_text" <?php echo $en_readonly; ?> name="net_fees" id="net_fees" value="<?php if($_POST['net_fees']) echo $_POST['net_fees']; else echo $row_record['net_fees'];?>" /></td>

            </tr>
            
            <?php
			if($_SESSION['tax_type']=='GST')
			{
				?>
                <tr>      
                  <td width="20%" class="heading">CGST <span id="cgst_id"><?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['cgst'];} ?></span>%<span class="orange_font">*</span></td><input type="hidden" id="cgst_taxes" name="cgst_taxes" value="<?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['cgst'];} ?>"  />
                  <td><input type="text" class="validate[required] input_text" readonly="readonly" name="cgst_tax" id="cgst_tax"  value="<?php if($_POST['cgst_tax']) echo $_POST['cgst_tax']; else echo $row_record['cgst_tax'];?>" /></td>
                </tr>
                <tr>      
                      <td width="20%" class="heading">SGST <span id="sgst_id"><?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['sgst'];} ?></span>%<span class="orange_font">*</span></td><input type="hidden" id="sgst_taxes" name="sgst_taxes" value="<?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['sgst'];} ?>"  />
                      <td><input type="text" class="validate[required] input_text" readonly="readonly" name="sgst_tax" id="sgst_tax"  value="<?php if($_POST['sgst_tax']) echo $_POST['sgst_tax']; else echo $row_record['sgst_tax'];?>" /></td>
                </tr>
                <?php
			}
			else
			{
				?>
                <tr>      
                    <td width="20%" class="heading">Service Tax  <span id="service_tax_id"><?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['service_tax'];} ?> %</span> <span class="orange_font">*</span></td><input type="hidden" id="service_taxes" name="service_taxes" value="<?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['service_tax'];} ?>"  />
                    <td><input type="text" class="validate[required] input_text" name="service_tax" id="service_tax"  value="<?php if($_POST['service_tax']) echo $_POST['service_tax']; else echo $row_record['service_tax'];?>" /></td>
                </tr>
                <?php
			}
			?>
           	<tr>      
                  <td width="20%" class="heading">Total Fees <span class="orange_font">*</span></td>
                  <td><input type="text" class="validate[required] input_text" <?php echo $en_readonly; ?> name="fees" id="fees"  value="<?php if($_POST['fees']) echo $_POST['fees']; else echo $row_record['total_fees'];?>" /></td> 
             </tr>
            <tr>
                <td width="20%" class="heading">Down Payment(Including tax)<span class="orange_font">*</span></td>
                <td><input type="text" class="validate[required] input_text" name="down_payment" id="down_payment" onKeyUp="show_record()" value="<?php if($_POST['down_payment']) echo $_POST['down_payment']; else if($row_record['down_payment']!=0) echo $row_record['down_payment']; else echo 0;?>" /></td>
            </tr>
             
            
            <?php
			if($_SESSION['tax_type']=='GST')
			{
				?>
                <tr>      
                    <td width="20%" class="heading">CGST <span id="down_cgst_id"><?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['cgst'];} ?></span>% on down payment <span class="orange_font">*</span></td><input type="hidden" id="down_cgst_taxes" name="down_cgst_taxes" value="<?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['cgst'];} ?>"  />
                    <td><input type="text" class="validate[required] input_text" readonly="readonly" name="down_cgst_tax" id="down_cgst_tax"  value="<?php if($_POST['down_cgst_tax']) echo $_POST['down_cgst_tax']; else echo $row_record['cgst_tax'];?>" /></td>
                </tr>
                <tr>      
                   <td width="20%" class="heading">SGST <span id="down_sgst_id"><?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['sgst'];} ?></span>% on down payment <span class="orange_font">*</span></td><input type="hidden" id="down_sgst_taxes" name="down_sgst_taxes" value="<?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['sgst'];} ?>"  />
                    <td><input type="text" class="validate[required] input_text" readonly="readonly" name="down_sgst_tax" id="down_sgst_tax"  value="<?php if($_POST['down_sgst_tax']) echo $_POST['down_sgst_tax']; else echo $row_record['sgst_tax'];?>" /></td>
                </tr>
                <?php
			}
			else
			{
				?>
                <tr>
                      <td width="20%" class="heading">Service Tax <span id="down_service_id"><?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['service_tax'];} ?></span>% on down payment<span class="orange_font">*</span></td><input type="hidden" id="down_service_taxes" name="down_service_taxes" value="<?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['service_tax'];} ?>"  />
                      <td><input type="text" class="validate[required] input_text" readonly="readonly" name="down_payment_tax" id="down_payment_tax" value="<?php if($_POST['down_payment_tax']) echo $_POST['down_payment_tax']; else if($row_record['down_payment_tax']!=0) echo $row_record['down_payment_tax']; else echo 0;?>" /></td>
                </tr>
                <?php
			}
			?>
            <tr>
                <td width="20%" class="heading">Down Payment(Without tax)<span class="orange_font">*</span></td>
                <td><input type="text" class="validate[required] input_text" <?php echo $en_readonly; ?> name="down_payment_wo_tax" id="down_payment_wo_tax" onKeyUp="show_record()" value="<?php if($_POST['down_payment_wo_tax']) echo $_POST['down_payment_wo_tax']; else if($row_record['down_payment_wo_tax']!=0) echo $row_record['down_payment_wo_tax']; else echo 0;?>" /></td>
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
                     <?php for ($i = 0; $i <= 24; $i++)
                     {
                        $selc = '';
                        if($row_record['no_of_installment']==$i || $_POST['numDep']== $i)
                        $selc =' selected="selected" ';
                            echo '<option value="'.$i.'" '.$selc.'>'.$i.'</option>';
                     }
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
                    $selec_installemnt="select * from installment where enroll_id='$record_id' and course_id='".$row_record['course_id']."' ";
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
                    <td ><div id="pay_type"> <input type="radio" class="validate[required] input_radio" name="payment_type" id="payment_type" value="cash" onClick="hide();" <?php //if($row_invoice['paid_type']=='cash'|| $_POST['payment_type']=='cash') echo 'checked="checked"'; ?> /> Cash
             
                   <input type="radio" class="validate[required] input_radio" name="payment_type"  id="payment_type" value="cheque" onClick="show();" <?php //if($row_invoice['paid_type']=='cheque'|| $_POST['payment_type']=='cheque') echo 'checked="checked"'; ?> />By Cheque
                 
                  <input type="radio" class="validate[required] input_radio" name="payment_type" id="payment_type" value="online" onClick="hide();"   <?php //if($row_invoice['paid_type']=='online'|| $_POST['payment_type']=='online') echo 'checked="checked"'; ?> />Online
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
                <div id="bank_ref_no" <?php if($_POST['payment_type'] =='online-5') echo 'style="display:block"'; else if($data_invoice['paid_type'] =='5') echo 'style="display:block"';  else echo 'style="display:none"'; ?>>
                    <table width="100%">
                        <tr>
                            <td width="10%" class="tr-header" align="">Ref. no</td>
                            <td width="35%"><input type="text" name="bank_ref_no" id="ref_no_bank" value="<?php if($_POST['bank_ref_no']) echo $_POST['bank_ref_no']; else echo $data_invoice['bank_ref_no']; ?>"/></td>
                        </tr>
                    </table>
                </div>
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
                        }*/
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
             <td><input type="text" name="credit_card_no" id="credit_card_no" maxlength="4" value="<?php if($_POST['credit_card_no']) echo $_POST['credit_card_no']; else echo $row_invoice['credit_card_no']; ?>" /></td>
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
                  <td width="20%" class="heading">Customer <?php if($_SESSION['tax_type']=='GST') echo 'GST'; else echo 'VAT'; ?> no.(if availale)<span class="orange_font">*</span></td>
                  <td><input type="text" class="input_text" name="cust_gst_no" id="cust_gst_no" value="<?php if($_POST['cust_gst_no']) echo $_POST['cust_gst_no']; else if($row_record['cust_gst_no']!=0) echo $row_record['cust_gst_no']; else echo '';?>" /></td>
            </tr>
            <tr>
                  <td width="20%" class="heading">Total Balance Amount<span class="orange_font">*</span></td>
                  <td><input type="text" class="validate[required] input_text" <?php echo $en_readonly; ?> name="final_amt" id="final_amt" value="<?php  if($_POST['final_amt']) echo $_POST['final_amt']; else echo $row_record['balance_amt'];?>" /></td>
            </tr>
            <tr>
                  <td width="20%" class="heading">Final Amount<span class="orange_font">*</span></td>
                  <td><input type="text" class="validate[required] input_text" <?php echo $en_readonly; ?> name="total_amt" id="total_amt" value="<?php  if($_POST['total_amt']) echo $_POST['total_amt']; else echo $row_record['total_fees'];?>" /></td>
            </tr>
            <tr>
                <td width="22%">Assigned to<span class="orange_font"></span></td>
                <td width="44%"><select id="employee_id" name="employee_id" >
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
                    <!--<option <?php //echo $sele_staff?> value = "<?php //echo $data_staff['admin_id']?>" <?php //if (isset($employee_id) && $employee_id == $data_staff['admin_id']) echo "selected";?> > <?php //echo $data_staff['name'] ?> </option>-->
                    <?
                //}
                ?>
                </select></td>
                <td width="34%"></td>
            </tr>
        </table>
        <input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
        <center>
        <input type="hidden" name="course_only_fee" id="course_only_fee" value="" />
        <input type="hidden" value="save" name="save_records" id="save_records" /> 
        <div id="hide_btns">
        	<input type="submit" value="Save Record" name="save_changes" />
        </div>
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
					//var service_taxes = $("#service_taxes").val();
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
							//alert(html);
                            $(".customized_select_box").html(html);
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
if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
{
	?>
    <script>
	branch_name =document.getElementById("branch_name").value;
	//alert(branch_name);
	show_bank(branch_name);
	</script>
    <?php
}

$sel_inq="select apply_now_disc from inquiry where inquiry_id='".$_REQUEST['record_id']."'";
$ptr_inq=mysql_query($sel_inq);
$data_inq=mysql_fetch_array($ptr_inq);
if($data_inq['apply_now_disc']=='yes')
{
	?>
	<script>
	$('#kit_offer').prop('checked', true);
	setTimeout(show_offer_discount(),200);
	</script>
	<?php
}
	
?>
<script>
if(document.getElementById("branch_name"))
{
	branch_id= document.getElementById("branch_name").value;
	admin_id=<?php echo $_SESSION['admin_id']; ?>;
	//alert(admin_id);
	show_staff(branch_id,admin_id)
}
/*var display_id=document.getElementById("inst_student_id").value;
stud_id=display_id.replace("ISAS","ISAS/"+branch);
document.getElementById("inst_student_id").value=stud_id;*/
</script>
</body>
</html>
<?php $db->close();?>