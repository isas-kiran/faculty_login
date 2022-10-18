<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
//record_id= question_id
//topic_id=topic_id
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT question_img,chapter_id,subject_id FROM question where question_id ='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
	
	$sele_opt_img="select option_image from option_image where question_id='".$record_id."'";
	$ptr_opt_img1=mysql_query($sele_opt_img);
	if(mysql_num_rows($ptr_opt_img1))
	$row_opt_img=mysql_fetch_array($ptr_opt_img1);
	else
	$row_opt_img=0;
}
if($record_id && $_REQUEST['deleteThumbnail'])
{
    $update_ques="update questions_image set question_image='' where question_id='".$record_id."'";
    $db->query($update_ques);
    if($row_record['question_img'] && file_exists("question_photo/".$row_record['question_img']))
        unlink("question_photo/".$row_record['question_img']);
    $row_record=$db->fetch_array($db->query($sql_record));
	
	$update_ques="update question set question_img='' where question_id='".$record_id."'";
    $db->query($update_ques);
    if($row_record['question_img'] && file_exists("question_photo/".$row_record['question_img']))
        unlink("question_photo/".$row_record['question_img']);
    $row_record=$db->fetch_array($db->query($sql_record));
}
if($record_id && $_REQUEST['deleteoption'] && $_REQUEST['option_id'] )
{
	$id=$_REQUEST['option_id'];
    $update_ques="update option_image set option_image".$id."='' where question_id='".$record_id."'";
    //echo $update_events;
    $db->query($update_ques);
    if($row_opt_img['option_image'.$id] && file_exists("question_photo/".$row_opt_img['option_image'.$id]))
        unlink("question_photo/".$row_opt_img['option_image'.$id]);
    $row_opt_img=$db->fetch_array($db->query($sele_opt_img));
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
Question</title>
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
    </script>
    
    <script language="javascript">
		function show_paper(exam_id)
			{
				
	//alert("this is first");
	var url="show_paper.php";
    url=url+"?exam_id="+exam_id;
	//alert(url);
	document.getElementById('textdis').innerHTML = "<p>Please Wait....</p>";
	loadXMLDocUserPaging(url);
}
function loadXMLDocUserPaging(url)
{
	if (window.XMLHttpRequest)
	{
		req = new XMLHttpRequest();
		req.onreadystatechange = processReqChangeUserPaging;
		req.open("GET", url, true);
		req.send(null);
		// branch for IE/Windows ActiveX version
	}
	else if (window.ActiveXObject)
	{
		req = new ActiveXObject("Microsoft.XMLHTTP");
		if (req)
		{
			req.onreadystatechange = processReqChangeUserPaging;
			req.open("GET", url, true);
			req.send();
		}
	}
}

function processReqChangeUserPaging()
{
	// only if req shows "complete"
	
	if (req.readyState == 4)
	{
		// only if "OK"
	
		
		if (req.status == 200)
		{
		
			response = req.responseXML.documentElement;
			var urlpath='';
			
			////alert(response.getElementsByTagName('testingnode')[0].childNodes[x].data); inside for loop
			for(var x = 0; response.getElementsByTagName('urlpath')[0].childNodes[x]; x++ )
			
				 urlpath = urlpath.concat(response.getElementsByTagName('urlpath')[0].childNodes[x].data);			
	//alert(urlpath+"pramod");
			document.getElementById('textdis').innerHTML = urlpath;
		}
		else
		{
			alert("There was a problem retrieving the XML data:\n" + req.statusText);
		}
	}
}

function valid()
{/*
	if(document.getElementById('exam').value=='')
	{
		alert('please select Exam');
		return false
	}*/
	
	if(document.getElementById('paper_id').value=='')
	{
		alert('please Select Paper');
		return false
	}
	
	return true;
}

 function del_degree()
 {
	var j=document.getElementById('extra').value;
	hide_div = parseInt(j) - 1;
	
	document.getElementById(hide_div).style.display='none'; 
	if(hide_div<1)
	{
	hide_div =1;
	}
	document.getElementById('extra').value=hide_div;
	
 }
					 function add_degree()
					 {
					 	//alert(document.getElementById('extra').value);
					 	var i=document.getElementById('extra').value;
						
					 	var next =  parseInt(parseInt(i)+1);
						if(document.getElementById(i).style.display=='none')
						{
							document.getElementById(i).style.display='block';
						}
						else
						{
					 	var value='<div id="'+i+'"><br/><table border="0" style=" border:solid #000099 1px;width:900px""><tr><td  valign="top" ><div align="left">Question '+i+' </div></td><td  colspan="3"><textarea name="question_'+i+'" maxlength="100" size="100" class="input_textarea" ></textarea></td><td  valign="top" ><div align="left">Description </div></td><td  colspan="3"><textarea name="ans_dis_'+i+'" maxlength="100" size="100" class="input_textarea" ></textarea></td><td align="left">Marks</td><td  align="left"><input type="text" name="mark_'+i+'" size="2" maxlength="2" class="input_text"  /></td></tr><tr><td valign="top"><div align="left">Question Image</div></td><td valign="top"><input type="file" name="ques_img_'+i+'" style=" width: 120px;overflow:hidden;" /></td></tr><tr><td  valign="top"><div align="left">Option&nbsp;1</div></td><td width="107"><input type="text" name="option1_'+i+'" size="10" ></td><td  valign="top"><div align="left">Option&nbsp;2</div></td><td width="107"><input type="text" name="option2_'+i+'" size="10"  ></td><td  valign="top"><div align="left">Option&nbsp;3</div></td><td width="107"><input type="text" name="option3_'+i+'" size="10"  ></td><td  valign="top"><div align="left">Option&nbsp;4</div></td><td width="107"><input type="text" name="option4_'+i+'" size="10"  /></td></tr><tr><td></td><td valign="top" colspan="2"><input type="file" name="opt_img1_'+i+'" style=" width: 120px;overflow:hidden;" /></td><td valign="top" colspan="2"><input type="file" name="opt_img2_'+i+'" style=" width: 120px;overflow:hidden;" /></td><td valign="top" colspan="2"><input type="file" name="opt_img3_'+i+'" style=" width: 120px;overflow:hidden;" /></td><td valign="top" colspan="2"><input type="file" name="opt_img4_'+i+'" style=" width: 120px;overflow:hidden;" /></td></tr><tr><td  valign="top"><div align="left">Answer</div></td><td width="107"><input type="radio" name="right_ans_'+i+'" value="1_'+i+'" ></td><td  valign="top"><div align="left"> </div></td><td width="107"><input type="radio" name="right_ans_'+i+'" value="2_'+i+'"  /></td><td  valign="top"><div align="left"></div></td><td width="107"><input type="radio" name="right_ans_'+i+'" value="3_'+i+'"></td><td  valign="top"><div align="left"></div></td><td width="107"><input type="radio" name="right_ans_'+i+'" value="4_'+i+'" /></td><td  valign="top"><div align="left"> </div></td></tr></table></div> <div id="'+next+'"></div>';
						document.getElementById(i).innerHTML= value;
						document.getElementById('extra').value=next;
						//alert(document.getElementById('extra').value);
						}
					 }
</script>
<!--***************************************************************************************************************************-->
<script>
function showUser(str)
{
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");					
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getuser.php?q="+str,true);
xmlhttp.send();
}
</script>
   <!--***************************************************************************************************************************-->
<script>
function showBatch(str)
{
if (str=="")
  {
  document.getElementById("txtHint1").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");					
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint1").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","get_batch.php?q="+str,true);
xmlhttp.send();
}
</script>
<script>
function show_subject(subject)
		{
//alert(subject);
var data1="show_subject=1&subject="+subject;
 $.ajax({
url: "show_subjects.php", type: "post", data: data1, cache: false,
success: function (html)
{
 document.getElementById('show_subject').innerHTML=html;
}
});
 }
 
 function show_chapter(subject_id)
 {
	
	 //alert(subject_id);
	 var course="show_chapter=1&subject_id="+subject_id;
	 //alert(course);
	 <? if($row_record !='')
	 { ?>
	 var topic_id= document.getElementById('topic_id').value
	 //alert(topic_id);
	 <? }else{?>
	 var topic_id=0;
	 <? }?>
	 $.ajax({
		 url: "show_chapter.php?topic_id="+topic_id, type: "post", data: course, cache:false,
		 success: function (chapters)
		 {
			 document.getElementById('show_chapter').innerHTML=chapters;
		 }
	 });
 }
	</script>
    <script>
	function show_news(valuesss,idss)
	{
	if(valuesss=='new_dist')
	document.getElementById('new_dist'+idss).style.display="block";
	else
	document.getElementById('new_dist'+idss).style.display="none";
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
    <td class="top_mid" valign="bottom"><?php include "include/exams_menu.php"; ?></td>
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
                        $chapter_id=$_POST['chapter_id'];
						$subject_id=$_POST['subject_id'];
						$diffculty=$_POST['diffculty'];
                      	$ques_img=$_POST['ques_img'];
						$opt_img1=$_POST['opt_img1'];
						$opt_img2=$_POST['opt_img2'];
						$opt_img3=$_POST['opt_img3'];
						$opt_img4=$_POST['opt_img4'];
						
                        if($chapter_id =="")
                        {
                                $success=0;
                                $errors[$i++]="Please Select Topic";
                        }
						if($diffculty =="")
                        {
                                $success=0;
                                $errors[$i++]="Please Select Diffculty level";
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
							
                            if($record_id)
							{
							if(addslashes($_POST['question']) !="")
							{
						
							if($_POST['new_dist']!='')
							{
								$insert_district="UPDATE `topic` set topic_name='".$_POST['new_dist']."',subject_id='".$_POST['subject_id']."' where topic_id='".$_GET['topic_id']."' ";
								$ptr_query=mysql_query($insert_district);
								$insert_district=mysql_query($insert_district);
								 
								 
				echo '<br>'.$insert_query = "update question set question_title='".addslashes($_POST['question'])."',ans_dis='".addslashes($_POST['ans_dis'])."',mark='".addslashes($_POST['mark'])."' where question_id='".$record_id."' and subject_id ='".$_POST['subject_id']."' and chapter_id='".$_GET['topic_id']."' ";
							$insert_ptr=mysql_query($insert_query);
							$msg= "<center><font color='green'>Question Added successfully..!</font></center>";
						
							$question_id=mysql_insert_id();
							$right_ans = $_POST['right_ans'];	
							for($i=1;$i<4;$i++)
							{		
							$ans ='';		
							$option = $_POST['option'.$i];	
							if($right_ans ==$i)
							{
							$ans ='y';
							}
							if($option !='')
							{
							'<br>'. $insert_options = " update options set option_title='".$option."',answer='".$ans."' where question_id='".$record_id."' ";
							$pts_option_extra = mysql_query($insert_options);
							}
						}
							
	//////////////=============CODE FOR MULTIPLE QUESTION==========////////
	
	//////////////=============END CODE FOR MULTIPLE QUESTION==========////////
					
							}
							else
							{
				 '<br>'.$insert_query = "update question set question_title='".addslashes($_POST['question'])."',ans_dis='".addslashes($_POST['ans_dis'])."',mark='".addslashes($_POST['mark'])."' where question_id='".$record_id."' and subject_id ='".$_POST['subject_id']."' and chapter_id='".$_GET['topic_id']."'";
							$insert_ptr=mysql_query($insert_query);
							$msg= "<center><font color='green'>Question Added successfully..!</font></center>";
						
							$question_id=mysql_insert_id();
							$de_option="DELETE FROM `options` WHERE question_id='".$record_id."'";
							$ptr_del=mysql_query($de_option);
							 '<br>'.$right_ans = $_POST['right_ans'];	
							for($i=1;$i<5;$i++)
							{		
								$ans ='';		
								$option = $_POST['option'.$i];	
								if($right_ans ==$i)
								{
								$ans ='y';
								}
								if($option !='')
								{
								 '<br>'. $insert_options = " insert into options values(0,'".$_SESSION['admin_id']."','".$record_id."',
							'".$_POST['paper_id']."','".$_POST['exam_id']."','".$option."','$ans')";
								$pts_option_extra = mysql_query($insert_options);
								}
							}
							}
						
							}
							else
							{
								$msg= "<center><font color='red'>Question Should Not Blank and atleast insert two option and answer too...!</font></center>";
							}
							  
								echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
							
								//$where_record=" form_id='".$record_id."'";                                
							   // $db->query_update("forms", $data_record,$where_record);                              
							   // echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                            else ///record id
                            {
                              if(addslashes($_POST['question']) !="")
							  {
							
								$check_exist = "select question_id from question where question_title ='".addslashes($_POST['question'])."' 
								and exam_id='".$_POST['exam_id']."' and  paper_id='".$_POST['paper_id']."' ";
								
								$ptr_check = mysql_query($check_exist);
								$count = mysql_num_rows($ptr_check);
								if($count !=0)
								{
									$msg= "<center><font color='red'>Question Already Exist...!</font></center>";
								}
								else
								{
									if($_POST['new_dist']!='')
									{
									//===========================FOR QUESTION IMAGE=======================================
										$uploaded_url_ques=time().basename($_FILES['ques_img']["name"]);
                                		$newfile = "question_photo/";
										$filename = $_FILES['ques_img']['tmp_name']; // File being uploaded.
										$filetype = $_FILES['ques_img']['type'];// type of file being uploaded
										$filesize = filesize($filename); // File size of the file being uploaded.
										$source1 = $_FILES['ques_img']['tmp_name'];
										$target_path1 = $newfile.$uploaded_url_ques;
										if($filename !='')
										{
											list($width1, $height1, $type1, $attr1) = getimagesize($source1);
											if(strtolower($filetype) == "image/jpeg" || strtolower($filetype) == "image/pjpeg" || strtolower($filetype) == "image/GIF" || strtolower($filetype) == "image/gif" || strtolower($filetype) == "image/png")
											{
												
												if(move_uploaded_file($source1, $target_path1))
												{
													$file_uploaded=1;
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
									//==============================END QUESTION IMAGE======================================================	
									//===========================FOR OPTION =======================================
										//OPTION 1
									
										$uploaded_url_opt1=time().basename($_FILES['opt_img1']["name"]);
                                		$newfile1 = "question_photo/";
										$filename1 = $_FILES['opt_img1']['tmp_name']; // File being uploaded.
										$filetype1= $_FILES['opt_img1']['type'];// type of file being uploaded
										$filesize1 = filesize($filename1); // File size of the file being uploaded.
										$source11 = $_FILES['opt_img1']['tmp_name'];
										$target_path11 = $newfile1.$uploaded_url_opt1;
		
										if(strtolower($filetype1) == "image/jpeg" || strtolower($filetype1) == "image/pjpeg" || strtolower($filetype1) == "image/GIF" || strtolower($filetype1) == "image/gif" || strtolower($filetype1) == "image/png")
										{
											
											if(move_uploaded_file($source11, $target_path11))
											{
												$file_uploaded=1;
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
										
										//OPTION 2
									
										$uploaded_url_opt2=time().basename($_FILES['opt_img2']["name"]);
                                		$newfile2 = "question_photo/";
										$filename2 = $_FILES['opt_img2']['tmp_name']; // File being uploaded.
										$filetype2 = $_FILES['opt_img2']['type'];// type of file being uploaded
										$filesize2 = filesize($filename2); // File size of the file being uploaded.
										$source12 = $_FILES['opt_img2']['tmp_name'];
										$target_path12 = $newfile2.$uploaded_url_opt2;
		
										if(strtolower($filetype2) == "image/jpeg" || strtolower($filetype2) == "image/pjpeg" || strtolower($filetype2) == "image/GIF" || strtolower($filetype2) == "image/gif" || strtolower($filetype2) == "image/png")
										{
											
											if(move_uploaded_file($source12, $target_path12))
											{
												$file_uploaded=1;
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
										
										//OPTION 3
									
										$uploaded_url_opt3=time().basename($_FILES['opt_img3']["name"]);
                                		$newfile3 = "question_photo/";
										$filename3 = $_FILES['opt_img3']['tmp_name']; // File being uploaded.
										$filetype3 = $_FILES['opt_img3']['type'];// type of file being uploaded
										$filesize3 = filesize($filename3); // File size of the file being uploaded.
										$source13 = $_FILES['opt_img3']['tmp_name'];
										$target_path13 = $newfile3.$uploaded_url_opt3;
		
										if(strtolower($filetype3) == "image/jpeg" || strtolower($filetype3) == "image/pjpeg" || strtolower($filetype3) == "image/GIF" || strtolower($filetype3) == "image/gif" || strtolower($filetype3) == "image/png")
										{
											
											if(move_uploaded_file($source13, $target_path13))
											{
												$file_uploaded=1;
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
										
										//OPTION 4
									
										$uploaded_url_opt4=time().basename($_FILES['opt_img4']["name"]);
                                		$newfile4 = "question_photo/";
										$filename4 = $_FILES['opt_img4']['tmp_name']; // File being uploaded.
										$filetype4 = $_FILES['opt_img4']['type'];// type of file being uploaded
										$filesize4 = filesize($filename4); // File size of the file being uploaded.
										$source14 = $_FILES['opt_img4']['tmp_name'];
										$target_path14 = $newfile4.$uploaded_url_opt4;
		
										if(strtolower($filetype4) == "image/jpeg" || strtolower($filetype4) == "image/pjpeg" || strtolower($filetype4) == "image/GIF" || strtolower($filetype4) == "image/gif" || strtolower($filetype4) == "image/png")
										{
											
											if(move_uploaded_file($source14, $target_path14))
											{
												$file_uploaded=1;
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
									//==============================END OPTION IMAGE======================================================		
										
										$insert_district="INSERT INTO `topic` (`topic_name`, `subject_id`,`admin_id`)
										VALUES ('".$_POST['new_dist']."', '".$_POST['subject_id']."','".$_SESSION['admin_id']."');";
										$ptr_query=mysql_query($insert_district);
										$insert_district=mysql_query($insert_district);
										 
										 
										$insert_query = "insert into question values(0,'".$_SESSION['admin_id']."','".$_POST['paper_id']."','".$_POST['exam_id']."','".$_POST['course_id']."','".$_POST['users']."','".$_POST['div']."','".$_POST['subject_id']."','".addslashes($_POST['question'])."','".addslashes($_POST['ans_dis'])."','".addslashes($_POST['mark'])."','".$uploaded_url."','".$insert_district."')";
										$insert_ptr=mysql_query($insert_query);
										$question_id=mysql_insert_id();
										
										$ins_diff="insert into question_difficulties (`question_id`,`diffculty`) values ('".$question_id."','".$_POST['diffculty']."')";
										$ptr_diff=mysql_query($ins_diff);
										
										$ins_img_ques="insert into questions_image (`question_id`,`question_image`) values ('".$question_id."','".$_POST['ques_img']."')";
										$ptr_img1=mysql_query($ins_img_ques);
										
										 "<br>1- ".$ins_img="insert into option_image (`question_id`,`option_image1`,`option_image2`,`option_image3`,`option_image4`) values ('".$question_id."','".$_POST['opt_img1']."','".$_POST['opt_img2']."','".$_POST['opt_img3']."','".$_POST['opt_img4']."')";
										$ptr_img=mysql_query($ins_img);
										
										$right_ans = $_POST['right_ans'];	
										for($i=1;$i<5;$i++)
										{		
										$ans ='';		
										$option = $_POST['option'.$i];	
										if($right_ans ==$i)
										{
										$ans ='y';
										}
										if($option !='')
										{
										$insert_options = " insert into options values(0,'".$_SESSION['admin_id']."','".$question_id."',
										'".$_POST['paper_id']."','".$_POST['exam_id']."','".$option."','$ans')";
										$pts_option_extra = mysql_query($insert_options);
										}
										$msg= "<center><font color='green'>Question Added successfully..!</font></center>";
								}
							
						//////////////=============CODE FOR MULTIPLE QUESTION==========////////
											
						$no_of_extra = $_POST['no_of_extra'];
						for($j=1;$j<$no_of_extra;$j++)
						if(	(addslashes($_POST['question_'.$j]) !="") )
						{			
							$check_exist_extra = "select question_id from  question  where question_title ='".addslashes($_POST['question_'.$j])."' 
							and exam_id='".$_POST['exam_id']."'  and  paper_id='".$_POST['paper_id']."' ";
							
							$ptr_check_extra = mysql_query($check_exist_extra);
							$count_extra = mysql_num_rows($ptr_check_extra);
							if($count_extra !=0)
							{
								$msg= "<center><font color='red'>Question Already Exist...!</font></center>";
							}
							else
							{
							//===========================FOR QUESTION IMAGE=======================================
							$uploaded_url_ques1=time().basename($_FILES['ques_img_'.$j.'']["name"]);
							$newfile = "question_photo/";
							$filename = $_FILES['ques_img_'.$j.'']['tmp_name']; // File being uploaded.
							$filetype = $_FILES['ques_img_'.$j.'']['type'];// type of file being uploaded
							$source1 = $_FILES['ques_img_'.$j.'']['tmp_name'];
							$target_path1 = $newfile.$uploaded_url_ques1;

							if(strtolower($filetype) == "image/jpeg" || strtolower($filetype) == "image/pjpeg" || strtolower($filetype) == "image/GIF" || strtolower($filetype) == "image/gif" || strtolower($filetype) == "image/png")
							{
								
								if(move_uploaded_file($source1, $target_path1))
								{
									$file_uploaded=1;
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
						//==============================END QUESTION IMAGE======================================================	
						//===========================FOR OPTION =======================================
							//OPTION 1
						
							$uploaded_url_opt1=time().basename($_FILES['opt_img1_'.$j.'']["name"]);
							$newfile1 = "question_photo/";
							$filename1 = $_FILES['opt_img1_'.$j.'']['tmp_name']; // File being uploaded.
							$filetype1= $_FILES['opt_img1_'.$j.'']['type'];// type of file being uploaded
							$filesize1 = filesize($filename1); // File size of the file being uploaded.
							$source11 = $_FILES['opt_img1_'.$j.'']['tmp_name'];
							$target_path11 = $newfile1.$uploaded_url_opt1;
	
							if(strtolower($filetype1) == "image/jpeg" || strtolower($filetype1) == "image/pjpeg" || strtolower($filetype1) == "image/GIF" || strtolower($filetype1) == "image/gif" || strtolower($filetype1) == "image/png")
							{
								
								if(move_uploaded_file($source11, $target_path11))
								{
									$file_uploaded=1;
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
							
							//OPTION 2
						
							$uploaded_url_opt2=time().basename($_FILES['opt_img2_'.$j.'']["name"]);
							$newfile2 = "question_photo/";
							$filename2 = $_FILES['opt_img2_'.$j.'']['tmp_name']; // File being uploaded.
							$filetype2 = $_FILES['opt_img2_'.$j.'']['type'];// type of file being uploaded
							$filesize2 = filesize($filename2); // File size of the file being uploaded.
							$source12 = $_FILES['opt_img2_'.$j.'']['tmp_name'];
							$target_path12 = $newfile2.$uploaded_url_opt2;
	
							if(strtolower($filetype2) == "image/jpeg" || strtolower($filetype2) == "image/pjpeg" || strtolower($filetype2) == "image/GIF" || strtolower($filetype2) == "image/gif" || strtolower($filetype2) == "image/png")
							{
								
								if(move_uploaded_file($source12, $target_path12))
								{
									$file_uploaded=1;
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
							
							//OPTION 3
						
							$uploaded_url_opt3=time().basename($_FILES['opt_img3_'.$j.'']["name"]);
							$newfile3 = "question_photo/";
							$filename3 = $_FILES['opt_img3_'.$j.'']['tmp_name']; // File being uploaded.
							$filetype3 = $_FILES['opt_img3_'.$j.'']['type'];// type of file being uploaded

							$filesize3 = filesize($filename3); // File size of the file being uploaded.
							$source13 = $_FILES['opt_img3_'.$j.'']['tmp_name'];
							$target_path13 = $newfile3.$uploaded_url_opt3;
	
							if(strtolower($filetype3) == "image/jpeg" || strtolower($filetype3) == "image/pjpeg" || strtolower($filetype3) == "image/GIF" || strtolower($filetype3) == "image/gif" || strtolower($filetype3) == "image/png")
							{
								
								if(move_uploaded_file($source13, $target_path13))
								{
									$file_uploaded=1;
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
							
							//OPTION 4
						
							$uploaded_url_opt4=time().basename($_FILES['opt_img4_'.$j.'']["name"]);
							$newfile4 = "question_photo/";
							$filename4 = $_FILES['opt_img4_'.$j.'']['tmp_name']; // File being uploaded.
							$filetype4 = $_FILES['opt_img4_'.$j.'']['type'];// type of file being uploaded
							$filesize4 = filesize($filename4); // File size of the file being uploaded.
							$source14 = $_FILES['opt_img4_'.$j.'']['tmp_name'];
							$target_path14 = $newfile4.$uploaded_url_opt4;
	
							if(strtolower($filetype4) == "image/jpeg" || strtolower($filetype4) == "image/pjpeg" || strtolower($filetype4) == "image/GIF" || strtolower($filetype4) == "image/gif" || strtolower($filetype4) == "image/png")
							{
								
								if(move_uploaded_file($source14, $target_path14))
								{
									$file_uploaded=1;
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
						//==============================END OPTION IMAGE======================================================						
						$insert_query_extra = "insert into question (`admin_id`,`paper_id`,`exam_id`,`course_id`,`add_class_id`,`div_id`,`subject_id`,`question_title`,`ans_dis`,`mark`,`question_img`,`chapter_id`) values
('".$_SESSION['admin_id']."','".$_POST['paper_id']."','".$_POST['exam_id']."','".$_POST['course_id']."','".$_POST['users']."','".$_POST['div']."','".$_POST['subject_id']."','".addslashes($_POST['question_'.$j])."','".addslashes($_POST['ans_dis_'.$j])."','".addslashes($_POST['mark_'.$j])."','".$uploaded_url_ques1."','".$_POST['chapter_id']."')";
						$insert_ptr_extra=mysql_query($insert_query_extra);
						$question_id=mysql_insert_id();
						
						$ins_diff="insert into question_difficulties (`question_id`,`diffculty`) values ('".$question_id."','".$_POST['diffculty']."')";
						$ptr_diff=mysql_query($ins_diff);
						
						$ins_img_ques="insert into questions_image (`question_id`,`question_image`) values ('".$question_id."','".$uploaded_url_ques."')";
						$ptr_img1=mysql_query($ins_img_ques);
						
						$ins_img="insert into option_image (`question_id`,`option_image1`,`option_image2`,`option_image3`,`option_image4`) values ('".$question_id."','".$uploaded_url_opt1."','".$uploaded_url_opt2."','".$uploaded_url_opt3."','".$uploaded_url_opt4."')";
						$ptr_img=mysql_query($ins_img);
									
						$right_ans = $_POST['right_ans_'.$j];	
						
						for($i=1;$i<5;$i++)
						{		
						$ans ='';		
						$option = $_POST['option'.$i.'_'.$j];	
						
						if($right_ans ==$i)
						{
						$ans ='y';
						}
						if($option !='')
						{
						$insert_options_extra = " insert into options values(0,'".$_SESSION['admin_id']."','".$question_id."','".$_POST['paper_id']."',
						'".$_POST['exam_id']."','".$option."','$ans')";
						$pts_option_extra = mysql_query($insert_options_extra);
						}
						}	
						}
						$msg= "<center><font color='green'>Question Added successfully..!</font></center>";
						
						}
						//////////////=============END CODE FOR MULTIPLE QUESTION==========////////
					
							}
							else
							{
							//===========================FOR QUESTION IMAGE=======================================
										$uploaded_url_ques=time().basename($_FILES['ques_img']["name"]);
                                		$newfile = "question_photo/";
										$filename = $_FILES['ques_img']['tmp_name']; // File being uploaded.
										$filetype = $_FILES['ques_img']['type'];// type of file being uploaded
										$filesize = filesize($filename); // File size of the file being uploaded.
										$source1 = $_FILES['ques_img']['tmp_name'];
										$target_path1 = $newfile.$uploaded_url_ques;
										if($filename !='')
										{
											list($width1, $height1, $type1, $attr1) = getimagesize($source1);
											if(strtolower($filetype) == "image/jpeg" || strtolower($filetype) == "image/pjpeg" || strtolower($filetype) == "image/GIF" || strtolower($filetype) == "image/gif" || strtolower($filetype) == "image/png")
											{
												
												if(move_uploaded_file($source1, $target_path1))
												{
													$file_uploaded=1;
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
									//==============================END QUESTION IMAGE======================================================	
									//===========================FOR OPTION =======================================
										//OPTION 1
									
										$uploaded_url_opt1=time().basename($_FILES['opt_img1']["name"]);
                                		$newfile1 = "question_photo/";
										$filename1 = $_FILES['opt_img1']['tmp_name']; // File being uploaded.
										$filetype1= $_FILES['opt_img1']['type'];// type of file being uploaded
										$filesize1 = filesize($filename1); // File size of the file being uploaded.
										$source11 = $_FILES['opt_img1']['tmp_name'];
										$target_path11 = $newfile1.$uploaded_url_opt1;
		
										if(strtolower($filetype1) == "image/jpeg" || strtolower($filetype1) == "image/pjpeg" || strtolower($filetype1) == "image/GIF" || strtolower($filetype1) == "image/gif" || strtolower($filetype1) == "image/png")
										{
											
											if(move_uploaded_file($source11, $target_path11))
											{
												$file_uploaded=1;
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
										
										//OPTION 2
									
										$uploaded_url_opt2=time().basename($_FILES['opt_img2']["name"]);
                                		$newfile2 = "question_photo/";
										$filename2 = $_FILES['opt_img2']['tmp_name']; // File being uploaded.
										$filetype2 = $_FILES['opt_img2']['type'];// type of file being uploaded
										$filesize2 = filesize($filename2); // File size of the file being uploaded.
										$source12 = $_FILES['opt_img2']['tmp_name'];
										$target_path12 = $newfile2.$uploaded_url_opt2;
		
										if(strtolower($filetype2) == "image/jpeg" || strtolower($filetype2) == "image/pjpeg" || strtolower($filetype2) == "image/GIF" || strtolower($filetype2) == "image/gif" || strtolower($filetype2) == "image/png")
										{
											
											if(move_uploaded_file($source12, $target_path12))
											{
												$file_uploaded=1;
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
										
										//OPTION 3
									
										$uploaded_url_opt3=time().basename($_FILES['opt_img3']["name"]);
                                		$newfile3 = "question_photo/";
										$filename3 = $_FILES['opt_img3']['tmp_name']; // File being uploaded.
										$filetype3 = $_FILES['opt_img3']['type'];// type of file being uploaded
										$filesize3 = filesize($filename3); // File size of the file being uploaded.
										$source13 = $_FILES['opt_img3']['tmp_name'];
										$target_path13 = $newfile3.$uploaded_url_opt3;
		
										if(strtolower($filetype3) == "image/jpeg" || strtolower($filetype3) == "image/pjpeg" || strtolower($filetype3) == "image/GIF" || strtolower($filetype3) == "image/gif" || strtolower($filetype3) == "image/png")
										{
											
											if(move_uploaded_file($source13, $target_path13))
											{
												$file_uploaded=1;
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
										
										//OPTION 4
									
										$uploaded_url_opt4=time().basename($_FILES['opt_img4']["name"]);
                                		$newfile4 = "question_photo/";
										$filename4 = $_FILES['opt_img4']['tmp_name']; // File being uploaded.
										$filetype4 = $_FILES['opt_img4']['type'];// type of file being uploaded
										$filesize4 = filesize($filename4); // File size of the file being uploaded.
										$source14 = $_FILES['opt_img4']['tmp_name'];
										$target_path14 = $newfile4.$uploaded_url_opt4;
		
										if(strtolower($filetype4) == "image/jpeg" || strtolower($filetype4) == "image/pjpeg" || strtolower($filetype4) == "image/GIF" || strtolower($filetype4) == "image/gif" || strtolower($filetype4) == "image/png")
										{
											
											if(move_uploaded_file($source14, $target_path14))
											{
												$file_uploaded=1;
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
									//==============================END OPTION IMAGE======================================================	
										
							 $insert_query = "insert into question (`admin_id`,`paper_id`,`exam_id`,`course_id`,`add_class_id`,`div_id`,`subject_id`,`question_title`,`ans_dis`,`mark`,`question_img`,`chapter_id`)values
('".$_SESSION['admin_id']."','".$_POST['paper_id']."','".$_POST['exam_id']."','".$_POST['course_id']."','".$_POST['users']."','".$_POST['div']."','".$_POST['subject_id']."','".addslashes($_POST['question'])."','".addslashes($_POST['ans_dis'])."','".addslashes($_POST['mark'])."','".$uploaded_url_ques."','".$_POST['chapter_id']."')";

							$insert_ptr=mysql_query($insert_query);
							$question_id=mysql_insert_id();
							
							$ins_diff="insert into question_difficulties (`question_id`,`diffculty`) values ('".$question_id."','".$_POST['diffculty']."')";
							$ptr_diff=mysql_query($ins_diff);
							
							$ins_img_ques="insert into questions_image (`question_id`,`question_image`) values ('".$question_id."','".$uploaded_url_ques."')";
							$ptr_img1=mysql_query($ins_img_ques);
							
							$ins_img="insert into option_image (`question_id`,`option_image1`,`option_image2`,`option_image3`,`option_image4`) values ('".$question_id."','".$uploaded_url_opt1."','".$uploaded_url_opt2."','".$uploaded_url_opt3."','".$uploaded_url_opt4."')";
							$ptr_img=mysql_query($ins_img);

							$right_ans = $_POST['right_ans'];	
							for($i=1;$i<5;$i++)
							{		
							$ans ='';
							$option_image1='';		
							$option = $_POST['option'.$i];	
							$option_image1=$uploaded_url_opt.$i;
							if($right_ans ==$i)
							{
							$ans ='y';
							}
							if($option !='' || $option_image !='' )
							{
							"<br />single- ".$insert_options = " insert into options (`admin_id`,`question_id`,`paper_id`,`exam_id`,`option_title`,`option_image`,`answer`)
							 values('".$_SESSION['admin_id']."','".$question_id."','".$_POST['paper_id']."','".$_POST['exam_id']."','".$option."','".$option_image1."','$ans')";
							$pts_option_extra = mysql_query($insert_options);
							}
							$msg= "<center><font color='green'>Question Added successfully..!</font></center>";
						}
							
						//////////////=============CODE FOR MULTIPLE QUESTION==========////////
											
						$no_of_extra = $_POST['no_of_extra'];
						for($j=1;$j<$no_of_extra;$j++)
						if(
						(addslashes($_POST['question_'.$j]) !="" /*&& $_POST['mark_'.$j] !="" ) && $_POST['right_ans_'.$j] !='' &&  (addslashes($_POST['option1_'.$j]) !="" || addslashes($_POST['option2_'.$j]) !="" || addslashes($_POST['option_'.$j]) !="" && 
						addslashes($_POST['option4_'.$j]) !="" &&  addslashes($_POST['option5_'.$j]) !=""*/ )
						)
						{			
						 '<br>'.$check_exist_extra = "select question_id from  question  where question_title ='".addslashes($_POST['question_'.$j])."' 
						and exam_id='".$_POST['exam_id']."'  and  paper_id='".$_POST['paper_id']."' ";
						
						$ptr_check_extra = mysql_query($check_exist_extra);
						$count_extra = mysql_num_rows($ptr_check_extra);
						if($count_extra !=0)
						{
						$msg= "<center><font color='red'>Question Already Exist...!</font></center>";
						}
						else
						{
						//===========================FOR QUESTION IMAGE=======================================
							$uploaded_url_ques1=time().basename($_FILES['ques_img_'.$j.'']["name"]);
							$newfile = "question_photo/";
							$filename = $_FILES['ques_img_'.$j.'']['tmp_name']; // File being uploaded.
							$filetype = $_FILES['ques_img_'.$j.'']['type'];// type of file being uploaded
							$source1 = $_FILES['ques_img_'.$j.'']['tmp_name'];
							$target_path1 = $newfile.$uploaded_url_ques1;

							if(strtolower($filetype) == "image/jpeg" || strtolower($filetype) == "image/pjpeg" || strtolower($filetype) == "image/GIF" || strtolower($filetype) == "image/gif" || strtolower($filetype) == "image/png")
							{
								
								if(move_uploaded_file($source1, $target_path1))
								{
									$file_uploaded=1;
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
						//==============================END QUESTION IMAGE======================================================	
						//===========================FOR OPTION =======================================
							//OPTION 1
						
							$uploaded_url_opt1=time().basename($_FILES['opt_img1_'.$j.'']["name"]);
							$newfile1 = "question_photo/";
							$filename1 = $_FILES['opt_img1_'.$j.'']['tmp_name']; // File being uploaded.
							$filetype1= $_FILES['opt_img1_'.$j.'']['type'];// type of file being uploaded
							$filesize1 = filesize($filename1); // File size of the file being uploaded.
							$source11 = $_FILES['opt_img1_'.$j.'']['tmp_name'];
							$target_path11 = $newfile1.$uploaded_url_opt1;
	
							if(strtolower($filetype1) == "image/jpeg" || strtolower($filetype1) == "image/pjpeg" || strtolower($filetype1) == "image/GIF" || strtolower($filetype1) == "image/gif" || strtolower($filetype1) == "image/png")
							{
								
								if(move_uploaded_file($source11, $target_path11))
								{
									$file_uploaded=1;
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
							
							//OPTION 2
						
							$uploaded_url_opt2=time().basename($_FILES['opt_img2_'.$j.'']["name"]);
							$newfile2 = "question_photo/";
							$filename2 = $_FILES['opt_img2_'.$j.'']['tmp_name']; // File being uploaded.
							$filetype2 = $_FILES['opt_img2_'.$j.'']['type'];// type of file being uploaded
							$filesize2 = filesize($filename2); // File size of the file being uploaded.
							$source12 = $_FILES['opt_img2_'.$j.'']['tmp_name'];
							$target_path12 = $newfile2.$uploaded_url_opt2;
	
							if(strtolower($filetype2) == "image/jpeg" || strtolower($filetype2) == "image/pjpeg" || strtolower($filetype2) == "image/GIF" || strtolower($filetype2) == "image/gif" || strtolower($filetype2) == "image/png")
							{
								
								if(move_uploaded_file($source12, $target_path12))
								{
									$file_uploaded=1;
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
							
							//OPTION 3
						
							$uploaded_url_opt3=time().basename($_FILES['opt_img3_'.$j.'']["name"]);
							$newfile3 = "question_photo/";
							$filename3 = $_FILES['opt_img3_'.$j.'']['tmp_name']; // File being uploaded.
							$filetype3 = $_FILES['opt_img3_'.$j.'']['type'];// type of file being uploaded
							$filesize3 = filesize($filename3); // File size of the file being uploaded.
							$source13 = $_FILES['opt_img3_'.$j.'']['tmp_name'];
							$target_path13 = $newfile3.$uploaded_url_opt3;
	
							if(strtolower($filetype3) == "image/jpeg" || strtolower($filetype3) == "image/pjpeg" || strtolower($filetype3) == "image/GIF" || strtolower($filetype3) == "image/gif" || strtolower($filetype3) == "image/png")
							{
								
								if(move_uploaded_file($source13, $target_path13))
								{
									$file_uploaded=1;
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
							
							//OPTION 4
						
							$uploaded_url_opt4=time().basename($_FILES['opt_img4_'.$j.'']["name"]);
							$newfile4 = "question_photo/";
							$filename4 = $_FILES['opt_img4_'.$j.'']['tmp_name']; // File being uploaded.
							$filetype4 = $_FILES['opt_img4_'.$j.'']['type'];// type of file being uploaded
							$filesize4 = filesize($filename4); // File size of the file being uploaded.
							$source14 = $_FILES['opt_img4_'.$j.'']['tmp_name'];
							$target_path14 = $newfile4.$uploaded_url_opt4;
	
							if(strtolower($filetype4) == "image/jpeg" || strtolower($filetype4) == "image/pjpeg" || strtolower($filetype4) == "image/GIF" || strtolower($filetype4) == "image/gif" || strtolower($filetype4) == "image/png")
							{
								
								if(move_uploaded_file($source14, $target_path14))
								{
									$file_uploaded=1;
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
						//==============================END OPTION IMAGE======================================================						
						$insert_query_extra = "insert into question (`admin_id`,`paper_id`,`exam_id`,`course_id`,`add_class_id`,`div_id`,`subject_id`,`question_title`,`ans_dis`,`mark`,`question_img`,`chapter_id`) values
('".$_SESSION['admin_id']."','".$_POST['paper_id']."','".$_POST['exam_id']."','".$_POST['course_id']."','".$_POST['users']."','".$_POST['div']."','".$_POST['subject_id']."','".addslashes($_POST['question_'.$j])."','".addslashes($_POST['ans_dis_'.$j])."','".addslashes($_POST['mark_'.$j])."','".$uploaded_url_ques1."','".$_POST['chapter_id']."')";
						$insert_ptr_extra=mysql_query($insert_query_extra);
						$question_id=mysql_insert_id();
						
						$ins_diff="insert into question_difficulties (`question_id`,`diffculty`) values ('".$question_id."','".$_POST['diffculty']."')";
						$ptr_diff=mysql_query($ins_diff);
						
						$ins_img_ques="insert into questions_image (`question_id`,`question_image`) values ('".$question_id."','".$uploaded_url_ques."')";
						$ptr_img1=mysql_query($ins_img_ques);
						
						$ins_img="insert into option_image (`question_id`,`option_image1`,`option_image2`,`option_image3`,`option_image4`) values ('".$question_id."','".$uploaded_url_opt1."','".$uploaded_url_opt2."','".$uploaded_url_opt3."','".$uploaded_url_opt4."')";
						$ptr_img=mysql_query($ins_img);
									
						$right_ans = $_POST['right_ans_'.$j];	
						
						for($i=1;$i<5;$i++)
						{		
						$ans ='';	
						$option_image='';	
						$option = $_POST['option'.$i.'_'.$j];	
						$option_image=$uploaded_url_opt1.$i;
						if($right_ans ==$i)
						{
						$ans ='y';
						}
						if($option !='' || $option_image !='')
						{
						"<br />Multi- ".$insert_options_extra = " insert into options (`admin_id`,`question_id`,`paper_id`,`exam_id`,`option_title`,`option_image`,`answer`) values('".$_SESSION['admin_id']."','".$question_id."','".$_POST['paper_id']."','".$_POST['exam_id']."','".$option."','".$option_image."','$ans')";
						$pts_option_extra = mysql_query($insert_options_extra);
						}
						}	
						}
						$msg= "<center><font color='green'>Question Added successfully..!</font></center>";
						
						}
						//////////////=============END CODE FOR MULTIPLE QUESTION==========////////
					}
						}
							  }
							else
							{
								$msg= "<center><font color='red'>Question Should Not Blank and atleast insert two option and answer too...!</font></center>";
							}
							  
                                echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
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
            <tr>
            <td width="20%">Select Subject<span class="orange_font">*</span></td>
            <td width="40%" >
                    <select name="subject_id" id="subject_id" class="validate[required] input_select" onchange="show_chapter(this.value); ">  
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
                    </select>
                    </td> 
                <td width="40%"></td>
            </tr>
            <!-- <tr>
                <td width="20%"> Select Subject </td>
                <td width="40%" ><div id="show_subject"></div> </td> 
                <td width="40%"></td>
            </tr>-->
             <tr>
                <td width="20%"> Select Topic </td>
                <td width="40%" >
                <div id="show_chapter">
                <select name="chapter" class="input_select ">
                <option value="">Select Topic </option>
                </select>
                </div>
                <input type="hidden" name="topic_id" id="topic_id" value="<? echo $row_record['chapter_id']; ?>" />
                </td> 
                <td width="40%"></td>
            </tr>
            <tr>
            	<td>Question Diffculty</td>
                <td><select name="diffculty" id="diffculty">
                <option value="easy">Easy</option>
                <option value="medium">Medium</option>
                <option value="hard">Hard</option>
                </select></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                 <?php if($record_id !='')
					{ 
						?>
						
						<?php
						$selec_question = " select question_title,ans_dis,mark,question_id from question where question_id ='".$record_id."' ";
						$ptr_question= mysql_query($selec_question);
						$i=1;
						while($dat_question = mysql_fetch_array($ptr_question))
						{
							
						?>
						<table border="0" style=" border:solid #000099 1px; width:900px">
						<tr><td valign="top"><div align="left">Question </div></td>
                            <td colspan="3"><textarea name="question" maxlength="100" size="100" class="input_textarea" ><?php echo $dat_question['question_title'] ?></textarea></td>
                            <td valign="top" ><div align="left">Discription</div></td>
                            <td colspan="3"><textarea name="ans_dis" maxlength="100" size="100" class="input_textarea" ><?php echo $dat_question['ans_dis'] ?></textarea></td>
                            <td  align="left">Marks</td><td  align="left"><input type="text" name="mark" size="2" maxlength="2" class="input_text" value="<?php if($_POST['mark']) echo $_POST['mark']; else echo $dat_question['mark'] ;?>"  /></td>
                        </tr>
                        <?php
						  $sele_ques_img="select question_image from questions_image where question_id=".$dat_question['question_id']."";
							$ptr_ques=mysql_query($sele_ques_img);
							if(mysql_num_rows($ptr_ques))
							{
								$data_ques_img=mysql_fetch_array($ptr_ques);
						 ?>
                        <tr>
                          	<td valign="top"><div align="left">Question Image</div></td>
                          	<td valign="top" colspan="2">
                            <?php
                    if($record_id && $data_ques_img['question_image'] && file_exists("question_photo/".$data_ques_img['question_image']))
                        echo '<img height="90px" width="90px" src="question_photo/'.$data_ques_img['question_image'].'"><br><a href="'.$_SERVER['PHP_SELF'].'?deleteThumbnail=1&record_id='.$record_id.'">Delete / Upload new</a></td>';
                    else
                        echo '<input type="file" name="ques_img" style=" width: 120px;overflow:hidden;" /></td>';?>
                            
                        </tr>
                        <tr>
                        <?php
							}
							 '<br/>'.$sel=" SELECT option_title FROM `options` WHERE `question_id`=".$dat_question['question_id']." ORDER BY `option_id` ASC "; 
							$ptr_option=mysql_query($sel);
							$k=1;
							
							while($data_options=mysql_fetch_array($ptr_option))
							{
								?>
								
                           <td  valign="top"><div align="left">Option&nbsp;<? echo $k;?></div></td>
                           <td width="107"><input type="text" name="option<? echo $k?>" size="10" value="<?php if($_POST['option'.$k]) echo $_POST['option'.$k]; else echo $data_options['option_title'] ;?>" ></td>
                           	<?
							$k++;
							}
						?>
                       <input type="hidden" name="no_of_extra" id="extra" value="1" />
                       </tr>
                       <?php 
					   $sel_opt_img="select option_image from option_image where question_id=".$dat_question['question_id']."";
					   $ptr_opt_img=mysql_query($sel_opt_img);
					   if(mysql_num_rows($ptr_opt_img))
					   {
					   ?>
                       <tr>
                           <td>Option image</td>
                           <?php
							$data_img=mysql_fetch_array($ptr_opt_img);
							for($i=1; $i<5; $i++)
							{
							?>
						 		<td valign="top" colspan="2">
                                <?php
                    if($record_id && $data_img['option_image'.$i] && file_exists("question_photo/".$data_img['option_image'.$i]))
                        echo '<img height="90px" width="90px" src="question_photo/'.$data_img['option_image'.$i].'"><br><a href="'.$_SERVER['PHP_SELF'].'?deleteoption=1&record_id='.$record_id.'&option_id='.$i.'">Delete / Upload new</a></td>';
                    else
                        echo '<input type="file" name="opt_img'.$i.'" style=" width: 120px;overflow:hidden;" /></td>';?>
                                </td>
                                
							<?php
							} ?>
                           
                       </tr>
                       <?php } ?>
                       <tr>
                       <td  valign="top"><div align="left">Answer</div></td>
                       <?
					   $s=1;
					    '<br/>'.$sel_ans=" SELECT answer FROM `options` WHERE `question_id`=".$dat_question['question_id']." ORDER BY `option_id` ASC "; 
							$ptr_option_ans=mysql_query($sel);
                       while($data_ans=mysql_fetch_array($ptr_option_ans))
					   {
						  
					   ?>
                           <td width="107"><input type="radio" name="right_ans" value="<? echo $s; ?>" <?php if($_POST['right_ans']=='y' || $data_ans['answer']=='y') {echo 'checked="checked"' ;}?> /></td>
                           <td  valign="top"><div align="left"></div></td>
                        <? 
						$s++;
						}?>
                           
                       </tr>
                       
						<?php 
						$i++;
						}?>
						</table>
                        
						<?php
						
					}
					else
					{
					 ?>
                <table border="0" style=" border:solid #000099 1px; width:900px">
                   <tr>
                   <td width="125"  valign="top" ><div align="left">Question</div></td>
                   <td  colspan="3"><textarea name="question" maxlength="100" size="100" class="input_textarea" ></textarea></td>
                   <td width="88" valign="top" ><div align="left">Discription</div></td>
                    <td colspan="3"><textarea name="ans_dis" maxlength="100" size="100" class="input_textarea" ></textarea></td>
                   <td width="45"  align="left">Marks</td><td width="17"  align="left"><input type="text" name="mark" size="2" maxlength="2" class="input_text"  /></td>
                   </tr>
                   <tr>
                   <td valign="top"><div align="left">Question Image</div></td>
                   <td valign="top"><input type="file" name="ques_img" style=" width: 120px;overflow:hidden;" /></td>
                   </tr>
                   <tr>
                   <td  valign="top"><div align="left">Option&nbsp;1</div></td>
                   <td width="120"><input type="text" name="option1" size="10"  ></td>
                   <td width="61"  valign="top"><div align="left">Option&nbsp;2</div></td>
                   <td width="116"><input type="text" name="option2" size="10"  ></td>
                   <td  valign="top"><div align="left">Option&nbsp;3</div></td>
                   <td width="107"><input type="text" name="option3" size="10"  ></td>
                   <td width="70"  valign="top"><div align="left">Option&nbsp;4</div></td>
                   <td width="107"><input type="text" name="option4" size="10"  /></td>
                   <!--<td  valign="top"><div align="left">Option&nbsp;5</div></td>
                   <td width="107"><input type="text" name="option5" size="10"  ></td>-->
                   </tr>
                   <tr>
                   <td>Option image</td>
                   <td valign="top" colspan="2"><input type="file" name="opt_img1" style=" width: 120px;overflow:hidden;" /></td>
                   <td valign="top" colspan="2"><input type="file" name="opt_img2" style=" width: 120px;overflow:hidden;" /></td>
                   <td valign="top" colspan="2"><input type="file" name="opt_img3" style=" width: 120px;overflow:hidden;" /></td>
                   <td valign="top" colspan="2"><input type="file" name="opt_img4" style=" width: 120px;overflow:hidden;" /></td>
                   </tr>
                   <tr><td  valign="top"><div align="left">Answer</div></td>
                   <td width="120"><input type="radio" name="right_ans" value="1" ></td>
                   <td  valign="top"><div align="left"> </div></td>
                   <td width="116"><input type="radio" name="right_ans" value="2"  /></td>
                   <td  valign="top"><div align="left"></div></td>
                   <td width="107"><input type="radio" name="right_ans" value="3"></td>
                   <td  valign="top"><div align="left"></div></td>
                   <td width="107"><input type="radio" name="right_ans" value="4" /></td>
                   <td  valign="top"><div align="left"> </div></td>
                  <!-- <td width="107"><input type="radio" name="right_ans" value="5" ></td>-->
                   <input type="hidden" name="no_of_extra" id="extra" value="1" />
                   </tr>
                   </table>
                   <? }?>
                </td>
                <td></td>
            <tr>
                <td>&nbsp;</td>
                <td>
                   <div id='1'> </div>
                   </td>
                   </tr>
                   <tr>
                    <td>&nbsp;</td>
                    <td align="right"><input type="button" name="Add"  class="addBtn" onClick="javascript:add_degree(1);" alt="Add(+)" >&emsp; 
                   <input type="button" name="Add"  class="delBtn"  onClick="javascript:del_degree(1);" alt="Delete(-)" ></td>
                    </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Question" name="save_changes"  /></td>
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
<script>
show_chapter(<?php echo $row_record['subject_id'] ?>);
</script>
</div>
<!--info end-->
<div class="clearit"></div>
<!--footer start-->
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>