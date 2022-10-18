<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM vendor where vendor_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0; 
}
if($record_id && $_REQUEST['deleteThumbnail'])
{
    $update_news="update vendor set photo='' where vendor_id='".$record_id."'";
    //echo $update_events;
    $db->query($update_news);
    if($row_record['photo'] && file_exists("../teacher_photo/".$row_record['photo']))
        unlink("../teacher_photo/".$row_record['photo']);
    $row_record=$db->fetch_array($db->query($sql_record));
}
/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='140'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Vendor</title>
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
<!--<script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
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
	   	if(frm.staff_contact.value=='')
		{
			/*  disp_error +='Enter Mobile Number \n';
			 document.getElementById('staff_contact').style.border = '1px solid #f00';
			 frm.staff_contact.focus();
			 error='yes'; */
	    }
		else
		{	
			var text = frm.staff_contact.value;
			if(text.length <10)
			{
					 disp_error +='Enter Valid Mobile Number \n';
					 document.getElementById('staff_contact').style.border = '1px solid #f00';
					 error='yes';
			}
		}
		
		  
		 if(frm.staff_mail.value=='')
		 {
			 /* disp_error +='Enter Email ID\n';
			 document.getElementById('staff_mail').style.border = '1px solid #f00';
			 frm.staff_mail.focus();
			 error='yes'; */
	     }
		 else
		 {
			  var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if(document.getElementById("staff_mail").value !='')
		{
			if (reg.test(document.getElementById("staff_mail").value) == false) 
			{
				disp_error +='Invalid Email ID\n';
			 document.getElementById('staff_mail').style.border = '1px solid #f00';
			 frm.staff_mail.focus();
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
/*function validateEmail(emailField)
	 {
		
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if(document.getElementById("staff_mail").value !='')
		{
        if (reg.test(document.getElementById("staff_mail").value) == false) 
        {
            alert('Invalid Email Address');
			document.getElementById('staff_mail').style.border = '1px solid #f00';
			document.getElementById("staff_mail").focus();
            return false;
        }
		}

        return true;

	}	 */
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
    <td class="top_mid" valign="bottom"><?php include "include/product_category_menu.php"; ?></td>
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
						
                        $staff_name = $_POST['name'];
                        $staff_contact=$_POST['staff_contact']; 
					    $staff_mail=$_POST['staff_mail'];
					    $staff_address=$_POST['staff_address'];
						$staff_info=$_POST['staff_info'];
						$photo=$_POST['photo'];
						$invoice_no=$_POST['invoice_no'];
						$tax_no=$_POST['tax_no'];
						$date=$_POST['date'];
						$gst_no=$_POST['gst_no'];
						$wallet_amount='0';
						$added_date=date('Y-m-d H:i:s');    
						$branch_name=$_POST['branch_name'];
						if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
						{
							$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
							$ptr_branch=mysql_query($sel_branch);
							$data_branch=mysql_fetch_array($ptr_branch);
							$cm_id=$data_branch['cm_id'];
							$data_record['cm_id']=$cm_id;
							
						}	
						else
						{
							$branch_name1=$_SESSION['branch_name'];
							$cm_id=$_SESSION['cm_id'];
							$data_record['cm_id']=$cm_id;
						}                
                        if($staff_name =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter name";
                        }
						/*  if($staff_contact =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter Contact No";
                        } */
						
						if($record_id=='')
							 {
								  
								  
								  $sel_mobile_ext="select name from vendor where name ='".$staff_name."' ";
								  $ptr_mobile_ext=mysql_query($sel_mobile_ext);
								  if(mysql_num_rows($ptr_mobile_ext))
								  {
									  $success=0;
									  $errors[$i++]="Vendor Name already Exist.";
								  }
							 }
						
						
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
							
                            $data_record['name']=$staff_name;
							$data_record['email'] =$staff_mail;
                            $data_record['contact'] =$staff_contact;
                            $data_record['address'] = $staff_address;
                            $data_record['detail'] =$staff_info;
                            $data_record['added_date'] = $added_date;
							$data_record['invoice_no'] = $invoice_no;
							$data_record['date'] = $date;
							$data_record['tax_no'] = $tax_no;
							$data_record['gst_no'] = $gst_no;
							$data_record['wallet_balance'] = $wallet_amount;
							
							if($file_uploaded && $uploaded_url !='')
								$data_record['photo'] = $uploaded_url;
							else
								$data_record['photo'] = $_POST['photo'];
                            
							if($record_id)
                            {
								$where_record="vendor_id='".$record_id."'";                                
								$staff_id= $db->query_update("vendor", $data_record,$where_record); 
								
								"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_vendor','Edit','".$staff_name."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
								$query=mysql_query($insert);   
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                            else
                            {
							    $data_record['added_date'] = date('Y-m-d H:i:s');
                                $courses_id=$db->query_insert("vendor", $data_record);  
							    $staff_id= mysql_insert_id();
								
								$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_vendor','Add','".$staff_name."','".$staff_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
								$query=mysql_query($insert);                        
									echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
							}
						}
                    }
                    if($success==0)
                    {
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
            <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
           
            <?php
                $sql_sub_cat = "select * from site_setting where admin_id='".$row_record['admin_id']."' ";
                $data_sub_cat = $db->fetch_array($db->query($sql_sub_cat));
                //$implode_data = explode(",",$data_sub_cat['course_author']);            
             ?>
             <?php 
				if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
				{
					?>
					  <tr>
						<td>Select Branch</td>
						<td>
							<?php 
							if($_REQUEST['record_id'])
							{
								$sel_cm_id="select branch_name from site_setting where cm_id=".$row_record['cm_id']." ";
								$ptr_query=mysql_query($sel_cm_id);
								$data_branch_nmae=mysql_fetch_array($ptr_query);
							}
							$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
							$query_branch = mysql_query($sel_branch);
							$total_Branch = mysql_num_rows($query_branch);
							echo '<table width="100%"><tr><td>'; 
							echo ' <select id="branch_name" name="branch_name">';
							while($row_branch = mysql_fetch_array($query_branch))
							{
								?>
								<option value="<?php echo $row_branch['branch_name'];?>" <?php if ($_POST['branch_name'] ==$row_branch['branch_name']) echo 'selected="selected"'; else if($row_branch['branch_name']==$data_branch_nmae['branch_name']) echo 'selected="selected"' ?> /><?php echo $row_branch['branch_name']; ?> 
						
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
					 <?php 
				}?>
            <tr>
                <td width="20%">Vendor Name<span class="orange_font">*</span></td>
                <td width="40%">
                    <input type="text" class="validate[required] input_text" name="name" id="name" value="<?php if($_POST['save_changes']) echo $_POST['name']; else echo $row_record['name'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>  
            <tr>
                <td width="20%">Contact No<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text" onKeyPress="return isNumber(event)" maxlength="12" name="staff_contact" id="staff_contact" value="<?php if($_POST['save_changes']) echo $_POST['staff_contact']; else echo $row_record['contact'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>   
            <tr>
                <td width="20%">Email Id<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text" name="staff_mail" onBlur="validateEmail('mail')" id="staff_mail" value="<?php if($_POST['save_changes']) echo $_POST['staff_mail']; else echo $row_record['email'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>  
             <tr>
                <td width="20%">Address<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text" name="staff_address" id="staff_address" value="<?php if($_POST['save_changes']) echo $_POST['staff_address']; else echo $row_record['address'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>   
            <tr>
                <td width="20%" valign="top"> Description <!--span class="orange_font">*</span --></td>
                <td colspan="2">
                      <script src="ckeditor/ckeditor.js"></script>
                        <textarea name="staff_info" id="staff_info"><?php if ($_POST['staff_info']) echo stripslashes($_POST['staff_info']); else echo $row_record['detail']; ?></textarea>
                    <script>
                        CKEDITOR.replace( 'staff_info' );
                    </script>
                </td> 
           </tr>
           <tr>
                <td width="20%">Invoice No.<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text" name="invoice_no" id="invoice_no" value="<?php if($_POST['invoice_no']) echo $_POST['invoice_no']; else echo $row_record['invoice_no'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>  
            <tr>
                <td width="20%">Date<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text datepicker" name="date" id="date" value="<?php if($_POST['date']) echo $_POST['date']; else echo $row_record['date'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>  
            <tr>
                <td width="20%">Tax No.<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text" name="tax_no" id="tax_no" value="<?php if($_POST['tax_no']) echo $_POST['tax_no']; else echo $row_record['tax_no'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>  
            <tr>
                <td width="20%">GST No.<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text" name="gst_no"  id="gst_no" value="<?php if($_POST['gst_no']) echo $_POST['gst_no']; else echo $row_record['gst_no'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>  
            <tr>
            <td width="20%">Photo</td>
            <td width="40%"><?php
                    if($record_id && $row_record['photo'] && file_exists("../teacher_photo/".$row_record['photo']))
                        echo '<img height="77px" width="77px" src="../teacher_photo/'.$row_record['photo'].'"><br><a href="'.$_SERVER['PHP_SELF'].'?deleteThumbnail=1&record_id='.$record_id.'">Delete / Upload new</a></td><td width="40%"></td><input type="hidden" name="photo" id="photo" class="input_text" value="'.$row_record['photo'].'">';
                    else
                        echo '<input type="file" name="photo" id="photo" class="input_text"></td>';?></td> 
            <td width="40%"></td>
            </tr>
            <tr>
            <td>&nbsp;</td>
            <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Vendor" name="save_changes" onClick="return validme()"   /></td>
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
</body>
</html>
<?php $db->close();?>