<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT id,name,email_id,mobile,address FROM  sms_mail_configuration where id ='".$record_id."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> SMS & Email</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
    </script>
   <script>
   
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
		 
		  if(frm.mobile.value=='')
		 {
			 disp_error +='Enter Mobile Number \n';
			 document.getElementById('mobile').style.border = '1px solid #f00';
			 frm.mobile.focus();
			 error='yes';
	     }
		 else
		 {	 var text = frm.mobile.value;
			 if(text.length <10)
				{
					 disp_error +='Enter Valid Mobile Number \n';
					 document.getElementById('mobile').style.border = '1px solid #f00';
					 error='yes';
				}
		 }
		 
		 if(frm.email_id.value=='')
		 {
			 disp_error +='Enter Email ID \n';
			 document.getElementById('email_id').style.border = '1px solid #f00';
			 frm.email_id.focus();
			 error='yes';
	     }
		 else
		 {
			var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			if(document.getElementById("email_id").value !='')
			{
			if (reg.test(document.getElementById("email_id").value) == false) 
			{
				disp_error +='Enter Valid Email Address';
				document.getElementById('email_id').style.border = '1px solid #f00';
				frm.email_id.focus();
			 	error='yes';
			}
			}

		 }
		 
		 if(error=='yes')
		 {
			 alert(disp_error);
			 return false;
		 }
		 else
		 return true;
	 }
   /* function validateEmail(emailField)
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
	function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
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
    <td class="top_mid" valign="bottom"><?php include "include/general_setting_menu.php"; ?></td>
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
                            $name=$_POST['name'];
							$mobile=$_POST['mobile'];
							$email_id=$_POST['email_id'];
							$address=$_POST['address'];
							$status =$_POST['status'];
                            if($name =="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter Name ";
                            }
							 if($mobile =="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter Mobile No ";
                            }
							 if($email_id =="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter Email ID ";
                            }  
							$id="";
                            if($record_id !='')  
							{
								$id="and id !='".$record_id."'";
							}
                               $select_exist_userTable = "SELECT id FROM sms_mail_configuration where  (mobile ='".$mobile."' or email_id ='".$email_id."') ".$id."";
                                if(mysql_num_rows($db->query($select_exist_userTable)))	
                                {
                                        $success=0;
                                        $errors[$i++]="This Mobile No. or Email ID is already exists";
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
								
                                $data_record['name'] =$name;
								$data_record['mobile'] =$mobile;
								$data_record['email_id'] =$email_id;
								$data_record['address'] =$address;
								$data_record['added_date'] = date('Y-m-d');
								$data_record['status']=$status;
//                              $data_record['country_id'] = $country_code;
								//===============================CM ID for Super Admin===============
									/*if($_SESSION['type']=='S')
									{
									 "<br />".$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
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
									}*/
								//========================================================================
								/*$data_record['cm_id'] =$cm_id;
								$data_record['branch_name'] =$branch_name1;*/
                               if($record_id)
                                {
                                    $where_record=" id ='".$record_id."'";
                                    $db->query_update("sms_mail_configuration", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $record_id=$db->query_insert("sms_mail_configuration", $data_record);
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                                }
                            }
                        }
                        if($success==0)
                        {
                        //United States USA
                          //  Canada CAN
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
              </tr>
              <? if($_SESSION['type']=='S')
						{
							?>
                     <!-- <tr>
                      	<td>Select Branch</td>
                        <td>
                        <? 
                       /* $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
						$query_branch = mysql_query($sel_branch);
						$total_Branch = mysql_num_rows($query_branch);
						echo '<table width="100%"><tr><td>';
						echo ' <select id="branch_name" name="branch_name">';
						
						while($row_branch = mysql_fetch_array($query_branch))
						{
							?>
							<option value="<?php echo $row_branch['branch_name'];?>"><? echo $row_branch['branch_name']; ?> 
							</option>
							<?
						
						}
							echo '</select>';
							echo "</td></tr></table>";*/
							?>
					</td>
                </tr>-->
                <? } ?>
              <tr>
                <td width="20%">Name <span class="orange_font">*</span></td>
                <td width="40%"><input type="text"  class="validate[required] input_text" name="name" id="name" value="<?php if($_POST['save_changes']) echo $_POST['name']; else echo $row_record['name'];?>" /></td> 
                <td width="40%"></td>
              </tr>  
              <tr>
                <td width="20%">Mobile 1<span class="orange_font">*</span></td>
                <td width="40%"><input type="text" class="validate[required] inputText" name="mobile" id="mobile" value="<?php if($_POST['mobile']) echo $_POST['mobile']; else echo $row_record['mobile'];?>" onKeyPress="return isNumber(event)" maxlength="12"/></td>
                <td width="40%"></td>
              </tr>     
              <tr>
                <td width="20%">E-Mail<span class="orange_font"></span></td>
                <td width="40%"><input type="text" class="validate[required] inputText" name="email_id" id="email_id" value="<?php if($_POST['email_id']) echo $_POST['email_id']; else echo $row_record['email_id'];?>" onBlur="validateEmail('mail');"/></td>
                <td width="40%"></td>
              </tr>
               <tr>
                <td width="20%">Status<span class="orange_font"></span></td>
                <td width="40%"><input type="radio" name="status" id="status" value="active" <?php if($_POST['status'] == "active") echo 'checked="checked"'; else if($row_record['status'] =="active") echo 'checked="checked"'; else echo 'checked="checked"';  ?> /> Active  
                <input type="radio" name="status" id="status" value="inactive" <?php if($_POST['status'] == "inactive") echo 'checked="checked"'; else if($row_record['status'] =="inactive") echo 'checked="checked"'; ?> /> Inactive</td>
                <td width="40%"></td>
              </tr>
               <tr>
                <td width="20%">Address<span class="orange_font"></span></td>
                <td width="40%"><textarea name="address" id="address" class=" textarea"><?php if($_POST['address']) echo $_POST['address']; else echo $row_record['address'];?></textarea></td>
                <td width="40%"></td>
              </tr>
                     
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="Save" onclick="return validme()" name="save_changes"  /></td>
                  <td></td>
              </tr>
        </table>
        </form>
        </td></tr>
<?php
                        }?>
	 
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