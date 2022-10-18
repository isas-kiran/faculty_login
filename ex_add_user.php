<?php include 'ex_inc_classes.php';?>
<?php include "ex_admin_authentication.php";?>
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
}
if($record_id && $_REQUEST['deleteThumbnail'])
{
    $update_news="update site_setting set photo='' where admin_id='".$record_id."'";
    //echo $update_events;
    $db->query($update_news);
    if($row_record['photo'] && file_exists("../faculty_photo/".$row_record['photo']))
        unlink("../faculty_photo/".$row_record['photo']);
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
<?php if($record_id) echo "Edit"; else echo "Add";?>
User</title>
<?php include "ex_include/headHeader.php";?>
<?php include "ex_include/functions.php"; ?>
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
            $('.datepicker').datepicker({dateFormat: 'dd/mm/yy', changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear',yearRange: '1900:' + new Date().getFullYear()});
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

 
	 function validme()
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
	 /*if(frm.user_type.value=='U')
		 {
			 disp_error +='Select User Type\n';
			 document.getElementById('user_type').style.border = '1px solid #f00';
			 frm.user_type.focus();
			 error='yes';
		 }*/
	   if(frm.contact_phone.value=='')
		 {
			 disp_error +='Enter Mobile Number \n';
			 document.getElementById('contact_phone').style.border = '1px solid #f00';
			 frm.contact_phone.focus();
			 error='yes';
	     }
		 else
		 {	 var text = frm.contact_phone.value;
			 if(text.length <10 || text.length >15 )
				{
					 disp_error +='Enter Valid Mobile Number \n';
					 document.getElementById('contact_phone').style.border = '1px solid #f00';
					 error='yes';
				}
		 }
		 if(frm.dob.value!='')
		  {
		  
					var date1 = new Date(frm.dob.value);
					var date2 = new Date();
					var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24)); 
					
					if(diffDays<6570)
					{
						 disp_error +='Your Age is not valid for Registration. need more than 18 year age\n';
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
			if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(frm.email.value))  
			{  
				
			}
			else
			{
				disp_error +="Enter Valid Email ID\n";
				document.getElementById('email').style.border = '1px solid #f00';
				frm.email.focus();
				error="yes";
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
		 if(frm.dob.value=='')
		 {
			 disp_error +='Enter Date of Birth \n';
			 document.getElementById('dob').style.border = '1px solid #f00';
			 frm.dob.focus();
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
	function isSpclChar(id){
var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>? ";

 vals = document.getElementById(id).value;
for (var i = 0; i < vals.length; i++) {
    if (iChars.indexOf(vals.charAt(i)) != -1) {
          return 'yes';
        }
    }
	
}  

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
	//alert(charCode);
	if(charCode ==43 || charCode ==32 || charCode ==45 || charCode ==40 || charCode ==41  )
	return true;
	else
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
} 
	
</script>
<style> 
#panel, #flip{
	}
#panel {
	display:none;
}
</style>
</head>
<body>
<?php include "ex_include/header.php";?>
<!--info start-->
<div id="info">
<!--left start-->
<?php include "ex_include/menuLeft.php"; ?>
<!--left end-->
<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "ex_include/user_menu.php"; ?></td>
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
                        $name = $_POST['name'];
						$username=$_POST['username'];
						$email=$_POST['email'];
						$pass=$_POST['pass'];
						$dob = $_POST['dob'];
                        $contact_phone=$_POST['contact_phone']; 
					    $email=$_POST['email'];
					    $staff_quilification=$_POST['staff_quilification'];
						$designation=$_POST['designation'];
					    $contact_address=$_POST['contact_address'];
			            $detail=$_POST['detail'];
						$photo=$_POST['photo'];
						$added_date=date('Y-m-d H:i:s');    
 						
						$where_id='';
						if($_REQUEST['record_id'])
						{
							$where_id="and admin_id !='".$record_id."'";
						}
							
						$chk_exist = " select username from site_setting where username='".$username."' ".$where_id."";
						$ptr_chk_exit = mysql_query($chk_exist);
						if(mysql_num_rows($ptr_chk_exit))
						
						{
							 $success=0;
                             $errors[$i++]="Username Already Exist. Choose Other username ";
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
						
						if($username =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter User Name";
                        }
						if($pass =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter PassWord";
                        }
                       
                       $uploaded_url="";
                            if(count($errors)==0 && $_FILES['photo']["name"])
                            {
                                if($record_id)
                                {
                                    $update_news="update site_setting set photo='' where admin_id='".$record_id."'";
                                    $db->query($update_news);

                                    if($row_record['photo'] && file_exists("../faculty_photo/".$row_record['photo']))
                                        unlink("../faculty_photo/".$row_record['photo']);
                                    if($row_record['photo'] && file_exists("../faculty_photo/".$row_record['photo']))
                                        unlink("../faculty_photo/".$row_record['photo']);
                                }
                                $uploaded_url=time().basename($_FILES['photo']["name"]);
                                $newfile = "../faculty_photo/";

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
                                     	$thump_target_path="../faculty_photo/".$uploaded_url;
                                        copy($target_path1,$thump_target_path);
                                        $file_uploaded=1;
                                        
                                       /* else
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
                                               
                                            }
                                        }*/
                                    }
                                    else
                                    {
                                        $file_uploaded=0;
                                        $success=0;
                                        $errors[$i++]="There are some Problem while uploading image, please try again";
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
							
							$data_record['designation']=$designation;
							$data_record['cm_id']=$_SESSION['admin_id'];
                            $data_record['name']=$name;
							$data_record['dob']=$dob;
                            $data_record['username'] =$username;
                            $data_record['pass'] =$pass;
                            $data_record['email'] =$email;
                            $data_record['contact_phone'] =$contact_phone;
                            $data_record['contact_address'] = $contact_address;
					    	$data_record['qualification']=$staff_quilification;
						    $data_record['detail'] =$detail;
                            $data_record['added_date'] = $added_date;
 							
						 	if($file_uploaded)
							$data_record['photo'] = $uploaded_url;
                            if($record_id)
                            {
								$data_record['user_pass'] =md5($pass);
								/*$del="delete from admin_previleges where admin_id='".$record_id."'";
								$del_ptr=mysql_query($del);
								
								$del="delete from site_setting where admin_id='".$record_id."'";
								$del_site=mysql_query($del);*/
								
                                //$data_record['added_date'] = date('Y-m-d H:i:s');
								$where_record=" admin_id='".$record_id."'";
                                $courses_id=$db->query_update("site_setting", $data_record,$where_record);  
							   // $admin_id= mysql_insert_id();
/*								if($_POST['user_type']=='A')
								{  
									$update_cm_id = " update site_setting  set cm_id = admin_id where admin_id='".$record_id."'";
									mysql_query($update_cm_id);
								}
*/								
								/*$privilege_ids = $_POST['privilege_id'];
								for($i=0;$i<count($privilege_ids);$i++)
								{
									$insert_for_prevelgegeis = "insert into admin_previleges values(0,'".$privilege_ids[$i]."','".$record_id."')";
									$ptr_insert_preilgef = mysql_query($insert_for_prevelgegeis);
								} */
									 
									
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                            else
                            {
							    $data_record['added_date'] = date('Y-m-d H:i:s');
                                $courses_id=$db->query_insert("site_setting", $data_record);  
							    $admin_id= mysql_insert_id();
/*								if($_POST['user_type']=='A')
								{  
									$update_cm_id = " update site_setting  set cm_id = admin_id where admin_id='".$admin_id."'";
									mysql_query($update_cm_id);
                                }
                                

                                
*/								
								// $privilege_ids = $_POST['privilege_id'];
								// for($i=0;$i<count($privilege_ids);$i++)
								// {
								// 	$insert_for_prevelgegeis = "insert into admin_previleges values(0,'".$privilege_ids[$i]."','".$admin_id."')";
								// 	$ptr_insert_preilgef = mysql_query($insert_for_prevelgegeis);
                                // }   
                                
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
									echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
							}
                        }
                    }
                    if($success==0)
                    {
                        ?>
            <tr><td>
        <form method="post" name="jqueryForm" id="jqueryForm" enctype="multipart/form-data">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
            <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
           
            <?php
                $sql_sub_cat = "select * from site_setting where admin_id='".$row_record['admin_id']."' ";
                $data_sub_cat = $db->fetch_array($db->query($sql_sub_cat));
                //$implode_data = explode(",",$data_sub_cat['course_author']);            
             ?>
           
                
                <tr>
                <td width="20%">Name<span class="orange_font">*</span></td>
                <td width="40%" style="">
                    <input type="text" class="validate[required] input_text" name="name" id="name" value="<?php if($_POST['save_changes']) echo $_POST['name']; else echo $row_record['name'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
             
            <tr>
                <td width="20%">Contact No<span class="orange_font">*</span><br />
                <font size="-1" color="#FF33FF">Hint : (+country code)number</font></td>
                <td width="40%" style="">
                    <input type="text" class="validate[required] input_text" onKeyPress="return isNumber(event)" name="contact_phone" id="contact_phone" value="<?php if($_POST['save_changes']) echo $_POST['contact_phone']; else echo $row_record['contact_phone'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>   
            <tr>
                <td width="20%">Email Id<span class="orange_font">*</span></td>
                <td width="40%" style="">
                    <input type="text" class="input_text" name="email" id="email" value="<?php if($_POST['save_changes']) echo $_POST['email']; else echo $row_record['email'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
           
             <tr>
                <td width="20%">Date Of Birth<span class="orange_font">*</span><br /><font size="-1" color="#FF33FF">Hint : mm/dd/yyyy</font></td>
                <td width="40%" style="">
                    <input type="text" class="input_text datepicker" name="dob" id="dob" 
                    value="<?php if($_POST['dob']) echo $_POST['dob']; else if($row_record['dob'] !='')
					{
				/*$arrage_date= explode('/',$row_record['dob']);     
				echo $arrage_date[1].'/'.$arrage_date[0].'/'.$arrage_date[2]; */
				
				echo $row_record['dob'];
					}
					
					?>" />
                </td> 
                <td width="40%"></td>
            </tr>      
             <tr>
                <td width="20%">Address<span class="orange_font"></span></td>
                <td width="40%" style="">
                    <input type="text" class="input_text" name="contact_address" id="contact_address" value="<?php if($_POST['save_changes']) echo $_POST['contact_address']; else echo $row_record['contact_address'];?>" />
                </td> 
                <td width="40%" ></td>
            </tr> 
          <!--  <div id="flip"><tr><td>Staff</td></tr></div>-->
            <div id="panel"> 
            
            <tr>
                <td width="20%">Qualification <span class="orange_font"></span></td>
                <td width="40%" style="">
                    <input type="text" class="input_text" name="staff_quilification" id="staff_quilification" value="<?php if($_POST['save_changes']) echo $_POST['staff_quilification']; else echo $row_record['qualification'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>   
           <tr>
                <td width="20%">Role <span class="orange_font"></span></td>
                <td width="40%" style="">
                    <input type="text" class="input_text" name="designation" id="designation" value="<?php if($_POST['save_changes']) echo $_POST['designation']; else echo $row_record['designation'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>   
            
            </div> 
            <!-- <tr>
            <td width="20%">Privileges</td>
            <td width="40%" >
                      
                    <select  multiple="multiple" id="user_id" name="privilege_id[]"  style=" width:250px;">                        
                        <?php 
							
                            $select_faculty = "select * from previleges order by privilege_id asc";
                            $ptr_faculty = mysql_query($select_faculty);
							$i=0;
                            while($data_faculty = mysql_fetch_array($ptr_faculty))
                            { 
                                $selecteds = '';
                               
							   if($record_id !='' || $record_id)
							   {
							   		$selc = " select privilege_id FROM `admin_previleges` where admin_id =$record_id and privilege_id= '".$data_faculty['privilege_id']."'";
							   		$ptr_sle = mysql_query($selc);
								 	$selecteds='';
								 	if(mysql_num_rows($ptr_sle))
								 	echo "<br/>".	$selecteds = 'selected="selected"';
							   }
									
                                    echo '<option value="'.$data_faculty['privilege_id'].'" '.$selecteds.' >'.$data_faculty['previlege_name'].' </option>';  
									
                                 
                            $i++;
							}
                            ?>        
                    </select>
                    </td> 
                <td width="40%"></td>
            </tr> --> 

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
										$sql_sub_cat = "select * from admin_previleges where admin_id='".$record_id."' and privilege_id='".$data_faculty['privilege_id']."' ";
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
                <td width="20%" valign="top"> Description <!--span class="orange_font">*</span --></td>
                <td colspan="2">
                   
                     <script src="ckeditor/ckeditor.js"></script>
                <textarea name="detail" id="detail"><?php if ($_POST['detail']) echo stripslashes($_POST['detail']); else echo $row_record['detail']; ?></textarea>
            <script>
                CKEDITOR.replace( 'detail' );
            </script>
                </td> 
            </tr>
            <!--tr>
                <td width="20%"><div id="coursess" class="coursess" >Basic Payment</div></td>
                <td width="40%" style="box-shadow: 3px 3px 3px #888888;"><div id="coursess" class="coursess" >
                <input type="text" class="input_text" name="basic_pay" id="basic_pay" value="<--?php if($_POST['save_changes']) echo $_POST['basic_pay']; else echo $row_record['basic_pay'];?>" />
                </div>
                </td>                
                <td width="40%"></td>
            </tr-->
            <tr>
                <td width="20%"> User Name<span class="orange_font">*</span> </td>
                <td width="40%" style="">
                <input type="text" class="validate[required] input_text" name="username" id="username" value="<?php if($_POST['save_changes']) echo $_POST['username']; else echo $row_record['username'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Password<span class="orange_font">*</span></td>
                <td width="40%" style=""><input type="password" class="validate[required] input_text" name="pass" id="pass" value="<?php if($_POST['save_changes']) echo $_POST['pass']; else echo $row_record['pass'];?>" />
            </td> 
            <td width="40%"></td>
            </tr>
            <tr>
            <td width="20%">Photo</td>
            <td width="40%" style=""><?php
                    if($record_id && $row_record['photo'] && file_exists("../faculty_photo/".$row_record['photo']))
                        echo '<img height="77px" width="77px" src="../faculty_photo/'.$row_record['photo'].'"><br><a href="'.$_SERVER['PHP_SELF'].'?deleteThumbnail=1&record_id='.$record_id.'">Delete / Upload new</a></td><td width="40%"></td>';
                    else
                        echo '<input type="file" name="photo" id="photo" class="input_text"></td>';?></td> 
                    <input type="hidden" name="photo" id="photo" value="<?php echo $row_record['photo']; ?>"  />
            <td width="40%"></td>
            </tr>
            <tr>
            <td>&nbsp;</td>
            <td><input type="submit" onClick="return validme()" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Staff" name="save_changes"  /></td>
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
<div id="footer"><? require("ex_include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>