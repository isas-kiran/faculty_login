<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Campaign Report</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <?php include "include/headHeader_gst.php";?>
    <?php include "include/functions.php"; ?>
    <script type="text/javascript" src="../js/common.js"></script>
	<link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <link rel="stylesheet" href="js/chosen.css" />
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
     <script src="js/chosen.jquery.js" type="text/javascript"></script>
	<script type="text/javascript">
    $(document).ready(function()
	{  
		var currentDate = new Date();
		$('.datepicker').datepicker({ changeMonth: true, changeYear: true, showButtonPanel: true, closeText: 'Clear'});
		/*$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
		}*/
		$("#campaign_name").chosen({allow_single_deselect:true});
		<?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
		{ 
			?>
			$("#branch_name").chosen({allow_single_deselect:true});
			<?php 
		}
		?>
		$("#type").chosen({allow_single_deselect:true});
		//$('#inquiry_date').datepicker().datepicker('setDate', 'today');
	});
	</script>
    
    <style type = "text/css">
		.obrderclass{ border:1px solid #f00}
    </style>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='238'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>  
    <script>
		mail=Array();
		<?php
		"<br/>".$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='38' ".$_SESSION['where']."";
		$ptr_sel_sms=mysql_query($sel_sms_cnt);
		$tot_num_rows=mysql_num_rows($ptr_sel_sms);
		$i=0;
		while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
		{
			$sel_act="select email from site_setting where admin_id='".$data_sel_cnt['staff_id']."' and email!='' ".$_SESSION['where']."";
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
	 
	function show_campaign()
	{
		var campaign_id=document.getElementById('campaign_name').value;
		var from_date=document.getElementById('from_date').value;
		var to_date=document.getElementById('to_date').value;
		var data="campaign_id="+campaign_id+"&from_date="+from_date+"&to_date="+to_date;
		//alert(data);
		$.ajax({
		url:"show_campaign_details.php",type:"post",data:data,cache:false,
		success: function(prod_data)
		{
			//alert(prod_data);
			document.getElementById('campaign_id').innerHTML=prod_data;
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
            function(result){
				//alert(result);
                $('#feedback').html(result).show();
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
										<?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
                                        {
											?>
											<td width="10%">Select Branch<span class="orange_font">*</span></td>
											 <td width="15%">
												<select name="branch_name" id="branch_name"  class="input_select_login"  style="width:150px;" onchange="change_campaign(this.value);">
													<option value="">-Branch Name-</option>
													<?php 
														$sel_branch="select branch_id,branch_name from branch";
														$ptr_sel=mysql_query($sel_branch);
														while($data_branch=mysql_fetch_array($ptr_sel))
														{
															$sel='';
															if($data_branch['branch_name']==$_GET['branch_name'])
															{
																$sel='selected="selected"';
															}
															echo '<option '.$sel.' value="'.$data_branch['branch_name'].'" > '.$data_branch['branch_name'].'</option>';
														}
													?>
												</select>
											</td>
											<?php
                                        }
										else 
										{
											?>
											<input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
											<?php 
										}
                                        ?>
                                        <td width="10%">Select Type<span class="orange_font">*</span></td>
                                        <td width="15%">
                                            <select name="type" id="type"  class="input_select_login"  style="width: 150px;" onchange="change_type(this.value);">
                                                <option value="">-Type-</option>
                                                <option value="institute">Institute</option>
                                                <option value="service">Service</option>
                                            </select>
                                        </td>
                                        <td width="10%">Select Campaign<span class="orange_font">*</span></td>
                                        <td width="20%" id="camaign">
                                        <table width="100%">
                                            <tr>
                                                <td>
                                                    <select id="campaign_name" name="campaign_name" class="input_select" style="width:250px">
                                                        <option value="">Select Campaign</option>
                                                        <?php 
                                                        $course_category = " select DISTINCT(cm_id),branch_name from site_setting where type='A' ".$_SESSION['where']."";
                                                        $ptr_course_cat = mysql_query($course_category);
                                                        while($data_cat = mysql_fetch_array($ptr_course_cat))
                                                        {	
                                                            echo "<optgroup label='".$data_cat['branch_name']."'>";
                                                            $sel_source="SELECT * FROM campaign where 1 and cm_id='".$data_cat['cm_id']."' and status='Active' order by campaign_for asc";
                                                            $ptr_src=mysql_query($sel_source);
                                                            while($data_src=mysql_fetch_array($ptr_src))
                                                            {
                                                                $sele_source="";
                                                                if($data_src['campaign_id']==$_REQUEST['campaign_name'] || $_POST['enquiry_src']==$data_src['campaign_id'] )
                                                                {
                                                                    $sele_source='selected="selected"';
                                                                }
                                                                ?>
                                                                <option <?php echo $sele_source?> value ="<?php echo $data_src['campaign_id']?>" <?php if (isset($_REQUEST['campaign_name']) && $_REQUEST['campaign_name'] == $data_src['campaign_name']) echo "selected";?> > <?php echo $data_src['campaign_name']; ?> </option>
                                                                <?php
                                                            }
                                                            echo "</optgroup>";
                                                        }?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="10%"><input type="text" class="input_text datepicker" name="from_date" style="width:100px" placeholder="From Date" id="from_date" value="<?php if($_REQUEST['from_date']!="") echo $_REQUEST['from_date'];?>" /></td>
                                    <td width="10%"><input type="text" class="input_text datepicker" name="to_date" id="to_date" style="width:100px" placeholder="To Date" value="<?php if($_REQUEST['to_date']!="") echo $_REQUEST['to_date'];?>"  /></td>
                                    <td><input type="button" class="input_btn" onclick="show_campaign()" value="Search Campaign" name="search" id="search" /></td>
                                    <td width="60%"></td>
                                </tr>
                            </table>
                                    <div id="campaign_id"></div>
                            </form>
                            </td>
                         </tr>
                         <?php
                        } ?>
                    </table>
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
    <!--info end-->
    <div class="clearit"></div>
    <!--footer start-->
    <div id="footer">
    <?php require("include/footer.php");?>
    </div>
    <!--footer end-->
	<script>
	function change_campaign(branch)
	{
		var branch=document.getElementById('branch_name').value
		var cat_data="action=show_campaign&branch="+branch;
		$.ajax({
		url: "ajax.php",type:"post", data: cat_data,cache: false,
		success: function(retbank)
		{
			document.getElementById("camaign").innerHTML=retbank;
			//$("#expense_type").chosen({allow_single_deselect:true});
			$("#campaign_name").chosen({allow_single_deselect:true});
		}
		});
	}
	function change_type(type)
	{
		var branch_id=document.getElementById('branch_name').value;
		var cat_data="action=show_campaign_type&type="+type+"&branch_id="+branch_id;
		//alert(cat_data);
		$.ajax({
		url: "ajax.php",type:"post", data: cat_data,cache: false,
		success: function(retbank)
		{
			//alert(retbank);
			document.getElementById("camaign").innerHTML=retbank;
			//$("#expense_type").chosen({allow_single_deselect:true});
			$("#campaign_name").chosen({allow_single_deselect:true});
		}
		});
	}
	</script>
    <?php
	
	?>
</body>
</html>
<?php $db->close();?>