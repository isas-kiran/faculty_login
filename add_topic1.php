<?php session_start();?>
<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM topic where topic_id='".$record_id."' and admin_id='".$_SESSION['admin_id']."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Course</title>
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
					 	var value='<div id="'+i+'"><table class="table_class" width="58%"  cellspacing="0" cellpadding="2"> <tr style="text-align:center;"><td align="center" ></td><td align="center"><input type="text" name="batch_name'+i+'"  class="input_text" /></td><td><input type="text" name="batch_time'+i+'"  class="input_text" /></td></tr></table></div> <div id="'+next+'"></div>';
						document.getElementById(i).innerHTML= value;
						document.getElementById('extra').value=i;
						}
					 }  
	 function del_sub(del)  // for delete the degree
					 {
						var i=parseInt(document.getElementById('sub').value);
						if(i !=0)
						{
							document.getElementById(i).style.display='none';
							document.getElementById('sub').value=parseInt((i-1));
						}
					 	//document.getElementById(j).style.display='none'; 
						
					 }
			function add_sub(no) //for add a degree
					 {
					 	var i=parseInt(document.getElementById('sub').value);
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
					 	var value='<div id="'+i+'"><table class="table_class" width="58%"  cellspacing="0" cellpadding="2"> <tr style="text-align:center;"><td align="center" ></td><td align="center">Topic Name</td><td><input type="text" name="course_id'+i+'"  class="input_text" /></td></tr></table></div> <div id="'+next+'"></div>';
						document.getElementById(i).innerHTML= value;
						document.getElementById('sub').value=i;
						}
					 }  
	
      </script>
      <script>
function show_subject(subject)
		{
			//alert(subject);
			var data1="show_subject=1&subject="+subject;
				 $.ajax({
            url: "show_topic_multiple.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				
				 document.getElementById('show_subject').innerHTML=html;
			}
			});
		}
		function show_fees(course_id)
		{
			var data1="show_fees=1&course_id="+course_id;
				 $.ajax({
            url: "show_fees.php", type: "post", data: data1, cache: false,
            success: function (retrive_func)
            {
				 document.getElementById('total_fees').innerHTML=retrive_func;
			}
			});
		}
		function show_batch(course_id)
		{
			var data1="show_batch=1&course_id="+course_id;
				 $.ajax({
            url: "show_batch.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				 document.getElementById('batches').innerHTML=html;
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
    <td class="top_mid" valign="bottom"><?php include "include/topic_menu.php"; ?></td>
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
						$subject=$_POST['course_id'];
                        $course_description = $_POST['course_description'];
                        $course_duration=$_POST['course_duration'];
                        $course_level=$_POST['course_level'];
                        $course_video=$_POST['course_video'];
                        $course_pdf=$_POST['course_pdf'];                        
                        $staff_idsss=@implode(",",$_POST['staff_id']);                        
                        $course_duration=$_POST['course_duration'];
                        $category_id = $_POST['category_id'];
                        $free_course = $_POST['free_course'];
                        $course_price = $_POST['course_price'];
                  
                        
                        $discountss=$_POST['discount'];                        
                        $start_date=$_POST['start_date'];
                        $end_date=$_POST['end_date'];
                          
                          
                        $status=$_POST['status'];
                        
                       /* if($course_name =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter course name";
                        }
                        if($course_duration =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter course duration";
                        }  */ 
                       
                        $uploaded_url="";
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
                            
                            $uploaded_url1="";
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
                           
                            // echo $_POST['course_url'];
                            if($_POST['topic_url'] != '')
                            {
                               if(strpos($_POST['topic_url'],"<iframe")!==false)
                               {
                                  // echo '1'.'<br />';
                                   $ex=explode("/", $_POST['topic_url']);
                                   $ex1=explode('"', $ex[4]);
                                   $data_record['topic_url']= $ex1[0];   //$data_record1['course_url'] =   nl2br($_POST['course_url']);
                               }
                               else if(strpos($_POST['topic_url'],"http://")!==false || strpos($_POST['topic_url'],"https://")!==false)
                               {
                                   $ex=explode("/", $_POST['topic_url']);                              
                                   if($ex[2]=='youtu.be')
                                   {
                                       //echo 'sub 1'.'<br />';
                                        $data_record['topic_url']= $ex[3];                                    
                                   }
                                   else
                                   {                                   
                                        //echo 'sub 2<br />';
                                        $ex1=explode('=', $ex[3]);
                                        $data_record['topic_url']=$ex1[1];
                                   }
                               }
                            }
                            $data_record['admin_id'] = $_SESSION['admin_id'];
                            
                            $data_record['topic_name'] =$topic_name;
                            $data_record['description'] =$course_description;
                            $data_record['duration'] =$course_duration;
                            $data_record['subject_id'] =$subject;
							//$data_record['course_id'] =$course_name;
                            //$data_record['category_id'] =$category_id;
                            //$data_record['free_course'] = $free_course;
                            //$data_record['course_price'] = $course_price;
							$data_record['added_date'] = date('Y-m-d H:i:s');
							//========================================================
                            /*echo $total_sub=$_POST['total_checked_question'];
							$concat="";
									
							for($i=1;$i<=$total_sub;$i++)
							{
								$comma="";
								$subject_id =$_POST['subject_id'.$i];
								if($i < $total_sub)
									$comma= ",";
								$concat.=$subject_id.$comma;
							}
								
						echo '<br/>'.$data_record['subject_id']= $concat;*/
							//=========================================================
                            if($file_uploaded)
                                $data_record['topic_video'] =$uploaded_url;
                            if($file_uploaded1)
                                $data_record['topic_pdf'] =$uploaded_url1;
                        
                           // $data_record['teacher_id'] =$staff_idsss;
						   
                            if($record_id)
                            {
                                $where_record=" topic_id='".$record_id."'";   
								                             
                                $db->query_update("topic", $data_record,$where_record);                              
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                            else
                            {
								
									
									$where_admin_id="admin_id='". $_SESSION['admin_id']."'";
                                	$topics_id=$db->query_insert("topic", $data_record);  
									
									
								  /*  $data_record_batch['topic_name']=$_POST['topic_name'];
									$data_record_batch['course_id']=$course_name;
							        $topics_idsss=$db->query_insert("topic", $data_record_batch);  */
								
								$no_of_extra=$_POST['no_of_extra'];
								for($i=0;$i<=$no_of_extra;$i++)
								{
									if($_POST['topic_name'.$i] !='')
									{
									$data_record_batch_extra['topic_name']=$_POST['topic_name'.$i];
									$data_record_batch_extra['course_id']=$course_name;
									
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
              <tr>
                	<td width="22%"> Select Subject </td>.
               <td width="40%">
               	<table width="453">
                	<tr>
                	
                    	
                	</tr>
                	<tr>
                		<td width="40%">  <select name="course_id" id="course_id" class="validate[required] input_select"  >  
                        	<option value=""> Select Subject </option>
                        	<?php
                            	$select_category = "select * from subject order by subject_id asc";
                            	$ptr_category = mysql_query($select_category);
                            	while($data_category = mysql_fetch_array($ptr_category))
                            	{
                              	  if($data_category['course_id'] == $row_record['course_id'])
                                 	   echo '<option value='.$data_category['subject_id'].' selected="selected">'.$data_category['name'].'</option>';
                             	   else
                                 	   echo '<option value='.$data_category['subject_id'].'>'.$data_category['name'].'</option>';
                            	}
                            ?>        
                    		</select>
                    	</td>
                        <td width="154" > 
                 		<input type="button" name="Add"   class="addBtn" onClick="javascript:add_sub(1);" alt="Add(+)" >
                 		<input type="button" name="Add"  class="delBtn"  onClick="javascript:del_sub(1);" alt="Delete(-)" >
                		</td>
                	</tr>
                    <tr>
                 		<td>Topic Name<span class="orange_font">*</span></td>
                		<td width="38%">
                    		<input type="text" class="validate[required] input_text" name="topic_name" id="topic_name" value="<?php if($_POST['save_changes']) echo $_POST[                             'topic_name']; else echo $row_record['topic_name'];?>" />
                		</td> 
                		<td width="40%"></td>
            		</tr>      
                </table>
                	<input type="hidden" name="no_of_extra" id="sub"  value="0" />
                	<div id='1'></div>
              </td>
              <td width="10%"></td>
            </tr>
            <!--========================================================================-->
               
            <tr>
                <td width="22%">Topic Duration<span class="orange_font">*</span></td>
                <td width="38%"><input type="text" class="validate[required] input_text" name="course_duration" id="course_duration" value="<?php if($_POST['save_changes']) echo $_POST['course_duration']; else echo $row_record['course_duration'];?>" /></td> 
                <td width="40%"></td>
            </tr>
            <?php
                $sql_sub_cat = "select * from courses where course_id='".$row_record['course_id']."' ";
                $data_sub_cat = $db->fetch_array($db->query($sql_sub_cat));
                $implode_data = explode(",",$data_sub_cat['course_author']);            
             ?>
            
            <tr>
            <td width="22%" valign="top">Topic Description <!--span class="orange_font">*</span --></td>
            <td colspan="2">
                    <?php
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
                            $oFCKeditor->Create() ;
                     ?>
                </td> 
<!--                <td width="40%"></td>-->
            </tr>
            <!--<tr>
                <td width="22%">Is it free course</td>
                <td width="38%">
                    <input type="radio" name="free_course" onchange="showdiv(this.value);" id="free_course" value="Y" <?php if($_POST['free_course'] == 'Y' || $row_record['free_course'] == 'Y') echo 'checked="checked"';?>/>Yes  &nbsp; &nbsp; 
                    <input type="radio" name="free_course" id="free_course" onchange="showdiv(this.value);" value="N" <?php if($_POST['free_course'] == 'N' || $row_record['free_course'] == 'N') echo 'checked="checked"';else echo 'checked="checked"';?> />No </td> 
                <td width="40%"></td>
            </tr>-->
            
            <tr>
                <td width="22%"><div id="coursess" class="coursess" >Topic Fees</div></td>
                
                <td width="38%"><div id="coursess" class="coursess" >
                    <input type="text" class="input_text" name="course_price" id="course_price" value="<?php if($_POST['save_changes']) echo $_POST['course_price']; else echo $row_record['course_price'];?>" />
                </div>
                </td>                
                <td width="40%"></td>
            </tr>
            
            
            <tr>
                <td width="22%">Topic PDF</td>
                <td width="38%"><input type="file" class="input_text" name="course_pdf" id="course_pdf" value=""/></td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="22%">Topic video</td>
                <td width="38%"><input type="file" class="input_text" name="course_video" id="course_video" value=""/></td> 
                <td width="40%"></td>
            </tr>
<!--            <tr><td></td><td colspan="2" class="orange_font"><strong>OR</strong></td></tr>            
            <tr>
                <td width="20%">Youtube Video Url</td>
                <td width="40%"><input type="text" class="input_text" name="course_url" id="course_url" value="<?php if($_POST['save_changes']) echo $_POST['course_url']; else echo $row_record['course_url'];?>" /></td> 
                <td width="40%"></td>
            </tr>-->
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Course" name="save_changes"  /></td>
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