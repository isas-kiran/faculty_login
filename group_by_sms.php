 <?php session_start();?>
<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Group By SMS</title>
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
           /* $("#user_id").multiselect().multiselectfilter();
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});*/
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
$(document).ready(function() {
    $("#send_by").change(function() {
        var selVal = $(this).val();
		//alert(selVal);
        $("#customise").html('');
		
        if(selVal == 'email') 
		{
            $("#customise").append('<table width="100%"><tr><td width="20%" class="heading">Add Subject</span></td><td width="70%" colspan=2"><input type="text" class="input_text" name="subject" style="width:300px;"/></td></tr></table>');
			$("#for_sms").hide();
			$("#for_mail").show(); 
			
			$("#photo_id").css("display", "block");
		}
		else
		{
			 $("#customise").append('<table width="100%"><tr><td width="23%" class="heading">Select SMS Type</span></td><td width="39%"><select name="sms_type" class="input_select"><option value="">Select type</option><option value="promotional">Promotional</option><option value="transactional">Transactional</option></select></td><td></td></tr></table>');
			$("#for_mail").hide();
			$("#for_sms").show();
			
			$("#photo_id").css("display", "none");
		}
    });
});

function del_not(enroll_id, i)
{
	
				 var el = 'requirment_id'+i;
				
				//alert(document.getElementById(el).checked);
				if( document.getElementById(el).checked)
				
					document.getElementById("del_enroll_"+i).value='';
				
				else
				document.getElementById("del_enroll_"+i).value=enroll_id;
				
				
				//alert (document.getElementById("del_enroll_"+i).value);
	
}

</script>

 <script>
 
			
			function get_group(group_id) 
			 {
        		var selVal = group_id;
				
				<?php 
				$concsts ='';
				if($record_id)
				{
					$concsts= "+'&group_id=$record_id'";
				}
				?>
			var data1="group_id="+selVal<?php echo $concsts; ?>;
                //alert(data1);
                 $.ajax ({
            url: "get_group.php", type: "post", data: data1, cache: false,
            success: function (html)
				{
					document.getElementById('student_div').innerHTML=html;
					//alert(html);
				  $(".multiselect").multiselect();
				}
            });
		}
    </script>
    

<script type="text/javascript">
	
//Edit the counter/limiter value as your wish
var count = "160";   //Example: var count = "175";
function limiter(){
var tex = document.jqueryForm.text.value;
var len = tex.length;
/* if(len > count){
        tex = tex.substring(0,count);
        document.jqueryForm.text.value =tex;
        return false;
} */
document.jqueryForm.limit.value = count-len;
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
<?php
function died($error) 
{
	// your error code can go here
	echo "We are very sorry, but there were error(s) found with the form you submitted. ";
	echo "These errors appear below.<br /><br />";
	echo $error."<br /><br />";
	echo "Please go back and fix these errors.<br /><br />";
	die();
}
function clean_string($string) 
{
  $bad = array("content-type","bcc:","to:","cc:","href");
  return str_replace($bad,"",$string);
}
?>
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/sms_mail_menu.php"; ?></td>
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
						$arrage_date= explode('/',$_POST['start_date'],3);     
						$start_date= $arrage_date[2].'-'.$arrage_date[1].'-'.$arrage_date[0];
						$start_date = ( true == isset( $start_date )) ? $start_date : "";
						$group_id = ( true == isset( $_POST['group_id'] )) ? $_POST['group_id'] : "";
					   	$batch_name = ( true == isset( $_POST['batch_name'] )) ? $_POST['batch_name'] : "";                 
						$no_of_student = ( true == isset( $_POST['no_of_student'] )) ? $_POST['no_of_student'] : "0";
						$group_id = ( true == isset( $_POST['group_id'] )) ? $_POST['batch'] : "0";
						$branch_name = ( true == isset( $_POST['branch_name'] )) ? $_POST['branch_name'] : "";
						                       
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
                         	</td></tr><br></br>  
                    	<?php
                        }
                        else
                        {
                            $success=1;
							$uploaded_url="";
                            if(count($errors)==0 && $_FILES['photo']["name"])
                            {
                                
                                $uploaded_url=time().basename($_FILES['photo']["name"]);
                                $newfile = "email_photo/";
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
                                        $thump_target_path="email_photo/".$uploaded_url;
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
                            
                            $data_record['start_date'] =$start_date;
							$data_record['end_date'] = $end_date;
                            $data_record['start_time'] = $start_time;
                            $data_record['end_time'] =$end_time;
							$data_record['admin_id']=$_SESSION['admin_id'];
							$data_record['added_date']=date('Y-m-d H:i:s');
							$data_record['course_id']=$course_id;
							if($_SESSION['cm_id'] !='')
								$data_record_batch['cm_id']=$_SESSION['cm_id'];
							$data_record_batch['admin_id']=$_SESSION['admin_id'];
							$data_record_batch['added_date']=date('Y-m-d H:i:s');
							$data_record_batch['batch_time_id']=$batch;
							$data_record_batch['staff_id']=$staff;
							$data_record_s_c_b_map['admin_id']=$_SESSION['admin_id'];
							$data_record_s_c_b_map['added_date']=date('Y-m-d H:i:s');
							$data_record_s_c_b_map['course_id']=$course_id;
							$data_record_s_c_b_map['enroll_id']=$enroll_id;
							//$data_record_s_c_b_map['cm_id']=$_SESSION['cm_id'];
							//===============================CM ID for Super Admin===============
							if($_SESSION['type']=='S')
							{
								$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
								$cm_id=$data_branch['cm_id'];					
								$data_record_batch['cm_id'] =$cm_id;
								$data_record_s_c_b_map['cm_id']=$cm_id;
							}	
							else
							{
								$branch_name1=$_SESSION['branch_name'];
								$cm_id=$_SESSION['cm_id'];
								$data_record_batch['cm_id'] =$cm_id;
								$data_record_s_c_b_map['cm_id']=$cm_id;
							}
							//====================================================================
                           	if($_POST['send_by']=='sms')
						   	{
								$sel_sms="select * from add_group where group_id='".$_POST['group_id']."'";
								$ptr_sel=mysql_query($sel_sms);
								$tpp=mysql_fetch_array($ptr_sel);
						 		$sel_sms_cnt="select id from add_group_detail where group_id='".$_POST['group_id']."'";
								$ptr_sel_sms1=mysql_query($sel_sms_cnt);
								while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms1))
								{
									if($tpp['send_to']=='student')
									{
										$sel_sms_cnt1="select contact,name from enrollment where enroll_id='".$data_sel_cnt['id']."'";
										$ptr_sel_sms=mysql_query($sel_sms_cnt1);
										$tpp1=mysql_fetch_array($ptr_sel_sms);
										//echo ">>>>>>>>>>>".$tpp1['contact'];
										send_sms_function($tpp1['contact'],$_POST['text'],$_POST['sms_type']);
										$insert_sms="insert into sms_log_history (`name`,`mobile_no`,`sms_text`,`sms_type`,`cm_id`,`added_date`) values('".$data_sel_cnt['name']."','".$data_sel_cnt['contact']."','".$_POST['text']."','".$_POST['send_by']."','".$cm_id."','".$start_date."')";
										$ptr_sms=mysql_query($insert_sms);
									} 
									else
									{
										$sel_sms_cnt1="select contact_phone,name from site_setting where admin_id='".$data_sel_cnt['id']."'";
										$ptr_sel_sms=mysql_query($sel_sms_cnt1);	
										$tpp1=mysql_fetch_array($ptr_sel_sms);
										//echo ">>>>>>>>>>>".$tpp1['contact_phone'];
										send_sms_function($tpp1['contact_phone'],$_POST['text'],$_POST['sms_type']);
										$insert_sms="insert into sms_log_history (`name`,`mobile_no`,`sms_text`,`sms_type`,`cm_id`,`added_date`) values('".$data_sel_cnt['name']."','".$data_sel_cnt['contact_phone']."','".$_POST['text']."','".$_POST['send_by']."','".$cm_id."','".$start_date."')";
										$ptr_sms=mysql_query($insert_sms);
									}
								}
                                	echo ' <br></br><div id="msgbox" style="width:40%;">SMS Send successfully</center></div> <br></br>';
						   	}
							if($_POST['send_by']=='email')
						   	{
						  		$sel_sms="select * from add_group where group_id='".$_POST['group_id']."'";
								$ptr_sel=mysql_query($sel_sms);
								$tpp=mysql_fetch_array($ptr_sel);
						 
                           		$sel_sms_cnt="select id from add_group_detail where group_id='".$_POST['group_id']."'";
								$ptr_sel_sms1=mysql_query($sel_sms_cnt);
								while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms1))
								{
									if($tpp['send_to']=='student')
									{
										$sel_sms_cnt1="select mail,name from enrollment where enroll_id='".$data_sel_cnt['id']."'";
									    $ptr_sel_sms=mysql_query($sel_sms_cnt1);
										$tpp1=mysql_fetch_array($ptr_sel_sms);
										
										$insert_sms="insert into sms_log_history (`name`,`mobile_no`,`sms_text`,`sms_type`,`cm_id`,`added_date`) values('".$data_sel_cnt['name']."','".$data_sel_cnt['mail']."','".$_POST['text']."','".$_POST['send_by']."','".$cm_id."','".$start_date."')";
										$ptr_sms=mysql_query($insert_sms);
										$mail=$tpp1['mail'];
									} 
									else
									{
										$sel_sms_cnt1="select email,name from site_setting where admin_id='".$data_sel_cnt['id']."'";
										$ptr_sel_sms=mysql_query($sel_sms_cnt1);	
										$tpp1=mysql_fetch_array($ptr_sel_sms);
										
										$insert_sms="insert into sms_log_history (`name`,`mobile_no`,`sms_text`,`sms_type`,`cm_id`,`added_date`) values('".$data_sel_cnt['name']."','".$data_sel_cnt['email']."','".$_POST['mail_text']."','".$_POST['send_by']."','".$cm_id."','".$start_date."')";
										$ptr_sms=mysql_query($insert_sms);
										$mail=$tpp1['email'];
									}
						 			//if(isset($data_sel_cnt['mail'])) 
									//{
										//echo "mail sending";	
										// EDIT THE 2 LINES BELOW AS REQUIRED
										$email_to = $mail;
										$email_subject = $_POST['subject'];
										$text = $_POST['mail_text']; // required
										$email_from="learn@isas-pune.com";
										$error_message = "";
										$imag_below="";	
										$img_above="";			 
										if($_POST['alignment']=='below')
										{
											$imag_below .= "<br/><br/><img width='500' height='500' src='http://isasbeautyschool.org/isastest/faculty_login/email_photo/".$uploaded_url."'><br><br>";
										}
										else if($_POST['alignment']=='above')
										{
											$img_above .= "<br/><br/><img width='500' height='500' src='http://isasbeautyschool.org/isastest/faculty_login/email_photo/".$uploaded_url."'><br><br>"; 
										}
									 
									 	$email_message .="<div style='border: solid black;padding:10px;'>".$img_above."<b>".$text."</b>".$imag_below."</div>";
										// create email headers
										$headers = 'From: '.$email_from."\r\n".
										'Reply-To: '.$email_from."\r\n" .
										'X-Mailer: PHP/' . phpversion();
										$headers .= 'MIME-Version: 1.0' . "\r\n";
										$headers .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";									
										@mail($email_to, $email_subject, $email_message, $headers);  
		            	 			//}
						 		}
								echo '<br></br><div id="msgbox" style="width:40%;">Email Send successfully</center></div> <br></br>';
							}
								
						}
					}
                    if($success==0)
                    {
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data" >
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
            <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
           
            
            <tr>
                <td width="22%">Select Group<span class="orange_font">*</span></td>
                <td width="38%" >
                    <select name="group_id" id="group_id" class="validate[required] input_select" >  
                        <option value=""> Select Group</option>
                        <?php
                            $select_category = "select * from add_group where 1 order by group_id asc";
                            $ptr_category = mysql_query($select_category);
							
                            while($data_category = mysql_fetch_array($ptr_category))
                            {
                                    echo '<option value='.$data_category['group_id'].'>'.$data_category['group_name'].'</option>';
                            }
                            ?>  
                            
                                
                    </select>
                    </td> 
                <td width="40%"></td>
            </tr>
			
			<tr>
            	<td></td>
            	<td>
                	 <div id="student_div" >
                     </div>
                </td>
            </tr>
		   <tr>
                <td height="43">Send By</td>
                <td>
				<select name="send_by" id="send_by" class="input_select">
                <option value="">Select Type</option>
				<option value="sms">SMS</option>
				<option value="email">Email</option>
				</select>
                </td>
            </tr>
			<tr>
				<td colspan="3"> <div id="customise"></div></td> 
		   </tr>         
		   <tr>
		   <td colspan="3">
		   <table id="for_mail" style="display:none;">
		   <tr>
            <td width="22.5%" valign="top">Message <!--span class="orange_font">*</span --></td>
            <td colspan="2">
            <!--<script src="ckeditor/ckeditor.js"></script>
            <textarea name="mail_text" id="mail_text"></textarea>
            <script>
            CKEDITOR.replace( 'mail_text' );
            </script>-->
            <script src="//cdn.ckeditor.com/4.15.0/full/ckeditor.js"></script>
            	<textarea id="mail_text" name="mail_text"></textarea>
            <script>
            	CKEDITOR.replace('mail_text');
            </script>
            </td> 
			</tr>
			</table>
			</td>
            </tr>
		  	
            <tr style="padding:10px;">
			<td colspan="2">
		 		<table id="for_sms">
		 		<tr>
		 			<td width="39.5%">Message: </td>
		 			<td colspan="2"><textarea class='input_text' style="height: 77px; width: 413px;" name="text" onkeyup="limiter()"></textarea></td>
	   			</tr>
	 	   		<tr>
	   				<td></td>
      				<td>Character left: <script type="text/javascript">
       				document.write("<input type=text name=limit style='width:100px' class='input_text' size=4 readonly value="+count+">");
       				</script><br>
	   				</td>
                   	</tr>
                   	</table>
                   	</td>
                   	</tr>

                <tr>
                <td width="20%">Date</td>
                <td width="40%">
                 <?php 
				if($record_id!='')
				{
					if($data_course_batch_mapping['start_date']!='')
					{
					 $arrage_date= explode('-', $data_course_batch_mapping['start_date'],3); 
					  $new_arrange_date= $arrage_date[1].'/'.$arrage_date[2].'/'.$arrage_date[0];
					}
				}
				?>
                <input type="text" class="validate[required] input_text datepicker" name="start_date" placeholder="Date" id="start_date" readonly="true" 
                value="<?php if($_POST['save_changes']) echo $_POST['start_date']; else  echo $new_arrange_date ?>" />
                </td>
            </tr>
           	<tr>
                <td colspan="3">
                    <table id="photo_id" width="100%" style="display:none">
                        <tr>
                            <td width="43%">Photo</td>
                            <td width="40%"><?php
                                echo '<input type="file" name="photo" id="photo" class="input_text"></td>';?></td> 
                            
                        </tr>
                        <tr>
                            <td height="43">Photo Alignment</td>
                            <td>
                            <select name="alignment" id="alignment" class="input_select">
                            <option value="">Select Allignment</option>
                            <option value="above">Above Message</option>
                            <option value="below">Below Message</option>
                            </select>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr >
                <td>&nbsp;</td>
                <td>
			
                <input type="submit" id="mySubmit" class="input_btn" onclick="return validme()" value="Send"  <?php echo $disbled; ?> name="save_changes"  />
               <?php if($disbled !='') echo "No Student is pending for batch schedule"; ?>
                </td>
                <td></td>
            </tr>
        </table>
        </form>
         <?php
		if($record_id)
		{
			?>
        <script language="javascript"> 
		
		</script>
        <?php } ?>
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