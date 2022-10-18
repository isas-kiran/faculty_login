<?php include 'ex_inc_classes.php';?>
<?php include "ex_admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM  previleges where privilege_id 	='".$record_id."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Privelage</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="t	ext/css"/>
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
           // $("#user_id").multiselect().multiselectfilter();
			$("#staff_privilege_id").multiselect().multiselectfilter();
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
    <td class="top_mid" valign="bottom"><?php include "ex_include/privilages_menu.php"; ?></td>
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
                            $previlege_name=$_POST['previlege_name'];
							$privilege_parent_id=$_POST['privilege_parent_id'];
							$sms_text=$_POST['sms_text'];
							$email_text=$_POST['email_text'];
							
                            if($previlege_name =="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter Privilages name ";
                            }  
                            if($record_id =='' && $privilege_parent_id==0)  
							{
                                $select_exist_userTable = "SELECT * FROM previleges where previlege_name='".$previlege_name."'";
                                if(mysql_num_rows($db->query($select_exist_userTable)))	
                                {
                                        $success=0;
                                        $errors[$i++]="This previlege name is already exists, please choose another one";
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
								$data_record['privilege_parent_id'] = $privilege_parent_id;
                                $data_record['previlege_name'] =$previlege_name;
								
								$data_record['sms_text'] =$sms_text;
								$data_record['email_text'] =$email_text;
                                $data_record['added_date'] = date('Y-m-d');
                               if($record_id)
                               {
                                    $where_record=" privilege_id ='".$record_id."'";
                                    $db->query_update("previleges", $data_record,$where_record);
									
									$del="delete from sms_mail_configuration_map where previlege_id='".$record_id."'";
									$ptr_del=mysql_query($del);
									//=========================STAFF PREVELEGES===================================
									$staff_privilege_id = $_POST['staff_privilege_id'];
									//echo count($privilege_ids);
									for($i=0;$i<count($staff_privilege_id);$i++)
									{
										$select_parent="select privilege_parent_id from previleges where privilege_id='".$staff_privilege_id[$i]."'";
										$ptr_parent=mysql_query($select_parent);
										$data_parent=mysql_fetch_array($ptr_parent);
										
										$sel_cm_id="select cm_id from site_setting where admin_id='".$staff_privilege_id[$i]."'";
										$ptr_cm_id=mysql_query($sel_cm_id);
										$data_cm=mysql_fetch_array($ptr_cm_id);
										
										$insert_for_prevelgegeis = "insert into sms_mail_configuration_map (`previlege_id`,`staff_id`,`cm_id`,`added_date`) values('".$record_id."','".$staff_privilege_id[$i]."','".$data_cm['cm_id']."','".date('Y-m-d')."')";
										$ptr_insert_preilgef = mysql_query($insert_for_prevelgegeis);
									}   
									//===============================================================================
									
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_preveleges','Edit','".$previlege_name."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $record_id=$db->query_insert("previleges", $data_record);
									
									//=========================STAFF PREVELEGES===================================
									$staff_privilege_id = $_POST['staff_privilege_id'];
									//echo count($privilege_ids);
									for($i=0;$i<count($staff_privilege_id);$i++)
									{
										$select_parent="select privilege_parent_id from previleges where privilege_id='".$staff_privilege_id[$i]."'";
										$ptr_parent=mysql_query($select_parent);
										$data_parent=mysql_fetch_array($ptr_parent);
										
										 $sel_cm_id="select cm_id from site_setting where admin_id='".$staff_privilege_id[$i]."'";
										$ptr_cm_id=mysql_query($sel_cm_id);
										$data_cm=mysql_fetch_array($ptr_cm_id);
										
										 $insert_for_prevelgegeis = "insert into sms_mail_configuration_map (`previlege_id`,`staff_id`,`cm_id`, `added_date`) values('".$record_id."','".$staff_privilege_id[$i]."','".$data_cm['cm_id']."','".date('Y-m-d')."')";
										$ptr_insert_preilgef = mysql_query($insert_for_prevelgegeis);
									}   
									//===============================================================================
									
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_preveleges','Add','".$previlege_name."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);
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
        <form method="post" id="jqueryForm" enctype="multipart/form-data">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
              </tr>
              
              <tr>
                <td width="20%">Select Privilage</td>
                <td width="40%">
                 <select name="privilege_parent_id">
                 <option value="0">Select Privilage</option>
                 <?php
				   $sel_priviles="select privilege_id, previlege_name from previleges where privilege_parent_id=0 order by privilege_id asc";
				   $quer_priviles=mysql_query($sel_priviles);
				   while($fetch_privies=mysql_fetch_array($quer_priviles))
				   {
					   $selected='';
					   if($fetch_privies['privilege_id']==$row_record['privilege_parent_id'])
					   $selected='selected="selected"';
					   
					   echo '<option value="'.$fetch_privies['privilege_id'].'" '.$selected.'>'.$fetch_privies['previlege_name'].'</option>';
				   }
				 ?>
                 
                 </select>
                </td> 
              </tr>
              <tr>
                <td width="20%">Privilage Name <span class="orange_font">*</span></td>
                <td width="40%"><input type="text"  class="validate[required] input_text" name="previlege_name" id="previlege_name" value="<?php if($_POST['save_changes']) echo $_POST['previlege_name']; else echo $row_record['previlege_name'];?>" /></td> 
                <td width="40%"></td>
              </tr>  
              <tr>
              	<td width="20%">SMS Text Template<span class="orange_font">*</span></td>
              	<td width="40%"><textarea class="input_textarea" name="sms_text" id="sms_text"/><?php if($_POST['sms_text']) echo $_POST['sms_text']; else echo $row_record['sms_text'];?></textarea></td> 
                <td width="40%"></td>
              </tr>
              <tr>
            	<td width="12%" valign="top">Email Text Template</td>
            	<td colspan="2">
				<script src="ckeditor/ckeditor.js"></script>
                <textarea name="email_text" id="email_text"><?php if ($_POST['email_text']) echo stripslashes($_POST['email_text']); else echo $row_record['email_text']; ?></textarea>
				<script>
                    CKEDITOR.replace('email_text');
            	</script>
                </td> 
            </tr> 
            <tr>
            <td width="20%">Staff Acesss Privileges for sms & mail</td>
            <td width="40%" >
                <select  multiple="multiple" name="staff_privilege_id[]" id="staff_privilege_id" class="input_select" style="width:150px;">
                        <?php 
                            //$select_faculty = "select admin_id,name from site_setting where 1 and  ".$_SESSION['where']." order by admin_id asc";
                            $select_faculty = "select admin_id,name from site_setting ";
                            $ptr_faculty = mysql_query($select_faculty);
							$i=0;
                            while($data_faculty = mysql_fetch_array($ptr_faculty))
                            { 
								$class = '';
								if($record_id)
								{
									$sql_sub_cat ="select * from sms_mail_configuration_map where staff_id='".$data_faculty['admin_id']."' and previlege_id='".$record_id."' ";
									$ptr_sub_cat = mysql_query($sql_sub_cat);

									if(mysql_num_rows($ptr_sub_cat))
									{
										$class ='selected="selected"';
									}
								}
								echo '<option '.$class.' value="'.$data_faculty['admin_id'].'" >'.$data_faculty['name'].'</option>';
                            $i++;
							}
                            ?> 
                    </select>
                    </td> 
                <td width="40%"></td>
            </tr>
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Privilage" name="save_changes"  /></td>
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
<div id="footer"><? require("ex_include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>