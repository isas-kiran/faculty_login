<?php include '../../../faculty_login/include/config.php';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

<title>
    <?php
        if ( ! defined( 'WPSEO_VERSION' ) ) {
            echo bloginfo( 'name' ) . wp_title( '|', true, '' );
        }
        else {
            //IF WordPress SEO by Yoast is activated
            wp_title();
        }
    ?>
</title>
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>"/>
<link rel="profile" href="http://gmpg.org/xfn/11"/>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/style1.css" type="text/css" media="screen" />
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/script.js"></script>
    <!-- New Code Added sudhir--->
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/js/development-bundle/themes/base/jquery.ui.all.css">
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/js/development-bundle/demos/demos.css"/>
    
    <script src="<?php bloginfo('template_url'); ?>/js/jquery-1.6.2.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/development-bundle/ui/jquery.ui.datepicker.js"></script>
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
		
		function ajax_course(course_id)
	{
			course_id = course_id;
			//alert(course_id);
			if(course_id !='')
        	{
				if( course_id != 'custome')
				{
            var data1="action=show_course&course_id="+course_id;
           // document.getElementById('custome_div').style.display="none";
            $.ajax({
                url: "http://isasbeautyschool.com/faculty_login/ajax.php", type: "post", data: data1, cache: false,
                success: function (html)
                {
                  // alert(html);
					vals =html.split('###');
					document.getElementById('duration_studies').value=vals[0].trim();
					document.getElementById('total_fees').value=vals[1].trim();
					
                }
				
            });
				}
				else
				{
                                    //alert("1");
                                    $( ".new_custom_course" ).dialog({
                                        width: '500',
                                        height:'400'
                                    });
                                    //document.getElementById('custome_div').style.display="block";
				}
				
            return false;
        }
				
	}
</script>
<style type = "text/css">
    #feedback{
        line-height:;
    }
    .obrderclass{ border:1px solid #f00}
</style>  
<script>
	
		function ajax_send()
		{  error= 0;
		//alert('hi');
			firstname= $("#firstname").val();
			concat_error ='';
			
			middlename= $("#middlename").val();
			lastname= $("#lastname").val();
			dob= $("#dob").val();
			username= $("#username").val();
			pass1= $("#pass1").val();
			maritalstatus= $("#maritalstatus").val();
			address= $("#address").val();
			gender= $("#gender").val();
			mobile1= $("#mobile1").val();
			mobile2= $("#mobile2").val();
			landline_no= $("#landline_no").val();
			email_id= $("#email_id").val();
			education= $("#education").val();
			course_id= $("#course_id").val();
			
			paid_type= $("#paid_type").val();
			total_fees= $("#toal_fees").val();
			discount_type =$("#discount_type").val();
			concession=$("#concession").val();
			net_fees= $("#net_fees").val();
			//alert(net_fees);
			service_tax= $("#service_tax").val();
			fees= $("#fees").val();
			down_payment= $("#down_payment").val();
			installment_on= $("#installment_on").val();
			dropdown= $("#dropdown").val();
			installments=$("#installments").val();
			installment_date=$("#installment_date").val();
			payment_type= $("#payment_type").val();
			bank_name= $("#bank_name").val();
			chaque_no= $("#chaque_no").val();
			chaque_date= $("#chaque_date").val();
			final_amt= $("#final_amt").val();
			batch= $("#batch").val();
			enquiry_src= $("#enquiry_src").val();
			remark= $("#remark").val();
			inquiry_for= $("#inquiry_for").val();
			cm_id = $("#cm_id").val();
			
			
		 frm = document.register_form;
		 error='';
		 disp_error = 'Clear The Following Errors : \n\n';
		 
		 
		
		 
		 if(frm.firstname.value=='')
		 {
			 disp_error +='Enter Firstname\n';
			 document.getElementById('firstname').style.border = '1px solid #f00';
			 frm.firstname.focus();
			 error='yes';
	     }
		 if(frm.lastname.value=='')
		 {
			 disp_error +='Enter Lastname\n';
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
		 if(frm.email_id.value=='')
		 {
			 disp_error +='Enter Email ID\n';
			 document.getElementById('email_id').style.border = '1px solid #f00';
			 frm.email_id.focus();
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
		 if(frm.pass1.value=='')
		 {
			 disp_error +='Enter Password \n';
			 document.getElementById('pass1').style.border = '1px solid #f00';
			 frm.pass1.focus();
			 error='yes';
	     }
		 if(frm.address.value=='')
		 {
			 disp_error +='Enter address \n';
			 document.getElementById('address').style.border = '1px solid #f00';
			 frm.address.focus();
			 error='yes';
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
		  if(frm.down_payment.value==0)
		 {
			 disp_error +='Add Down Payment  \n';
			 $("#down_payment").addClass("obrderclass");
			 frm.down_payment.focus();
			 error='yes';
	     }
		 else
		 $("#down_payment").removeClass("obrderclass");
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
			$('#dropdown').removeClass("obrderclass"); 
			
			
			
			
		 ///================= END Installmetn Dat4 Validation  ===
		 
		if($('input[name=payment_type]:checked').length<=0)
		{
		 disp_error +='Payment mode not selected \n'; 
		
		 $('#pay_type').addClass("obrderclass"); 
		  error='yes';
		}
		else
		{
			
			  $('#pay_type').removeClass("obrderclass"); 
			var selected = $("input[name=payment_type]:checked");
				if (selected.length > 0) {
					selectedVal = selected.val();
					if(selectedVal=='cheque')
					{
						if(frm.bank_name.value=='')
						{
							disp_error +='Bank Name is blank \n';
							 error='yes';
							 document.getElementById('bank_name').style.border = '1px solid #f00';
							 frm.bank_name.focus();
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
					
				}
			
		}
		// alert(error);
		 if(error=='yes')
		 {
			 alert(disp_error);
			 return false;
		 }
		 else
		 {
			 
			 var data1="action=add_enquiry&firstname="+firstname+"&middlename="+middlename+"&lastname="+lastname+"&dob="+dob+"&maritalstatus="+maritalstatus+"&address="+address+"&gender="+gender+"&mobile1="+mobile1+"&mobile2="+mobile2+"&landline_no="+landline_no+"&email_id="+email_id+"&education="+education+"&course_id="+course_id+"&paid_type="+paid_type+"&total_fees="+total_fees+"&batch="+batch+"&enquiry_src="+enquiry_src+"&remark="+remark+"&inquiry_for="+inquiry_for+"&cm_id="+cm_id+"&discount_type="+discount_type+"&concession="+concession+"&net_fees="+net_fees+"&service_tax="+service_tax+"&fees="+fees+"&final_amt="+final_amt+"&down_payment="+down_payment+"&installment_on="+installment_on+ "&numDep="+dropdown+"&payment_type="+payment_type+"&bank_name="+bank_name+"&chaque_no="+chaque_no+"&chaque_date="+chaque_date+"&username="+username+"&pass1="+pass1;
			alert(data1);
			$.ajax({
                url: "http://isasbeautyschool.com/faculty_login/ajax.php", type: "post", data: data1, cache: false,
                success: function (html)
                {
                   alert(html);
				   //disablePopup();
										
                }
				
            });
			
			
		 }
		 return true;
		 
		 
		 
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
function isSpclChar(id)
{
var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>? ";

vals = document.getElementById(id).value;
for (var i = 0; i < vals.length; i++) {
if (iChars.indexOf(vals.charAt(i)) != -1) {
	  return 'yes';
	}
}

} 

			
		}
    </script>
    <!-- New Code End -->
<?php
    global $znData, $post;
    $data = $znData;
    wp_head();
?>





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
        function show() { document.getElementById('payment').style.display = 'block'; $('#pay_type').removeClass("obrderclass");  }
        function hide() { document.getElementById('payment').style.display = 'none'; $('#pay_type').removeClass("obrderclass");  }
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
        //alert (no_inst);
       
        if(selVal > 0)
        {
            for(var i = 1; i<= selVal; i++)
            {
                $("#textboxDiv").append('<table width="100%"><tr><td width="23%" class="heading">Installment '+i+' </span></td><td width="40%" colspan="2"><input type="text" class="input_text installment_input installment_inp_'+i+'" alt="'+i+'" name="installments[]" value="'+Math.round(no_inst)+'" /></td><td><input type="text" name="installment_date[]" class="datepicker date_class'+i+'" placeholder="installment date " ></td></tr></table>');
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
                        var final_installment_term = Math.round(final_total_installment/(installments-current_number));
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
</script>

</head>
<body  <?php body_class(); ?>>
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 945923732;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript"
src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt=""
src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/945923732/?value=0
<http://googleads.g.doubleclick.net/pagead/viewthroughconversion/945923732/?value=0&amp;guid=ON&amp;script=0>
&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
    <!-- BEGIN SIGN IN FORM -->
<!--<div id="options">
        <h3 id="register-tab">Register</h3>
    </div>-->
    <form id="sign-in-form" method="post" action="/?page_id=2185">
        <div class="close"></div><!-- close button of the sign in form -->
        <ul id="form-section">
            <li>
                <label>
                    <span>Username</span>
                    <input placeholder="Please enter your username" id="user" name="username" pattern="[a-zA-Z0-9]{6,}" type="text" tabindex="1" title="It must contain the username that you have chosen at registration" required autofocus>
                </label>
            </li>
            <li>
                <label>
                    <span>Password</span>
                    <input placeholder="Please enter your password" id="pass" name="password" pattern=".{6,}" type="password" tabindex="2" title="It must contain the password that you have chosen at registration" required>
                </label>
            </li>
            <div id="checkbox">
                <li>
                    <input name="remember-me" type="checkbox" id="remember-me"/>
                    <span class="unchecked-state"></span>
                    <span class="checked-state"></span>
                </li>
                <label for="remember-me" class="rem-me">Remember me next time</label>
            </div>
            <li>
                <button name="sign-in-submit" type="submit" id="sign-in-submit">Sign In</button>
            </li>
            <li>
        <h3 id="register-tab">Not Register Yet?</h3>
            </li>
            <div style="clear: both;"></div>
        </ul>
        
    </form>
<!--        <script type="text/javascript">
    function checkPass() {
        
        var pass1 = document.getElementById("user").value;
        var pass2 = document.getElementById("pass").value;
        
        if (pass1 == "adminisas" && pass2 == "adminisas") {
            
            alert("Passwords  match");
           // document.location = '../?page_id=1479';
        //   window.open('http://localhost/isas/?page_id=1479','_parent',"status=1");
            window.open('/?page_id=1479','_blank');
        }
        else {
           
              $("#sign-in-form").fadeIn(300);
            $("#background-on-popup").css("opacity", "0.7");
            $("#background-on-popup").fadeIn(300);
        }
    
    }
    </script>-->
    
    <!-- END OF SIGN IN FORM -->
    <!-- BEGIN REGISTER FORM -->
    <form name="register_form" id="register-form" action="" method="post" enctype="multipart/form-data" onSubmit="return ajax_send();">
        <div class="close"></div><!-- close button of the register form -->
        <div id="form-section">
       
        <table width="100%" cellspacing="0" cellpadding="0" >
                <?php
				/*
				$host 			= "mysql1003.mochahost.com";
				$dbuid			= "lahoo123_inst";
				$dbpwd 			= "Reset123*#()xxx";
				$dbname			= "lahoo123_inst";
				$con1 = mysql_connect($host ,$dbuid, $dbpwd);
				mysql_select_db($dbname,$con1 );*/
				
                    
                        ?>
                <tr>
                <td>
                    <table border="0" cellspacing="15" cellpadding="0" width="100%">
                    <tr>
                        <td colspan="2" ><code>* Fields are Mandatory</code></td>
                    </tr>
                    <tr>
                        <td width="20%" class="left-column">Firstname<span class="orange_font">*</span></td>
                        <td width="40%" ><input type="text" class="inputText" name="firstname" id="firstname" required autofocus
                                            value="<?php if($_POST['firstname']) echo $_POST['firstname']; else echo $row_record['firstname'];
											?>"/></td>
                      </tr>
                    <tr>
                        <td width="20%"  class="left-column">Middlename</td>
                        <td width="40%"><input type="text" class="inputText" name="middlename" id="middlename" 
                                            value="<?php if($_POST['middlename']) echo $_POST['middlename']; else echo $row_record['middlename'];
											?>"/></td>
                      </tr>
                    <tr>
                        <td width="20%"  >Lastname<span class="orange_font">*</span></td>
                        <td 40%><input type="text" class="inputText" name="lastname" id="lastname" required autofocus
                                            value="<?php if($_POST['lastname']) echo $_POST['lastname']; else echo $row_record['lastname'];
											?>"/></td>
                      </tr>
                    <tr>
                        <td width="20%">Birth Date<span class="orange_font"></span></td>
                        <td width="40%"><input type="text" class="input_text datepicker" name="dob" id="dob" 
                                    value="<?php if($_POST['save_changes']) echo $_POST['dob']; else 
									$arrage_date= explode('-',$row_record['dob'],3);     
									//echo $arrage_date[1].'/'.$arrage_date[2].'/'.$arrage_date[0]; 
										// $row_record['staff_dob'];
										?>" /></td>
                       
                      </tr>
                    <tr>
                        <td width="20%">Marital Status<span class="orange_font">*</span></td>
                        <td width="40%"><select id="maritalstatus" name="maritalstatus" class="input_text" required autofocus>
                            <option    value="---Select---">---Select---</option>
                            <option    value="Married">Married</option>
                            <option   value="Unmarried">Unmarried</option>
                          </select></td>
                      </tr>
                    <tr>
                        <td width="20%">Gender<span class="orange_font"></span></td>
                        <td width="40%"> Female
                        <input type="radio" id="gender" name="gender" value="female" style="width:50px !important"/>
                        <br/>
                        Male
                        <input type="radio" id="gender" name="gender" value="male" style="width:76px !important" /></td>
                        
                      </tr>
                    <tr>
                        <td width="20%">Address<span class="orange_font"></span></td>
                        <td width="40%"><textarea name="address" id="address" class=" textarea"><?php if($_POST['address']) echo $_POST['address']; else echo $row_record['address'];?>
</textarea></td>
                       
                      </tr>
                    <tr>
                        <td width="20%">Mobile 1<span class="orange_font">*</span></td>
                        <td width="40%"><input type="text" class="inputText" name="mobile1" id="mobile1" value="<?php if($_POST['mobile1']) echo 			                                                     $_POST['mobile1']; else echo $row_record['mobile1'];?>" required autofocus/></td>
                      
                      </tr>
                    <tr>
                        <td width="20%"> Mobile 2 </td>
                        <td width="40%"><input type="text" class=" inputText" name="mobile2" id="mobile2" value="<?php if($_POST['mobile2']) echo                                                      $_POST['mobile2']; else echo $row_record['mobile2'];?>"/></td>
                        
                      </tr>
                    <tr>
                        <td width="20%">Landline No</td>
                        <td width="40%"><input type="text" class="inputText" name="landline_no" id="landline_no" value="<?php if($_POST['landline_no'                                                     ]) echo $_POST['landline_no']; else echo $row_record['landline_no'];?>"/></td>
                       
                      </tr>
                    <tr>
                        <td width="20%">E-Mail <span class="orange_font">*</span></td>
                        <td width="40%"><input type="text" class=" inputText" name="email_id" id="email_id" value="<?php if(                                                    $_POST['email_id']) echo $_POST['email_id']; else echo $row_record['email_id'];?>" required autofocus /></td>
                       
                      </tr>
                    <tr>
                        <td width="20%">Education<span class="orange_font"></span></td>
                        <td width="40%"><select name="education" id="education"  class="inputText">
                            <option  value="">----Select----</option>
                            <option  value="SSC">SSC</option>
                            <option  value="HSC">HSC</option>
                            <option value="Under Graduation">Under Graduation</option>
                            <option value="Graduation">Graduation</option>
                            <option value="Post Graduation">Post Graduation</option>
                          </select></td>
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
                                        <td width="40%"><input type="text" class="validate[required] input_text" name="pass1" id="pass1" value="<?php if($_POST['pass1']) echo $_POST['pass1']; else echo $row_record['pass'];?>" />
 										</td> 
                						<td width="40%"></td>
                            </tr>
                       <tr>
                        <td width="20%">Branch Interested<span class="orange_font">*</span></td>
                        <td class="customized_select_box"><select id="cm_id" name="cm_id" required autofocus >
                            <option value="">Select</option>
                            <?php
														   $course_category = " select admin_id,branch_name  from site_setting where type='A' and branch_name !=''  ";
														   
														   $ptr_course_cat = mysql_query($course_category, $con1);
														   while($data_cat = mysql_fetch_array($ptr_course_cat))
														   {
															
															?>
                            										<option value = "<?php echo $data_cat['admin_id']?>" > <?php echo $data_cat['branch_name'] ?> </option>
                            							 <?php  }
													?>
                           
                          </select></td>
                      </tr>
                   <!-- <tr>
                        <td width="20%">Course Interested<span class="orange_font">*</span></td>
                        <td class="customized_select_box"><select id="course_interested" name="course_interested" onChange="ajax_course(this.value);">
                            <option value="select">Select</option>
                            <?php
														   $course_category = " select category_name,category_id from course_category ";
														   
														   $ptr_course_cat = mysql_query($course_category, $con1);
														   while($data_cat = mysql_fetch_array($ptr_course_cat))
														   {
															   echo " <optgroup label='".$data_cat['category_name']."'>";
														
                                        					$get="SELECT course_name FROM courses where category_id='".$data_cat['category_id']."' order by course_id";
										 					$myQuery=mysql_query($get, $con1);
										 					while($row = mysql_fetch_assoc($myQuery))
															{
																
															?>
                            <option value = "<?php echo $row['course_name']?>" > <?php echo $row['course_name'] ?> </option>
                            <?php }
													echo " </optgroup>";
														   }
													?>
                           
                          </select></td>
                      </tr>
                    
                    
                    <tr>
                        <td width="22%">Total Fees</td>
                        <td width="38%"><input type="text" class=" inputText" name="total_fees" id="total_fees" 
                value="<?php if($_POST['total_fees'])echo $_POST['total_fees']; else echo $row_record['total_fees'];?>"/></td>
                       
                      </tr>-->
          <!--====================================================New Code for Enrollment================================================================== -->
                       <tr>
            <td width="20%">Select Course<span class="orange_font">*</span></td>
            <td width="40%" >
            
                    <select name="course_id" id="course_id" class="validate[required] input_select" onChange="show_course(this.value);" >  
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
                      <tr>
                <td width="22%">Paid Type </td>
                <td width="38%">
                <input type="radio" name='paid_type' id="paid_type" value="<?php if($_POST['paid_type']) echo $_POST['paid_type']; else echo one_time; ?>" checked="checked" onChange="show_record()" />One Time <input type="radio" name='paid_type' id="paid_type" value="<?php if($_POST['paid_type']) echo $_POST['paid_type']; else echo installments; ?>" onChange="show_record()" />Installment <?php echo $_SESSION['installment_tax']; ?>% add
                
                </td>                
                
            </tr>
           
                                            
                                      
                                             <tr>
                <td width="22%">Course Fees</td>
                <td width="38%"><div id=total_fees>
                <input type="text" class="input_text" name="total_fees" id="toal_fees" readonly="readonly" value="<?php if($_POST['total_fees']) echo $_POST['total_fees']; else echo $row_record['course_fees'];?>" />
                </div>
                </td>                
                
            </tr>
            <tr>
                <td width="22%">Discount in <input type="radio" name='discount_type' id="discount_type" value="<?php if($_POST['discount_type']) echo $_POST['discount_type']; else echo percent; ?>" checked="checked" onChange="show_record()" />% or <input type="radio" name='discount_type' value="<?php if($_POST['discount_type']) echo $_POST['discount_type']; else echo cash; ?>" onChange="show_record()" />Cash</td>
                <td width="38%">
                <input type="text" class="input_text" name="concession" id="concession" value="<?php if($_POST['concession']) echo $_POST['concession']; else if($row_record['discount'] !=0) echo $row_record['discount']; else echo 0; ?>" 
                onblur="show_record()"/>
                
                </td>                
               
            </tr>
                       
                                            
                                           
                                            
                                           <tr>
                                                  <th width="20%" class="heading">Fee breakup </th>
                                            </tr>  
                                            <tr>    
                                                  <td width="20%" class="heading">Net Fees<span class="orange_font">*</span></td>
                                                  <td><input type="text" class="validate[required] input_text" name="net_fees" id="net_fees" value="<?php if($_POST['net_fees']) echo $_POST['net_fees']; else echo $row_record['net_fees'];?>" /></td>
                                            </tr>
                                            <tr>      
                                                  <td width="20%" class="heading"> Service Tax <?php echo $data_tax['service_tax']; ?>%<span class="orange_font">*</span></td>
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
                                                    
                                                    <tr><td width="23%" class="heading">Installment <?php echo $i; ?> </span></td><td width="40%" colspan=2""><input type="text" class="input_text" name="installments[]" id="installments" value='<?php if($_POST['installments']) echo $_POST['installments']; else echo $dat_installment['installment_amount'];  ?>' /></td><td><input type="text" name="installment_date[]" id="installment_date" class="datepicker" placeholder="installment date" value="<?php if($_POST['installment_date']) echo $_POST['installment_date']; else echo $sep_da[1].'/'.$sep_da[2].'/'.$sep_da[0]; ?>"  ></td></tr>
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
                                             <tr>
                                                  <td width="20%" class="heading">Payment Mode<span class="orange_font">*</span></td>
                                                 <td ><div id="pay_type"> <input type="radio" class="validate[required] input_radio" name="payment_type" id="payment_type" value="cash" onClick="hide();" <?php if($row_invoice=='cash'|| $_POST['payment_type']=='cash') echo 'checked="checked"'; ?> > Cash
                                                 
                                                   <input type="radio" class="validate[required] input_radio" name="payment_type"  id="payment_type" value="cheque" onClick="show();" <?php if($row_invoice=='cheque'|| $_POST['payment_type']=='cheque') echo 'checked="checked"'; ?> />By Cheque
                                                   
                                                  <input type="radio" class="validate[required] input_radio" name="payment_type" id="payment_type" value="online" onClick="hide();"   <?php if($row_invoice=='online'|| $_POST['payment_type']=='online') echo 'checked="checked"'; ?> />Online
                                                 </div> </td>
                                            </tr>
                                            <tr>
												<td></td>
                                            	<td colspan="2">
                                                <div id="payment" <?php  if($row_invoice=='cheque' || $_POST['payment_type'] =='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>> 
                                                <table>
                                                	<tr>
                                                    	<td>Bank Name</td>
                                                        <td><input type="text" name="bank_name" id="bank_name"  class="validate[required] input_text" 
                                                        value="<?php if($_POST['bank_name']) echo $_POST['bank_name']; else echo $row_invoice['bank_name'];?>"/></td>
                                                     </tr>
                                                     <tr>
                                                        <td>Cheque No.</td>
                                                        <td><input type="text" name="chaque_no" id="chaque_no"  class="validate[required] input_text"  value="<?php if($_POST['chaque_no']) echo $_POST['chaque_no']; else echo $row_invoice['chaque_no'];?>" onKeyPress="return isNumber(event)" maxlength="6"/></td>
                                                     </tr>
                                                     <tr>
                                                        <td>Cheque Date</td>
                                                        <td><input type="text" name="chaque_date" id="chaque_date"  class="datepicker" placeholder="cheque date " value="<?php if($_POST['save_changes']) echo $_POST['chaque_date']; else echo $chaque_date ;?>"/></td>
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
                                            
                           <!-- ======================================================END===========================================================-->
                      
                      
                    <tr>
                        <td width="22%">Prefer Batch </td>
                        <td width="38%"><select id="batch" name="batch">
                            <option value="">----Select----</option>
                            <option value="Morning">Morning</option>
                            <option value="Evening">Evening</option>
                          </select></td>
                        
                      </tr>
                    <tr>
                        <td width="20%" class="heading">Enquiry Source<span class="orange_font">*</span></td>
                        <td><select id="enquiry_src" name="enquiry_src">
                            <option value="">----Select----</option>
                            <option value="By Email">By Email</option>
                            <option  value="Newspaper">Newspaper </option>
                          </select></td>
                      </tr>
                    <!-- <tr>      
                                                  <td width="20%" class="heading">Enquiry Taken By <span class="orange_font">*</span></td>
                                                  <td><input type="text" class=" inputText" name="enquiry_taken" id="enquiry_taken" /></td>
                                            </tr>-->
                    <tr>
                        <td width="20%" class="heading">Remark<span class="orange_font">*</span></td>
                        <td><textarea name="remark" id="remark" ></textarea></td>
                      </tr>
                    <tr>
                        <td width="20%" >Enquiry For </td>
                        <td width="20%" ><textarea name="inquiry_for" id="inquiry_for" ></textarea></td>
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
                        
                         <input type="hidden" name="course_only_fee" id="course_only_fee" value="" />
                        
                        <td colspan="2"><button  type="submit" class="btn btn-warning" name="submit" onClick="return ajax_send();">Register</button></td>
                        
                      </tr>
                  </table>
                  
                   
                </td>
              </tr>
     
              </table>
              
              </div>
        <!--
        <ul id="form-section">
            <p><span class="register-numbering">1</span><span class="register-numbering-text">Basic information</span></p>
            <li>
                <label class="left-column">
                    <span>First Name*</span>
                    <input type="text" name="fname" tabindex="1" pattern="[a-zA-Z ]{2,}"  placeholder="Please enter your first name" required autofocus title="It must contain only letters and a length of minimum 2 characters!">
                </label>
                <label class="right-column">
                    <span>Last Name*</span>
                    <input type="text" name="lname" tabindex="2" pattern="[a-zA-Z ]{2,}" placeholder="Please enter your last name" title="It must contain only letters and a length of minimum 2 characters!" required>
                </label>
            </li>
            <div style="clear: both;"></div>
            <li>
                <label>
                    <span>Email*</span>
                    <input type="email" name="email" tabindex="3" placeholder="Please enter a valid email address" title="It must contain a valid email address e.g. 'someone@provider.com' !" required>
                </label>
            </li>
            <li>
                <label>
                    <span>Telephone*</span>
                    <input type="tel" name="telephone" pattern="(\+?\d[- .]*){7,13}" tabindex="4" placeholder="Please enter your phone number" title="It must contain a valid phone number formed only by numerical values and a length between 7 and 13 characters !" required>
                </label>
            </li>
            <p><span class="register-numbering">2</span><span class="register-numbering-text">Location details</span></p>
            <li>
                <label>
                    <span>Address*</span>
                    <input type="text" name="address" tabindex="5" pattern="[a-zA-Z0-9. - , ]{10,}"  placeholder="Please enter your street address" title="It must contain letters and/or separators and a length of minimum 10 characters !" required>
                </label>
            </li>
            <li>
                <label class="left-column">
                    <span>Country*</span>
                    <input type="text" name="country" tabindex="6" pattern="[a-zA-Z- ]{2,}"  placeholder="Please enter your country" title="It must contain only letters and a length of minimum 2 characters !" required>
                </label>
            </li>
            <li>
                <label class="right-column">
                    <span>ZIP Code*</span>
                    <input type="text" name="zipcode" tabindex="7" pattern="[0-9 ]{3,}" placeholder="Please enter your zip code" title="It must contain only numbers and a length of minimum 3 characters !" required>
                </label>
            </li>
            <div style="clear: both;"></div>
            <p><span class="register-numbering">3</span><span class="register-numbering-text">Account credentials</span></p>
            <li>
                <label>
                    <span>Username*</span>
                    <input type="text" name="username"  tabindex="8" pattern="[a-zA-Z0-9]{5,}"  placeholder="Please enter your username" title="It must contain alphanumeric characters and a length of minimum 6 characters !" required>
                </label>
            </li>
            <li>
                <label>
                    <span>Password*</span>
                    <input type="password" name="password" tabindex="9" pattern=".{5,}"  placeholder="Please enter your password" title="It can contain all types of characters and a length of minimum 6 characters!" required>
                </label>
            </li>
            <div style="clear: both;"></div>
            <li>
                <button name="submit" tabindex="11" type="submit" id="create-account-submit">Create Account</button>
            </li>
        </ul>
        -->
    </form>

    <script>

	 function show_course(course_id)
	{
			course_id = course_id;
			//alert(course_id);
			if(course_id !='')
        	{
				if( course_id != 'new_course')
				{
            var data1="action=show_course_enrolled&course_id="+course_id;
            document.getElementById('custome_div').style.display="none";
            $.ajax({
                url: "http://isasbeautyschool.com/faculty_login/ajax.php", type: "post", data: data1, cache: false,
                success: function (html)
                {
                  vals =html.split('###');
					//document.getElementById('duration_studies').value=vals[0].trim();
					document.getElementById('toal_fees').value=vals[1].trim();
					if(document.getElementById('course_only_fee'))
					{
						document.getElementById('course_only_fee').value=vals[1].trim();
						
					}
					//alert("Hi...");
					show_record();
					
                }
				
            });
				}
				else
				{
                                    $( ".new_custom_course" ).dialog({
                                        width: '500',
                                        height:'400'
                                    });
					//document.getElementById('custome_div').style.display="block";
				}
            return false;
        }
				
	}
</script>
<script>
function show_record()
{ 
//alert('ss');    
 frm = document.register_form; 
      concession=0; 
	  //paid=0;
	  totals_fees=0;
	  balance=0;
	// alert("HI....");
	  //================================PAID TYPE==========================
		paid_type =frm.paid_type.value;
		//alert(paid_type);
		if(paid_type=='installments')
		 {
			 <?
			 $sel="select service_tax,installment_course_percentage from general_settings where branch_name='pune' ";
			 $ptr_query=mysql_query($sel);
			 $data_tax=mysql_fetch_array($ptr_query);
			 ?>
			 toatl_one_time=parseInt(document.getElementById('course_only_fee').value);
			 //alert(toatl_one_time);
			 installment_charge=  parseInt(toatl_one_time*<?php echo $data_tax['installment_course_percentage']; ?>/100);
			 totals_charge=installment_charge+toatl_one_time;
			 document.getElementById('toal_fees').value=totals_charge;
			 
			 totals_fees = parseInt(document.getElementById('toal_fees').value);
	  		 //alert('totals_fees');
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
		// alert(concession);
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
	  
	  var net_fees=parseInt(document.getElementById('net_fees').value);
		var tax =parseInt(net_fees*<?php echo $data_tax['service_tax']; ?>/100);
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
		if(total_f==0 || paid_type =='one_time')
		{
			var inst1 = document.getElementById("dropdown").disabled  = true;
			$('#dropdown').removeClass("obrderclass");  
			//alert(total_f);
		}
		else{document.getElementById("dropdown").disabled  = false;}
	
}
</script>
 <script language="javascript">show_course(<?php echo $row['course_id']; ?>)</script>
 
    <!-- END OF REGISTER FORM -->
    <!-- MCQ  Code Starts-->
    <?php if( $post->post_name == "course-topic" ) { ?>
    
<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="//v2.zopim.com/?31kC9MpOO4gFX167e6wBofKDRM0SR0F3";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zopim Live Chat Script-->
    
    <?php }?>
    
    <!--Start of Zopim Live Chat Script-->

<!--End of Zopim Live Chat Script-->
          <form action="" method="post" id="quiz-form">
          <div class="close"></div>
        <ul id="form-section">
             <li>
                 <h3>When should exfoliation take place?</h3>
                     <div>
                        <input style="width: 10%; float: left; margin-top: 4px;" type="radio" name="question-1-answers" id="question-1-answers-A" value="A" />
                        <label for="question-1-answers-A">A) After the heat treatment </label>
                    </div>
                    <div>
                        <input style="width: 10%; float: left; margin-top: 4px;" type="radio" name="question-1-answers" id="question-1-answers-B" value="B" />
                        <label for="question-1-answers-B">B) At the end of the spa treatment plan</label>
                    </div>                 
                    <div>
                        <input style="width: 10%; float: left; margin-top: 4px;" type="radio" name="question-1-answers" id="question-1-answers-C" value="C" />
                       <label for="question-2-answers-C">C) At the beginning of the spa treatment plan</label>
                    </div>                 
                    <div>
                        <input style="width: 10%; float: left; margin-top: 4px;" type="radio" name="question-1-answers" id="question-1-answers-D" value="D" />
                         <label for="question-2-answers-D">D) At any time during the spa treatment plan</label>
                    </div>          
                </li>
                 <li>
                <button name="Submit-Quiz" type="submit" id="Submit-Quiz">Submit Your Answer</button>
            </li>
            </ul>
           
        </form>
    <!-- End MCQ  Code ends-->
        <!-- Finished Code Starts-->
          <form action="" method="post" id="finished-form">
          <div class="close"></div>
        <ul id="form-section">
        <li><label style="text-align:center;font-weight:bold;">Thank You! You have completed training successfully.</label></li>
        <br/><br />
        <li><a href=""><input type="button" style="margin-left: 19px;" value="Ok" /></a></li>
        </ul>          
        </form>
    <!-- End Finished  Code Ends-->
    <div id="background-on-popup"></div>
    
<!-- MCQ -->
          <form action="" method="post" id="mcq-form" style="width: 100%;">
          <div class="close1"></div>


            <ol id="form-section" class="m form-style">
            
                <li>
                
                    <h3>1) In general, the pH balance of the water used in flotation therapy should be
:</h3>
                    
                    <div>
                        <input style="width:1%;" type="radio" value="A" id="question-1-answers-A" name="question-1-answers">
                        <label for="question-1-answers-A">A) 6.4 - 6.6 </label>
                    </div>
                    
                    <div>
                        <input style="width:1%;" type="radio" value="B" id="question-1-answers-B" name="question-1-answers">
                        <label for="question-1-answers-B">B)  6.8 - 7.0</label>
                    </div>
                    
                    <div>
                        <input style="width:1%;" type="radio" value="C" id="question-1-answers-C" name="question-1-answers">
                        <label for="question-1-answers-C">C) 7.2 - 7.4</label>
                    </div>
                    
                    <div>
                        <input style="width:1%;" type="radio" value="D" id="question-1-answers-D" name="question-1-answers">
                        <label for="question-1-answers-D">D) 7.6 - 7.8</label>
                    </div>
                
                </li>
                
                <li>
                
                    <h3>2) When should exfoliation take place?</h3>
                    
                    <div>
                        <input style="width:1%;" type="radio" value="A" id="question-2-answers-A" name="question-2-answers">
                        <label for="question-2-answers-A">A) After the heat treatment</label>
                    </div>
                    
                    <div>
                        <input style="width:1%;" type="radio" value="B" id="question-2-answers-B" name="question-2-answers">
                        <label for="question-2-answers-B">B) At the end of the spa treatment plan</label>
                    </div>
                    
                    <div>
                        <input style="width:1%;" type="radio" value="C" id="question-2-answers-C" name="question-2-answers">
                        <label for="question-2-answers-C">C) At the beginning of the spa treatment plan</label>
                    </div>
                    
                    <div>
                        <input style="width:1%;" type="radio" value="D" id="question-2-answers-D" name="question-2-answers">
                        <label for="question-2-answers-D">D) At any time during the spa treatment plan</label>
                    </div>
                
                </li>
                
                <li>
                
                    <h3>3) What was the spa pool originally known as?</h3>
                    
                    <div>
                        <input style="width:1%;" type="radio" value="A" id="question-3-answers-A" name="question-3-answers">
                        <label for="question-3-answers-A">A) Blitz bath</label>
                    </div>
                    
                    <div>
                        <input style="width:1%;" type="radio" value="B" id="question-3-answers-B" name="question-3-answers">
                        <label for="question-3-answers-B">B) Affusion</label>
                    </div>
                    
                    <div>
                        <input  style="width:1%;" type="radio" value="C" id="question-3-answers-C" name="question-3-answers">
                        <label for="question-3-answers-C">C) Hot tub</label>
                    </div>
                    
                    <div>
                        <input style="width:1%;" type="radio" value="D" id="question-3-answers-D" name="question-3-answers">
                        <label for="question-3-answers-D">D) Jacuzzi</label>
                    </div>
                
                </li>
                
                <li>
                
                    <h3>4) Which of the following is an effect of paraffin wax?</h3>
                    
                    <div>
                        <input style="width:1%;" type="radio" value="A" id="question-4-answers-A" name="question-4-answers">
                        <label for="question-4-answers-A">A) To stimulate the nerves</label>
                    </div>
                    
                    <div>
                        <input style="width:1%;" type="radio" value="B" id="question-4-answers-B" name="question-4-answers">
                        <label for="question-4-answers-B">B) To cool the skin</label>
                    </div>
                    
                    <div>
                        <input style="width:1%;" type="radio" value="C" id="question-4-answers-C" name="question-4-answers">
                        <label for="question-4-answers-C">C) To reduce blood flow</label>
                    </div>
                    
                    <div>
                        <input style="width:1%;" type="radio" value="D" id="question-4-answers-D" name="question-4-answers">
                        <label for="question-4-answers-D">D) To relax the muscles</label>
                    </div>
                
                </li>
                
                <li>
                
                    <h3>5) What is the effect of lemongrass in a herbal pack?</h3>
                    
                    <div>
                        <input style="width:1%;" type="radio" value="A" id="question-5-answers-A" name="question-5-answers">
                        <label for="question-5-answers-A">A) Astringent</label>
                    </div>
                    
                    <div>
                        <input style="width:1%;" type="radio" value="B" id="question-5-answers-B" name="question-5-answers">
                        <label for="question-5-answers-B">B) Anti - bacterial</label>
                    </div>
                    
                    <div>
                        <input style="width:1%;" type="radio" value="C" id="question-5-answers-C" name="question-5-answers">
                        <label for="question-5-answers-C">C) Cleansing</label>
                    </div>
                    
                    <div>
                        <input style="width:1%;" type="radio" value="D" id="question-5-answers-D" name="question-5-answers">
                        <label for="question-5-answers-D">D) Relaxing</label>
                    </div>
                
                </li>
                            <br/><br />
                
        <li><a href=""><input type="button" class="quiz-submit" value="Submit Quiz" style=" margin-left: 19px; width: 190px; font-family: inherit; font-weight: bold; background-color: maroon; float: right;" /></a></li>
            </ol>  
                


           
        </form>
<!-- End MCQ -->
    
    
<!-- AFTER BODY ACTION -->
<?php do_action( 'zn_after_body' ); ?>
<?php
$page_id = 0;
if ( ! empty( $post ) ) {
    if ( strcasecmp( 'portfolio', get_post_type() ) == 0 ) {
        // if portfolio category
        if(is_archive()){
            global $wp_query;
            $qo = $wp_query->get_queried_object();
            if(isset($qo->term_id)) {
                $page_id     = $qo->term_id;
                $meta_fields = get_post_meta( $page_id, 'zn_meta_elements', true );
                $meta_fields = maybe_unserialize( $meta_fields );
            }
        }
        else {
            $k_postMeta = get_page_by_title( 'portfolio' );
            $page_id    = $k_postMeta->ID;
        }
    }
    else {
        $page_id = $post->ID;
    }
    $meta_fields = get_post_meta( $post->ID, 'zn_meta_elements', true );
    $meta_fields = maybe_unserialize( $meta_fields );
}

if ( is_home() || ( is_archive() && get_post_type() == 'post' ) ) {
    $page_id = get_option( 'page_for_posts' );
    $meta_fields = get_post_meta( $page_id, 'zn_meta_elements', true );
    $meta_fields = maybe_unserialize( $meta_fields );
}

if ( is_archive() && get_post_type() == 'product' ) {
    $page_id     = get_option( 'woocommerce_shop_page_id' );
    $meta_fields = get_post_meta( $page_id, 'zn_meta_elements', true );
    $meta_fields = maybe_unserialize( $meta_fields );
}

$header_css = '';
if ( ! empty( $meta_fields['zn_disable_subheader'] ) && $meta_fields['zn_disable_subheader'] == 'yes' ) {
    $header_css = 'no_subheader';
}
elseif ( ! empty( $meta_fields['zn_disable_subheader'] ) && $meta_fields['zn_disable_subheader'] == 'no' ) {
    $header_css = '';
}
elseif ( ( ! empty( $data['zn_disable_subheader'] ) && $data['zn_disable_subheader'] == 'yes' ) ) {
    $header_css = 'no_subheader';
}
?>

<div id="page_wrapper">
<?php
    $cta_button_class = '';
    if ( isset( $data['head_show_cta'] ) && ! empty( $data['head_show_cta'] ) ) {
        if ( $data['head_show_cta'] == 'yes' ) {
            $cta_button_class = 'cta_button';
        }
    }
?>
<header id="header" class="<?php echo $data['zn_header_layout'] . ' ' . $cta_button_class . ' ' . $header_css; ?>">
    <div class="container">

        <!-- logo container-->
        <?php
            $hasInfoCard = '';
            if ( isset( $data['infocard_display_status'] ) && ( $data['infocard_display_status'] == 'yes' ) ) {
                $hasInfoCard = 'hasInfoCard';
            }
        ?>
        <div class="logo-container <?php echo $hasInfoCard; ?>">
            <!-- Logo -->
            <?php echo zn_logo(); ?>
            <!-- InfoCard -->
            <?php do_action( 'zn_show_infocard' ); ?>
        </div>

        <?php $isSearch = empty( $data['head_show_search'] ) || ( ! empty( $data['head_show_search'] ) && $data['head_show_search'] == 'yes' ); ?>

        <!-- HEADER ACTION -->
        <div class="header-links-container <?php if ( ! $isSearch ) {
            echo 'nomarginright';
        } ?>">
            <?php do_action( 'zn_head_right_area' ); ?>
        </div>

        <?php if ( $isSearch ) { ?>
            <!-- search -->
            <div id="search">
                <a href="#" class="searchBtn"><span class="icon-search icon-white"></span></a>

                <div class="search">
                    <form id="searchform" action="<?php echo home_url(); ?>" method="get">
                        <input name="s" maxlength="20" class="inputbox" type="text" size="20"
                               value="<?php echo __( 'SEARCH ...', THEMENAME ); ?>"
                               onblur="if (this.value=='') this.value='<?php echo __( 'SEARCH ...', THEMENAME ); ?>';"
                               onfocus="if (this.value=='<?php echo __( 'SEARCH ...', THEMENAME ); ?>') this.value='';"/>
                        <input type="submit" id="searchsubmit" value="<?php _e( 'go', THEMENAME ); ?>"
                               class="icon-search"/>
                    </form>
                </div>
            </div>
            <!-- end search -->
        <?php } ?>

        <?php if ( empty( $data['head_show_cta'] ) || ( ! empty( $data['head_show_cta'] ) && $data['head_show_cta'] == 'yes' ) ) { ?>
            <?php
            if ( isset( $data['head_add_cta_link'] ) && ! empty( $data['head_add_cta_link'] ) ) {
                $link_extracted = kall_extract_link( $data['head_add_cta_link'], false, 'id="ctabutton"' );
                if ( ! empty( $data['head_set_text_cta'] ) ) {
                    if(isset($znData['wpk_cs_bg_color']) && isset($znData['wpk_cs_fg_color'])) {
                        echo '<style type="text/css">
                            #ctabutton .trisvg path { fill: ' . $znData['wpk_cs_bg_color'] . '; }
                            #ctabutton { background-color: ' . $znData['wpk_cs_bg_color'] . '; color: '.$znData['wpk_cs_fg_color'].'; }
                        </style>';
                    }
                    echo $link_extracted['start'];
                    echo $data['head_set_text_cta'];
                    echo '<svg version="1.1" class="trisvg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" preserveAspectRatio="none" width="14px" height="5px" viewBox="0 0 14.017 5.006" enable-background="new 0 0 14.017 5.006" xml:space="preserve"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.016,0L7.008,5.006L0,0H14.016z"></path></svg>';
                    echo $link_extracted['end'];
                }
            }
        } ?>

        <!-- main menu -->
        <nav id="main_menu"
             class="<?php if ( ! empty ( $data['res_menu_style'] ) && $data['res_menu_style'] == 'smooth' ) {
                 echo 'smooth_menu';
             } ?>">
            <?php if ( ! empty ( $data['res_menu_style'] ) && $data['res_menu_style'] == 'smooth' ) {
                echo '<div class="zn_menu_trigger"><a href="">' . __( 'Menu', THEMENAME ) . '</a></div>';
            } ?>
            <?php zn_show_nav( 'main_navigation' ); ?>
        </nav>
        <!-- end main_menu -->
    </div>
</header>

<div class="clearfix"></div>

<?php
    /*--------------------------------------------------------------------------------------------------

        HEADER AREA

    --------------------------------------------------------------------------------------------------*/

    if ( ! empty( $meta_fields['zn_disable_subheader'] ) && $meta_fields['zn_disable_subheader'] == 'yes') {
        return;
    }
    elseif ( ! empty( $meta_fields['zn_disable_subheader'] ) && $meta_fields['zn_disable_subheader'] == 'no' && isset ( $meta_fields['header_area'] ) && is_array( $meta_fields['header_area'] ) ) {
        zn_get_template_from_area( 'header_area', $post->ID, $meta_fields );
        return;
    }
    elseif ( ( ! empty( $data['zn_disable_subheader'] ) && $data['zn_disable_subheader'] == 'yes' ) ) {
        return;
    }
    elseif ( isset ( $meta_fields['header_area'] ) && is_array( $meta_fields['header_area'] ) ) {
        zn_get_template_from_area( 'header_area', $post->ID, $meta_fields );
        return;
    }
    elseif (is_404())
    {
        $style = 'uh_' . $data['404_header_style'];
?>
    <div id="page_header" class="<?php echo $style; ?> bottom-shadow">
        <div class="bgback"></div>
            <div data-images="<?php echo IMAGES_URL; ?>/" id="sparkles"></div>
            <div class="zn_header_bottom_style"></div>
    </div>
    <?php
        return;
    }
    else{
        // THIS SHOULD BE THE LAST CHECK FOR PAGE HEADER
        if(empty($meta_fields)){
            if(empty($page_id)){
                $page_id = get_the_ID();
            }
            $meta_fields = get_post_meta( $page_id, 'zn_meta_elements', true );
            $meta_fields = maybe_unserialize( $meta_fields );
        }
        WpkZn::displayPageHeader($znData, $page_id, $meta_fields);
    }