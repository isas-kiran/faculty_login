<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'] !='')
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM inquiry where inquiry_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
}
else
{
	$record_id=0;
}
if($record_id && $_REQUEST['deleteThumbnail'])
{
    $update_news="update inquiry set photo='' where inquiry_id='".$record_id."'";
    //echo $update_events; 
    $db->query($update_news);
    if($row_record['photo'] && file_exists("../student_photos/".$row_record['photo']))
        unlink("../student_photos/".$row_record['photo']);
    $row_record=$db->fetch_array($db->query($sql_record));
}

$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='38'";
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
    <title>
    <?php if($record_id) echo "Edit"; else echo "Student";?>Form</title>
    <?php include "include/headHeader_gst.php";?>
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
	<link rel="stylesheet" href="js/chosen.css" />
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script src="js/chosen.jquery.js" type="text/javascript"></script>
	<script>
	$(document).ready(function()
	{
		$("#course_id").chosen({allow_single_deselect:true});
		$("#enquiry_src").chosen({allow_single_deselect:true});
		<?php 
		if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
		{
			?>
			$("#branch_name").chosen({allow_single_deselect:true});
			<?php
		}
		?>
		$("#country").chosen({allow_single_deselect:true});
		$("#state").chosen({allow_single_deselect:true});
		$("#city").chosen({allow_single_deselect:true});
		$("#area").chosen({allow_single_deselect:true});
		$("#response").chosen({allow_single_deselect:true});
		$("#religion").chosen({allow_single_deselect:true});
		$("#employee_id").chosen({allow_single_deselect:true});
		$("#batch").chosen({allow_single_deselect:true});
		$("#maritalstatus").chosen({allow_single_deselect:true});
		$("#education").chosen({allow_single_deselect:true});
	});
	</script>
     <style type = "text/css">
		.obrderclass{ border:1px solid #f00}
    </style>
   
    <script>
		
		function send()
		{
			//alert('hi');
			mail=Array();
			<?php
			$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='38' ".$_SESSION['where']."";
			$ptr_sel_sms=mysql_query($sel_sms_cnt);
			$tot_num_rows=mysql_num_rows($ptr_sel_sms);
			$i=0;
			while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
			{
				$sel_act="select email from site_setting where admin_id='".$data_sel_cnt['staff_id']."' and email!='' and system_status='Enabled' ".$_SESSION['where']."";
				$ptr_cnt=mysql_query($sel_act);
				if(mysql_num_rows($ptr_cnt))
				{
					$data_cnt=mysql_fetch_array($ptr_cnt);
					?>
					mail[<?php echo $i; ?>]='<?php echo  $data_cnt['email'];?>';
					<?php
					$i++;
				}
			}
			if($_SESSION['type']!='S')
			{
				$sel_act="select contact_phone,email from site_setting where type='Z' and email!='' "; //type='S' and (admin_id!='8' and admin_id!='69')
				$ptr_cnt=mysql_query($sel_act);
				if(mysql_num_rows($ptr_cnt))
				{
					$j=$tot_num_rows;
					while($data_cnt=mysql_fetch_array($ptr_cnt))
					{
						?>
						mail[<?php echo $j; ?>]='<?php echo $data_cnt['email'];?>';
						<?php
						$j++;
					}
				}
			}
			
			$sel_mail_text="select email_text from previleges where privilege_id='38'";
			$ptr_mail_text=mysql_query($sel_mail_text);
			if($tot_mail_text=mysql_num_rows($ptr_mail_text))
			{
				$data_mail_text=mysql_fetch_array($ptr_mail_text);
				?>
				email_text_msg='<?php echo urlencode($data_mail_text['email_text']);?>';
				<?php
			}
			?>
			var firstname =document.getElementById('firstname').value;
			var middlename =document.getElementById('middlename').value;
			var lastname =document.getElementById('lastname').value;
			var mobile1 =document.getElementById('mobile1').value;
			var email_id =document.getElementById('email_id').value;
			var inquiry_date =document.getElementById('inquiry_date').value;
			var lead_category =document.getElementById('lead_category').value;
			var lead_category_followup =document.getElementById('lead_category_followup').value;
			var lead_grade =document.getElementById('lead_grade').value;
			var dob =document.getElementById('dob').value;
			var maritalstatus =document.getElementById('maritalstatus').value;
			var address =document.getElementById('address').value;
			var mobile2 =document.getElementById('mobile2').value;
			var landline_no =document.getElementById('landline_no').value;
			var education =document.getElementById('education').value;
			var course_id =document.getElementById('course_id').value;
			var duration_studies =document.getElementById('duration_studies').value;
			var total_fees =document.getElementById('toal_fees').value;
			var batch =document.getElementById('batch').value;
			var remark =document.getElementById('remark').value;
			var inquiry_for =document.getElementById('inquiry_for').value;
			var followup_date =document.getElementById('followup_date').value;
			var branch_name =document.getElementById('branch_name').value;
			var response1 =document.getElementById('response');
			var response = response1.options[response1.selectedIndex].text;
			var followup_desc =document.getElementById('followup_desc').value;
			var inqyiry_idss =document.getElementById('inqyiry_idss').value;
			//alert(inqyiry_idss);
			var users_mail=mail;
			//alert(email_id);
			//alert(users_mail);
			data1='action=inquiry&firstname='+firstname+'&middlename='+middlename+'&lastname='+lastname+'&mobile1='+mobile1+'&email_id='+email_id+'&inquiry_date='+inquiry_date+'&lead_category='+lead_category+'&lead_category_followup='+lead_category_followup+'&lead_grade='+lead_grade+'&dob='+dob+'&maritalstatus='+maritalstatus+'&address='+address+'&mobile2='+mobile2+'&landline_no='+landline_no+'&education='+education+'&course_id='+course_id+'&duration_studies='+duration_studies+'&total_fees='+total_fees+'&batch='+batch+'&remark='+remark+'&inquiry_for='+inquiry_for+'&followup_date='+followup_date+'&branch_name='+branch_name+'&response='+response+'&followup_desc='+followup_desc+'&inqyiry_idss='+inqyiry_idss+"&users_mail="+users_mail+"&email_text_msg="+email_text_msg;
			//alert(data1);
			$.ajax({
			url:'send_email.php',type:"post",data:data1,cache:false,crossDomain:true,async:false,
			success: function (html)
				{
					//alert(html);
				}
			});
			return true;
		}
	</script>
    <script type="text/javascript">
    $(document).ready(function()
	{  
		var currentDate = new Date();
		$('.datepicker').datepicker({ changeMonth: true, dateFormat:'dd/mm/yy',changeYear: true, showButtonPanel: true, closeText: 'Clear'});
		/* $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
		} */
		//$('#inquiry_date').datepicker().datepicker('setDate', 'today');
		$('#followup_date').datepicker();
	});
	function date()
	{
		 var followup_date= document.getElementById('followup_date');
	 	//alert (followup_date)
		 var date = new Date();
	 	if(followup_date < Date())
	 	{
			alert("Followup Date should Be Greater than Todays Date");
			document.getElementById('followup_date').style.border = '1px solid #f00';
	 	}
	}
	 
	function show_bank(branch_id)
	{
		/*var bank_data="show_bnk=1&branch_id="+branch_id;
		alert(bank_data);
		$.ajax({
		url: "show_bank.php",type:"post", data: bank_data,cache: false,
		success: function(retbank)
		{
			alert(retbank);
			document.getElementById("bank_id").innerHTML=retbank;
		}
		});*/
		
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
				
				document.getElementById("cgst_taxes").value=cgst;
				document.getElementById("sgst_taxes").value=sgst;
				<?php
			}
			else
			{
				?>
				document.getElementById("service_tax_id").innerHTML=service_tax;
				document.getElementById("service_taxes").value=service_tax;
				<?php
			}
			?>
			
			//document.getElementById("inst_tax_id").innerHTML=installment_tax;
			//document.getElementById("inst_taxes").value=installment_tax;
			//alert("service tax- "+service_tax);
			course_id1= document.getElementById("course_id").value;
			ajax_course(course_id1);
		}
		});
		var bank_data="action=inquiry&branch_id="+branch_id+"&admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&record_id="+<?php echo $record_id; ?>;
		//alert(bank_data);
		$.ajax({
		url: "show_councellor.php",type:"post", data: bank_data,cache: false,
		success: function(retbank)
		{
			//alert(retbank);
			document.getElementById("emp_ids").innerHTML=retbank;
			$("#employee_id").chosen({allow_single_deselect:true});
		}
		}); 
	}
	 
	function validme()
	{
		frm = document.jqueryForm;
		error='';
		disp_error = 'Clear The Following Errors : \n\n';
		if(frm.firstname.value=='')
		{
			disp_error +='Enter First Name\n';
			document.getElementById('firstname').style.border = '1px solid #f00';
			frm.firstname.focus();
			error='yes';
	    }
		else  // validation for number
		{
			var text = frm.firstname.value;
			  
			text = text.split(' '); //we split the string in an array of strings using     whitespace as separator
			if(text.length > 1)
			{
				disp_error +='Enter Valid First Name.Space and Symbols are not allowed\n';
				document.getElementById('firstname').style.border = '1px solid #f00';
			 	frm.firstname.focus();
				error='yes';
			}
		}
		/*if(frm.lastname.value=='')
		{
			disp_error +='Enter Last Name \n';
			document.getElementById('lastname').style.border = '1px solid #f00';
			frm.lastname.focus();
			error='yes';
	    }
		else  // validation for number
		{
			var text = frm.lastname.value;
			text = text.split(' '); //we split the string in an array of strings using  whitespace as separator
			if(text.length > 1)
			{
				disp_error +='Enter Valid Last Name. Space and Symbol not allowed\n';
				document.getElementById('lastname').style.border = '1px solid #f00';
			 	frm.firstname.focus();
				error='yes';
			}
		}*/
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
		 /* if(frm.maritalstatus.value=='')
		 {
			 disp_error +='Enter Marrital Staus \n';
			 document.getElementById('maritalstatus').style.border = '1px solid #f00';
			 frm.maritalstatus.focus();
			 error='yes';
	     }*/
		 if(frm.mobile1.value=='')
		 {
			 disp_error +='Enter Mobile Number \n';
			 document.getElementById('mobile1').style.border = '1px solid #f00';
			 frm.mobile1.focus();
			 error='yes';
	     }
		 else
		 {	 var text = frm.mobile1.value;
			 if(text.length < 8)
				{
					 disp_error +='Enter Valid Mobile Number \n';
					 document.getElementById('mobile1').style.border = '1px solid #f00';
					 error='yes';
				}
		 }
		 /*if(frm.mobile1.value)
		 {
			user_mobile= document.getElementById("user_mobile").innerHTML;
			if(user_mobile == "Mobile No already taken.")
			{
				disp_error +='Mobile No. already Exist. Please try other no.\n';
				document.getElementById('mobile1').style.border = '1px solid #f00';
				frm.mobile1.focus();
				error='yes';
			}
		 }*/
		 if(frm.mobile2.value !='')
		 {
			 
		 	 var text = frm.mobile2.value;
			 if(text.length <8)
				{
					 disp_error +='Enter Valid Mobile Number 2 \n';
					 document.getElementById('mobile2').style.border = '1px solid #f00';
					 error='yes';
				}
		 }
		 if(frm.email_id.value!='')
		 {
			/* disp_error +='Enter Email ID \n';
			 document.getElementById('email_id').style.border = '1px solid #f00';
			 frm.email_id.focus();
			 error='yes';*/
			var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			if (reg.test(document.getElementById("email_id").value) == false) 
			{
				disp_error +='Invalid Email Address\n';
				document.getElementById('email_id').style.border = '1px solid #f00';
				frm.email_id.focus();
				error='yes';
			}
	     }
		
		
		 if(frm.course_id.value=='')
		 {
			 disp_error +='Select Interested Course \n';
			 document.getElementById('course_id').style.border = '1px solid #f00';
			 frm.course_id.focus();
			 error='yes';
	     }
		  if(frm.enquiry_src.value=='')
		 {
			 disp_error +='Select Enquiry Source \n';
			 document.getElementById('enquiry_src').style.border = '1px solid #f00';
			 frm.enquiry_src.focus();
			 error='yes';
	     }

		/*  if(frm.remark.value=='')
		 {
			 disp_error +='Enter Remark  \n';
			 document.getElementById('remark').style.border = '1px solid #f00';
			 frm.remark.focus();
			 error='yes';
	     }*/
		 
		if(frm.followup_date.value=='')
		{
			 disp_error +='Enter followup date  \n';
			 document.getElementById('followup_date').style.border = '1px solid #f00';
			 frm.followup_date.focus();
			 error='yes';
	    }
		else
		{
			 
			if(isFeatureDate(frm.followup_date.value))
			{
			}
			else
			{
				disp_error +='Enter Valid Follow (feature) up Date\n';
				document.getElementById('followup_date').style.border = '1px solid #f00';
				error='yes';
			 }
		}
		if(frm.response.value=='')
		{
			disp_error +='Select Response Category  \n';
			document.getElementById('response').style.border = '1px solid #f00';
			frm.response.focus();
			error='yes';
	    }
		else if(frm.response.value=='7')
		{
			if(frm.response_reason.value=='')
			{
				disp_error +='Select Response Reason  \n';
				document.getElementById('response_reason').style.border = '1px solid #f00';
				frm.response_reason.focus();
				error='yes';
			}
		}
		/* if(frm.captcha.value=='')
		 {
			 disp_error +='Enter Security code \n';
			 document.getElementById('captcha-form').style.border = '1px solid #f00';
			 frm.captcha.focus();
			 error='yes';
			 
	     }*/
		/* else
		 {
			 if(frm.captcha.value != frm.captcha_code.value)
			 {
				 disp_error +='Please Enter Correct Security code \n';
				 document.getElementById('captcha-form').style.border = '1px solid #f00';
				 frm.captcha.focus();
				 error='yes';
			 }
		 }*/
		 /*if ( ( frm.gender.checked== false ) )
		{
			alert ( "Please choose your Gender: Male or Female" );
		   //return false;
			disp_error +="Please choose your Gender: Male or Female! \n";
			error='yes';
		}*/
		<?php
		/*if($_SESSION['active_login']=='')
		{
			?>
			disp_error +='Session Logout. Please login again \n';
            error='yes';
			<?php
		}*/
		?>
		 
		if(error=='yes')
		{
			 alert(disp_error);
			 return false;
		}
		else
		{ 
			return send();
		}
	 }
	 
	 /*function validateEmail(emailField)
	 {
		
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if(document.getElementById("email_id").value !='')
		{
        if (reg.test(document.getElementById("email_id").value) == false) 
        {
            alert('Invalid Email Address');
			document.getElementById('email_id').style.border = '1px solid #f00';
			document.getElementById("email_id").focus();
            return false;
        }
		}

        return true;

	}*/
	 
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


function show_responce(vals)
{
	response_id=vals;
	if(response_id=="7")
	{
		document.getElementById('show_reason').style.display="block";
		$("#response_reason").chosen({allow_single_deselect:true});
	}
	else
	{
		document.getElementById('show_reason').style.display="none";
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
<style type = "text/css">
    #feedback{
        line-height:;
    }
    .obrderclass{ border:1px solid #f00}
	
	#feedback2{
        line-height:;
    }
    .obrderclass{ border:1px solid #f00}
</style>  
     
<script type = "text/javascript">
    //this script will be triggered once the 
    //user type in the textbox 
 	
    //when the document is ready, run the function
    $(document).ready(function(){ 
		frm = document.jqueryForm;
        $('#feedback').load('check_mobile.php').show();
        $('#mobile1').keyup(function(){
            //this will pass the form input
			var mobiles=frm.mobile1.value;
			var i_id=frm.record_id.value;
            $.post('check_mobile.php', { mobile1: mobiles ,i_id: i_id ,action:"inquiry"},
            //then print the result
            function(result){
				//alert(result);
                $('#feedback').html(result).show();
            });
        });
		
		$('#feedback2').load('check_mobile.php').show();
        
        $('#mobile2').keyup(function(){
            //this will pass the form input
			var mobiles=frm.mobile2.value;
			var i_id=frm.record_id.value;
            $.post('check_mobile.php', { mobile1: mobiles ,i_id: i_id ,action:"inquiry_mobile2"},
            //then print the result
            function(result){
				//alert(result);
                $('#feedback2').html(result).show();
            });
        });
    });
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
				if($_POST['submit'] && $_SESSION['name']!='')
				{
					$branch_name=( ($_POST['branch_name'])) ? $_POST['branch_name'] : "";
					//$inquiry_date=$_POST['inquiry_date'];
					$inquiry_date=( ($_POST['inquiry_date'])) ? $_POST['inquiry_date'] : "";
					if($inquiry_date !='')
					{
						$seps_date = explode('/',$inquiry_date);
						$inquiry_date = $seps_date[2].'-'.$seps_date[1].'-'.$seps_date[0];
					}
					else
						$inquiry_date='';
					//$lead_category=$_POST['lead_category'];
					$lead_category=( ($_POST['lead_category'])) ? $_POST['lead_category'] : "";
					//$lead_category_followup=$_POST['lead_category_followup'];
					$lead_category_followup=( ($_POST['lead_category_followup'])) ? $_POST['lead_category_followup'] : "";
					//$lead_grade=$_POST['lead_grade'];
					$lead_grade=( ($_POST['lead_grade'])) ? $_POST['lead_grade'] : "";
					//$firstname=$_POST['firstname'];
					$firstname=( ($_POST['firstname'])) ? $_POST['firstname'] : "";
					//$middlename=$_POST['middlename'];
					$middlename=( ($_POST['middlename'])) ? $_POST['middlename'] : "";
					//$lastname=$_POST['lastname'];
					$lastname=( ($_POST['lastname'])) ? $_POST['lastname'] : "";
					//$birth_date=$_POST['dob'];
					$birth_date=( ($_POST['birth_date'])) ? $_POST['birth_date'] : "";
					//$gender=$_POST['gender'];
					$gender=( ($_POST['gender'])) ? $_POST['gender'] : "";
					//$maritalstatus=$_POST['maritalstatus'];
					$maritalstatus=( ($_POST['maritalstatus'])) ? $_POST['maritalstatus'] : "";
					//$address=$_POST['address'];
					$address=mysql_real_escape_string($_POST['address']) ? $_POST['maritalstatus'] : "";
					//$mobile1=$_POST['mobile1'];
					$religion=mysql_real_escape_string($_POST['religion']) ? $_POST['religion'] : "";
					$mobile1=( ($_POST['mobile1'])) ? $_POST['mobile1'] : "";
					//$mobile2=$_POST['mobile2'];
					$mobile2=( ($_POST['mobile2'])) ? $_POST['mobile2'] : "";
					//$landline_no=$_POST['landline_no'];
					$landline_no=( ($_POST['landline_no'])) ? $_POST['landline_no'] : "";
					//$email_id=$_POST['email_id'];
					$email_id=( ($_POST['email_id'])) ? $_POST['email_id'] : "";
					//$education=$_POST['education'];
					$education=( ($_POST['education'])) ? $_POST['education'] : "";
					//$course_interested=trim($_POST['course_id']);
					$course_interested=( ($_POST['course_id'])) ? $_POST['course_id'] : "0";
					//$employee_id=$_POST['employee_id'];
					$employee_id=( ($_POST['employee_id'])) ? $_POST['employee_id'] : "0";
					/*$customised_course=trim($_POST['customised_course']);
					if($course_interested =='custome')
					$course_interested=$customised_course;*/
					$country=(true== isset($_POST['country'])) ? $_POST['country'] : "";
					$state=(true== isset($_POST['state'])) ? $_POST['state'] : "";
					$city=(true== isset($_POST['city'])) ? $_POST['city'] : "";
					$area=(true== isset($_POST['area'])) ? $_POST['area'] : "";
					$enquiry_date=date('y-m-d');
					//$duration_studies=$_POST['duration_studies'];
					$duration_studies=( ($_POST['duration_studies'])) ? $_POST['duration_studies'] : "";
					//$total_fees=$_POST['total_fees'];
					$total_fees=( ($_POST['total_fees'])) ? $_POST['total_fees'] : "0";
					//$batch=$_POST['batch'];
					$batch=( ($_POST['batch'])) ? $_POST['batch'] : "";
					//$enquiry_src=$_POST['enquiry_src'];
					if($record_id && $_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD' )
					{
						$enquiry_src=$row_record['enquiry_source'];
					}
					else
					{
					 $enquiry_src= mysql_real_escape_string($_POST['enquiry_src']) ? mysql_real_escape_string($_POST['enquiry_src']) : "";
					}
					$enquiry_type_category=mysql_real_escape_string($_POST['enquiry_type_category']) ? $_POST['enquiry_type_category'] : "";
					//$enquiry_taken=$_SESSION['admin_id'];
					//$enquiry_taken=( ($_POST['enquiry_taken'])) ? $_POST['enquiry_taken'] : "0";
					//$remark=$_POST['remark'];
					$remark=addslashes(mysql_real_escape_string($_POST['remark'])) ? $_POST['remark'] : "";
					//$company=$_POST['company'];
					$company=( ($_POST['company'])) ? $_POST['company'] : "";
					//$inquiry_for=$_POST['inquiry_for'];
					$inquiry_for=mysql_real_escape_string($_POST['inquiry_for']) ? $_POST['inquiry_for'] : "";
					//$followup_date1=$_POST['followup_date'];
					$followup_date1=( ($_POST['followup_date'])) ? $_POST['followup_date'] : "";
					//$branch_name=$_POST['branch_name'];
					//$address=$_POST['address'];
					$address=addslashes(mysql_real_escape_string($_POST['address'])) ? $_POST['address'] : "";
					//$batch_time=$_POST['batch_time'];
					$batch_time=( ($_POST['batch_time'])) ? $_POST['batch_time'] : "";
					//$response=$_POST['response'];
					$response=( ($_POST['response'])) ? $_POST['response'] : "";
					$response_reason=addslashes(mysql_real_escape_string($_POST['response_reason'] ? $_POST['response_reason'] : ""));
					//$followup_desc= $_POST['followup_desc'];
					$followup_desc=addslashes(($_POST['followup_desc'] ? $_POST['followup_desc'] : ""));
					$stud_id="";
					if($record_id)
					{
						$stud_id="and inquiry_id !=".$record_id."";
					}
					$sel_mob_no="select mobile1 from inquiry where mobile1 ='".$mobile1."' ".$stud_id."";
					$ptr_mob_no=mysql_query($sel_mob_no);
					if(mysql_num_rows($ptr_mob_no))
					{
						$success=0;
						$errors[$i++]="Mobile no already Exist for another Enquiry.";
					}
					
				   	if($firstname=="")
					{
						$success=0;
						$errors[$i++]="Enter your firstname";
					}
					else
					{
						if(!preg_match("/^[a-zA-Z _.-]+$/", $firstname))
						{
							$success=0;
						$errors[$i++]="Invalid Firstname. Only letters and symbol( _  .  -) allowed";	
						}
					}
					
					/*if($lastname=="")
					{
						$success=0;
						$errors[$i++]="Enter your lastname";
					}
					else
					{
						if(!preg_match("/^[a-zA-Z _.-]+$/", $lastname))
						{
							$success=0;
						$errors[$i++]="Invalid Lastname. Only letters and symbol( _  .  -) allowed";	
						}
					}*/
					if($birth_date !='')
					{
					
						$sep_date = explode('/',$birth_date);
						"<br/>".$birth_date = $sep_date[2].'-'.$sep_date[1].'-'.$sep_date[0];
					}
					/*if($gender =="")
					{
						$success=0;
						$errors[$i++]="Select your Gender";
					}*/
																
					if($mobile1=="")
					{
						$success=0;
						$errors[$i++]="Enter Mobile 1 Number.";
					}
					else
					{
						if(!preg_match('/^([0-9]{08,15})+$/iD',$mobile1))
						{
							$success=0;
							$errors[$i++]="Invalid Mobile 1. only 10 to 12 digit allowed";
						}
					}
					/*if($email_id=="")
					{
						$success=0;
						$errors[$i++]="Enter Email ID.";
					}else
					{
						if(!filter_var($email_id, FILTER_VALIDATE_EMAIL))
						{
							$success=0;
							$errors[$i++]="Invalid Email ID ";
						}
					}*/
															
					
					if($course_interested=="select")
					{
						$success=0;
						$errors[$i++]="Enter your course_interested";
					}
				   
					if($followup_date1 !='//' )
					{
					
						$sep_date = explode('/',$followup_date1);
						$followup_date = $sep_date[2].'-'.$sep_date[1].'-'.$sep_date[0];
					}
					else
					{
						if($followup_date1 <= date('(Y-m-d)') )
						{
							$success=0;
							$errors[$i++]="Invalid Followup Date";
						}
						$success=0;
						$errors[$i++]="Enter your Followup Date";
					}
					
					if($total_fees=="")
					{
						$success=0;
						$errors[$i++]="Enter Course fees";
					}
					if($enquiry_src=="")
					{
						$success=0;
						$errors[$i++]="Select Source";
					}
					if($response=="")
					{
						$success=0;
						$errors[$i++]="Select Response Category";
					}
					if(count($errors))
					{
						?>
						<table width="90%" align="left" class="alert">
							<tr>
								<td align="left"><strong>Please correct the following errors</strong>
								<div style=" border: 1px solid #F00 ; padding-left:20px; background-color:#FC9">
									<?php
									for($k=0;$k<count($errors);$k++)
											echo '<div style="text-align:left;padding:5px;">'.$errors[$k].'</div>'; ?>
								  </div></td>
							</tr>
						</table>
						<br clear="all">
  			<?php
			}
			else
			{
				$success=1;
				$data_record['inquiry_date']=$inquiry_date;
				$data_record['lead_category'] = $lead_category;
				$data_record['lead_category_followup'] = $lead_category_followup;
				$data_record['lead_grade'] = $lead_grade;
				$data_record['firstname'] = $firstname;
				$data_record['middlename'] = $middlename;
				$data_record['lastname'] = $lastname;
				$data_record['birth_date'] = $birth_date; 
				$data_record['gender'] = $gender;
				$data_record['maritalstatus'] = $maritalstatus;
				$data_record['adress'] = $address;
				$data_record['country_id'] =$country;
				$data_record['state_id'] =$state;
				$data_record['religion'] =$religion;
				$data_record['city_id'] =$city;
				$data_record['area_id'] =$area;
				$data_record['mobile1'] = $mobile1;
				$data_record['mobile2'] = $mobile2;
				$data_record['landline_no'] = $landline_no;
				$data_record['email_id'] = $email_id;
				$data_record['education'] = $education;
				$data_record['course_interested'] = $course_interested;	
				$data_record['total_fees'] = $total_fees;
				$data_record['enquiry_date'] = $enquiry_date;
				$data_record['duration_studies'] = $duration_studies;
				$data_record['batch'] = $batch;
				$data_record['enquiry_source'] = $enquiry_src;
				$data_record['enquiry_type_category'] = $enquiry_type_category;
				$data_record['remark'] = $remark;  
				$data_record['inquiry_for'] = $inquiry_for;
				$data_record['followup_date'] =$followup_date;
				$data_record['not_status']='signs_on';
				$data_record['added_date'] =date('Y-m-d H:i:s');
				$data_record['response']=$response;
				$data_record['response_reason']=$response_reason;
				$data_record['followup_details']=$followup_desc;
				$data_record['employee_id']=$employee_id;
				/*if($course_interested !='')
				{
					echo"<br />".$select_existing_course_id="select course_id,course_name from courses where course_id='$course_interested' ";
					$ptr_course_id = mysql_query($select_existing_course_id);
					
					if(mysql_num_rows($ptr_course_id))
					{
						$data_course_id = mysql_fetch_array($ptr_course_id);
						$course_id = $data_course_id['course_id'];
						$course_interested = $data_course_id['course_name'];
					}
					else
					{
						$insert_new_course = " insert into courses(`admin_id`,`course_name`,`course_price`,`course_duration`,`added_date`)values('".$_SESSION['admin_id']."','".addslashes($customised_course)."', '$total_fees','$duration_studies','".date('Y-m-d H:i:s')."' ) ";
						$ptr_insert= mysql_query($insert_new_course);
						$course_id = mysql_insert_id();
					}
				}*/
				//===============================CM ID for Super Admin===============
				if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
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
					$update_inquiry= "update inquiry set `inquiry_date`='$inquiry_date', `course_id`='$course_interested', `lead_category`='$lead_category',`firstname`='$firstname',`middlename`='$middlename',`lastname`='$lastname',`birth_date`= '$birth_date',`gender`= '$gender',`maritalstatus`='$maritalstatus',`address`='$address',`mobile1`='$mobile1',`mobile2`= '$mobile2',`landline_no`='$landline_no',`email_id`= '$email_id', `education`= '$education', `total_fees`='$total_fees', `enquiry_date`='".date('Y-m-d H:i:s')."',`duration_studies`='$duration_studies',`batch`='$batch',`enquiry_source`= '$enquiry_src',`remark`='$remark',`inquiry_for`='$inquiry_for',`followup_date`= '$followup_date',`followup_details` ='$followup_desc',`lead_category_followup`='$lead_category_followup',`lead_grade`='$lead_grade',`added_date`='".date('Y-m-d H:i:s')."',`cm_id` ='".$cm_id."',`response`='$response',`response_reason`='".$response_reason."',`employee_id`='".$employee_id."' where inquiry_id='".$record_id."'";
					$ptr_update=mysql_query($update_inquiry);
					$up_inqyiry_id = mysql_insert_id();
									
					$update_stud="update stud_regi set `course_id`='$course_interested',`admin_id`='".$_SESSION['admin_id']."', `cm_id`='".$cm_id."',`name`='".$firstname." ".$lastname."',`dob`='$birth_date',`address`='".$address."',`contact`='$mobile1', `mail`='".$email_id."',`qualification`='$education',`added_date`='".date('Y-m-d H:i:s')."', `status`='Enquiry' ,`not_status`='signs_on',`enquiry_source`='$enquiry_src',`response`='$response' where student_id='".$record_id."'";
					$ptr_stud_update=mysql_query($update_stud);
									
					$sel_foll="select followup_id from followup_details where student_id='".$record_id."' order by followup_id asc limit 0,1";
					$ptr_foll=mysql_query($sel_foll);
					if(mysql_num_rows($ptr_foll))
					{
						$update_followups="update followup_details set `lead_category_followup`='".$lead_category_followup."',`followup_date`='".$followup_date."',`lead_grade`= '".$lead_grade."',`cm_id` ='".$cm_id."' where student_id ='".$record_id."'";
						$ptr_update_followups=mysql_query($update_followups);
					}
					else
					{
						$insert_followup = "INSERT INTO `followup_details` (`student_id`,`lead_category_followup`, `followup_date`,`followup_details`,`lead_grade`,`response`, `added_date`, `cm_id`,`admin_id`)VALUES ('".$record_id."','".$lead_category_followup."', '".$followup_date."','".$followup_desc."','".$lead_grade."','".$response."','".date('Y-m-d H:i:s')."','".$cm_id."','".$admin_id."')";
						$ptr_followup = mysql_query($insert_followup);
					}
					
					$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('inquiry','Edit','".$firstname." ".$middlename." ".$lastname."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert);    
					
					echo'<br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
					?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Enquiry added successfully</p></center></div>
						<script type="text/javascript">
                            $(document).ready(function() {
                                $( "#statusChangesDiv" ).dialog({
                                        modal: true,
                                        buttons: {
                                                    Ok: function() { $( this ).dialog( "close" );}
                                                 }
                                });
                                
                            });
                            setTimeout('document.location.href="manage_student.php";',1000);
                        </script>
                    <?php
                }
                else
                {
					$insert= "INSERT INTO inquiry (`inquiry_date`, `course_id`, `lead_category`, `firstname`, `middlename`, `lastname`, `birth_date`, `gender`, `maritalstatus`, `address`, `mobile1`,`mobile2`,`landline_no`,`email_id`, `education`,`total_fees`, `enquiry_date`,`duration_studies`, `batch`,`enquiry_source`, `remark`, `inquiry_for`,`followup_date`,`followup_details`, `lead_category_followup`,`lead_grade`,`added_date`,`cm_id`,`admin_id`, `status`,`enquiry_from`, `response`,`response_reason`, `employee_id`) VALUES ('".$inquiry_date."','".$course_interested."','".$lead_category."','".$firstname."','".$middlename."','".$lastname."','".$birth_date."','".$gender."','".$maritalstatus."','".addslashes($address)."','".$mobile1."','".$mobile2."','".$landline_no."','".$email_id."','".$education."','".$total_fees."','".date('Y-m-d H:i:s')."','".$duration_studies."', '".$batch."','".$enquiry_src."', '".addslashes($remark)."','".$inquiry_for."','".$followup_date."','".addslashes($followup_desc)."','".$lead_category_followup."','".$lead_grade."','".date('Y-m-d H:i:s')."','".$cm_id."','".$_SESSION['admin_id']."','Enquiry','offline','".$response."','".$response_reason."','".$employee_id."')";
					$ptr_query=mysql_query($insert);
 					$inqyiry_id1 = mysql_insert_id();
					
					if($response=='1' && $cm_id=='60')
					{
						$update_cnt="update inquiry set apply_now_disc='yes',countdown_time='".date("Y-m-d H:i:s", strtotime('+3 days'))."' where inquiry_id='".$inqyiry_id1."' ";
						$ptr_cnt=mysql_query($update_cnt);
					}
					
					if($inqyiry_id1 !='')
					{
 						$insert_regi = "INSERT INTO `stud_regi` (`class_id`,`course_id`,`admin_id`,`cm_id`,`name`,  `dob`, `address`, `contact`, `mail`, `qualification`,  `added_date`, `status` ,`not_status`,`enquiry_source`,`response`) VALUES ('".$inqyiry_id1."','".$course_interested."','".$_SESSION['admin_id']."','".$cm_id."', '".$firstname." ".$lastname."', '".$birth_date."', '".$address."', '".$mobile1."', '".$email_id."', '$education', '".date('Y-m-d H:i:s')."', 'Enquiry','signs_on','".$enquiry_src."','".$response."')";
 						$ptr_reg = mysql_query($insert_regi);

 						$insert_followup = "INSERT INTO `followup_details` (`student_id`,`lead_category_followup`, `followup_date`,`followup_details`,`lead_grade`,`response`, `added_date`, `cm_id`,`admin_id`)VALUES ('".$inqyiry_id1."','".$lead_category_followup."', '".$followup_date."','".$followup_desc."','".$lead_grade."','".$response."','".date('Y-m-d H:i:s')."','".$cm_id."','".$admin_id."')";
						$ptr_followup = mysql_query($insert_followup);
					}
					else
					{
						echo '<br></br><div id="msgbox" style="width:40%;">Insert Query Error to adding Inquiry</center></div> <br></br>';
						exit();
					}
					"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('inquiry','ADD','".$firstname." ".$middlename." ".$lastname."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert);    
					//---------Send Message-------------
					$sel_course_name="select course_name from courses where course_id='".$course_interested."'";
					$ptr_course_sel=mysql_query($sel_course_name);
					$data_course_name=mysql_fetch_array($ptr_course_sel);
									
					/* $sel_resp="select * from responce_category where responce_id='".$response."'";
					$ptr_query=mysql_query($sel_resp);
					$resp='';
					if(mysql_num_rows($ptr_query))
					{
						$data_resp=mysql_fetch_array($ptr_query);
						if($response==$data_resp['responce_id'])
						{
							$resp =$data_resp['sms_text']." ";
						}
					} */
					///$mesg ="Enquiry of ".$firstname." ".$lastname.", for ".$data_course_name['course_name']." and respnce by";
					$sel_inq="select sms_text from previleges where privilege_id='38'";
					$ptr_inq=mysql_query($sel_inq);
					$txt_msg='';
					if(mysql_num_rows($ptr_inq))
					{
						$dta_msg=mysql_fetch_array($ptr_inq);
						$txt_msg=$dta_msg['sms_text']." ";
					}
					//$messagessss =$mesg.$resp." has successfully placed for ".$branch_name." branch".$txt_msg;
					//$messagessss=$txt_msg;
					$sel_cnt="select contact_phone from site_setting where type='C' and other_type='inquiry' and branch_name='".$branch_name."' ";
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
					
					$sel_br="select branch_address from branch where branch_name='".$branch_name1."'";
					$ptr_br=mysql_query($sel_br);
					$data_br=mysql_fetch_array($ptr_br);
					$address=$data_br['branch_address'];
					
					/*if($branch_name1=="Pune")
					{
						$address="International School of Aesthetics and Spa, 2nd Floor, The Greens,Next to New HDFC Bank,North Main Road,Koregoan Park, Pune-411001. Website:  https://isasbeautyschool.com ";//https://bit.ly/2yOhji6 ,Events - https://bit.ly/2O2uDTU ,Student artwork - https://bit.ly/2La2VXz ,Institute Photos: https://bit.ly/2O2qO0Q
					}
					else if($branch_name1=="Ahmedabad")
					{
						$address="International School of Aesthetics and Spa, First Floor, Zodiac Plaza,Near Nabard Flat, H.L. Comm. College Road, Navrangpura, Ahmedabad- 380 009.Tel No-:079-26300007. Website:  https://isasbeautyschool.com "; //Location: https://bit.ly/2N28vbw ,Events: https://bit.ly/2O2uDTU ,Student artwork: https://bit.ly/2La2VXz ,Institute photos: https://bit.ly/2uzwfMx
					}
					else if($branch_name1=="ISAS PCMC")
					{
						$address="Hari A1,Next to ABS Gym, Pimple Nilakh, Pune 411027. Website:  https://isasbeautyschool.com"; //Location: https://bit.ly/2Ke26fQ ,Events - https://bit.ly/2O2uDTU ,Student artwork: https://bit.ly/2La2VXz ,Institute photos: https://bit.ly/2LrF6JM
					}*/
					
					$search_by= array("student_name", "course_name", "branch_name", "mobile_no","address");
					$replace_by = array($firstname, $data_course_name['course_name'], $branch_name, $staff_contact,$address);
					$messagessss = str_replace($search_by, $replace_by, $messagessss);

					$messagessss =urlencode($messagessss);
					$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='38' ".$_SESSION['where']."";
					$ptr_sel_sms=mysql_query($sel_sms_cnt);
					while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
					{
					    $sel_act="select contact_phone from site_setting where admin_id='".$data_sel_cnt['staff_id']."' ".$_SESSION['where']." ";										
						$ptr_cnt=mysql_query($sel_act);
						if(mysql_num_rows($ptr_cnt))
						{
							$data_cnt=mysql_fetch_array($ptr_cnt);
							//send_sms_function($data_cnt['contact_phone'],$messagessss);
						}
					}
					if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD')
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
					send_sms_function($mobile1,$messagessss);
							
					//------send notification on inquiry addition-----
					$notification_args['reference_id'] = $inqyiry_id1;
					$notification_args['on_action'] = 'enquiry_added';
					$notification_status = addNotifications($notification_args);
					//-----------------------------------------------
					$insert_sms="insert into sms_log_history (`name`,`mobile_no`,`sms_text`,`sms_type`,`admin_id`,`cm_id`,`added_date`) values('".$firstname."','".$mobile1."','".$messagessss."','inquiry','".$_SESSION['admin_id']."','".$_SESSION['cm_id']."','".date('Y-m-d H:i:s')."')";
					$ptr_sms=mysql_query($insert_sms);
					/*-------------------------------------------------------------------------*/
					echo '<br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
						?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Enquiry added successfully</p></center></div>
							<script type="text/javascript">
								$(document).ready(function() {
								$( "#statusChangesDiv" ).dialog({
									modal: true,
									buttons: {
											Ok: function() { $( this ).dialog( "close" );}
								}
								});
							});
						setTimeout('document.location.href="manage_student.php";',1000);
						</script>
      					<?php
					}//else record id
				}
			}
			
			$redonly='';
			if($_SESSION['type']!='S' || $edit_access!='yes')
			{
				$redonly='readonly="readonly"';
			}
            if($success==0)
            {
	            ?>
          		<tr>
         			<td colspan="2"><form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data" onSubmit="return validme()">
              			<table border="0" cellspacing="15" cellpadding="0" width="100%">
                               
							<tr>
								<?php
								$select_email_id= "select email from site_setting where 1 cm_id='".$_SESSION['cm_id']."' and type='A' and email !='' ";					
								$ptr_emails = mysql_query($select_email_id);
								$data_emails = mysql_fetch_array($ptr_emails);
								?>
								<td><input type="hidden" name="inqyiry_idss" id="inqyiry_idss" value="<?php echo $data_emails['email']; ?>" /></td> 						</tr>
               				<tr>
                   				<td height="30" colspan="3" class="orange_font">* Mandatory Fields <input type="hidden" name="record_id" id="record_id" value="<?php echo $record_id; ?>"/></td>
               				</tr>
                      				<tr>
                      					<td width="22%"class="orange_font">* Date Format should be [ DD/MM/YYYY ]</td>
                     				</tr>
                       				<?php 
									if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
									{
									?>
                      				<tr>
                      					<td>Select Branch</td>
                        				<td>
										<?php 
                                        $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
                                        $query_branch = mysql_query($sel_branch);
                                        $total_Branch = mysql_num_rows($query_branch);
                                        echo '<table width="100%"><tr><td>';
                                        echo '<select id="branch_name" name="branch_name" onchange="show_bank(this.value)" style="width:150px">';
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
                       			<input type="hidden"  name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                       		<?php }?>
							 
                				<tr>
									<td width="22%">Inquiry Date<span class="orange_font"></span></td>
									<td width="44%"><input type="text" class="input_text datepicker" <?php echo $redonly; ?> name="inquiry_date" id="inquiry_date" 	value="<?php 
									if($_POST['inquiry_date']) 
									echo $_POST['inquiry_date']; 
									else if($row_record['inquiry_date'] !='')
									{
										$arrage_datesa= explode(' ',$row_record['inquiry_date']);     
										$arrage_date= explode('-',$arrage_datesa[0],3);     
										echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0]; 
									}else echo date('d/m/Y')?>" />
									</td>
									<td width="34%"></td>
								</tr>
                               
                				<tr>
                        			<td width="22%">Lead Category<span class="orange_font">*</span></td>
                        			<td width="44%"><input type="radio" name ="lead_category" id="lead_category" checked="checked" value="phone" <?php if($_POST['lead_category'] == "phone") echo 'checked="checked"'; else if($row_record['lead_category'] == "phone") echo 'checked="checked"'; ?> /> Phone 
                        <input type="radio" name ="lead_category" id="lead_category" value="walkin" <?php if($_POST['lead_category'] == "walkin") echo 'checked="checked"'; else if($row_record['lead_category'] == "walkin") echo 'checked="checked"'; ?> /> Walk-in</td>
                      			</tr>
                   				<tr>
                        			<td width="22%">Firstname<span class="orange_font">*</span></td>
                        			<td width="44%"><input type="text" class="input_text required" name="firstname" id="firstname" value="<?php if($_POST['firstname']) echo $_POST['firstname']; else echo $row_record['firstname'];?>"/>
                                    </td>
                      			</tr>
                    			<tr>
                        			<td width="22%" >Middlename<span class="orange_font"></span></td>
                        			<td width="44%"><input type="text" class="input_text" name="middlename" id="middlename"
                                            value="<?php if($_POST['middlename']) echo $_POST['middlename']; else echo $row_record['middlename'];
											?>"/></td>
                      			</tr>
                    			<tr>
                       				<td width="22%">Lastname<span class="orange_font"></span></td>
                        			<td 40%><input type="text" class="input_text" name="lastname" id="lastname" value="<?php if($_POST['lastname']) echo $_POST['lastname']; else echo $row_record['lastname']; ?>"/></td>
                      			</tr>
                    			<tr>
                        			<td width="22%">Birth Date<span class="orange_font"></span></td>
                        			<td width="44%"><input type="text" class="input_text datepicker" name="dob" id="dob" value="<?php if($_POST['dob']) 
									echo $_POST['dob']; 
									else if($row_record['birth_date'] !='')
									{
										$arrage_date= explode('-',$row_record['birth_date'],3);     
										echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0]; 
									}?>" />
                                    </td>
                        			<td width="34%"></td>
                      			</tr>
                    			<tr>
                        			<td width="22%">Marital Status<span class="orange_font"></span></td>
                        			<td width="44%"><select id="maritalstatus" name="maritalstatus" class="input_text">
                            		<option    value="">---Select---</option>
                            		<option  value="Married" <? if ($_POST['maritalstatus'] == "Married") echo "selected='selected'"; else if($row_record['maritalstatus'] == "Married") echo "selected='selected'";?> >Married</option>
                            		<option   value="Unmarried" <? if ($_POST['maritalstatus'] == "Unmarried") echo "selected='selected'"; else if($row_record['maritalstatus']== "Unmarried") echo "selected='selected'";?>>Unmarried</option>
                          			</select>
                                   	</td>
                      			</tr>
                    			<tr>
                        			<td width="22%">Gender<span class="orange_font"></span></td>
                        			<td width="44%"> Female
                        			<input type="radio" name="gender" value="female" <? if (isset($gender) && $gender == "female" || $row_record['gender']== "female") echo "checked";?>  style="width:50px !important"/><br/>Male <input type="radio" name="gender" value="male" <? if (isset($gender) && $gender == "male" || $row_record['gender']== "male") echo "checked";?> style="width:76px !important" /></td>
                        			<td width="34%"></td>
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
                        			<td width="22%">Address<span class="orange_font"></span></td>
                        			<td width="44%"><textarea name="address" id="address" class="input_text textarea"><?php if($_POST['address']) echo $_POST['address']; else echo $row_record['address'];?></textarea></td>
                        			<td width="34%"></td>
                      			</tr>
                    			<tr>
                        			<td width="22%">Mobile 1<span class="orange_font">*</span></td>
                        			<td width="44%"><input type="text" class="input_text" name="mobile1" id="mobile1" value="<?php if($_POST['mobile1']) echo $_POST['mobile1']; else echo $row_record['mobile1'];?>" onKeyPress="return isNumber(event)" maxlength="15"/></td>
                        			<td width="34%"><div id="feedback"></div></td>
                      			</tr>
                    			<tr>
                        			<td width="22%"> Mobile 2 </td>
                        			<td width="44%"><input type="text" class=" input_text" name="mobile2" id="mobile2" value="<?php if($_POST['mobile2']) echo $_POST['mobile2']; else echo $row_record['mobile2'];?>" onKeyPress="return isNumber(event)" maxlength="15"/></td>
                        			<td width="40%"><div id="feedback2"></div></td>
                      			</tr>
                   				<tr>
                        			<td width="22%">Landline No</td>
                                    <td width="44%"><input type="text" class="input_text" name="landline_no" id="landline_no" value="<?php if($_POST['landline_no']) echo $_POST['landline_no']; else echo $row_record['landline_no'];?>"/></td>
                                    <td width="34%"></td>
                                </tr>
                                <tr>
                                    <td width="22%">E-Mail<span class="orange_font"></span></td>
                                    <td width="44%"><input type="text" class=" input_text" name="email_id" id="email_id" value="<?php if($_POST['email_id']) echo $_POST['email_id']; else echo $row_record['email_id'];?>" /></td>
                                    <td width="34%"></td>
                                </tr>
								<tr>
									<td width="20%">Select Country<span class="orange_font"></span></td>
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
									<td width="20%">Select State<span class="orange_font"></span></td>
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
									<td width="20%">Select City<span class="orange_font"></span></td>
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
                        			<td width="22%">Education<span class="orange_font"></span></td>
                        			<td width="44%"><select name="education" id="education"  class="input_select" >
                                    <option  value="">----Select----</option>
                                    <option  value="SSC" <? if (isset($education) && $education == "SSC") echo "selected"; else if ($row_record['education'] == "SSC" ) echo "selected";?> >SSC</option>
                                    <option  value="HSC" <? if (isset($education) && $education == "HSC") echo "selected"; else if ($row_record['education'] == "HSC" ) echo "selected";?> >HSC</option>
                                    <option value="Under Graduation" <? if (isset($education) && $education == "Under Graduation") echo "selected"; else if ($row_record['education'] == "Under Graduation" ) echo "selected";?> >Under Graduation</option>
                                    <option value="Graduation" <? if (isset($education) && $education == "Graduation") echo "selected"; else if ($row_record['education'] == "Graduation" ) echo "selected";?> >Graduation</option>
                                    <option value="Post Graduation" <? if (isset($education) && $education == "Post Graduation") echo "selected"; else if ($row_record['education'] == "Post Graduation" ) echo "selected";?> >Post Graduation</option>
                                     <option value="Other" <? if (isset($education) && $education == "Other") echo "selected"; else if ($row_record['education'] == "Other" ) echo "selected";?> >Other</option>
                                  </select></td>
                     			</tr>
                    			<tr>
                                    <td width="22%">Course Interested<span class="orange_font">*</span></td>
                                    <td class="customized_select_box">
                                    <select id="course_id" name="course_id" onChange="show_course(this.value);" class="input_text">
                                       <option value="">Select</option>
                                       <?php
                                       $course_category = " select category_name,category_id from course_category ";
                                       $ptr_course_cat = mysql_query($course_category);
                                       while($data_cat = mysql_fetch_array($ptr_course_cat))
                                       {
                                            echo " <optgroup label='".$data_cat['category_name']."'>";
                                            $get="SELECT course_id,course_name FROM courses where category_id='".$data_cat['category_id']."' order by course_id";
                                            $myQuery=mysql_query($get);
                                            while($row = mysql_fetch_assoc($myQuery))
                                            {
                                                $selected_course='';
                                                if($row_record['course_id'] == $row['course_id'])
                                                {
                                                    $selected_course='selected="selected"';
                                                }
                                            ?>
                            				<option <?php echo $selected_course; ?> value = "<?php echo $row['course_id']?>" <?php if (isset($course_interested) && $course_interested == $row['course_name']) echo "selected";?> > <?php echo $row['course_name'] ?> </option>
                           				<?php }
										echo " </optgroup>";
										}?>
                            				<option value="custome">Customised Course</option>
                          			</select>
                                   </td>
                     			</tr>
                    			<tr>
                        			<td colspan="3"><div id="custome_div" style="display:none">
                            			<table width="100%">
                            			<tr>
                                			<td width="26%">Customised Course<span class="orange_font">*</span></td>
                                			<td width="40%"><input type="text" class="input_text" name="customised_course" id="customised_course"  value="<?php if($_POST['customised_course']) echo $_POST['customised_course']; else echo $row_record['customised_course'];?>"/></td>
                                			<td width="20%">&nbsp;</td>
                              			</tr>
                          				</table>
                          			</div>
                                    </td>
                      			</tr>
                    			<tr>
                        			<td width="22%"> Duration For Studies </td>
                        			<td width="44%" ><div id="show_subject"></div>
                        			<input type="text" class="input_text" name="duration_studies" id="duration_studies" value="<?php if($_POST['duration_studies'])echo $_POST['duration_studies']; else echo $row_record['duration_studies'];?>" /></td>
                       				 <td width="34%"></td>
                      			</tr>
                                <?php
								if($_SESSION['type']!='S' || $edit_access!='yes')
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
                        			<td width="22%">Course Fees
                                    <?php
									if($_SESSION['tax_type']=='GST')
									{
										echo '(with CGST <span id="cgst_id"></span>% and SGST <span id="sgst_id"></span>%)';
										if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ $s_cgst= $_SESSION['cgst'];}
										if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ $s_sgst= $_SESSION['sgst'];}
										echo '<input type="hidden" id="cgst_taxes" name="cgst_taxes" value="'.$s_cgst.'"  /><input type="hidden" id="sgst_taxes" name="sgst_taxes" value="'.$s_sgst.'"/>';
									}
									else if($_SESSION['tax_type']=='service_tax')
									{
										echo '(with VAT <span id="service_tax_id"></span>%)';
										if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ $v_servTax= $_SESSION['service_tax'];}
										echo '<input type="hidden" id="service_taxes" value="'.$v_servTax.'" />';
									}
									else
									{
										echo '(Not included any tax)';
									}
									?>                                    
                        			</td>
                        			<td width="44%"><input readonly="readonly" type="text" <?php echo $readonly; echo $bg;?> class=" input_text" name="total_fees" id="toal_fees" value="<?php if($_POST['total_fees'])echo $_POST['total_fees']; else echo $row_record['total_fees'];?>"/></td>
                        			<td width="34%">
                                    <input type="hidden" name="discount_otp" id="discount_otp" value="" />
                                    <input type="hidden" name="discount_inst" id="discount_inst" value="" />
                                    <input type="hidden" name="discount_now_otp" id="discount_now_otp" value="" />
                                    <input type="hidden" name="discount_now_inst" id="discount_now_inst" value="" />
                                    <input type="hidden" name="discount_otp_inst" id="discount_otp_inst" value="" />
                                    <input type="hidden" name="discount_now_otp_inst" id="discount_now_otp_inst" value="" />
                                    </td>
                      			</tr>
                                <tr>
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
                                    <input type="radio" name='paid_type' id="paid_type" value="one_time" <?php if($_POST['paid_type'] =="one_time")  echo 'checked="checked"'; ?>  checked="checked" onChange="show_record()" />One Time <input type="radio" name='paid_type' id="paid_type" value="installments" <?php if($_POST['paid_type'] =="installments")  echo 'checked="checked"'; ?> onChange="show_record()" />OTP with Installment <input type="hidden" id="inst_taxes" value="<?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['installment_tax'];} ?>"  /> <input type="radio" name='paid_type' id="paid_type" value="installments_zero"  <?php if($_POST['paid_type'] =="installments_zero")  echo 'checked="checked"'; ?> onChange="show_record()" />Installment 0% add
                                    </td>                
                                    <td width="40%"></td>
                                </tr>
                                <tr>
                                    <td width="22%">Discount in <input type="radio" name='discount_type' readonly="readonly" value="<?php if($_POST['discount_type']) echo $_POST['discount_type']; else echo percent; ?>" checked="checked" onChange="show_record()" />% <!--or--> <input type="hidden" name='discount_type' <?php echo $en_readonly; ?> value="<?php //if($_POST['discount_type']) echo $_POST['discount_type']; else echo cash; ?>" onChange="show_record()" /><!--Cash--></td>
                                    <td width="38%"><input type="text" class="input_text" <?php echo $en_readonly; ?> name="concession" <?php echo $readonly; echo $bg;?> id="concession" value="<?php if($_POST['concession']) echo $_POST['concession']; else if($row_record['discount'] !=0) echo $row_record['discount']; else echo 0; ?>" onBlur="show_record()"/>
                                    </td>
                                    <td width="40%">
                                    </td>
                                </tr>
                                <tr>    
                                   <td width="20%" class="heading">Net Fees<span class="orange_font">*</span></td>
                                   <td><input type="text" class="validate[required] input_text" <?php echo $readonly; echo $bg;?> name="net_fees" id="net_fees" value="<?php if($_POST['net_fees']) echo $_POST['net_fees']; else echo $row_record['net_fees'];?>" /></td>
                    
                                </tr>
                    			<tr>
                        			<td width="22%">Prefer Batch </td>
                        			<td width="44%">
                                    <select id="batch" name="batch" class="input_select">
                            		<option value="">----Select----</option>
									<?php 
                                    $sel_batch="SELECT * FROM batch_time";
                                    $ptr_batch=mysql_query($sel_batch);
                                    while($data_batch=mysql_fetch_array($ptr_batch))
                                    {
                                        $sele_batch="";
                                        if($data_batch['batch_time_id'] == $row_record['batch'])
                                        {
                                            $sele_batch='selected="selected"';
                                        }
                                    ?>
                                        <option <?php echo $sele_batch; ?> value="<?php echo $data_batch['batch_time_id']?>" <?php if ($_POST['batch']== $data_batch['batch_time_id']) echo 'selected="selected"';?> > <?php echo $data_batch['batch_time'] ?> </option>
                                    <?php
                                    }
                                    ?>
                           
                          			</select>
                                    </td>
                        			<td width="34%"></td>
                      			</tr>
                                
                    			<tr>
                                    <td width="22%" class="heading">Enquiry Source<span class="orange_font">*</span></td>
                                    <td>
                                    <select id="enquiry_src" name="enquiry_src" <?php echo $redonly; ?> class="input_select">
                                    <option value="">----Select----</option>
                                    <?php 
									$course_category ="select DISTINCT(cm_id),branch_name from site_setting where type='A' ".$_SESSION['where']."";
									$ptr_course_cat=mysql_query($course_category);
									while($data_cat=mysql_fetch_array($ptr_course_cat))
									{
										echo "<optgroup label='".$data_cat['branch_name']."'>";
										$sel_source="SELECT * FROM campaign where 1 and cm_id='".$data_cat['cm_id']."' and campaign_for='institute' and status='Active'";
										$ptr_src=mysql_query($sel_source);
										while($data_src=mysql_fetch_array($ptr_src))
										{
											$sele_source="";
											if($data_src['campaign_id'] == $row_record['enquiry_source'] || $_POST['enquiry_src']== $data_src['campaign_id'] )
											{
												$sele_source='selected="selected"';
											}
											?>
											<option <?php echo $sele_source?> value ="<?php echo $data_src['campaign_id']?>" <? if (isset($enquiry_src) && $enquiry_src == $data_src['campaign_name']) echo "selected";?> > <?php echo $data_src['campaign_name'] ?> </option>
											<?
										}
										echo " </optgroup>";
									}?>
                                    </select>
                                    </td>
                      			</tr>
                    			<!-- <tr>      
                                      <td width="20%" class="heading">Enquiry Taken By <span class="orange_font">*</span></td>
                                      <td><input type="text" class=" inputText" name="enquiry_taken" id="enquiry_taken" /></td>
                                </tr>-->
                                <tr>
                        			<td width="22%">Enquiry Type Category<span class="orange_font"></span></td>
                        			<td width="44%"><select id="enquiry_type_category" name="enquiry_type_category" class="input_text">
                            		<option  value="">Select Category</option>
                            		<option  value="student_default" <?php if ($_POST['enquiry_type_category'] == "student_default") echo "selected='selected'"; else if($row_record['enquiry_type_category'] == "student_default") echo "selected='selected'";?> >Student Default</option>
                            		<option   value="salon_data" <?php if ($_POST['enquiry_type_category'] == "salon_data") echo "selected='selected'"; else if($row_record['enquiry_type_category']== "salon_data") echo "selected='selected'";?>>Salon Data</option>
                                    <option   value="career_consultant" <?php if ($_POST['enquiry_type_category'] == "career_consultant") echo "selected='selected'"; else if($row_record['enquiry_type_category']== "career_consultant") echo "selected='selected'";?>>Career Consultant</option>
                                    <option   value="weeding_planner" <?php if ($_POST['enquiry_type_category'] == "weeding_planner") echo "selected='selected'"; else if($row_record['enquiry_type_category']== "weeding_planner") echo "selected='selected'";?>>Wedding Planners</option>
                                    <option   value="foreign_planner" <?php if ($_POST['enquiry_type_category'] == "foreign_planner") echo "selected='selected'"; else if($row_record['enquiry_type_category']== "foreign_planner") echo "selected='selected'";?>>Foreign Education</option>
                                    <option   value="community_tie-up" <?php if ($_POST['enquiry_type_category'] == "community_tie-up") echo "selected='selected'"; else if($row_record['enquiry_type_category']== "community_tie-up") echo "selected='selected'";?>>Community Tie-up</option>
                                     <option   value="corporate_tie-up" <?php if ($_POST['enquiry_type_category'] == "corporate_tie-up") echo "selected='selected'"; else if($row_record['enquiry_type_category']== "corporate_tie-up") echo "selected='selected'";?>>Corporate Tie Up</option>
                                    <option   value="school_tie-up" <?php if ($_POST['enquiry_type_category'] == "school_tie-up") echo "selected='selected'"; else if($row_record['enquiry_type_category']== "school_tie-up") echo "selected='selected'";?>>School/College Tie Up</option>
                                    <option   value="other_tie-up" <?php if ($_POST['enquiry_type_category'] == "other_tie-up") echo "selected='selected'"; else if($row_record['enquiry_type_category']== "other_tie-up") echo "selected='selected'";?>>Any Other Tie-Up</option>
                          			</select>
                                   	</td>
                      			</tr>
                   				<tr>
                                    <td width="22%" class="heading">Remark<span class="orange_font"></span></td>
                                    <td><textarea name="remark" id="remark" class="input_text" style="height: 53px;"><?php if($_POST['remark']) echo $_POST['remark']; else echo $row_record['remark'];?></textarea></td>
                                </tr>
                                <tr>
                                    <td width="22%" >Enquiry For</td>
                                    <td width="44%" ><textarea name="inquiry_for" id="inquiry_for" class="input_text" style="height: 53px;"><?php if($_POST['inquiry_for']) echo $_POST['inquiry_for']; else echo $row_record['inquiry_for'];?></textarea></td>
                                </tr>
                                <tr>
                      				<td width="22%">Lead Grade<span class="orange_font">*</span></td>
                        			<td width="44%">
                        			<input type="radio" name ="lead_grade" id="lead_grade" value="very_hot" <?php if($_POST['lead_grade'] == "very_hot") echo 'checked="checked"';else if($row_record['lead_grade'] == "very_hot") echo 'checked="checked"'; else echo 'checked="checked"'; ?> /> Very Hot &nbsp;
                        			<input type="radio" name ="lead_grade" id="lead_grade" value="hot"  <?php if($_POST['lead_grade'] == "hot") echo 'checked="checked"';else if($row_record['lead_grade'] == "hot") echo 'checked="checked"'; ?> /> Hot &nbsp;
                        			<input type="radio" name ="lead_grade" id="lead_grade" value="warm" <?php if($_POST['lead_grade'] == "warm") echo 'checked="checked"'; else if($row_record['lead_grade'] == "warm") echo 'checked="checked"'; ?> /> Warm&nbsp;
                        			<input type="radio" name ="lead_grade" id="lead_grade" value="Nutral" <?php if($_POST['lead_grade'] == "Nutral") echo 'checked="checked"';else if($row_record['lead_grade'] == "Nutral") echo 'checked="checked"'; ?> /> Nutral&nbsp;
                        			<input type="radio" name ="lead_grade" id="lead_grade" value="cold" <?php if($_POST['lead_grade'] == "cold") echo 'checked="checked"';else if($row_record['lead_grade'] == "cold") echo 'checked="checked"'; ?> /> Cold
                        			</td>
                      			</tr>
                       			<tr>
                        			<td width="22%">Response Category<span class="orange_font">*</span></td>
                        			<td width="44%"><select id="response" name="response" class="input_select" onchange="show_responce(this.value)">
                            		<option value="">--Select Resonse--</option>
									<?php 
                                    $sel_source="SELECT * FROM responce_category";
                                    $ptr_src=mysql_query($sel_source);
                                    while($data_src=mysql_fetch_array($ptr_src))
                                    {
                                        $sele_source="";
                                        if($data_src['responce_id']==$row_record['response'] || $_POST['response']==$data_src['responce_id'])
                                        {
                                            $sele_source='selected="selected"';
                                        }
                                        ?>
                                        <option <?php echo $sele_source?> value="<?php echo $data_src['responce_id']?>" <? if (isset($response) && $response == $data_src['responce_id']) echo "selected";?> > <?php echo $data_src['respnce_category_name'] ?> </option>
                                        <?php
                                    }
                                    ?>
                          			</select></td>
                        			<td width="34%"></td>
                      			</tr>
								<tr>
                        			<td colspan="3" width="100%" align="center">
                                    <div id="show_reason" style="display:none; width:100%">
                                    <table width="100%">
                                    	<tr>
                                        	<td width="22%">Reason for not intrested<span class="orange_font">*</span></td>
                                            <td><select id="response_reason" name="response_reason" class="input_select" style="width:400px" >
                                                    <option value="">--Select Reason--</option>
                                                    <option value="1">Long Distance</option>
                                                    <option value="2">High Fees</option>
                                                    <option value="3">Joined Somewhere</option>
                                                    <option value="4">Parents not allowed</option>
                                                    <option value="5">Problem with Institute</option>
                                                    <option value="6">Time Not match</option>
                                                    <option value="7">Plan Cancel</option>
                                                </select>
                                            </td>	
                                        </tr>
                                    </table>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                        			<td width="22%" >Followup Description</td>
                        			<td width="44%" ><textarea name="followup_desc" id="followup_desc" class="input_text" style="height: 53px;"><?php if($_POST['followup_desc']) echo $_POST['followup_desc']; else echo $row_record['followup_details'];?></textarea></td>
                      			</tr>
                                <tr>
                        			<td width="22%">Next Followup Date<span class="orange_font">*</span></td>
                        			<td width="44%"><input type="text" class="input_text datepicker" name="followup_date" id="followup_date" value="<?php if($_POST['followup_date']) echo $_POST['followup_date']; else {
										if($row_record['followup_date'] !='')
										{
											$arrage_date= explode('-',$row_record['followup_date'],3);     
											echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0]; 
										}
										// $row_record['staff_dob'];
									}?>" /></td>
                        			<td width="34%"><input type="radio" name ="lead_category_followup" id="lead_category_followup" checked="checked" value="phone_followup" <?php if($_POST['lead_category_followup'] == "phone_followup") echo 'checked="checked"'; else if($row_record['lead_category_followup'] == "phone_followup") echo 'checked="checked"'; ?> /> Phone Followup
                        			<input type="radio" name ="lead_category_followup" id="lead_category_followup" value="walkin_followup" <?php if($_POST['lead_category_followup'] == "walkin_followup") echo 'checked="checked"'; else if($row_record['lead_category_followup'] == "walkin_followup") echo 'checked="checked"'; ?> /> Walk-in Followup</td>
                      			</tr>
                                <?php
								/*if($_SESSION['type']=="S" && $_SESSION['type']=="Z")
								{
									$disbledA='';
								}
								else
								{
									$disbledA='readonly="readonly"';
								}*/
								?>
                                <tr>
                        			<td width="22%">Assigned to<span class="orange_font"></span></td>
                        			<td width="44%" id="emp_ids">
                                    <select id="employee_id" name="employee_id" class="input_select">
                            		<option value="">Select Staff</option>
                          			</select></td>
                        			<td width="34%"></td>
                      			</tr>
                                <!--<tr>
                                      <td width="30%" class="heading">Security Image)<span class="orange_font">*</span></td>
                                      <td><table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            
                                            <tr><td>
                                                    <img src="captcha/captcha.php" id="captcha" height="40px"/><img onClick="document.getElementById('captcha')
                                                    .src='captcha/captcha.php?'+Math.random();" id="change-image" style="cursor: pointer;" src="captcha/refresh.png" />
                                                </td>
                                                <td >&nbsp;</td>
                                            </tr>
                                            <tr><td width="30%"><input type="text"  name="captcha" id="captcha-form"/></td>
                                                
                                            </tr>
                                        </table></td>
                                </tr> -->
                    			<tr>
                        
                                	<td><input type="reset" class="inputButton" onClick="document.contactUs.reset();"/></td>&nbsp;
                                	<td><input type="submit" class="inputButton" value="Submit" name="submit" id="submit1" /></td>
                              	</tr>
                  			</table>
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
								<?php if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'){?>
									var branch_name= document.getElementById('branch_name').value;
								<?php } 
								else
								{?>
									var branch_name= "<?php $_SESSION['branch_name']; ?>";
									
								<?php }?>
								
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
                                var data1 = 'action=custome_course_submit&course_name='+course_name+'&course_duration='+course_duration+'&course_desc='+course_desc+'&course_fee='+course_fee+'&category_id='+category_id+'$branch_name='+branch_name
                                $.ajax({
                                    url: "ajax.php", type: "post", data: data1, cache: false,
                                    success: function (html)
                                    {
										
                                        $(".customized_select_box").html(html);
										
										var cgst_tax=(cgst_taxes * course_fee)/100;
										var sgst_tax=(sgst_taxes * course_fee)/100;
							
										//var tax=(service_taxes * course_fee)/100;
										var course_with_tax=Number(course_fee)+Number(cgst_tax)+Number(sgst_tax);
										
                                        $("#duration_studies").val(course_duration);
                                        $("#toal_fees").val(course_with_tax);
                                        $('.new_custom_course').dialog( 'close');
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
                                    <td width="40%">
                                    <input type="text" class="inputText" name="course_name" id="course_name"/></td>
                                </tr>
                                <tr>
                                    <td>Course Category<span class="orange_font">*</span></td>
                                    <td>
                                        <select name="category_id" id="category_id" class="validate[required] input_select" >  
                                            <option value=""> Select Category</option>
                                            <?php
                                                $select_category = "select * from course_category order by category_id asc";
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
                                    <td>
                                    <input type="button" class="inputButton custom_cuorse_submit" value="Submit" name="submit" id="submit1" />&nbsp;
                                    <input type="reset" class="inputButton" value="Close" onClick="$('.new_custom_course').dialog('close');"/>
                                    </td>
                                </tr>
                               
                            </table>
                        </form>
                    </div>
                </td>
              </tr>
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
    <div id="footer">
    <input type="hidden" name="course_only_fee" id="course_only_fee" value="" />
    <script>
	function show_record(vals,no)
	{    
		frm = document.jqueryForm; 
		concession=0; 
		//paid=0;
		totals_fees=0;
		balance=0;
		//================================PAID TYPE==========================
		paid_type =frm.paid_type.value;
		now_disc_type =frm.now_disc.value;
		
		if(document.getElementById('toal_fees') && vals !='' && no==1)
		{
			courses_fees=roundNumber(document.getElementById('toal_fees').value,3);
			document.getElementById('course_only_fee').value=courses_fees;
		}
		
		if(frm.now_disc[1].checked == true) //Now Discount
		{
			if(paid_type=='installments')
			{
				var discount_inst=document.getElementById('discount_now_otp_inst').value;
				document.getElementById('concession').value=discount_inst;
				
				totals_fees = roundNumber(document.getElementById('course_only_fee').value,3);
				document.getElementById('toal_fees').value=totals_fees;
				//document.getElementById("dropdown").disabled  = true;
				//down_fees=roundNumber(document.getElementById('down_payment').value,3);
				
				/*$("#dropdown option[value]").filter(function() {
					return +$(this).val() > 1;
				}).hide();*/
			}
			else if(paid_type=='installments_zero')
			{
				var discount_inst=document.getElementById('discount_now_inst').value;
				document.getElementById('concession').value=discount_inst;
				
				totals_fees = roundNumber(document.getElementById('course_only_fee').value,3);
				document.getElementById('toal_fees').value=totals_fees;
				/*document.getElementById("dropdown").disabled  = true;
				down_fees=roundNumber(document.getElementById('down_payment').value,3);
				$("#dropdown option[value]").filter(function() {
					return +$(this).val() > 1;
				}).show();*/
			}
			else
			{
				var discount_otp=document.getElementById('discount_now_otp').value;
				document.getElementById('concession').value=discount_otp;
				
				/*document.getElementById("dropdown").disabled  = true;
				var inst1 = document.getElementById("dropdown").disabled  = true;
				$('#dropdown').removeClass("obrderclass");  */
				totals_fees = roundNumber(document.getElementById('course_only_fee').value,3);
				document.getElementById('toal_fees').value=totals_fees;
			}
		}
		else //Normal Discount
		{
			if(paid_type=='installments')
			{
				var discount_inst=document.getElementById('discount_otp_inst').value;
				document.getElementById('concession').value=discount_inst;
				
				totals_fees = roundNumber(document.getElementById('course_only_fee').value,3);
				document.getElementById('toal_fees').value=totals_fees;
				/*document.getElementById("dropdown").disabled  = true;
				down_fees=roundNumber(document.getElementById('down_payment').value,3);
				
				$("#dropdown option[value]").filter(function() {
					return +$(this).val() > 1;
				}).hide();*/
			}
			else if(paid_type=='installments_zero')
			{
				var discount_inst=document.getElementById('discount_inst').value;
				document.getElementById('concession').value=discount_inst;
				
				totals_fees = roundNumber(document.getElementById('course_only_fee').value,3);
				document.getElementById('toal_fees').value=totals_fees;
				/*document.getElementById("dropdown").disabled  = true;
				down_fees=roundNumber(document.getElementById('down_payment').value,3);
				$("#dropdown option[value]").filter(function() {
					return +$(this).val() > 1;
				}).show();*/
			}
			else
			{
				var discount_otp=document.getElementById('discount_otp').value;
				document.getElementById('concession').value=discount_otp;
				
				/*document.getElementById("dropdown").disabled  = true;
				var inst1 = document.getElementById("dropdown").disabled  = true;
				$('#dropdown').removeClass("obrderclass");  */
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
		
		//var coupon_disc=document.getElementById("discount_coupon_per").value;
		//var local = coupon_disc;
		
		/*if(local > 0)
		{
			var disc_perc= roundNumber(local*total_bal_ava/100,3);
			var total_disc_coupon= roundNumber(total_bal_ava - disc_perc,3);
			document.getElementById('net_fees').value=total_disc_coupon;
			document.getElementById('discount_coupon_price').value=local;
		}*/
		//var net_fees=roundNumber(document.getElementById('net_fees').value,3);
		
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
			/*var studs_id=document.getElementById('record_id').value;
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
			});*/
			
		}
		//var paid_type = document.getElementById('paid_type').value;
		setTimeout(show_record(),200);
	}
	</script>
    
      <?php require("include/footer.php");?>
    </div>
    <script>
	branch_name =document.getElementById("branch_name").value;
	//alert(branch_name);
	show_bank(branch_name);
	</script>
    <!--footer end-->
</body>
</html>
<?php $db->close();?>