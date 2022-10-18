<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT id,name,email_id,mobile,address,cm_id FROM  sms_mail_configuration where id ='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
	
	$select_previlege= "select * from sms_mail_configuration_map where id='".$record_id."'";
	$previlege_details=mysql_query($select_previlege);
	$row_record_previlages=mysql_fetch_array($previlege_details);
	
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
	 <!-- Multiselect -->
     <link rel="stylesheet" href="js/chosen.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>
     <script src="js/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
	
        jQuery(document).ready( function() 
        {
			$("#staff_id").chosen({allow_single_deselect:true});
			$("#user_id").multiselect().multiselectfilter();
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

function select_details(values)
{
	//alert(values);
	var data1="id="+values;
	
	$.ajax({
		url:"select_staff_deatils.php",type: "post", data:data1, cache:false,
		success: function(html)
		{
			//alert(html);
			sep=html.split("-");
			
			document.getElementById("mobile").value=sep[0];
			document.getElementById("email_id").value=sep[1];
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
                            $name=$_POST['staff_id'];
							$mobile=$_POST['mobile'];
							$email_id=$_POST['email_id'];
						  
						   
						   /* if(isset($_POST['privilege_id']))
							{
								$name=implode(',',$_POST['privilege_id']);
							}
								  $data = $_POST['privilege_id'];
	                    $len = count($data);
	                        for($x=0 ; $x < $len ; $x++){
	                       	     "$data[$x]"."<br />";
	                     }*/
						
							
							$address=$_POST['address'];
							$status =$_POST['status'];
							//$previlege_name=$_POST['previlege_name'];
							$branch_name=$_POST['branch_name'];
							
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
								
								if($_SESSION['type']=='S')
								{
									$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
									$ptr_branch=mysql_query($sel_branch);
									$data_branch=mysql_fetch_array($ptr_branch);
									$cm_id=$data_branch['cm_id'];
									$data_record['cm_id'] =$cm_id;
								}	
								else
								{
									$branch_name1=$_SESSION['branch_name'];
									$cm_id=$_SESSION['cm_id'];
									$data_record['cm_id'] =$cm_id;
								}
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
									$delete="delete from sms_mail_configuration_map where id ='".$record_id."' ";
									$ptr_qry=mysql_query($delete);
									foreach($_POST['privilege_id'] as $name)
						          	{
										/*$delete_map="delete from sms_mail_configuration_map where id='".$record_id."'";
										$ptr_delete=mysql_query($delete_map);*/
										
							        	$sel="INSERT INTO `sms_mail_configuration_map`(`id`,`module_type_id`) VALUES ('".$record_id."','".$name."')";
							        	$select=mysql_query($sel);
						          	}
                                    $db->query_update("sms_mail_configuration", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $record_id=$db->query_insert("sms_mail_configuration", $data_record);
									foreach($_POST['privilege_id'] as $name)
						          	{
							        	$sel="INSERT INTO `sms_mail_configuration_map`(`id`,`module_type_id`) VALUES ('".$record_id."','".$name."')";
							        	$select=mysql_query($sel);
						          	}
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
              <?php
            	if($_SESSION['type']=='S')
                {
                ?>
                      <tr>
                      	<td>Select Branch</td>
                        <td>
                        <?php
						$sel_cm_id="select branch_name from site_setting where cm_id=".$row_record['cm_id']." and type='A' ";
						$ptr_query=mysql_query($sel_cm_id);
						$data_branch_nmae=mysql_fetch_array($ptr_query);
						
                        $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
						$query_branch = mysql_query($sel_branch);
						$total_Branch = mysql_num_rows($query_branch);
						echo '<table width="100%"><tr><td>';
						echo ' <select id="branch_name" name="branch_name" >';
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
      			<?php }?>
              <tr>
                <td width="20%">Name <span class="orange_font">*</span></td>
                <td width="40%">
               <select name="staff_id" id="staff_id" style="width:90%" onchange="select_details(this.value)">
               <option value="">Select Staff</option>
			   <?php
				$sel_staff = "select admin_id,name from site_setting order by admin_id asc";	 
				$query_staff = mysql_query($sel_staff);
				if($total_staff=mysql_num_rows($query_staff))
				{
					while($data=mysql_fetch_array($query_staff))
					{
						$selected='';
						if($row_record['name'] ==$data['admin_id'] )
						{
							$selected='selected="selected"';
						}
						echo '<option value="'.$data['admin_id'].'" '.$selected.'>'.$data['name'].'</option>';
					}
				}
				?>
				</select>
                
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
			  <td width="20%">Privillages<span class="orange_font"></span></td>
			  <td width="40%">
            <?php
			
			?>
			  <select  multiple="multiple" name="privilege_id[]" id="user_id" class="input_select" style="width:150px;">
                
              <?php 
                            $select_faculty = "select * from previleges where privilege_parent_id=0 order by privilege_id asc";
                            $ptr_faculty = mysql_query($select_faculty);
							$i=0;
                            while($data_faculty = mysql_fetch_array($ptr_faculty))
                            { 
								
								echo '<optgroup label="'.$data_faculty['previlege_name'].'">  ';
								$sel_child="select privilege_id, previlege_name, privilege_parent_id from previleges where privilege_parent_id='".$data_faculty['privilege_id']."'";
								$query_child=mysql_query($sel_child);
								while($fetch_child=mysql_fetch_array($query_child))
								{
									
									$class = '';
									if($record_id)
									{
										$sql_sub_cat = "select * from sms_mail_configuration_map where id='".$record_id."' and module_type_id='".$fetch_child['privilege_id']."' ";
										$ptr_sub_cat = mysql_query($sql_sub_cat);
										if(mysql_num_rows($ptr_sub_cat))
										{
											$class = 'selected="selected"';
										}
									}
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