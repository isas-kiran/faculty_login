<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>

<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM campaign where campaign_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
}
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>
    <?php if($record_id) echo "Edit"; else echo "Add";?>
    Campaign</title>
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
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    
     <style type = "text/css">
		.obrderclass{ border:1px solid #f00}
    </style>  
   
     <script>
		mail=Array();
		<?php
		"<br/>".$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='38' ".$_SESSION['where']."";
		$ptr_sel_sms=mysql_query($sel_sms_cnt);
		$tot_num_rows=mysql_num_rows($ptr_sel_sms);
		$i=0;
		while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
		{
			"<br/>".$sel_act="select email from site_setting where admin_id='".$data_sel_cnt['staff_id']."' and email!='' ".$_SESSION['where']."";
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
			"<br/>".$sel_act="select contact_phone,email from site_setting where type='S' and email!=''";
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
		"<br/>".$sel_mail_text="select email_text from previleges where privilege_id='38'";
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
		//alert('hi');
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
		var total_fees =document.getElementById('total_fees').value;
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
		//alert(users_mail);
		data1='action=inquiry&firstname='+firstname+'&middlename='+middlename+'&lastname='+lastname+'&mobile1='+mobile1+'&email_id='+email_id+'&inquiry_date='+inquiry_date+'&lead_category='+lead_category+'&lead_category_followup='+lead_category_followup+'&lead_grade='+lead_grade+'&dob='+dob+'&maritalstatus='+maritalstatus+'&address='+address+'&mobile2='+mobile2+'&landline_no='+landline_no+'&education='+education+'&course_id='+course_id+'&duration_studies='+duration_studies+'&total_fees='+total_fees+'&batch='+batch+'&remark='+remark+'&inquiry_for='+inquiry_for+'&followup_date='+followup_date+'&branch_name='+branch_name+'&response='+response+'&followup_desc='+followup_desc+'&inqyiry_idss='+inqyiry_idss+"&users_mail="+users_mail+"&email_text_msg="+email_text_msg;
		//alert(data1);
		$.ajax({
		url:'send_email.php',type:"post",data:data1,cache:false,crossDomain:true,async:false,
		 success: function (html)
            {
				//alert("success");
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
		$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
		}
		//$('#inquiry_date').datepicker().datepicker('setDate', 'today');
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
			//service_tax= taxes[0];
			//installment_tax= taxes[1];
			cgst=taxes[2];
			sgst=taxes[3];
			//document.getElementById("service_tax_id").innerHTML=service_tax;
			//document.getElementById("inst_tax_id").innerHTML=installment_tax;
			document.getElementById("cgst_id").innerHTML=cgst;
			document.getElementById("sgst_id").innerHTML=sgst;
			
			document.getElementById("cgst_taxes").value=cgst;
			document.getElementById("sgst_taxes").value=sgst;
			//document.getElementById("service_taxes").value=service_tax;
			//document.getElementById("inst_taxes").value=installment_tax;
			//alert("service tax- "+service_tax);
			course_id1= document.getElementById("course_id").value;
			ajax_course(course_id1);
		}
		
		
		
		});
		
		

		var bank_data="show_bnk=1&branch_id="+branch_id;
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
			 if(text.length <10)
				{
					 disp_error +='Enter Valid Mobile Number \n';
					 document.getElementById('mobile1').style.border = '1px solid #f00';
					 error='yes';
				}
		 }
		  if(frm.mobile1.value)
		 {
			user_mobile= document.getElementById("user_mobile").innerHTML;
			if(user_mobile == "Mobile No already taken.")
			{
				disp_error +='Mobile No. already Exist. Please try other no.\n';
				document.getElementById('mobile1').style.border = '1px solid #f00';
				frm.mobile1.focus();
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
	$('#feedback').load('check_mobile.php').show();
	//we use keyup so that everytime the 
	//user type in the keyboard, it'll check
	//the database and get results
	//however, you can change this to a button click
	//which is I think, more advisable. 
	//Sometimes, your server response is slow
	//but just for this demo, we'll use 'keyup' 
	$('#mobile1').blur(function(){
		//this will pass the form input
		frm = document.jqueryForm;
		var mobiles=frm.mobile1.value;
		$.post('check_mobile.php', { mobile1: mobiles ,action:"inquiry"},
		//then print the result
		function(result){from_date
			//alert(result);
			$('#feedback').html(result).show();
		});
	});
});
</script>
<script>
function show_valid()
{
	document.getElementById('date_valid').style.display='block';
	document.getElementById('from_date').disabled='true';
	document.getElementById('to_date').disabled='true';
	document.getElementById('response_date').disabled='true';
}
function hide_valid()
{
	document.getElementById('date_valid').style.display='none';
	document.getElementById('from_date').disabled='false';
	document.getElementById('to_date').disabled='false';
	document.getElementById('response_date').disabled='true';
}

function get_url(page)
{
	var camp_url=document.getElementById('campaign_url').value;
	var new_url=camp_url+''+page;
	document.getElementById('campaign_url').value=new_url;
	document.getElementById("campaign_type").disabled = true; 
	document.getElementById("refresh_btn").style.display = "block"; 
	
}
function get_cid(cids)
{
	if(cids !='')
	{
		var camp_url=document.getElementById('campaign_url').value;
		var c_ids=camp_url+'?c_id='+cids;
		document.getElementById('campaign_url').value=c_ids;
		document.getElementById("camp_code").disabled = true; 
		document.getElementById("campaign_codes").value = cids; 
	}
}
function show_form()
{
	var camp_url=document.getElementById('campaign_url').value;
	var c_ids=camp_url+'&is_form=show';
	document.getElementById('campaign_url').value=c_ids;
	document.getElementById("form_show").disabled = true; 
	document.getElementById("form_hide").disabled = true; 
}
function hide_form()
{
	var camp_url=document.getElementById('campaign_url').value;
	var c_ids=camp_url+'&is_form=hide';
	document.getElementById('campaign_url').value=c_ids;
	document.getElementById("form_show").disabled = true; 
	document.getElementById("form_hide").disabled = true; 
}
function refresh_url()
{
	document.getElementById("campaign_type").disabled = false; 
	document.getElementById("camp_code").disabled = false; 
	document.getElementById("form_show").disabled = false; 
	document.getElementById("form_hide").disabled = false;
	document.getElementById("campaign_url").value ='http://isasbeautyschool.com/isas/'; 
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
            <td class="top_mid" valign="bottom"><?php include "include/campaign_menu.php"; ?></td>
            <td class="top_right"></td>
          </tr>
          <tr>
            <td class="mid_left"></td>
            <td class="mid_mid">
            <table width="100%" cellspacing="0" cellpadding="0">
                <?php
                    $errors=array(); $i=0;
                    $success=0;
                    if($_POST['submit'])
                    {
						//$inquiry_date=$_POST['inquiry_date'];
						$from_date=( ($_POST['from_date'])) ? $_POST['from_date'] : "";
						if($from_date !='')
						{
							$seps_date = explode('/',$from_date);
							$from_date = $seps_date[2].'-'.$seps_date[1].'-'.$seps_date[0];
						}
						else
						{
							$from_date='';
						}
						
						$to_date=( ($_POST['to_date'])) ? $_POST['to_date'] : "";
						if($to_date !='')
						{
							$seps_date = explode('/',$to_date);
							$to_date = $seps_date[2].'-'.$seps_date[1].'-'.$seps_date[0];
						}
						else
						{
							$to_date='';
						}
						
						$response_date=( ($_POST['response_date'])) ? $_POST['response_date'] : "";
						if($response_date !='')
						{
							$seps_date = explode('/',$response_date);
							$response_date = $seps_date[2].'-'.$seps_date[1].'-'.$seps_date[0];
						}
						else
						{
							$response_date='';
						}
						$lead_category=( ($_POST['lead_category'])) ? $_POST['lead_category'] : "";
						$campaign_name=( ($_POST['campaign_name'])) ? $_POST['campaign_name'] : "";
						$campaign_url=( ($_POST['campaign_url'])) ? $_POST['campaign_url'] : "";
						$pixel_code=( ($_POST['pixel_code'])) ? $_POST['pixel_code'] : "";
						$invest_cost=( ($_POST['invest_cost'])) ? $_POST['invest_cost'] : "0";
						$support_cost=( ($_POST['support_cost'])) ? $_POST['support_cost'] : "0";
						$total_cost=( ($_POST['total_cost'])) ? $_POST['total_cost'] : "0";
						$lead=( ($_POST['lead'])) ? $_POST['lead'] : "0";
						$roi=( ($_POST['roi'])) ? $_POST['roi'] : "0";
						$campaign_codes=( ($_POST['campaign_codes'])) ? $_POST['campaign_codes'] : "";
						$validity=( ($_POST['validity'])) ? $_POST['validity'] : "";
						
						if($campaign_name=="")
						{
							$success=0;
							$errors[$i++]="Enter Campaign Name";
						}
						/*if($campaign_url=="")
						{
							$success=0;
							$errors[$i++]="Enter Campaign URL";
						}
						if($pixel_code=="")
						{
							$success=0;
							$errors[$i++]="Enter Pixel Code";
						}
						if($invest_cost=="")
						{
							$success=0;
							$errors[$i++]="Enter Invest Cost";
						}
						if($support_cost=="")
						{
							$success=0;
							$errors[$i++]="Enter Support Cost";
						}
						if($total_cost=="")
						{
							$success=0;
							$errors[$i++]="Enter Total Cost";
						}*/
						
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
												$data_record['from_date']=$from_date;
												$data_record['to_date'] = $to_date;
												$data_record['response_date'] = $response_date;
												$data_record['campaign_name'] = $campaign_name;
												$data_record['campaign_url'] = $campaign_url;
												$data_record['pixel_code'] = $pixel_code;
												$data_record['invest_cost'] = $invest_cost;
											    $data_record['support_cost'] = $support_cost; 
												$dta_record['total_cost'] = $total_cost;
												$data_record['lead'] = $lead;
												$data_record['roi'] = $roi;
												$branch_name=$_REQUEST['branch_name'];
												$data_record['validity'] =$validity;
												
										//===============================CM ID for Super Admin===============
											if($_SESSION['type']=='S')
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
									
									
									 $update_inquiry= "update campaign set `from_date`='$from_date',`to_date`='$to_date',`response_date`= '$response_date',`campaign_name`='$campaign_name',`campaign_url` = '$campaign_url',`pixel_code`= '$pixel_code', `invest_cost`= '$invest_cost',`support_cost`= '$support_cost', `total_cost`= '$total_cost', `lead`= '$lead', `roi`= '$roi',`cm_id`='$cm_id',`admin_id` = '$admin_id', `branch_name`= '$branch_name',c_id='$campaign_codes', validity='$validity' where campaign_id='".$record_id."'";
									$ptr_update=mysql_query($update_inquiry);
									$up_inqyiry_id = mysql_insert_id();
									
																		
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('inquiry','Edit','".$firstname." ".$middlename." ".$lastname."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);    
									
									echo' <br></br><div id="msgbox" style="width:40%;">Record Updated successfully</center></div> <br></br>';
                                        
								}
								else
								{
									 $insert= "INSERT INTO campaign (`from_date`, `to_date`, `response_date`, `campaign_name`, `campaign_url`, `pixel_code`, `invest_cost`, `support_cost`, `total_cost`, `status`,`cm_id`,`admin_id`,`branch_name`,`c_id`,`validity`) VALUES ('".$from_date."','".$to_date."','".$response_date."','".$campaign_name."','".$campaign_url."','".$pixel_code."','".$invest_cost."','".$support_cost."','".$total_cost."','Active','".$cm_id."','".$admin_id."','".$branch_name."','".$campaign_codes."','".$validity."')";
									$ptr_query=mysql_query($insert);
 									$inqyiry_id1 = mysql_insert_id();
									
									$ins_count="insert into web_counter_totalview (`page`,`totalvisit`,`c_id`) values ('".$campaign_name."','0','".$campaign_codes."')";
									$ptr_ins=mysql_query($ins_count);
									
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('inquiry','ADD','".$firstname." ".$middlename." ".$lastname."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);    
									
									echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
				
								}//else record id
								
							}
					}
                    if($success==0)
                    {
                        ?>
                               
                		<tr>
                			<td colspan="2"><form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data" onSubmit="return validme()">
                    			<table border="0" cellspacing="15" cellpadding="0" width="100%">
                               
                                  <tr>
								  <?php
                        			$select_email_id= " select email from site_setting where 1 cm_id='".$_SESSION['cm_id']."' and type='A' and email !='' ";
									$ptr_emails = mysql_query($select_email_id);
									$data_emails = mysql_fetch_array($ptr_emails);
					
								  ?>
                                  
                                  <td><input type="hidden" name="inqyiry_idss" id="inqyiry_idss" value="<?php echo $data_emails['email']; ?>" /></td> 
                                 
                                  </tr>
                    				<tr>
                                      
                        				<td height="30" colspan="3" class="orange_font">* Mandatory Fields</td>
                      				</tr>
                      				<tr>
                      					<td width="22%"class="orange_font">* Date Format should be [ DD/MM/YYYY ]</td>
                     				</tr>
                       				<?php 
									if($_SESSION['type']=='S')
									{
									?>
                      				<tr>
                      					<td>Select Branch<span class="orange_font">*</span></td>
                        				<td>
										<?php 
                                        $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
                                        $query_branch = mysql_query($sel_branch);
                                        $total_Branch = mysql_num_rows($query_branch);
                                        echo '<table width="100%"><tr><td>';
                                        echo ' <select id="branch_name" name="branch_name" >';
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
                       				<input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                       		<?php }?>
							
								<tr>
                        			<td width="22%">Campaign Name<span class="orange_font">*</span></td>
                        			<td width="44%"><input type="text" class="inputText  required" name="campaign_name" id="campaign_name" value="<?php if($_POST['campaign_name']) echo $_POST['campaign_name']; else echo $row_record['campaign_name'];?>"/>
                                    </td>
                      			</tr>
                                <tr>
                        			<td width="22%"></td>
                        			<td width="44%" id="refresh_btn" style="display:none"><input type="button" name="refresh" id="refresh" value="Refresh" onclick="refresh_url()" class="input_btn"  /></td>
                      			</tr>
                                <tr>
                        			<td width="22%">Campaign Page<span class="orange_font">*</span></td>
                        			<td width="44%">
                                    <select name="campaign_type" style="width:200px" id="campaign_type" onchange="get_url(this.value)">
                                    <option value="">Select Campaign Page</option>
                                    <option value="index.php">Home</option>	
                                    <option value="makeup.php">Makeup</option>
                                    <option value="mic.php">MIC</option>
                                    <option value="pgdc.php">PGDC</option>
                                    <option value="dic.php">DIC</option>
                                    <option value="personal.php">Personal Grooming</option>
                                    <option value="beauty.php">Beauty Therapy</option>
                                    <option value="hair.php">Hair</option>
                                    <option value="spa.php">Spa</option>
                                    <option value="cidesco.php">CIDESCO</option>
                                    </select>
                                    </td>
                      			</tr>
								<tr>
                        			<td width="22%">Campaign Code<span class="orange_font"></span></td>
                        			<td width="44%"><input type="text" style="width:200px" class="inputText required" onBlur="get_cid(this.value)" name="camp_code" id="camp_code" value="<?php if($_POST['campaign_codes']) echo $_POST['campaign_codes']; else echo $row_record['c_id'];?>"/><input type="hidden" name="campaign_codes" id="campaign_codes" value="<?php if($_POST['campaign_codes']) echo $_POST['campaign_codes']; else echo $row_record['c_id'];?>"/>
                                    </td>
                      			</tr>
                                <tr>
                        			<td width="22%">Signup Form Visbility<span class="orange_font"></span></td>
                        			<td width="44%">Show<input type="radio"  onclick="show_form()" class="inputText required" name="form_show" id="form_show" value="show"/>Hide<input type="radio" onclick="hide_form()" class="inputText required" name="form_show" id="form_hide" value="hide"/>
                                    </td>
                      			</tr>
								<tr>
                        			<td width="22%">Campaign URL<span class="orange_font"></span></td>
                        			<td width="44%"><input type="text" style="width:200px" class="inputText  required" name="campaign_url" id="campaign_url" value="<?php if($_POST['campaign_url']) echo $_POST['campaign_url']; else if($row_record['campaign_url']!='') echo $row_record['campaign_url']; else echo 'http://isasbeautyschool.com/isas/';?>"/>
                                    </td>
                      			</tr>
                                <tr>
                        			<td width="22%">Pixel Code<span class="orange_font"></span></td>
                        			<td width="44%"><input type="text" style="width:200px" class="inputText  required" name="pixel_code" id="pixel_code" value="<?php if($_POST['pixel_code']) echo $_POST['pixel_code']; else echo $row_record['pixel_code'];?>"/>
                                    </td>
                      			</tr>
							 	<tr>
                        			<td width="22%">Validity<span class="orange_font"></span></td>
                        			<td width="44%">Limited Period <input type="radio"  onclick="show_valid()" class="inputText required" name="validity" id="validity" value="valid"/> Unlimited Period <input type="radio" onclick="hide_valid()" class="inputText required" name="validity" id="validity" value="invalid"/>
                                    </td>
                      			</tr>
                                <tr>
                                <td colspan="3">
                                 <div id="date_valid">
                                    <table width="100%">
                                        <tr>
                                            <td width="22%">From Date<span class="orange_font">*</span></td>
                                            <td width="44%"><input type="text" class="input_text datepicker" style="width:200px" name="from_date" id="from_date" value="<?php 
                                            if($_POST['from_date']) 
                                            echo $_POST['from_date']; 
                                            else if($row_record['from_date'] !='')
                                            {
                                                $arrage_datesa= explode(' ',$row_record['from_date']);     
                                                $arrage_date= explode('-',$arrage_datesa[0],3);     
                                                echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0]; 
                                            }else echo date('d/m/Y')?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="22%">To Date<span class="orange_font">*</span></td>
                                            <td width="44%"><input type="text" class="input_text datepicker" style="width:200px" name="to_date" id="to_date" value="<?php 
                                            if($_POST['to_date']) 
                                            echo $_POST['to_date']; 
                                            else if($row_record['to_date'] !='')
                                            {
                                                $arrage_datesa= explode(' ',$row_record['to_date']);     
                                                $arrage_date= explode('-',$arrage_datesa[0],3);     
                                                echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0]; 
                                            }else echo date('d/m/Y')?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="22%">Response Date<span class="orange_font">*</span></td>
                                            <td width="44%"><input type="text" class="input_text datepicker" style="width:200px" name="response_date" id="response_date" 	value="<?php 
                                            if($_POST['response_date']) 
                                            echo $_POST['response_date']; 
                                            else if($row_record['response_date'] !='')
                                            {
                                                $arrage_datesa= explode(' ',$row_record['response_date']);     
                                                $arrage_date= explode('-',$arrage_datesa[0],3);     
                                                echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0]; 
                                            }else echo date('d/m/Y')?>" />
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                </td>
                                </tr>
								                  			
								<tr>
                        			<td width="22%">Investment Cost<span class="orange_font"></span></td>
                        			<td width="44%"><input type="text" style="width:200px" class="inputText  required" name="invest_cost" id="invest_cost" value="<?php if($_POST['invest_cost']) echo $_POST['invest_cost']; else echo $row_record['invest_cost'];?>"/>
                                    </td>
                      			</tr>
                   				
                               <tr>
                        			<td width="22%">Supporting Cost<span class="orange_font"></span></td>
                        			<td width="44%"><input type="text" style="width:200px" class="inputText  required" name="support_cost" id="support_cost" value="<?php if($_POST['support_cost']) echo $_POST['support_cost']; else echo $row_record['support_cost'];?>"/>
                                    </td>
                      			</tr>
								
								 <tr>
                        			<td width="22%">Total Cost<span class="orange_font"></span></td>
                        			<td width="44%"><input type="text" style="width:200px" class="inputText  required" name="total_cost" id="total_cost" value="<?php if($_POST['total_cost']) echo $_POST['total_cost']; else echo $row_record['total_cost'];?>"/>
                                    </td>
                      			</tr>
								
								
                               
                    			<tr>
                        
                                	<td></td>
                                	<td><input type="submit" class="inputButton" value="Submit" name="submit" id="submit1" /></td>
                              	</tr>
                  			</table>
                  	</form>
                   
                  
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
      <? require("include/footer.php");?>
    </div>
    <?php
//if($_SESSION['type']=="S")
//{
	?>
    <script>
	//branch_name =document.getElementById("branch_name").value;
	//alert(branch_name);
	//show_bank(branch_name);
	</script>
    <?php
	//exit();
//}

?>

    <!--footer end-->
</body>
</html>
<?php $db->close();?>