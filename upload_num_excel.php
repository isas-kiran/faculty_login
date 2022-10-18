<?php 
ini_set('max_execution_time', 300);
include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Upload Excel</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
</head>
<body>
<?php include "include/header.php";?>
<div id="info">
<!--left start-->
<?php include "include/menuLeft.php"; ?>
<!--left end-->
<!--right start-->
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
 <link rel="stylesheet" href="js/chosen.css" />
<script src="js/chosen.jquery.js" type="text/javascript"></script>
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
         
<script type="text/javascript">
	
//Edit the counter/limiter value as your wish
var count = "160";   //Example: var count = "175";
function limiter(){
var tex = document.jqueryForm.text.value;
var len = tex.length;

document.jqueryForm.limit.value = count-len;
}


</script> 
<?php
if(isset($_POST['import_excel']))
{
	
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
	
    require_once 'Excel/reader.php';
    $filename = basename($_FILES['excel_file']['name']);
   
   
    move_uploaded_file($_FILES['excel_file']['tmp_name'],"excel_files/$filename");
   	
   
					$data = new Spreadsheet_Excel_Reader();
                    $data->setOutputEncoding('CP1251');
                    $path="excel_files/$filename";
                    $data->read("excel_files/$filename");
                   
                    echo "Total Sheets in this xls file: ".count($data->sheets)."<br /><br />";
                    $html="<table border='1'>";
                    for($i=0;$i<1;$i++) // Loop to get all sheets in a file.
                    {   
						$staff_id=0;
                        if(count($data->sheets[$i][cells])>0) // checking sheet not empty
                        {
                            echo "Sheet $i:<br /><br />Total rows in sheet $i  ".count($data->sheets[$i][cells])."<br />";
                             $n=1;
                      
                                $html.="<tr>";
							
								$html.="<td>";
								$html.='R=>'.$j.'C=>'.$k.' .. '. $data->sheets[$i][cells][$j][$k];
								$html.="</td>";
								$total_month=$_REQUEST['no_of_days'];
								
							
								for($k=1;$k<=count($data->sheets[$i][cells]);$k++)
								{
									
									$mobile_number=$data->sheets[0]['cells'][$k][1];
									if($_POST['send_by']=='sms')
						   			{
							 			//  echo $date=$data->sheets[0]['cells'][$k][1].">>>>>>>>>>".$_POST['text'];
										//send_sms_function($date=$data->sheets[0]['cells'][$k][1],$_POST['text']);
										send_sms_function($mobile_number,$_POST['text'],$_POST['sms_type']);
										
										$insert_sms="insert into sms_log_history (`name`,`mobile_no`,`sms_text`,`sms_type`,`admin_id`,`cm_id`,`added_date`) values('excel_file_name','".$mobile_number."','".$_POST['text']."','".$_POST['sms_type']."','".$_SESSION['admin_id']."','".$_SESSION['cm_id']."','".date('Y-m-d H:i:s')."')";
										$ptr_sms=mysql_query($insert_sms);
						   			}		
									//===============================CM ID for Super Admin===============
									$html.="</tr>";
								} // for loop end.
						   		if($_POST['send_by']=='email')
						   		{
									for($k=1;$k<=count($data->sheets[$i][cells]);$k++)
									{
										// EDIT THE 2 LINES BELOW AS REQUIRED
										$email_to = $date=$data->sheets[0]['cells'][$k][1];
										$email_subject = $_POST['subject'];
									 
										function died($error) 
										{
											// your error code can go here
											echo "We are very sorry, but there were error(s) found with the form you submitted. ";
											echo "These errors appear below.<br /><br />";
											echo $error."<br /><br />";
											echo "Please go back and fix these errors.<br /><br />";
											die();
										}
										$text = $_POST['mail_text']; // required
										$email_from="learn@isas-pune.com";								 
										$error_message = "";
									
										function clean_string($string) {
										  $bad = array("content-type","bcc:","to:","cc:","href");
										  return str_replace($bad,"",$string);
									}
 
     
 
    if($_POST['alignment']=='below')
	 {
    "</br>".$email_message .= "<div style='border: solid black;padding:10px;'><b> Message : ".$text." ".$_POST['text']."</b><br><br><img width='500' height='500' src='http://isasbeautyschool.org/faculty_login/email_photo/".$uploaded_url."'><br><br></div>";
	 }
	 else
	 {
	"</br>".$email_message .= "<div style='border: solid black;padding:10px;'><img width='500' height='500' src='http://isasbeautyschool.org/faculty_login/email_photo/".$uploaded_url."'><br><br><b> Message : ".$text." ".$_POST['text']."</b><br><br></div>"; 
	 }
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();

$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";

@mail($email_to, $email_subject, $email_message, $headers);  
		            	 
						 
						 }
						 echo ' <br></br><div id="msgbox" style="width:40%;">Email Send successfully</center></div> <br></br>';
						 }
     // Email End       
                }//checking sheet not empty
            }//Loop To Get To all Sheet- echo $html;
                     $html="</table>";
}                   

?>


<form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data" >
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
            <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
           
            
            <tr>
                <td width="22%">Import excel file<span class="orange_font">*</span></td>
                <td width="38%" >
                   <input type="file" onChange="getmonthdays();" name="excel_file" id="excel_file" class=" input_text">
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
		   <td colspan="2">
		   <table id="for_mail" style="display:none;">
		   <tr>
            <td width="36%" valign="top">Message <!--span class="orange_font">*</span --></td>
            <td colspan="2">
			<script src="ckeditor/ckeditor.js"></script>
                <textarea name="mail_text" id="mail_text"></textarea>
            <script>
                CKEDITOR.replace( 'mail_text' );
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
		 			<td width="60%">Message: </td>
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
                    <table id="photo_id" width="100%">
                        <tr>
                            <td width="22%">Photo</td>
                            <td width="40%"><?php
                                echo '<input type="file" name="photo" id="photo" class="input_text"></td>';?></td> 
                            <td width="40%"></td>
                        </tr>
                        <tr>
                            <td height="43">Photo Alignment</td>
                            <td>
                            <select name="alignment" id="alignment" class="input_select">
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
			
             <input  type="hidden" id="no_of_days" name="no_of_days" value="" />
			 <input style="margin-left: -10px;"  type="submit" class="input_btn" name="import_excel" id="save_changes" value="Send" /></td>
			 
                </td>
                <td></td>
            </tr>
        </table>
        </form>
          
 <!-- <table align="center" border="1" style="border-collapse:collapse;">
<tr><td colspan="3"><h2>Download Formats: </h2></td></tr>
<tr><td><center><a href="final.xls"><u>DownLoad Excel</u></a></center></td></tr>



</table>  -->         
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
 <div id="footer" style="margin-top:300px;"><?php require("include/footer.php");?></div>

</script>
<!--footer end-->
</body>
</html>