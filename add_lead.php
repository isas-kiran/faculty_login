<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
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
    Lead Form</title>
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
		$("#response").chosen({allow_single_deselect:true});
		$("#employee_id").chosen({allow_single_deselect:true});
		$("#batch").chosen({allow_single_deselect:true});
		$("#maritalstatus").chosen({allow_single_deselect:true});
	});
	</script>
    <style type = "text/css">
		.obrderclass{ border:1px solid #f00}
    </style>  
   	<script>
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
	$sel_mail_text="select email_text from previleges where privilege_id='38'";
	$ptr_mail_text=mysql_query($sel_mail_text);
	if($tot_mail_text=mysql_num_rows($ptr_mail_text))
	{
		$data_mail_text=mysql_fetch_array($ptr_mail_text);
		?>
		email_text_msg='<?php echo  urlencode($data_mail_text['email_text']);?>';
		<?php
	}
	?>
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
		var bank_data="action=add_leads&branch_id="+branch_id+"&admin_id=<?php echo $_SESSION['admin_id'];?>";
		//alert(bank_data);
		$.ajax({
		url: "show_councellor.php",type:"post",data: bank_data,cache: false,
		success: function(retbank)
		{
			//alert(retbank);
			document.getElementById("emp_ids").innerHTML=retbank;
			$("#employee_id").chosen({allow_single_deselect:true});
            show_campaign(branch_id);
		}
		}); 
	}
	 
	function validme()
	{
		frm = document.jqueryForm;
		error='';
		disp_error = 'Clear The Following Errors : \n\n';
		<?php
		if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
		{
			?>
			if(frm.branch_name.value=='')
			{
				disp_error +='Select Branch Name\n';
				document.getElementById('branch_name').style.border = '1px solid #f00';
				frm.branch_name.focus();
				error='yes';
			}
			<?php
		}
		?>
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
        if(frm.mobile1.value=='')
        {
            disp_error +='Enter Mobile Number \n';
            document.getElementById('mobile1').style.border = '1px solid #f00';
            frm.mobile1.focus();
            error='yes';
        }
        else
        {	 
            var text = frm.mobile1.value;
			if(text.length < 8)
            {
                disp_error +='Enter Valid Mobile Number \n';
                document.getElementById('mobile1').style.border = '1px solid #f00';
                error='yes';
            }
		}
		if(frm.enquiry_src.value=='')
        {
            disp_error +='Select Enquiry Source \n';
            document.getElementById('enquiry_src').style.border = '1px solid #f00';
            frm.enquiry_src.focus();
            error='yes';
	    }
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


function show_campaign(branch_name)
{
	branch_name=branch_name;
	var camp_data="action=add_lead&branch_name="+branch_name;
    //alert(bank_data);
    $.ajax({
    url: "show_campaign_name.php",type:"post", data: camp_data,cache: false,
    success: function(retbank)
    {
        document.getElementById("campaign_ids").innerHTML=retbank;
        $("#enquiry_src").chosen({allow_single_deselect:true});
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
            if(isset($_POST['submit']) && $_SESSION['name']!='')
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
                //$enquiry_taken=$_SESSION['admin_id'];
                //$enquiry_taken=( ($_POST['enquiry_taken'])) ? $_POST['enquiry_taken'] : "0";
                //$remark=$_POST['remark'];
                $remark=mysql_real_escape_string($_POST['remark']) ? $_POST['remark'] : "";
                //$company=$_POST['company'];
                $company=( ($_POST['company'])) ? $_POST['company'] : "";
                //$inquiry_for=$_POST['inquiry_for'];
                $inquiry_for=mysql_real_escape_string($_POST['inquiry_for']) ? $_POST['inquiry_for'] : "";
                //$followup_date1=$_POST['followup_date'];
                $followup_date1=( ($_POST['followup_date'])) ? $_POST['followup_date'] : "";
                //$branch_name=$_POST['branch_name'];
                //$address=$_POST['address'];
                $address=mysql_real_escape_string($_POST['address']) ? $_POST['address'] : "";
                //$batch_time=$_POST['batch_time'];
                $batch_time=( ($_POST['batch_time'])) ? $_POST['batch_time'] : "";
                //$response=$_POST['response'];
                $response=( ($_POST['response'])) ? $_POST['response'] : "";
                $response_reason=( mysql_real_escape_string($_POST['response_reason'])) ? $_POST['response_reason'] : "";
                //$followup_desc= $_POST['followup_desc'];
                $followup_desc=mysql_real_escape_string($_POST['followup_desc']) ? $_POST['followup_desc'] : "";
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
                if($enquiry_src=="")
                {
                    $success=0;
                    $errors[$i++]="Select Source";
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
                                    echo '<div style="text-align:left;padding:5px;">'.$errors[$k].'</div>'; 
								?>
                                </div>
                           	</td>
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
					$data_record['remark'] = $remark;  
					$data_record['inquiry_for'] = $inquiry_for;
					$data_record['followup_date'] =$followup_date;
					$data_record['not_status']='signs_on';
					$data_record['added_date'] =date('Y-m-d H:i:s');
					$data_record['response']=$response;
					$data_record['response_reason']=$response_reason;
					$data_record['followup_details']=$followup_desc;
					$data_record['employee_id']=$employee_id;
					
					//===============================CM ID for Super Admin===============
					if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
					{
						$sel_branch="select cm_id,admin_id from site_setting where branch_name='".$branch_name."' and type='A'";
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
					}
					else
					{
						$insert="INSERT INTO inquiry (`course_id`,`firstname`,`middlename`,`lastname`,`mobile1`,`email_id`, `enquiry_source`,`remark`,`added_date`,`cm_id`,`admin_id`,`status`,`enquiry_from`,`employee_id`,`campaign_type`) VALUES ('".$course_interested."','".$firstname."','".$middlename."','".$lastname."','".$mobile1."','".$email_id."','".$enquiry_src."', '".addslashes($remark)."','".date('Y-m-d H:i:s')."','".$cm_id."','".$_SESSION['admin_id']."','Enquiry','offline','".$employee_id."','lead_distribution')";
						$ptr_query=mysql_query($insert);
						$inqyiry_id1 = mysql_insert_id();
						if($inqyiry_id1 !='')
						{
							//$insert_regi = "INSERT INTO `stud_regi` (`class_id`,`course_id`,`admin_id`,`cm_id`,`name`,  `dob`, `address`, `contact`, `mail`, `qualification`,  `added_date`, `status` ,`not_status`,`enquiry_source`,`response`) VALUES ('".$inqyiry_id1."','".$course_interested."','".$_SESSION['admin_id']."','".$cm_id."', '".$firstname." ".$lastname."', '".$birth_date."', '".$address."', '".$mobile1."', '".$email_id."', '$education', '".date('Y-m-d H:i:s')."', 'Enquiry','signs_on','".$enquiry_src."','".$response."')";
							//$ptr_reg = mysql_query($insert_regi);
										
							//$insert_followup = "INSERT INTO `followup_details` (`student_id`,`lead_category_followup`, `followup_date`,`followup_details`,`lead_grade`,`response`, `added_date`, `cm_id`,`admin_id`)VALUES ('".$inqyiry_id1."','".$lead_category_followup."', '".$followup_date."','".$followup_desc."','".$lead_grade."','".$response."','".date('Y-m-d H:i:s')."','".$cm_id."','".$admin_id."')";
							//$ptr_followup = mysql_query($insert_followup);
						}
						else
						{
							echo ' <br></br><div id="msgbox" style="width:40%;">Insert Query Error to adding Inquiry</center></div> <br></br>';
							exit();
						}
						$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('inquiry','Add_lead','".$firstname." ".$middlename." ".$lastname."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
						$query=mysql_query($insert);    
						//---------Send Message-------------
						$sel_course_name="select course_name from courses where course_id='".$course_interested."'";
						$ptr_course_sel=mysql_query($sel_course_name);
						$data_course_name=mysql_fetch_array($ptr_course_sel);
						
						$sel_inq="select sms_text from previleges where privilege_id='38'";
						$ptr_inq=mysql_query($sel_inq);
						$txt_msg='';
						if(mysql_num_rows($ptr_inq))
						{
							$dta_msg=mysql_fetch_array($ptr_inq);
							$txt_msg=$dta_msg['sms_text']." ";
						}
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
							$sel_act="select contact_phone from site_setting where type='S' ";
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
						setTimeout('document.location.href="manage_lead.php";',1000);
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
								<td><input type="hidden" name="inqyiry_idss" id="inqyiry_idss" value="<?php echo $data_emails['email']; ?>" /></td> 		</tr>
							<tr>
								<td height="30" colspan="3" class="orange_font">* Mandatory Fields <input type="hidden" name="record_id" id="record_id" value="<?php echo $record_id; ?>"/></td>
							</tr>
							<?php 
							if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
							{
								?>
								<tr>
									<td>Select Branch</td>
									<td>
										<?php 
                                        $sel_branch="SELECT * FROM branch where 1 and status='Active' order by branch_id asc ";
                                        $query_branch = mysql_query($sel_branch);
                                        $total_Branch = mysql_num_rows($query_branch);
                                        echo '<table width="100%"><tr><td>';
                                        echo '<select id="branch_name" name="branch_name" onchange="show_bank(this.value);" style="width:150px">';
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
								<?php 
							}
							else 
							{ 
								?>
								<input type="hidden"  name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  />
								<?php 
							}?>
							<tr>
								<td width="22%">Firstname<span class="orange_font">*</span></td>
								<td width="44%"><input type="text" class="input_text required" name="firstname" id="firstname" value="<?php if($_POST['firstname']) echo $_POST['firstname']; else echo $row_record['firstname'];?>"/>
								</td>
							</tr>
							<tr>
								<td width="22%" >Middlename<span class="orange_font"></span></td>
								<td width="44%"><input type="text" class="input_text" name="middlename" id="middlename" value="<?php if($_POST['middlename']) echo $_POST['middlename']; else echo $row_record['middlename']; ?>"/></td>
							</tr>
							<tr>
								<td width="22%">Lastname<span class="orange_font"></span></td>
								<td 40%><input type="text" class="input_text" name="lastname" id="lastname" value="<?php if($_POST['lastname']) echo $_POST['lastname']; else echo $row_record['lastname']; ?>"/></td>
							</tr>
							<tr>
								<td width="22%">Mobile<span class="orange_font">*</span></td>
								<td width="44%"><input type="text" class="input_text" name="mobile1" id="mobile1" value="<?php if($_POST['mobile1']) echo $_POST['mobile1']; else echo $row_record['mobile1'];?>" onKeyPress="return isNumber(event)" maxlength="10" minlength="10"/></td>
								<td width="34%"><div id="feedback"></div></td>
							</tr>
							<tr>
								<td width="22%">E-Mail<span class="orange_font"></span></td>
								<td width="44%"><input type="text" class=" input_text" name="email_id" id="email_id" value="<?php if($_POST['email_id']) echo $_POST['email_id']; else echo $row_record['email_id'];?>" /></td>
								<td width="34%"></td>
							</tr>
							<tr>
								<td width="22%">Course Interested<span class="orange_font"></span></td>
								<td class="customized_select_box">
                                    <select id="course_id" name="course_id"  class="input_text">
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
                                                <?php 
                                            }
                                            echo " </optgroup>";
                                        }?>
                                        <option value="custome">Customised Course</option>
                                    </select>
								</td>
							</tr>
							<tr>
								<td width="22%" class="heading">Enquiry Source<span class="orange_font">*</span></td>
								<td id="campaign_ids">
								<select id="enquiry_src" name="enquiry_src" <?php echo $redonly; ?> class="input_select">
								<option value="">Select Source</option>
								<?php 
								/*$sel_source="SELECT * FROM campaign where 1 ".$_SESSION['where']." ";
								$ptr_src=mysql_query($sel_source);
								while($data_src=mysql_fetch_array($ptr_src))
								{
									$sele_source="";
									if($data_src['campaign_id'] == $row_record['enquiry_source'] || $_POST['enquiry_src']== $data_src['campaign_id'] )
									{
										$sele_source='selected="selected"';
									}
									?>
									<option <?php echo $sele_source?> value = "<?php echo $data_src['campaign_id']?>" <? if (isset($enquiry_src) && $enquiry_src == $data_src['campaign_name']) echo "selected";?> > <?php echo $data_src['campaign_name'] ?> </option>
									<?
								}*/
								?>
								<?php 
								$course_category="select DISTINCT(cm_id),branch_name from site_setting where type='A' ".$_SESSION['where']."";
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
										<?php
									}
									echo "</optgroup>";
								}?>
								</select>
								</td>
							</tr>
							<tr>
								<td width="22%" class="heading">Remark<span class="orange_font"></span></td>
								<td><textarea name="remark" id="remark" class="input_text" style="height: 53px;"><?php if($_POST['remark']) echo $_POST['remark']; else echo $row_record['remark'];?></textarea></td>
							</tr>
							<tr>
								<td width="22%">Assigned to<span class="orange_font">*</span></td>
								<td width="44%" id="emp_ids"><select id="employee_id" name="employee_id" class="input_select">
								<option value="">Select Staff</option>
								</select></td>
								<td width="34%"></td>
							</tr>
							<tr>
								<td><input type="reset" class="inputButton" onClick="document.contactUs.reset();"/></td>&nbsp;
								<td><input type="submit" class="inputButton" value="Submit" name="submit" id="submit1" /></td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
			<?php
		}
		?>
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
    <script>
	branch_name =document.getElementById("branch_name").value;
	//alert(branch_name);
	show_bank(branch_name);
	</script>
    <!--footer end-->
</body>
</html>
<?php $db->close();?>