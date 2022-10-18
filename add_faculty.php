    <?php include 'inc_classes.php';?>
    <?php include "admin_authentication.php";?>
    <?php include "../classes/thumbnail_images.class.php";?>
    <?php
    if($_REQUEST['record_id'])
    {
        $record_id=$_REQUEST['record_id'];
        $sql_record= "SELECT * FROM PB_user where user_id='".$record_id."'";
        if(mysql_num_rows($db->query($sql_record)))
            $row_record=$db->fetch_array($db->query($sql_record));
        else
            $record_id=0;

        $sql_faculty= "SELECT * FROM PB_faculty_details where user_id='".$record_id."'";
        if(mysql_num_rows($db->query($sql_faculty)))
            $row_faculty=$db->fetch_array($db->query($sql_faculty));
    }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php if($record_id) echo "Edit"; else echo "Add";?> Faculty</title>
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
                jQuery("#RegistrationForm").validationEngine('attach', {promptPosition : "topLeft"});
            });
    //        function OpenStatediv(country_id)
    //        {
    //            
    //            if(country_id)
    //                {
    //                    var data1="country_id="+country_id;
    //            //alert(data1);
    //            $.ajax({
    //                url: "select_state.php", type: "post", data: data1, cache: false,
    //                success: function (html)
    //                {
    //                    //alert(html);
    //                    $("#statediv").html(html);
    //                    //document.getElementById(div_id).innerHTML=html;
    //                }
    //            });
    //            
    //                }
    //            
    //        }
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
        <td class="top_mid" valign="bottom"><?php include "include/faculty_menu.php"; ?></td>
        <td class="top_right"></td>
      </tr>
      <tr>
        <td class="mid_left"></td>
        <td class="mid_mid">
            <table width="100%" cellspacing="0" cellpadding="0">            
         <?php
                $success=0;
                $errors=array(); $i=0;
                if($_POST['register'])
                {
                        $author_descriptionss=$_POST['author_description'];
                        $first_name = strip_tags($_POST['first_name']);
                        $last_name = strip_tags($_POST['last_name']);
                        $email_id = strip_tags($_POST['email_id']);
                        $password = strip_tags($_POST['passwords']);
                        $conf_password = strip_tags($_POST['conf_password']);

                        if($first_name == '')
                        {
                                $success=0;
                                $errors[$i++]="Please enter first name";	
                        }
                        if($last_name == '')
                        {
                                $success=0;
                                $errors[$i++]="Please enter last name";	
                        }
                        if($email_id == '')
                        {
                                $success=0;
                                $errors[$i++]="Please enter email Id";	
                        }
                        if($password == '')
                        {
                                $success=0;
                                $errors[$i++]="Please enter password";	
                        }
                        if($conf_password == '')
                        {
                                $success=0;
                                $errors[$i++]="Please enter confirm password";	
                        }
                        if($password !='' && $new_name !='')
                        {
                            if($password!=$conf_password)
                            {
                                    $success=0;
                                    $errors[$i++]="Password & confirm password should be same";
                            }
                        }
                        if($record_id =='')  {
                            $select_exist_userTable = "select user_id from PB_user where email_id = '".$email_id."' and status = 'Active' ";
                            if(mysql_num_rows($db->query($select_exist_userTable)))	
                            {
                                    $success=0;
                                    $errors[$i++]="This email Id is already in use, please choose another one";
                            }
                        }
                        if(count($errors))
                        {
                            ?>
                            <tr><td>
                                <table align="left" width="60%" style="text-align:left;" class="alert">
                                    <tr><td class="text"><strong>Please correct the following errors</strong><ul>
                                                <?php
                                                for ($k = 0; $k < count($errors); $k++)
                                                    echo '<li style="text-align:left;padding-top:5px;">' . $errors[$k] . '</li>';
                                                ?>
                                            </ul>
                                        </td></tr>
                                </table>
                            </td></tr>
                            <?php
                        }
                        else
                        {
                                $success=1;
                                
                                $data_register['first_name']=$first_name;
                                $data_register['last_name']=$last_name;
                                $data_register['email_id']=$email_id;
                                $data_register['password']=base64_encode($password);
                                $data_register['added_date'] =date('Y-m-d H:i:s');
                                $data_register['status']='Active';
                                $data_register['user_type']='Faculty';
                                $data_register['confirm_key']=$confirm_key;
                                $author_description['author_description']=$author_descriptionss;

                                $select_exist_user = "select user_id from PB_user where email_id = '".$email_id."' and status = 'Active' ";
                                if(mysql_num_rows($db->query($select_exist_user)))
                                {
                                        $data_val = $db->fetch_array($db->query($select_exist_user));
                                        $user_id = $data_val['user_id'];
                                        $where_record=" user_id= ".$user_id." ";
                                        $db->query_update("user", $data_register,$where_record);
                                }
                                else
                                {
                                        $user_id = $db->query_insert("user", $data_register);
                                }

                                $select_exist_user1 = "select user_id from PB_faculty_details where user_id = '".$user_id."' ";
                                if(mysql_num_rows($db->query($select_exist_user1)))
                                {
                                        $data_val1 = $db->fetch_array($db->query($select_exist_user1));
                                        $where=" faculty_id= ".$data_val1['faculty_id']." ";
                                        $id=  $db->query_update("faculty_details", $author_description,$where);

                                }
                                else
                                {
                                        $author_description['user_id']=$user_id;
                                        $db->query_insert("faculty_details", $author_description);
                                }

                                $message_subject="Account Created : ".$domainName;

                                $message_body.="<b>".ucfirst($domainName)." Account Created</b><br></br>
                                    </br>Thank you for creating an account on <a href='".$siteURL."'>".$domainName."</a>.<br />
                                        Thank you for registering with <a href='$domainName'>$domainName</a>. Your account details are: <br />
                                        Username: $email_id <br />
                                        Password: ".base64_decode($password)."<br /><br />";
                                $headers="From: no-reply@".$domainName."\nContent-Type:text/html;charset=iso-8859-1";
                                $return_path = "no-reply@".$domainName."";

                                $sendmail = sendUserMail($email_id,$message_subject,$message_body,$headers);
                                echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';             
                        }
                }
                        if($success==0)
                        {
                            ?>
                <tr><td>
            <form name="RegistrationForm" method="post" id="RegistrationForm">
              <div class="registrationForm">
                 <table cellpadding="0" cellspacing="10" width="80%">
                    <tr>
                        <td width="20%">First Name <span class="orange_font">*</span></td>
                        <td width="70%"><input type="text" name="first_name" id="first_name" class="validate[required] input_select" value="<?php if($_POST['register']) echo $_POST['first_name']; else echo $row_record['first_name']; ?>" /></td>
                        <td width="10%"></td>
                    </tr>
                    <tr>
                        <td width="20%">Last Name <span class="orange_font">*</span></td>
                            <td width="40%"><input type="text" name="last_name" id="last_name" class="validate[required] input_select" value="<?php if($_POST['register']) echo $_POST['last_name']; else echo $row_record['last_name']; ?>" /></td>
                        <td width="40%"></td>
                    </tr>
                    <tr>
                        <td width="20%">Email <span class="orange_font">*</span></td>
                        <td width="40%"><input type="text" name="email_id" id="email_id" class="validate[required,custom[email]] input_select" value="<?php if($_POST['register']) echo $_POST['email_id']; else echo $row_record['email_id']; ?>" /></td>
                        <td width="40%"></td>
                    </tr>
                    <tr>
                        <td width="20%">Password <span class="orange_font">*</span></td>
                        <td width="40%"><input type="password" name="passwords" id="passwords" class="validate[required,minSize[6]] input_select"  value="<?php if($_POST['register']) echo base64_decode($_POST['passwords']); else echo base64_decode($row_record['password']); ?>" /></td>
                        <td width="40%"></td>
                    </tr>
                    <tr>
                        <td width="20%">Confirm Password <span class="orange_font">*</span></td>
                        <td width="40%"><input type="password" name="conf_password" id="conf_password" class="validate[required,equals[passwords]] input_select"  value="<?php if($_POST['register']) echo base64_decode($_POST['passwords']); else echo base64_decode($row_record['password']); ?>" /></td>
                        <td width="40%"></td>
                    </tr>
                     <tr>
                        <td width="20%" valign="top">Author Description</td>
                        <td width="40%">
                            <?php
                                            include("../FCKeditor/fckeditor.php");
                                            $BasePath = "../FCKeditor/";
                                            $oFCKeditor 			= new FCKeditor('author_description') ;
                                            $oFCKeditor->BasePath	= $BasePath ;
                                            if($_POST['save_changes'])
                                                $oFCKeditor->Value		= stripslashes($_POST['author_description']);
                                            else
                                                $oFCKeditor->Value		= stripslashes($row_faculty['author_description']);
                                            //$oFCKeditor->ToolbarSet	= "MyToolBar";
                                            $oFCKeditor->Height		= "300";
                                            $oFCKeditor->Create() ;
                             ?>
                        </td> 
                        <td width="40%"></td>
                    </tr>
                    <tr>
                        <td width="20%"></td>
                        <td width="40%" align="center"><input type="submit" name="register" value="Register" class="input_btn"/></td>
                        <td width="40%"></td>
                  </tr>
                </table>
              </div>
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