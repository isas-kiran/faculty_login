<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM site_setting where admin_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
	$select_sallery_details="select * from sallery where admin_id='".$record_id."'";
	$sallery_details=mysql_query($select_sallery_details);
	$fetch_sallery=mysql_fetch_array($sallery_details);
}
if($record_id && $_REQUEST['deleteThumbnail'])
{
    $update_news="update site_setting set photo='' where admin_id='".$record_id."'";
    //echo $update_events;
    $db->query($update_news);
    if($row_record['photo'] && file_exists("../teacher_photo/".$row_record['photo']))
        unlink("../teacher_photo/".$row_record['photo']);
    $row_record=$db->fetch_array($db->query($sql_record));
}
/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php if($record_id) echo "Edit"; else echo "Add";?>User</title>
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
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            $("#user_id").multiselect().multiselectfilter();
			$("#staff_pre_id").multiselect().multiselectfilter();
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



$(document).ready(function(){



    $("#flip").click(function(){

			$("#panel").show('slow');

			$("#flip").hide();


    });



});



/*



$(document).ready(function() {



    $("#user_type").change(function() {



        var selVal = $(this).val();



		//alert(selVal);



		 $("#branch_name").html('');



        if(selVal == 'A' || selVal == 'F' || selVal == 'C' || selVal == 'B'  ) 



		{



			var data1="user_type="+selVal;	



			 $.ajax({



            url: "get_branch.php", type: "post", data: data1, cache: false,



            success: function (html)



            {



				//alert(html);



				 



				  document.getElementById('branch_name').innerHTML=html;



				 //$("#branch_name").css("display:block !important")



				 



				 //alert(html);



	             //show_bank(html);



            }



            });



           



		}



		else



		{}



		



    });



	



	



});



*/	function validme()
	{
	frm = document.jqueryForm;
	error='';
	disp_error = 'Clear The Following Errors : \n\n';
	if(frm.name.value=='')
	{
		 disp_error +='Enter Name\n';
		 document.getElementById('name').style.border = '1px solid #f00';
		 frm.name.focus();
		 error='yes';
	}
	if(frm.user_type.value=='U')
	{
		 disp_error +='Select User Type\n';
		 document.getElementById('user_type').style.border = '1px solid #f00';
		 frm.user_type.focus();
		 error='yes';
	}
	if(frm.contact_phone.value=='')
	{
		 disp_error +='Enter Mobile Number \n';
		 document.getElementById('contact_phone').style.border = '1px solid #f00';
		 frm.contact_phone.focus();
		 error='yes';
	}
	else
	{	 
		var text = frm.contact_phone.value;
		if(text.length <10)
		{
				 disp_error +='Enter Valid Mobile Number \n';
				 document.getElementById('contact_phone').style.border = '1px solid #f00';
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
	if(frm.dob.value!='')
	{
		if(isPastDate(frm.dob.value))
		{
			var date1 = new Date(frm.dob.value);
			var date2 = new Date();
			var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24)); 
			if(diffDays<6570)
			{
				 disp_error +='Your Age is not valid for Registration. need more than 18 year age';
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
	 if(frm.email.value=='')
	 {
		 disp_error +='Enter Email ID\n';
		 document.getElementById('email').style.border = '1px solid #f00';
		 frm.email.focus();
		 error='yes';
	 }
	 else
	 {
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if(document.getElementById('email').value !='')
		{
			if (reg.test(document.getElementById('email').value) == false) 
			{
				disp_error +='Invalid Email Address\n';
				document.getElementById('email').style.border = '1px solid #f00';
				frm.email.focus();
				error='yes';
			}
		}
	 }
		 /*if(frm.basic_sallery.value=='')
		 {
			 disp_error +='Enter Basic Sallery \n';
			 document.getElementById('basic_sallery').style.border = '1px solid #f00';
			 frm.basic_sallery.focus();
			 error='yes';
	     }*/
		 /*  if(frm.username.value=='')



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
	    }*/
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

	function isSpclChar(id){



var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>? ";







 vals = document.getElementById(id).value;



for (var i = 0; i < vals.length; i++) {



    if (iChars.indexOf(vals.charAt(i)) != -1) {



          return 'yes';



        }



    }



	



}  



	 



/*function validateEmail(emailField){



		



        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;



		if(document.getElementById('email').value !='')



		{



			if (reg.test(document.getElementById('email').value) == false) 



			{



				alert('Invalid Email Address');



				document.getElementById('email').style.border = '1px solid #f00';



				document.getElementById('email').focus();



				return false;



			}



		}



        return true;



}*/



</script>



<style> 



#panel, #flip{



	}



#panel {



	display:none;



}



</style>







 



 <style>	



					 



	.addBtn{background:no-repeat url(images/add.png); width:17px; border:0px; cursor:pointer;}



	.delBtn{background:no-repeat url(images/delete.png);width:17px; border:0px; cursor:pointer;}



	.editBtn{background:no-repeat url(images/edit_icon.gif); width:17px; border:0px; cursor:pointer;}



	.clrButton{background:no-repeat url(images/edit_clear.png);width:17px; border:0px; cursor:pointer;}



	.inactive{ background-color:#FFF;cursor:pointer; color:#000}



	.active{ background-color:#699;cursor:pointer; color:#FFF}



	.hidden{ display:none; width:0px; height:0px;}	



	.tbl{border-radius:3px; border:#333 solid 1px; background-color:#CCC; }



	.pointer{ cursor:pointer;}



	</style>



    



     <script language="javascript" src="js/script.js"></script>



     <script language="javascript" src="js/conditions-script.js"></script>



     



 <script>



function show_bank(branch_id)



{



	



	//alert(branch_id)



	var tax_data="show_tax=1&branch_id="+branch_id;



	//alert(tax_data);



	$.ajax({



	url: "show_allowance.php",type:"post", data: tax_data,cache: false,



	success: function(rettax)



	{



		var allowance=rettax.split('-');



		traveling_allowance= allowance[0];



		dearness_allowance= allowance[1];



		house_rent_allowance= allowance[2];



		



		document.getElementById("traveling_allowance_per").innerHTML=traveling_allowance;



		$('#traveling_allowance_per_hid').val(traveling_allowance);



		//alert(traveling_allowance);



		



		document.getElementById("dearness_allowance_per").innerHTML=dearness_allowance;



		$('#dearness_allowance_per_hid').val(dearness_allowance);



		//alert(dearness_allowance)



		



		document.getElementById("house_rent_allowance_per").innerHTML=house_rent_allowance;



		$('#house_rent_allowance_per_hid').val(house_rent_allowance);



		//alert(house_rent_allowance)

	}
	});

}
</script>

<script>

 function calculte_total_sal()
 {

	 var basic_sallery=document.getElementById("basic_sallery").value;
	//////////////////////travelling Allowance/////////////////////////////
	 var traveling_allowance_per_hid1=document.getElementById("traveling_allowance_per_hid").value;
	 //alert(traveling_allowance_per_hid)
	 travelling_allow1=parseFloat(basic_sallery * (traveling_allowance_per_hid1/100));
	 //alert(travelling_allow)
	 document.getElementById("traveling_allowance").value=travelling_allow1;

	 //////////////////////End travelling Allowance/////////////////////////////
	 //////////////////////Dearness Allowance/////////////////////////////
	 var dearness_allowance_per_hid1=document.getElementById("dearness_allowance_per_hid").value;
	 //alert(dearness_allowance_per_hid)
	 dearness_allowance1=parseFloat(basic_sallery * (dearness_allowance_per_hid1/100));
	 //alert(dearness_allowance)
	 document.getElementById("dearness_allowance").value=dearness_allowance1;
	 //////////////////////End Dearness Allowance/////////////////////////////
	 //////////////////////House Rent Allowance/////////////////////////////
	 var house_rent_allowance_per_hid1=document.getElementById("house_rent_allowance_per_hid").value;
	 //alert(house_rent_allowance_per_hid)
	 house_rent_allowance1=parseFloat(basic_sallery * (house_rent_allowance_per_hid1/100));
	 //alert(house_rent_allowance)
	 document.getElementById("house_rent_allowance").value=house_rent_allowance1;

	 //////////////////////House Rent Allowance/////////////////////////////

	 var total1=isNaN(parseFloat((+basic_sallery) + (+travelling_allow1) + (+dearness_allowance1) + (+house_rent_allowance1))) ? 0 :parseFloat((+basic_sallery) + (+travelling_allow1) + (+dearness_allowance1) + (+house_rent_allowance1))

	 $('#total_sal').val(total1);
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
    <td class="top_mid" valign="bottom"><?php include "include/user_menu.php"; ?></td>
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
						//$user_type = $_POST['user_type'];
						$user_type=( ($_POST['user_type'])) ? $_POST['user_type'] : "";
                        //$name = $_POST['name'];
						$name=( ($_POST['name'])) ? $_POST['name'] : "";
						//$username=$_POST['username'];
						$username=( ($_POST['username'])) ? $_POST['username'] : "";
						//$email=$_POST['email'];
						$email=( ($_POST['email'])) ? $_POST['email'] : "";
						//$pass=$_POST['pass'];
						$pass=( ($_POST['pass'])) ? $_POST['pass'] : "";
						if($_POST['dob'] !='')
						{
							$dob = $_POST['dob'];
							$explode=explode('/',$dob);
							$sep_dob=$explode[2].'-'.$explode[1].'-'.$explode[0];
						}
						else
							$sep_dob='';
                        //$contact_phone=$_POST['contact_phone']; 
						$contact_phone=( ($_POST['contact_phone'])) ? $_POST['contact_phone'] : "";
					    //$email=$_POST['email'];
						$email=( ($_POST['email'])) ? $_POST['email'] : "";
						//$staff_specification=$_POST['staff_specification'];
						$staff_specification=( ($_POST['staff_specification'])) ? $_POST['staff_specification'] : "";
					    //$staff_quilification=$_POST['staff_quilification'];
						$staff_quilification=( ($_POST['staff_quilification'])) ? $_POST['staff_quilification'] : "";
						//$staff_experience=$_POST['staff_experience']; 
						$staff_experience=( ($_POST['staff_experience'])) ? $_POST['staff_experience'] : "";
					    //$contact_address=$_POST['contact_address'];
						$contact_address=( ($_POST['contact_address'])) ? $_POST['contact_address'] : "";
						//$basic_pay=$_POST['basic_pay'];
						//$photo=$_POST['photo'];
						$photo=( ($_POST['photo'])) ? $_POST['photo'] : "";
						$added_date=date('Y-m-d H:i:s');    
						//$branch_name=$_POST['branch_name'];  
						$branch_name=( ($_POST['branch_name'])) ? $_POST['branch_name'] : "";
						//$detail==$_POST['detail'];  
						$detail=( ($_POST['detail'])) ? $_POST['detail'] : "";
						//$current_address=$_POST['current_address'];
						$current_address=( ($_POST['current_address'])) ? $_POST['current_address'] : "";
						//$company_name=$_POST['company_name'];
						$company_name=( ($_POST['company_name'])) ? $_POST['company_name'] : "";
						//$mobile2=$_POST['mobile2'];
						$mobile2=( ($_POST['mobile2'])) ? $_POST['mobile2'] : "";
						//$home_phone=$_POST['home_phone'];
						$home_phone=( ($_POST['home_phone'])) ? $_POST['home_phone'] : "";
						//$joining_date=$_POST['joining_date'];
						$joining_date=( ($_POST['joining_date'])) ? $_POST['joining_date'] : "";
						//$leaving_date=$_POST['leaving_date'];	
						$leaving_date=( ($_POST['leaving_date'])) ? $_POST['leaving_date'] : "";
						//$description=$_POST['description'];	
						$description=( ($_POST['description'])) ? $_POST['description'] : "";
						//$basic_sallery=$_POST['basic_sallery'];
						$basic_sallery=( ($_POST['basic_sallery'])) ? $_POST['basic_sallery'] : "";
						//$traveling_allowance=$_POST['traveling_allowance'];
						$traveling_allowance=( ($_POST['traveling_allowance'])) ? $_POST['traveling_allowance'] : "";
						//$dearness_allowance=$_POST['dearness_allowance'];
						$dearness_allowance=( ($_POST['dearness_allowance'])) ? $_POST['dearness_allowance'] : "";
						//$house_rent_allowance=$_POST['house_rent_allowance'];
						$house_rent_allowance=( ($_POST['house_rent_allowance'])) ? $_POST['house_rent_allowance'] : "";
						//$total_sal=$_POST['total_sal'];
						$total_sal=( ($_POST['total_sal'])) ? $_POST['total_sal'] : "";
						//$total_floor=$_POST['floor'];
						$total_floor=( ($_POST['floor'])) ? $_POST['floor'] : "";
						//$from=$_POST['from'];
						$from=( ($_POST['from'])) ? $_POST['from'] : "";
						//$to=$_POST['to'];
						$to=( ($_POST['to'])) ? $_POST['to'] : "";
						//$percentage=$_POST['percentage'];
						$percentage=( ($_POST['percentage'])) ? $_POST['percentage'] : "";
						
						if($record_id)
						{
							$admin_id="and admin_id !=".$record_id."";
						}
						else	
						{
							 $admin_id="";
						}
						$chk_exist = " select username from site_setting where username='".$username."' ".$admin_id." ";
						$ptr_chk_exit = mysql_query($chk_exist);
						if(mysql_num_rows($ptr_chk_exit))
						{
							 $success=0;
                             $errors[$i++]="Username Already Exist. Choose Other username ";
						}             
						if($_POST['user_type']=='A')
						{
							$select_branch='select branch_name from site_setting where branch_name="'.$branch_name.'" and 	type="A"';
							$ptr_branch_name=mysql_query($select_branch);
							if(mysql_num_rows($ptr_branch_name))
							{
								$success=0;
                             	$errors[$i++]="Center manager already assigned to '<b>$branch_name</b>' branch.  ";
							}
						}
                        if($name =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter name";
                        }
						if($user_type =="U")
                        {
                                $success=0;
                                $errors[$i++]="Select User Type";
                        }
						/*if($username =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter User Name";
                        }*/
						/*if($pass =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter PassWord";
                        }
*/
                       $uploaded_url="";
                            if(count($errors)==0 && $_FILES['photo']["name"])
                            {
                                if($record_id)
                                {
                                    $update_news="update site_setting set photo='' where admin_id='".$record_id."'";
                                    $db->query($update_news);
                                    if($row_record['photo'] && file_exists("../teacher_photo/".$row_record['photo']))
                                        unlink("../teacher_photo/".$row_record['photo']);
                                    if($row_record['photo'] && file_exists("../teacher_photo/".$row_record['photo']))
                                        unlink("../teacher_photo/".$row_record['photo']);
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
							if($user_type=='A')
							{
								$data_record['designation']='Center Manger';
							}elseif($user_type=='F')
							{
								$data_record['designation']='Staff';
							}
							elseif($user_type=='C')
							{
								$data_record['designation']='Councellor';
							}
							elseif($user_type=='B')
							{
								$data_record['designation']='BOP';
							}
							$data_record['type']=$user_type;
                            $data_record['name']=$name;
							$data_record['dob']=$sep_dob;
                            $data_record['username'] =$username;
                            $data_record['pass'] =$pass;
                            $data_record['email'] =$email;
                            $data_record['contact_phone'] =$contact_phone;
                            $data_record['contact_address'] = $contact_address;
                            $data_record['specilization']=$staff_specification;
					    	$data_record['qualification']=$staff_quilification;
							$data_record['experiance']=$staff_quilification;   
                            //$data_record['basic_pay'] =$basic_pay;
                            $data_record['added_date'] = $added_date;
							$data_record['branch_name'] = $_SESSION['branch_name'];
							$data_record['detail'] =$detail;
							$data_record['current_address']=$current_address;
							$data_record['company_name']=$company_name;
							$data_record['mobile2']=$mobile2;
							$data_record['home_phone']=$home_phone;
							$data_record['joining_date']=$joining_date;
							$data_record['leaving_date']=$leaving_date;
							$data_record['description']=$description;
							/*if($_POST['user_type']!='S')
							{
								 $data_rescord['branch_name'] = $branch_name;
								 $data_record['cm_id']='admin_id';
							}
							else
							{
								$data_record['branch_name'] = $_SESSION['branch_name'];
							}*/
							//=====================================
							if($_SESSION['type']=='S')
							{
								echo $sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								if(mysql_num_rows($ptr_branch))
								{
									$data_branch=mysql_fetch_array($ptr_branch);
									$data_record['cm_id']=$data_branch['cm_id'];
									$data_record['branch_name']=$branch_name;
									//$_SESSION['cm_id_notification']=$data_branch['cm_id'];
								}
								else{
									$data_record['cm_id']='0';
									$data_record['branch_name']=$branch_name;
								}
							}	
							else
							{
								$data_record['cm_id']=$_SESSION['cm_id'];
								$data_record['branch_name']=$_SESSION['branch_name'];
							}
						 	if($file_uploaded)
							$data_record['photo'] = $uploaded_url;

                            if($record_id)
                            {
								
								
                                $where_record="admin_id='".$record_id."'";                                
                                $db->query_update("site_setting", $data_record,$where_record); 
								if($_POST['user_type']=='A')
								{  
									$update_cm_id = " update site_setting  set cm_id = admin_id where admin_id='".$record_id."'";
									mysql_query($update_cm_id);
								}
								$select_sallery="select admin_id from sallery where admin_id='".$record_id."' ";
								$query_sal=mysql_query($select_sallery);
								$num_rows=mysql_num_rows($query_sal);
								if($num_rows!='')
								{
									$update_sallery="update sallery set admin_id='".$admin_id."', basic_sallery='".$basic_sallery."', traveling_allowance='".$traveling_allowance."', dearness_allowance='".$dearness_allowance."', house_rent_allowance='".$house_rent_allowance."', total_sal='".$total_sal."' where admin_id='".$record_id."'";

									$query_update=mysql_query($update_sallery);
								}
								else
								{
									$insert_for_sallary = "insert into sallery (`admin_id`, `basic_sallery`, `traveling_allowance`, `dearness_allowance`, `house_rent_allowance`, `total_sal`, `added_date`) values('".$admin_id."', '".$basic_sallery."', '".$traveling_allowance."', '".$dearness_allowance."', '".$house_rent_allowance."', '".$total_sal."', '".date('Y-m-d H:i:s')."')";
                            	$ptr_insert_sallary = mysql_query($insert_for_sallary);
								}
								
																	
								"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_user','Edit','".$name."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
								$query=mysql_query($insert);           

                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                            else
                            {
							    $data_record['added_date'] = date('Y-m-d H:i:s');
                                $courses_id=$db->query_insert("site_setting", $data_record);  
							    $admin_id= mysql_insert_id();
								if($_POST['user_type']=='A')
								{  
									echo $update_cm_id = " update site_setting  set cm_id = admin_id where admin_id='".$admin_id."'";
									mysql_query($update_cm_id);
								}
								//=========================ADMIN PREVELEGES===================================
								$privilege_ids = $_POST['privilege_id'];
								//echo count($privilege_ids);
								for($i=0;$i<count($privilege_ids);$i++)
								{
									"<br/>".$select_parent="select privilege_parent_id from previleges where privilege_id='".$privilege_ids[$i]."'";
									$ptr_parent=mysql_query($select_parent);
									$data_parent=mysql_fetch_array($ptr_parent);
									
									"<br/>".$insert_for_prevelgegeis = "insert into admin_previleges (`previlege_parent_id`,`privilege_id`,`admin_id`) values('".$data_parent['privilege_parent_id']."','".$privilege_ids[$i]."','".$admin_id."')";
									$ptr_insert_preilgef = mysql_query($insert_for_prevelgegeis);
								} 
								//=========================STAFF PREVELEGES===================================
								$staff_privilege_id = $_POST['staff_privilege_id'];
								//echo count($privilege_ids);
								for($i=0;$i<count($staff_privilege_id);$i++)
								{
									$select_parent="select privilege_parent_id from previleges where privilege_id='".$staff_privilege_id[$i]."'";
									$ptr_parent=mysql_query($select_parent);
									$data_parent=mysql_fetch_array($ptr_parent);
									$insert_for_prevelgegeis = "insert into staff_previleges (`previlege_parent_id`,`privilege_id`,`admin_id`,`cm_id`) values('".$data_parent['privilege_parent_id']."','".$staff_privilege_id[$i]."','".$admin_id."','".$data_record['cm_id']."')";
									$ptr_insert_preilgef = mysql_query($insert_for_prevelgegeis);
								}   
								//===============================================================================
							     $insert_for_sallary = "insert into sallery (`admin_id`, `basic_sallery`, `traveling_allowance`, `dearness_allowance`, `house_rent_allowance`, `total_sal`, `added_date`) values('".$admin_id."', '".$basic_sallery."', '".$traveling_allowance."', '".$dearness_allowance."', '".$house_rent_allowance."', '".$total_sal."', '".date('Y-m-d H:i:s')."')";

                            	$ptr_insert_sallary = mysql_query($insert_for_sallary);


								//====================FOR Type1 INSERT======================================================
								for($j=1;$j<=$total_floor;$j++)
								{
										if($_POST['from'.$j] !='')
										{
											$data_record_type1['admin_id'] = $admin_id;
											$data_record_type1['from'] =addslashes(trim($_POST['from'.$j]));      
											$data_record_type1['to'] =addslashes(trim($_POST['to'.$j]));
											$data_record_type1['percentage'] =addslashes(trim($_POST['percentage'.$j]));
											$data_record_type1['added_date'] =date("Y-m-d H:i:s");
											$record_comission=$db->query_insert("comission_slab", $data_record_type1);
											$slab_id=mysql_insert_id();  
								         }
								 }
								 
								 "<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_user','Add','".$name."','".$admin_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
								$query=mysql_query($insert);
								
                                echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                            }
                          }
                    }
                    if($success==0)
                    {
                        ?>
            <tr><td>
        <form method="post" name="jqueryForm" id="jqueryForm" enctype="multipart/form-data" >
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
            <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
            <tr>
            	<td>Select User Type <span class="orange_font">*</span></td>
            	 <td>
                    <select name="user_type" class="input_select_login" id="user_type"  style="width: 150px;">
                                <option value="U">-User Type-</option>
                                <?php if($_SESSION['type']=='S')
								{
								?>
                                <option value="A"<? if($_POST['user_type']=='A') echo 'selected'; elseif ('A' == $row_record['type'] )  echo 'selected'; ?>>Center Manager</option>
                                <? } ?>
                                <option value="F" <? if($_POST['user_type']=='F') echo 'selected'; elseif ('F' == $row_record['type'] )  echo 'selected'; ?>>Staff</option>
                                <option value="C" <? if($_POST['user_type']=='C') echo 'selected'; elseif ('C' == $row_record['type'] )  echo 'selected'; ?>>Councellor</option>
                                <option value="B" <? if($_POST['user_type']=='B') echo 'selected'; elseif ('B' == $row_record['type'] )  echo 'selected'; ?>>BOP</option>
                                </select>
                      </td>
                </tr>
                <?php if($_SESSION['type']=='S' )
				{
								?>
                <tr>
                <td>Select branch</td> 
                <td colspan="2" align="left">
                <?php
                $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
				$query_branch = mysql_query($sel_branch);
				$total_Branch = mysql_num_rows($query_branch);
				echo '<select id="branch_name" name="branch_name" onchange="show_bank(this.value)">';
				while($row_branch = mysql_fetch_array($query_branch))
				{
						?>
						<option value="<?php if ($_POST['branch_name']) echo $_POST['branch_name']; else echo $row_branch['branch_name'];  ?>" > <?php echo $row_branch['branch_name']; ?> 
                        </option>
						<?
				}
				echo '</select>';
                ?>
                <!--<div id="branch_name">
                    </div>-->
                    </td>
            	</tr>  
                <?php
				if($record_id || $_POST['branch_name'])
				{
					?>
					<tr>
                		<td colspan="2">
						<?php
						$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
						$query_branch = mysql_query($sel_branch);
						$total_Branch = mysql_num_rows($query_branch);
						echo '<table width="100%"><tr><td width="35%">';
						echo 'Select branch</td><td>';
						echo ' <select id="branch_name" name="branch_name" onchange="show_bank(this.value)">';
						while($row_branch = mysql_fetch_array($query_branch))
						{
								$selected=='';
								if(addslashes($row_record['branch_name']) == addslashes($row_branch['branch_name']) || $_POST['branch_name'] == $row_branch['branch_name'])
								{
									"<br />".$selected='selected="selected"';
								}

								?>
								<option <?php if ($_POST['branch_name'] == $row_branch['branch_name']) echo $selected; elseif($row_record['branch_name'] == $row_branch['branch_name'])  echo $selected; ?> value="<?php echo $row_branch['branch_name'];  ?>" > <?php echo $row_branch['branch_name']; ?>
								<?php
						}
						echo '</select>';
						echo "</td></tr></table>";
						?> 
								</option></td>
            		</tr>  
				<?php }
				?>
                 <? } ?> 
                <tr>
                <td width="20%">Name<span class="orange_font">*</span></td>
                <td width="40%"><input type="text" class="validate[required] input_text" name="name" id="name" value="<?php if($_POST['save_changes']) echo $_POST['name']; else echo $row_record['name'];?>" /></td>
                <td width="40%"></td>
            </tr> 
            <tr>
                <td width="20%">Mobile 1<span class="orange_font">*</span></td>
                <td width="40%">
                    <input type="text" class="validate[required] input_text" name="contact_phone" id="contact_phone" value="<?php if($_POST['save_changes']) echo $_POST['contact_phone']; else echo $row_record['contact_phone'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
            <tr>
                <td width="20%">Mobile 2</td>
                <td width="40%">
                    <input type="text" class="input_text" name="mobile2" id="mobile2" value="<?php if($_POST['save_changes']) echo $_POST['mobile2']; else echo $row_record['mobile2'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Home Phone</td>
                <td width="40%">
                    <input type="text" class="input_text" name="home_phone" id="home_phone" value="<?php if($_POST['save_changes']) echo $_POST['home_phone']; else echo $row_record['home_phone'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Email Id<span class="orange_font">*</span></td>
                <td width="40%">
                    <input type="text" class="input_text" name="email" id="email"  value="<?php if($_POST['save_changes']) echo $_POST['email']; else echo $row_record['email'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>  
             <tr>
                <td width="20%">Date Of Birth<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text datepicker" name="dob" id="dob" 
                    value="<?php if($_POST['dob']) echo $_POST['dob']; else if($row_record['dob'] !='')
					{
				    	if($row_record['dob']!='0000-00-00')
						{
				        	$arrage_date= explode('-',$row_record['dob'],3);     
				        	echo $arrage_date[2].'-'.$arrage_date[1].'-'.$arrage_date[0]; 
						}
					}
					// $row_record['councellor_dob'];
					?>" />
                </td> 
                <td width="40%"></td>
            </tr>  
              <tr>
                <td width="20%">Current Address<span class="orange_font"></span></td>
                <td width="40%">
                    <textarea type="text" style="height:60px" class="input_text" name="current_address" id="current_address" value="" ><?php if($_POST['save_changes']) echo $_POST['current_address']; else echo $row_record['current_address'];?></textarea>
                </td> 
                <td width="40%" ></td>
            </tr>   
             <tr>
                <td width="20%">Permanant Address<span class="orange_font"></span></td>
                <td width="40%">
                    <textarea type="text" style="height:60px" class="input_text" name="contact_address" id="contact_address" ><?php if($_POST['save_changes']) echo $_POST['contact_address']; else echo $row_record['contact_address'];?></textarea>
                </td> 
                <td width="40%" ></td>
            </tr> 
            <div id="panel"> 
             <tr>
                <td width="20%">Specialization<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text" name="staff_specification" id="staff_specification" value="<?php if($_POST['save_changes']) echo $_POST['staff_specification']; else echo $row_record['specilization'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>  
            <tr>
                <td width="20%">Qualification <span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text" name="staff_quilification" id="staff_quilification" value="<?php if($_POST['save_changes']) echo $_POST['staff_quilification']; else echo $row_record['qualification'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>   

            <tr>



                <td width="20%">Experiance <span class="orange_font"></span></td>



                <td width="40%">



                    <input type="text" class="input_text" name="staff_experience" id="staff_experience" value="<?php if($_POST['save_changes']) echo $_POST['staff_experience']; else echo $row_record['experiance'];?>" />



                </td> 



                <td width="40%"></td>



            </tr>  



            



            </div> 



            <tr>



            <td width="20%">Privillages </td>
            <td width="40%" >
                <select  multiple="multiple" name="privilege_id[]" id="user_id" class="input_select" style="width:150px;">
                        <?php 
                            $select_faculty = "select * from previleges where privilege_parent_id=0 order by privilege_id asc";
                            $ptr_faculty = mysql_query($select_faculty);
							$i=0;
                            while($data_faculty = mysql_fetch_array($ptr_faculty))
                            { 
									$class = '';
									if($record_id)
									{
										$sql_sub_cat = "select * from admin_previleges where admin_id='".$row_record['admin_id']."' and privilege_id='".$data_faculty['privilege_id']."' ";
										$ptr_sub_cat = mysql_query($sql_sub_cat);
	
										if(mysql_num_rows($ptr_sub_cat))
										{
												 $class = 'selected="selected"';
										}
									}
								     echo '<optgroup label="'.$data_faculty['previlege_name'].'">  ';
									 $sel_child="select privilege_id, previlege_name, privilege_parent_id from previleges where privilege_parent_id='".$data_faculty['privilege_id']."'";
									 $query_child=mysql_query($sel_child);
									 while($fetch_child=mysql_fetch_array($query_child))
									 {
                                       echo '<option '.$class.' value="'.$fetch_child['privilege_id'].'" >'.$fetch_child['previlege_name'].'</option>';
									 }
									 echo '</optgroup> ';  
                            $i++;
							}
                            ?> 
                    </select>
                    </td> 
                <td width="40%"></td>
            </tr>
            <tr>
            <td width="20%">Staff access Privillages </td>
			<td width="40%" >
                <select  multiple="multiple" name="staff_privilege_id[]" id="staff_pre_id" class="input_select" style="width:150px;">
                        <?php 
                            $select_faculty = "select * from previleges where privilege_parent_id=0 order by privilege_id asc";
                            $ptr_faculty = mysql_query($select_faculty);
							$i=0;
                            while($data_faculty = mysql_fetch_array($ptr_faculty))
                            { 
									$class = '';
									if($record_id)
									{
										$sql_sub_cat = "select * from staff_previleges where admin_id='".$row_record['admin_id']."' and privilege_id='".$data_faculty['privilege_id']."' ";
										$ptr_sub_cat = mysql_query($sql_sub_cat);
	
										if(mysql_num_rows($ptr_sub_cat))
										{
												 $class = 'selected="selected"';
										}
									}
								     echo '<optgroup label="'.$data_faculty['previlege_name'].'">  ';
									 $sel_child="select privilege_id, previlege_name, privilege_parent_id from previleges where privilege_parent_id='".$data_faculty['privilege_id']."'";
									 $query_child=mysql_query($sel_child);
									 while($fetch_child=mysql_fetch_array($query_child))
									 {
                                       echo '<option '.$class.' value="'.$fetch_child['privilege_id'].'" >'.$fetch_child['previlege_name'].'</option>';
									 }
									 echo '</optgroup> ';  
                            $i++;
							}
                            ?> 
                    </select>
                    </td> 
                <td width="40%"></td>
            </tr>

            <!--<tr>
                <td width="20%" valign="top"> Description </td>
                <td colspan="2">
                    -->
                     <!--<script src="ckeditor/ckeditor.js"></script>
                        <textarea name="staff_info" id="detail"><?php //echo stripslashes($row_record['detail']); ?></textarea>
                    <script>
                        CKEDITOR.replace( 'staff_info' );
                    </script>-->
               <!-- </td> 
            </tr>-->
            <tr>
                <td width="20%">Company Name<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text" name="company_name" id="company_name" value="<?php if($_POST['save_changes']) echo $_POST['company_name']; else echo $row_record['company_name'];?>" />
                </td> 
                <td width="40%" ></td>
            </tr>

            <tr>



                <td width="20%">Joining Date<span class="orange_font"></span></td>



                <td width="40%">



                    <input type="text" class=" datepicker input_text" name="joining_date" id="joining_date" value="<?php if($_POST['save_changes']) echo $_POST['joining_date']; else echo $row_record['joining_date'];?>" />



                </td> 



                <td width="40%" ></td>



            </tr>



            



            <tr>



                <td width="20%">Leaving Date<span class="orange_font"></span></td>



                <td width="40%">



                    <input type="text" class="datepicker input_text" name="leaving_date" id="leaving_date" value="<?php if($_POST['save_changes']) echo $_POST['leaving_date']; else echo $row_record['leaving_date'];?>" />



                </td> 



                <td width="40%" ></td>



            </tr>



            



            <tr>



                <td width="20%">Description<span class="orange_font"></span></td>



                <td width="40%">



                <textarea name="description" id="description" style="width:50%"><?php if($_POST['save_changes']) echo $_POST['description']; else echo $row_record['description'];?></textarea>



                    



                </td> 



                <td width="40%" ></td>



            </tr>



            



            <!--<tr>



                <td width="20%"><div id="coursess" class="coursess" >Basic Payment</div></td>



                <td width="40%"><div id="coursess" class="coursess" >



                <input type="text" class="input_text" name="basic_pay" id="basic_pay" value="<?php //if($_POST['save_changes']) echo $_POST['basic_pay']; else echo $row_record['basic_pay'];?>" />



                </div>



                </td>                



                <td width="40%"></td>



            </tr>-->



            



            



            <tr>



             <td colspan="3"><strong>Salary Details:</strong>



             



                 <table border="0" cellspacing="15" cellpadding="0" width="60%">



                   <tr>



                     <td width="20%">Basic Salary</td>



                      <td width="40%">



                        <input type="text" class="input_text" name="basic_sallery" id="basic_sallery" value="<?php if($_POST['save_changes']) echo $_POST['basic_sallery']; else echo $fetch_sallery['basic_sallery'];?>" onKeyUp="calculte_total_sal()"/>



                     </td>



                   </tr> 



                   



                   <tr>



                     <td width="20%">Travelling Allowance <span id="traveling_allowance_per"></span>%</td>



                      <td width="40%">



                        <input type="text" class="input_text" name="traveling_allowance" id="traveling_allowance" value="<?php if($_POST['save_changes']) echo $_POST['traveling_allowance']; else echo $fetch_sallery['traveling_allowance'];?>" onKeyUp="calculte_total_sal()"/>



                        



                        <input type="hidden" id="traveling_allowance_per_hid" value="" name="traveling_allowance_per_hid" />



                     </td>



                   </tr>



                   



                   <tr>



                     <td width="20%">Dearness Allowance <span id="dearness_allowance_per"></span>%</td>



                      <td width="40%">



                        <input type="text" class="input_text" name="dearness_allowance" id="dearness_allowance" value="<?php if($_POST['save_changes']) echo $_POST['dearness_allowance']; else echo $fetch_sallery['dearness_allowance'];?>" onKeyUp="calculte_total_sal()"/>



                        



                        <input type="hidden" id="dearness_allowance_per_hid" value="" name="dearness_allowance_per_hid" />



                     </td>



                   </tr>



                   



                   <tr>



                     <td width="20%">House Rent Allowance <span id="house_rent_allowance_per"></span>%</td>



                      <td width="40%">



                        <input type="text" class="input_text" name="house_rent_allowance" id="house_rent_allowance" value="<?php if($_POST['save_changes']) echo $_POST['house_rent_allowance']; else echo $fetch_sallery['house_rent_allowance'];?>" onKeyUp="calculte_total_sal()" />



                        



                        <input type="hidden" id="house_rent_allowance_per_hid" value="" name="house_rent_allowance_per_hid" />



                     </td>



                  </tr>



                  



                  <tr>



                     <td width="20%">Total Salary</td>



                      <td width="40%">



                        <input type="text" class="input_text" name="total_sal" id="total_sal" readonly="readonly" value="<?php if($_POST['save_changes']) echo $_POST['total_sal']; else echo $fetch_sallery['total_sal'];?>" />



                     </td>



                  </tr>



                    



                



                </table>



                </td>



            </tr>



            



            <tr>



                <td width="20%"> User Name<span class="orange_font"></span> </td>



                <td width="40%">



                <input type="text" class=" input_text" name="username" id="username" value="<?php if($_POST['save_changes']) echo $_POST['username']; else echo $row_record['username'];?>" />



                </td> 



                <td width="40%"></td>



            </tr>



            <tr>



                <td width="20%">Password<span class="orange_font"></span></td>



                <td width="40%"><input type="password" class=" input_text" name="pass" id="pass" value="<?php if($_POST['save_changes']) echo $_POST['pass']; else echo $row_record['pass'];?>" />



            </td> 



            <td width="40%"></td>



            </tr>



            



            <tr>



            <td width="20%">Photo</td>



            <td width="40%"><?php



                    if($record_id && $row_record['photo'] && file_exists("../teacher_photo/".$row_record['photo']))



                        echo '<img height="77px" width="77px" src="../teacher_photo/'.$row_record['photo'].'"><br><a href="'.$_SERVER['PHP_SELF'].'?deleteThumbnail=1&record_id='.$record_id.'">Delete / Upload new</a></td><td width="40%"></td>';



                    else



                        echo '<input type="file" name="photo" id="photo" class="input_text"></td>';?></td> 



            <td width="40%"></td>



            </tr>



            



            <tr>



             	<td colspan="3">



                  <table  width="90%" style="border:0px solid gray; ">



                    <tr>



                        <td colspan="2">



                        <!--===========================================================NEW TABLE START===================================-->



                        <table cellpadding="5" width="100%" >



                         <tr>



                         <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1" onKeyUp="create_floor();" value="0" />



                         



                         <script language="javascript">



									



									function floors(idss)



									{



										var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="90%"><tr><td style="width:10%;">From</td><td valign="top" width="10%" ><input type="text" name="from'+idss+'" id="from'+idss+'" /></td><td style="width:10%;">To</td><td valign="top" width="10%" ><input type="text" name="to'+idss+'" id="to'+idss+'" /></td><td style="width:10%;">Percentage</td><td valign="top" width="10%" ><input type="text" name="percentage'+idss+'" id="percentage'+idss+'" /></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';



										document.getElementById('floor').value=idss;



										return shows_data;



									}



									



							</script>



                         



                         



                           <td align="right"><input type="button" name="Add"  class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" > 



<input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >



  </td></tr>



                                <tr><td> <strong>Incentive Product</strong> </td><td align="left"></td></tr>



                        </table> 



                        <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>



  <tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>



  <tr>



                            <td colspan="6">



                           <!-- <table cellspacing="3" id="tbl" width="100%">



                            <tr>



                            <td valign="top" width="1%" align="center">Position</td>



                            <td valign="top" width="10%" align="center">Tag</td>



                            <td valign="top" width="10%" align="center" >Comment</td>



                            <td valign="top" width="10%"  align="center">Upload Image <font color="#CC66FF" size="-2">[jpg or gif only]</font></td>



                             </tr></table>-->



                             <input type="hidden" name="floor" id="floor"  value="0" />



                            <div id="create_floor"></div>



                        </td></tr></table>



                        <!--============================================================END TABLE=========================================-->



                        </td>



                        </tr>



                                        



                                    </table>



                               



                 </td>



              </tr>  







            



            



            <tr>



            <td>&nbsp;</td>



            <td><input type="submit" class="input_btn" onClick="return validme()" value="<?php if($record_id) echo "Update"; else echo "Add";?> Staff" name="save_changes"  /></td>



            <td></td>



            </tr>



        </table>



        </form>



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



if($_SESSION['type']=="S" && $record_id=='')



{



	?>



    <script>



	branch_name =document.getElementById("branch_name").value;



	//alert(branch_name);



	show_bank(branch_name);



	</script>



    <?php



	//exit();



}



?>







<script language="javascript">



create_floor('add');



//create_floor_dependent();



</script>



</body>



</html>



<?php $db->close();?>