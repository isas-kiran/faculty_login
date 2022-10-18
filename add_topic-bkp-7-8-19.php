<?php session_start();?>
<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
     $sql_record= "SELECT subject_id,topic_name,duration,description FROM topic where topic_id='".$record_id."' ";
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
}
/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Topic</title>
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
		
  
     function del_degree(del)  // for delete the degree
					 {
						var i=parseInt(document.getElementById('extra').value);
						if(i !=0)
						{
							document.getElementById(i).style.display='none';
							document.getElementById('extra').value=parseInt((i-1));
						}
					 	//document.getElementById(j).style.display='none'; 
						
					 }
			function add_degree(no) //for add a degree
					 {
					 	var i=parseInt(document.getElementById('extra').value);
						i=i+1;
						
						var next = i+1;
						if(document.getElementById(i).style.display=='none')
						{
							document.getElementById(i).style.display='block';
						}
						else
						{
							//var dealer= select_dealer(i); 
							//var  product     = select_product(i);
					 	var value='<div id="'+i+'"><table class="table_class" width="72%"  cellspacing="0" cellpadding="2"> <tr><td width="10%"><input type="text" name="topic_name'+i+'"class="input_text" /></td><td width="10%"><input type="text" name="duration'+i+'" class="input_text" /></td><td width="10%"><input type="text" name="description'+i+'"  class="input_text" /></td></tr></table></div> <div id="'+next+'"></div>';
						document.getElementById(i).innerHTML= value;
						document.getElementById('extra').value=i;
						}
					 }  
	
	
      </script>
      <script>
      $(document).ready(function() {
    $("#course_id").change(function() {
        var selVal = $(this).val();
		//alert("selVal");
        $("#customise").html('');
		
        if(selVal == 'new_course') 
		{
            $("#customise").append('<table width="100%"><tr><td width="19%" class="heading">New Subject Name</span></td><td width="81%"><input type="text"            class="input_text" name="costomize_subject" style="width:50% !important"/></td></tr><tr><td width="19%" class="heading">Descreption</span></td><td width="81%"><input type="text"            class="input_text" name="descreption" style="width:50% !important"/></td></tr></table>');
		}
		else{}
    });
});
</script>

    <script type="text/javascript">
        jQuery(document).ready( function() {
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
    </script>
</head>
<body>
<?php include "include/header.php";?>
<!--info start-->
<div id="info">
<!--left start-->
<?php include "include/menuLeft.php"; ?>
<?php include "include/course_menu.php"; ?>
<!--left end-->
<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom">&nbsp;</td>
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
						$topic_name=$_POST['topic_name'];
                        $course_name=$_POST['course_name'];
						 'sub=>'.$subject=$_POST['course_id'];
                        $course_description = $_POST['course_description'];
                        $course_duration=$_POST['course_duration'];
                        $course_level=$_POST['course_level'];
                        //$course_video=$_POST['course_video'];
                        //$course_pdf=$_POST['course_pdf'];                        
                        $staff_idsss=@implode(",",$_POST['staff_id']);                        
                        $course_duration=$_POST['duration'];
                        $category_id = $_POST['category_id'];
                        $free_course = $_POST['free_course'];
                        $course_price = $_POST['course_price'];
                  		$costomize_subject=$_POST['costomize_subject'];
                        $subject_description=$_POST['descreption'];
                        $discountss=$_POST['discount'];                        
                        $start_date=$_POST['start_date'];
                        $end_date=$_POST['end_date'];
                        $branch_name=$_POST['branch_name'];
                          
                        $status=$_POST['status'];
						
						if($topic_name =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter Topic name";
                        }
						
						if($record_id=='')
						{
							$select_ext_topic="select topic_name from topic where topic_name='".$topic_name."' ";
							$query_ext_topic=mysql_query($select_ext_topic);
							if(mysql_num_rows($query_ext_topic))
							{
								$success=0;
								$errors[$i++]="Topic Name Already Exist. ";
							}
						}
						
                        if($course_duration =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter  duration";
                        }   
                        
                        /*if($topic_name =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter Topic name";
                        }
                        if($course_duration =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter Duration";
                        }   */
                       
                        $uploaded_url="";
                            /*if(count($errors)==0 && $_FILES['course_video']["name"])
                            {
                                if($record_id)
                                {
                                    $update_news="update topic set topic_video='' where topic_id='".$record_id."'";
                                    $db->query($update_news);

                                    if($row_record['course_video'] && file_exists("../UploadedData/".$row_record['course_video']))
                                        unlink("../UploadedData/".$row_record['course_video']);
                                    if($row_record['course_video'] && file_exists("../UploadedData/".$row_record['course_video']))
                                        unlink("../UploadedData/".$row_record['course_video']);
                                }
                                $path = "../UploadedData/";
                                $valid_formats = array("wmv", "flv","mp4","mov","3gp","3ga","avi","mpg","3gpp","gsm","mpeg","m4v","cmp","mpe","movie","swf");
                                $name = $_FILES['course_video']['name'];
                                $size = $_FILES['course_video']['size'];
                                
                                    list($txt, $ext) = explode(".", $name);
                                    if($name) 
                                        {
                                        $lowercase = strtolower($ext);
                                            if(in_array($lowercase,$valid_formats))
                                                { 
                                                    $uploaded_url = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
                                                    $tmp = $_FILES['course_video']['tmp_name'];                                    
                                                    $newfile = "../UploadedData/";

                                                    $explodeName = explode(".",$uploaded_url);

                                                    $thumbfile = $explodeName[0] . ".jpg";
                                                    $thumbfileswf = $explodeName[0] . ".flv";
                                                    $thumbfileMp4 = $explodeName[0] . ".mp4";

                                                     //ffmpeg -i sample.3gp -ar 44100  sample3gp.swf 
                                                    // ffmpeg -i Nikon_Coolpix_S3000.AVI -r 24 nikon.mp4

                                                    $options = "-an -y -f mjpeg -ss 2 -s 180x150 -vframes 1 ";
                                                    $optionsSWF = "-ar 44100";
                                                    $optionsMP4 = "-r 24";

                                                    $thumbpath = "../UploadedData/".$thumbfile;  
                                                    $thumbpathSWf = "../UploadedData/".$thumbfileswf; 
                                                    $thumbpathMpp = "../UploadedData/".$thumbfileMp4; 

                                                    $target_path1 = $newfile.$uploaded_url;
                                                    if(move_uploaded_file($tmp, $path.$uploaded_url))
                                                        {
                                                            $thump_target_path="../UploadedData/".$uploaded_url;                                            
                                                            $file_uploaded = 1;
                                                            exec("ffmpeg -i " . $thump_target_path . " " . $options . " " . $thumbpath, $output);                                            
                                                            exec("ffmpeg -i ".$thump_target_path." ".$optionsSWF." ".$thumbpathSWf, $outputs);
                                                            exec("ffmpeg -i ".$thump_target_path." ".$optionsMP4." ".$thumbpathMpp, $outputss);
                                                            //print_r($output); 
                                                        }
                                                    else
                                                    {
                                                        $file_uploaded=0;
                                                        $success=0;
                                                        $errors[$i++]="There are some errors while uploading video, please try again";                                                        
                                                    }
                                                }
                                            else
                                                {
                                                    $file_uploaded=0;
                                                    $success=0;
                                                    $errors[$i++]="Invalid file format..";
                                                    
                                                }
                                        }
                            }*/
							
				//===========================================Save Multiple Course Video===========================================================
					/*$no_of_extra=$_POST['no_of_extra'];
					for($i=0;$i<=$no_of_extra;$i++)
						{
									
									if(count($errors)==0 && $_FILES['course_video']["name"])
                            		{
                               		 if($record_id)
                                	 {
                                    	$update_news="update topic set topic_video='' where topic_id='".$record_id."'";
                                    	$db->query($update_news);

                                    	if($row_record['course_video'] && file_exists("../UploadedData/".$row_record['course_video']))
                                        	unlink("../UploadedData/".$row_record['course_video']);
                                    	if($row_record['course_video'] && file_exists("../UploadedData/".$row_record['course_video']))
                                        	unlink("../UploadedData/".$row_record['course_video']);
                                	 }
                                	$path = "../UploadedData/";
                               		$valid_formats = array("wmv", "flv","mp4","mov","3gp","3ga","avi","mpg","3gpp","gsm","mpeg","m4v","cmp","mpe","movie","swf");
                                	$name = $_FILES['course_video']['name'];
                                	$size = $_FILES['course_video']['size'];
                                
                                    list($txt, $ext) = explode(".", $name);
                                    if($name) 
                                        {
                                        $lowercase = strtolower($ext);
                                            if(in_array($lowercase,$valid_formats))
                                                { 
                                                    $uploaded_url = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
                                                    $tmp = $_FILES['course_video']['tmp_name'];                                    
                                                    $newfile = "../UploadedData/";

                                                    $explodeName = explode(".",$uploaded_url);

                                                    $thumbfile = $explodeName[0] . ".jpg";
                                                    $thumbfileswf = $explodeName[0] . ".flv";
                                                    $thumbfileMp4 = $explodeName[0] . ".mp4";

                                                     //ffmpeg -i sample.3gp -ar 44100  sample3gp.swf 
                                                    // ffmpeg -i Nikon_Coolpix_S3000.AVI -r 24 nikon.mp4

                                                    $options = "-an -y -f mjpeg -ss 2 -s 180x150 -vframes 1 ";
                                                    $optionsSWF = "-ar 44100";
                                                    $optionsMP4 = "-r 24";

                                                    $thumbpath = "../UploadedData/".$thumbfile;  
                                                    $thumbpathSWf = "../UploadedData/".$thumbfileswf; 
                                                    $thumbpathMpp = "../UploadedData/".$thumbfileMp4; 

                                                    $target_path1 = $newfile.$uploaded_url;
                                                    if(move_uploaded_file($tmp, $path.$uploaded_url))
                                                        {
                                                            $thump_target_path="../UploadedData/".$uploaded_url;                                            
                                                            $file_uploaded = 1;
                                                            exec("ffmpeg -i " . $thump_target_path . " " . $options . " " . $thumbpath, $output);                                            
                                                            exec("ffmpeg -i ".$thump_target_path." ".$optionsSWF." ".$thumbpathSWf, $outputs);
                                                            exec("ffmpeg -i ".$thump_target_path." ".$optionsMP4." ".$thumbpathMpp, $outputss);
                                                            //print_r($output); 
                                                        }
                                                    else
                                                    {
                                                        $file_uploaded=0;
                                                        $success=0;
                                                        $errors[$i++]="There are some errors while uploading video, please try again";                                                        
                                                    }
                                                }
                                            else
                                                {
                                                    $file_uploaded=0;
                                                    $success=0;
                                                    $errors[$i++]="Invalid file format..";
                                                    
                                                }
                                        }
                            }
							
										
					}//For loop()*/
				//===========================================End Viodeo============================================================================
                            
                            $uploaded_url1="";
                            /*if(count($errors)==0 && $_FILES['course_pdf']["name"])
                            {
								echo $_FILES['course_pdf']["name"];
                                if($record_id)
                                {
                                    $update_news="update topic set topic_pdf='' where topic_id='".$record_id."'";
                                    $db->query($update_news);

                                    if($row_record['course_pdf'] && file_exists("../UploadedData/".$row_record['course_pdf']))
                                        unlink("../UploadedData/".$row_record['course_pdf']);
                                    if($row_record['course_pdf'] && file_exists("../UploadedData/".$row_record['course_pdf']))
                                        unlink("../UploadedData/".$row_record['course_pdf']);
                                }
                                $uploaded_url1=time().basename($_FILES['course_pdf']["name"]);
                                $newfile1 = "../UploadedData/";

                                $filename = $_FILES['course_pdf']['tmp_name']; // File being uploaded.
                               echo "<br />". $filetype = $_FILES['course_pdf']['type'];// type of file being uploaded
                                //echo $filetype;exit;
                                $filesize = filesize($filename); // File size of the file being uploaded.
                                $source1 = $_FILES['course_pdf']['tmp_name'];
                                $target_path1 = $newfile1.$uploaded_url1;

                                list($width1, $height1, $type1, $attr1) = getimagesize($source1);
                                if(strtolower($filetype) == "application/pdf" ||strtolower($filetype) =="application/x-pdf" ||strtolower($filetype) =="application/x-download")
                                {
                                    
                                    if(move_uploaded_file($source1, $target_path1))
                                    {
                                        $thump_target_path="../UploadedData/".$uploaded_url1;
                                        copy($target_path1,$thump_target_path);
                                        $file_uploaded1=1;
                                    }
                                    else
                                    {
                                        $file_uploaded1=0;
                                        $success=0;
                                        $errors[$i++]="There are some errors while uploading pdf, please try again";
                                    }
                                }
                                else
                                {
                                    $file_uploaded1=0;
                                    $success=0;
                                    $errors[$i++]="Location pdf: Only pdf files allowed";
                                }
                            }*/
				//===========================================Save Multiple Course PDF===========================================================
					/*$no_of_extra=$_POST['no_of_extra'];
					for($i=0;$i<=$no_of_extra;$i++)
					{
						
						if(count($errors)==0 && $_FILES['course_pdf']["name"])
                            {
                                if($record_id)
                                {
                                    $update_news="update topic set topic_pdf='' where topic_id='".$record_id."'";
                                    $db->query($update_news);

                                    if($row_record['course_pdf'] && file_exists("../UploadedData/".$row_record['course_pdf']))
                                        unlink("../UploadedData/".$row_record['course_pdf']);
                                    if($row_record['course_pdf'] && file_exists("../UploadedData/".$row_record['course_pdf']))
                                        unlink("../UploadedData/".$row_record['course_pdf']);
                                }
                                $uploaded_url1=time().basename($_FILES['course_pdf']["name"]);
                                $newfile1 = "../UploadedData/";

                                $filename = $_FILES['course_pdf']['tmp_name']; // File being uploaded.
                                $filetype = $_FILES['course_pdf']['type'];// type of file being uploaded
                                //echo $filetype;exit;
                                $filesize = filesize($filename); // File size of the file being uploaded.
                                $source1 = $_FILES['course_pdf']['tmp_name'];
                                $target_path1 = $newfile1.$uploaded_url1;

                                list($width1, $height1, $type1, $attr1) = getimagesize($source1);
                                if(strtolower($filetype) == "application/pdf")
                                {
                                    
                                    if(move_uploaded_file($source1, $target_path1))
                                    {
                                        $thump_target_path="../UploadedData/".$uploaded_url1;
                                        copy($target_path1,$thump_target_path);
                                        $file_uploaded1=1;
                                    }
                                    else
                                    {
                                        $file_uploaded1=0;
                                        $success=0;
                                        $errors[$i++]="There are some errors while uploading pdf, please try again";
                                    }
                                }
                                else
                                {
                                    $file_uploaded1=0;
                                    $success=0;
                                    $errors[$i++]="Location pdf: Only pdf files allowed";
                                }
                            }
					
					}*/
				//===========================================End Multiple Course PDF===========================================================

                        
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
                           
                           /* $data_record['admin_id'] = $_SESSION['admin_id'];
                            $data_record['topic_url']=$thumbfile;
                            $data_record['topic_name'] =$topic_name;
                            $data_record['description'] =$course_description;
                            $data_record['duration'] =$course_duration;
                            $data_record['subject_id'] =$subject;
							$data_record['added_date'] = date('Y-m-d H:i:s');*/
							
                          /*  if($file_uploaded)
                                $data_record['topic_video'] =$uploaded_url;
                            if($file_uploaded1)
                                $data_record['topic_pdf'] =$uploaded_url1;*/
                        
							
							
								
								
						
							$data_record['teacher_id'] =$staff_idsss;
							$data_record_subject['name'] =$costomize_subject;
							$data_record_subject['description'] =$subject_description;
							$data_record_batch_extra1['admin_id'] = $_SESSION['admin_id'];
							$data_record_batch_extra1['topic_name']=$_POST['topic_name'];
							$data_record_batch_extra1['duration']=$_POST['duration'];
							$data_record_batch_extra1['description']=$_POST['description'];
							$data_record_batch_extra1['subject_id'] =$subject;
						   //===============================CM ID for Super Admin===============
							if($_SESSION['type']=='S')
							{
								$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
								$cm_id=$data_branch['cm_id'];
								$data_record_batch_extra1['cm_id'] =$cm_id;
								$data_record_subject['cm_id'] =$cm_id;
								
							}	
							else
							{
								$branch_name1=$_SESSION['branch_name'];
								$cm_id=$_SESSION['cm_id'];
								$data_record_batch_extra1['cm_id'] =$cm_id;
								$data_record_subject['cm_id'] =$cm_id;
							}
							//====================================================================
                            if($record_id)
                            {
                                $where_record=" topic_id='".$record_id."'";   
								                             
                                $db->query_update("topic", $data_record_batch_extra1,$where_record);                              
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                            else
                            {
									
									if($file_uploaded)
										$data_record_batch_extra1['topic_video'] =$uploaded_url;
									if($file_uploaded1)
										$data_record_batch_extra1['topic_pdf'] =$uploaded_url1;
										
									
										
								
									if($_POST['topic_name'] !='')
									{
										
										
										//$data_record_batch_extra1['fees']=$_POST['fees'];
										$data_record_batch_extra1['added_date'] = date('Y-m-d H:i:s');
										if($data_record_subject['name'] !='')
										{
										$subject_idsss=$db->query_insert("subject", $data_record_subject); // For Inserting new subject
										$data_record_batch_extra1['subject_id'] =$subject_idsss;
										}
										else
										{
											
											$data_record_batch_extra1['subject_id'] =$subject;
										}
										$courses_idsss=$db->query_insert("topic", $data_record_batch_extra1);  
									}
								//===================================Save Multiple Video and pdf===============================
									
									/*$no_of_extra=$_POST['no_of_extra'];
									for($i=0;$i<=$no_of_extra;$i++)
									{
									 if($_POST['course_video'.$i] !='')
									  {
										$data_record_batch_extra['course_video'.$i] =$uploaded_url;
									  }
									
									 if($_POST['course_video'.$i] !='')
									  {
										$data_record_batch_extra['course_pdf'.$i] =$uploaded_url1;
									  }	
									}*/
								//=====================================================================  
									$no_of_extra=$_POST['no_of_extra'];
									for($i=0;$i<=$no_of_extra;$i++)
									{
										if($_POST['topic_name'.$i] !='')
										{
										//$data_record_batch_extra['topic_id'] =$subject;
										$data_record_subject['name'] =$costomize_subject;
										$data_record_subject['description'] =$subject_description;
										$data_record_batch_extra['admin_id'] = $_SESSION['admin_id'];
										$data_record_batch_extra['subject_id'] =$subject;
										$data_record_batch_extra['topic_name']=$_POST['topic_name'.$i];
										$data_record_batch_extra['duration']=$_POST['duration'.$i];
										$data_record_batch_extra['description']=$_POST['description'.$i];
										//$data_record_batch_extra['fees']=$_POST['fees'.$i];
										if($data_record_subject['name'] !='')
										{
										$subject_idsss=$db->query_insert("subject", $data_record_subject); // For Inserting new subject
										$data_record_batch_extra1['subject_id'] =$subject_idsss;
										}
										else
										{
											$data_record_batch_extra1['subject_id'] =$subject;
										}
										//$courses_idsss=$db->query_insert("topic", $data_record_batch_extra1);  
										$data_record_batch_extra1['added_date'] = date('Y-m-d H:i:s');
										$courses_idsss=$db->query_insert("topic", $data_record_batch_extra);  
										}
									}
									echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                            }
                            
							$discount['course_id']=$course_name;
                            $discount['discount']=$discountss;
                            $discount['start_date']=$start_date;
                            $discount['end_date']=$end_date;
                            $discount['status']=$status;
//                            $discount['for_edit']=$_POST['discount_course'];
                            
                            if($topics_id)
								
                               $discount['topic_id']=$topics_id;
                            else 
                                $discount['topic_id']=$record_id;
                            if($val_coupon['discount_coupon_id'] && $_POST['discount_course'] == 'Y')
                            {
                                $where=" discount_coupon_id='".$val_coupon['discount_coupon_id']."'";
                                $db->query_update("discount_coupon", $discount,$where);                                
                            }
                            else if($_POST['discount_course']== 'Y')
                            {
								$where_admin_id="admin_id='". $_SESSION['admin_id']."'";
                                $discount['added_date']=date("Y-m-d H:i:s");
                                $discount_id=$db->query_insert("discount_coupon", $discount);
                            }
                        }
                    }
                    if($success==0)
                    {
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" enctype="multipart/form-data">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
            <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
            
           
           <!-- <tr>
            <td width="20%">Select Subject<span class="orange_font">*</span></td>
            <td width="62%" >
                    <select name="course_id" id="course_id" class="validate[required] input_select"  >  
                        <option value=""> Select Subject </option>
                        <?php
                           /* $select_category = "select * from subject order by subject_id asc";
                            $ptr_category = mysql_query($select_category);
                            while($data_category = mysql_fetch_array($ptr_category))
                            {
                                if($data_category['course_id'] == $row_record['course_id'])
                                    echo '<option value='.$data_category['subject_id'].' selected="selected">'.$data_category['name'].'</option>';
                                else
                                    echo '<option value='.$data_category['subject_id'].'>'.$data_category['name'].'</option>';
                            }*/
                            ?>        
                    </select>
                    </td> 
            </tr> -->
            
            <!--========================================================================-->
            
            <?php
            	if($_SESSION['type']=='S')
                {
                ?>
                      <tr>
                      	<td>Select Branch</td>
                        <td>
                        <?php
						$sel_cm_id="select branch_name from site_setting where cm_id=".$row['cm_id']." ";
						$ptr_query=mysql_query($sel_cm_id);
						$data_branch_nmae=mysql_fetch_array($ptr_query);
                        $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
						$query_branch = mysql_query($sel_branch);
						$total_Branch = mysql_num_rows($query_branch);
						echo '<table width="100%"><tr><td>';
						echo ' <select id="branch_name" name="branch_name" onchange="show_bank(this.value)">';
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
                	<td width="20%"> Select Subject </td>.
               		
                    
                    <td width="80%" class="customized_select_box">  <select name="course_id" id="course_id" class="validate[required] input_select" >  
                        	<option value=""> Select Subject </option>
                        	<?php
                            	$select_category = "select subject_id,name from subject order by subject_id asc";
                            	$ptr_category = mysql_query($select_category);
                            	while($data_category = mysql_fetch_array($ptr_category))
                            	{
                              	  if($data_category['subject_id'] == $row_record['subject_id'])
                                 	   echo '<option value='.$data_category['subject_id'].' selected="selected">'.$data_category['name'].'</option>';
                             	   else
                                 	   echo '<option value='.$data_category['subject_id'].'>'.$data_category['name'].'</option>';
                            	}
                            ?>        
                            <option value="new_course" >New Course</option>
                    		</select>
                    	</td>
                        <tr>
                        		<td></td>
                              <td > <div id="customise"></div></td> 
                        </tr>
              <tr>
              
                <td width="20%"> Add Topic </td>.
                <td width="80%">
                <table width="802">
                <tr><td width="129">Topic Name </td><td width="129">Duration </td><td width="129">Description </td>
                <?php if($record_id ==''){ ?>
                <td width="150" > 
                 <input type="button" name="Add"   class="addBtn" onClick="javascript:add_degree(1);" alt="Add(+)" >
                 <input type="button" name="Add"  class="delBtn"  onClick="javascript:del_degree(1);" alt="Delete(-)" >
                </td>
                <?php 
				}
				?>
                </tr>
                <tr>
                <td> <input type="text" name="topic_name"  class=" validate[required] input_text" id="topic_name"  value="<?php if($_POST['save_changes']) echo $_POST['topic_name']; else echo $row_record['topic_name'];?>"/></td>
                <td><input type="text" name="duration" id="$course_duration"  class=" validate[required] input_text" value="<?php if($_POST['save_changes']) echo $_POST['duration']; else echo $row_record['duration'];?>" /></td>
                <td><input type="text" name="description"  class="input_text" value="<?php if($_POST['save_changes']) echo $_POST['description']; else echo $row_record['description'];?>" /></td>
                
                <?
				/*if(!$record_id)
				{*/
				?>
                	<!--<td><input type="file" name="course_pdf" class="input_text" /></td>-->
                <? 
				/*}
				else{
				
                	echo '<td><input type="file" name="course_pdf" class="input_text" value="'.$row_record['course_pdf'].'"/> </td>';
                
				}*/
				?>
                <!--<td><input type="file" name="course_video" class="input_text" /></td>-->
                </tr>
                </table>
                <input type="hidden" name="no_of_extra" id="extra"  value="0" />
                <div id='1'></div>
                </td>
               
                
                
            </tr>
            <!--========================================================================-->
               
           <!-- <tr>
                <td width="22%">Topic Duration<span class="orange_font">*</span></td>
                <td width="38%"><input type="text" class="validate[required] input_text" name="course_duration" id="course_duration" value="<?php //if($_POST['save_changes']) echo $_POST['course_duration']; else echo $row_record['course_duration'];?>" /></td> 
                <td width="40%"></td>
            </tr>
            <?php
               /* $sql_sub_cat = "select * from courses where course_id='".$row_record['course_id']."' ";
                $data_sub_cat = $db->fetch_array($db->query($sql_sub_cat));
                $implode_data = explode(",",$data_sub_cat['course_author']);            */
             ?>
            
            <tr>
            <td width="22%" valign="top">Topic Description <!--span class="orange_font">*</span </td>
            <td colspan="2">
                    <?php/*
                            include("../FCKeditor/fckeditor.php");
                            $BasePath = "../FCKeditor/";
                            $oFCKeditor 		= new FCKeditor('course_description') ;
                            $oFCKeditor->BasePath	= $BasePath ;
                            if($_POST['save_changes'])
                                $oFCKeditor->Value	= stripslashes($_POST['course_description']);
                            else
                                $oFCKeditor->Value	= stripslashes($row_record['course_description']);
                            //$oFCKeditor->ToolbarSet	= "MyToolBar";
                            $oFCKeditor->Height		= "230";
                            $oFCKeditor->Create() ;*/
                     ?>
                </td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="22%">Is it free course</td>
                <td width="38%">
                    <input type="radio" name="free_course" onchange="showdiv(this.value);" id="free_course" value="Y" <?php //if($_POST['free_course'] == 'Y' || $row_record['free_course'] == 'Y') echo 'checked="checked"';?>/>Yes  &nbsp; &nbsp; 
                    <input type="radio" name="free_course" id="free_course" onchange="showdiv(this.value);" value="N" <?php // if($_POST['free_course'] == 'N' || $row_record['free_course'] == 'N') echo 'checked="checked"';else echo 'checked="checked"';?> />No </td> 
                <td width="40%"></td>
            </tr>
            
            <tr>
                <td width="22%"><div id="coursess" class="coursess" >Topic Fees</div></td>
                
                <td width="38%"><div id="coursess" class="coursess" >
                    <input type="text" class="input_text" name="course_price" id="course_price" value="<?php //if($_POST['save_changes']) echo $_POST['course_price']; else echo $row_record['course_price'];?>" />
                </div>
                </td>                
                <td width="40%"></td>
            </tr>-->
            
            
            <!--<tr>
                <td width="20%">Topic PDF</td>
                <td width="80%"><input type="file" class="input_text" name="course_pdf" id="course_pdf" value=""/></td> 
                
            </tr>
            <tr>
                <td width="20%">Topic video</td>
                <td width="80%"><input type="file" class="input_text" name="course_video" id="course_video" value=""/></td> 
               
            </tr>-->
<!--            <tr><td></td><td colspan="2" class="orange_font"><strong>OR</strong></td></tr>            
            <tr>
                <td width="20%">Youtube Video Url</td>
                <td width="40%"><input type="text" class="input_text" name="course_url" id="course_url" value="<?php// if($_POST['save_changes']) echo $_POST['course_url']; else echo $row_record['course_url'];?>" /></td> 
                <td width="40%"></td>
            </tr>-->
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Topic" name="save_changes"  /></td>
               
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