<?php include 'ex_inc_classes.php';?>
<?php include "ex_admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
	$record_unit_id=$_REQUEST['unit_id'];
    $sql_record= "SELECT question_img,question_id,subject_id,question_img,unit_id,main_question_id FROM ex_question where question_id ='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
    {
		$row_record=$db->fetch_array($db->query($sql_record));
		$main_question_id = $row_record['main_question_id']; 
	}
    else
    $record_id=0;
	$unit_id=$_REQUEST['unit_id']; 
	$sel_unit="select topic_id,topic_name from topic";
	$ptr_unit=mysql_query($sel_unit);
	$data_unit=mysql_fetch_array($ptr_unit);
	/*$sele_opt_img="select option_image from option_image where question_id='".$record_id."'";
	$ptr_opt_img1=mysql_query($sele_opt_img);
	if(mysql_num_rows($ptr_opt_img1)
	$row_opt_img=mysql_fetch_array($ptr_opt_img1);
	else
	$row_opt_img=0;*/ 
}
if($_REQUEST['unit_record_id'] && $_REQUEST['unit_id'] && $_REQUEST['unit_record_id'] !=0)
{
	$record_unit_id=$_REQUEST['unit_record_id'];
	$unit_id_add=$_REQUEST['unit_id'];
    $sql_record= "SELECT question_img,question_id,subject_id,unit_id FROM ex_question where question_id ='".$record_unit_id."'";
    if(mysql_num_rows($db->query($sql_record)))
    $record_id_add=$db->fetch_array($db->query($sql_record));
    else
    $record_id_add=0;
	$unit_id=$_REQUEST['unit_id'];
	$sel_unit="select topic_id,topic_name from topic";
	$ptr_unit=mysql_query($sel_unit);
	$data_unit=mysql_fetch_array($ptr_unit);
}

if($_REQUEST['deleteThumbnail'] && $_REQUEST['question_id'])
{
	$question_id=$_REQUEST['question_id'];
	$sel_opt="select question_img from ex_question where  question_id='".$question_id."'";
	$ptr_opt=mysql_query($sel_opt);
	$data_opts=mysql_fetch_array($ptr_opt);

	 if($data_opts['question_img'] && file_exists("ex_question_photo/".$data_opts['question_img']))
        unlink("ex_question_photo/".$data_opts['question_img']);
	
    $update_ques="update ex_question set question_img='' where question_id='".$question_id."'";
	$db->query($update_ques);
	
    //if($row_record['question_img'] && file_exists("question_photo/".date('Y-m-d H:i:s').$row_record['question_img']))
       // unlink("question_photo/".date('Y-m-d H:i:s').$row_record['question_img']);
	   
    /*$row_record=$db->fetch_array($db->query($sql_record));
	$update_ques="update question set question_img='' where question_id='".$question_id."'";
    $db->query($update_ques);*/
	
    /*if($row_record['question_img'] && file_exists("question_photo/".$row_record['question_img']))
        unlink("question_photo/".$row_record['question_img']);
    $row_record=$db->fetch_array($db->query($sql_record));*/
}
if($_REQUEST['deleteOptionThumbnail'] && $_REQUEST['option_id'])
{
	$option_id=$_REQUEST['option_id'];
	$question_id=$_REQUEST['question_id'];
	$sel_opt="select option_id,	option_image from ex_options where option_id='".$option_id."' and  question_id='".$question_id."'";
	$ptr_opt=mysql_query($sel_opt);
	$data_opts=mysql_fetch_array($ptr_opt);

	 if($data_opts['option_image'] && file_exists("question_photo/".$data_opts['option_image']))
        unlink("ex_question_photo/".$data_opts['option_image']);
	
    $update_opt="update ex_options set option_image='' where option_id='".$option_id."' and  question_id='".$question_id."'";
    $db_query=mysql_query($update_opt);
   
}
/*if($record_id && $_REQUEST['deleteoption'] && $_REQUEST['option_id'] )
{
	$id=$_REQUEST['option_id'];
    $update_ques="update option_image set option_image".$id."='' where question_id='".$record_id."'";
    $db->query($update_ques);
    if($row_opt_img['option_image'.$id] && file_exists("question_photo/".$row_opt_img['option_image'.$id]))
        unlink("question_photo/".$row_opt_img['option_image'.$id]);
    $row_opt_img=$db->fetch_array($db->query($sele_opt_img));
}*/
/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Questions</title>
<?php include "ex_include/headHeader.php";?>
<?php include "ex_include/functions.php"; ?>
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
    <!-- Multiselect -->
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>
    
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <link rel="stylesheet" href="js/chosen.css" />
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
	var pageName = "add_checkout";
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
		
        });
    </script>
    
    <script language="javascript" src="js/script.js"></script>
    <script language="javascript" src="js/conditions-script.js"></script>


<script type="text/javascript">
        jQuery(document).ready( function() 
        {
            $("#service_id").multiselect().multiselectfilter();
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
</script>



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
	<script>
function validation()
{
	
	 disp_error="Please Correct Following errors\n\n";
	 error="";
	var floorval = document.getElementById("floor").value;
	var unit = document.getElementById("unit_id").value;
	
	if(unit=='')
	{
		
		disp_error +="Select unit Name\n";
		error="yes";
	}
	for(j=1;j<=floorval;j++){

		ques_name="question_"+j;
		ques_img="ques_img_a"+j;
	
	var ques_name1=document.getElementById(ques_name).value;
	var ques_img1=document.getElementById(ques_img).value;
	 
	if(ques_name1 =='' && ques_img1 =='')
	{
		disp_error +="Please enter question in "+j+"\n";
		error="yes";
	}
	//============= FOR OPTION NEW CODE =========///
	opt1= 'option1_'+j	; 
		opt2= 'option2_'+j	; 
		opt3= 'option3_'+j	; 
		opt4= 'option4_'+j	; 

		opt_img1= 'opt_img1_'+j	;
		opt_img2= 'opt_img2_'+j	;
		opt_img3= 'opt_img3_'+j	;
		opt_img4= 'opt_img4_'+j	;

		// alert(opt_img4);

		 if(document.getElementById(opt_img1).value==''&& document.getElementById(opt_img2).value=='' && document.getElementById(opt_img3).value=='' && document.getElementById(opt_img4).value=='')
			{
				if(document.getElementById(opt1).value==''&& document.getElementById(opt2).value=='' && document.getElementById(opt3).value=='' && document.getElementById(opt4).value=='')
				{
			
				disp_error +="Please enter all options in "+j+"\n";
				error="yes";
				}
		 	}

		ans1 = 'right_ans_1'+j;
		ans2 = 'right_ans_2'+j;
		ans3 = 'right_ans_3'+j;
		ans4 = 'right_ans_4'+j;

	

		if(document.getElementById(ans1).checked == false && document.getElementById(ans2).checked == false && document.getElementById(ans3).checked == false && document.getElementById(ans4).checked == false )
		{
			disp_error +="Please select right option in "+j+"\n";
			error="yes";
		}
		
		
	}
	if(error=="yes")
	{
		alert(disp_error);
		return false;
	}
	else
	return true;	
		
}
</script>
<script>
function show_question(unit_id)
 {
	 var course="show_unit=1&unit_id="+unit_id;
	 $("#total_quations").val($("#totla_q_"+unit_id).val());
	//alert(course)
	 $.ajax({
		url: "ex_show_question.php", type: "post", data: course, chache:false,
		 success: function (chapters)
		 {
			 //alert(chapters);
			document.getElementById('show_question').innerHTML=chapters;
		 }
	 });
 }
</script>
<style>
	#upload-photo {
   opacity: 0;
   position: absolute;
   z-index: -1;
}
#upload-photo1 {
   opacity: 0;
   position: absolute;
   z-index: -1;
}
</style>
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

    <td class="top_mid" valign="bottom"><?php include "ex_include/exams_menu.php"; ?></td>

    <td class="top_right"></td>

  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
	<form method="post" name="jqueryForm" id="jqueryForm" enctype="multipart/form-data">
        <table width="100%" cellspacing="0" cellpadding="0">
         <?php
         $errors=array(); $i=0;
         $success=0;

         if($_POST['save_changes'])
         {
            $unit_id=$_POST['unit_id'];
            
            $subject_id=$_POST['subject_id'];
            $total= $_POST['floor'];

            // for($j=1;$j<=$total;$j++)
			// {
            //     $unit_id=$_POST['unit_id'];
            //     $sum = 0;
            //     $right_ans = $_POST['right_ans_'.$j];
            //     for($k=1;$k<5;$k++)
            //     {
                   	
            //         if($_POST['option_'.$k.''.$j]){
            //             $sum = $sum + $k;
            //         };	
            //     }
            //     if($unit_id =="")
            //     {
            //         $success=0;
            //         $errors[$i++]="Please Select Unit First";
            //     }elseif($sum < 3){
            //         $success=0;
            //         $errors[$i++]="Please Insert at least three option";

            //     }elseif($right_ans == ''){
            //         $success=0;
            //         $errors[$i++]="Please select right option";

            //     }
			// }
                if(count($errors))
                {?>
                 <tr><td> 
                    
                    <table align="left"  class="alert">
                        <tr><td ><strong>Please correct the following errors</strong><ul>
                            <?php
                            for($k=0;$k<count($errors);$k++)
                                            echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>
                                    </ul>
                        </td></tr>
                    </table>
                     </td></tr>   
                     <?php 
                }
                else{
                   // $success=1;
                    if($record_id)
                    {

						 //===========================FOR QUESTION IMAGE=======================================
										
						 $uploaded_url_ques1='';
						 if($_FILES['ques_img_']["name"])
						 {
							 $uploaded_url_ques1=rand().basename($_FILES['ques_img_']["name"]);
							 $newfile = "ex_question_photo/";
							 $filename = $_FILES['ques_img_']['tmp_name']; // File being uploaded.
							 $filetype = $_FILES['ques_img_']['type'];// type of file being uploaded
							 $source1 = $_FILES['ques_img_']['tmp_name'];
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
 
							 $ques1 = "select question_img from ex_question WHERE question_id='".$_POST['question_id']."'";
							 $ques = mysql_query($ques1);
							 $o1 = mysql_fetch_array($ques);
							 if($o1['question_img'] != ''){
								 
								 
								 unlink("ex_question_photo/".$o1['question_img']);
							 }
								 $ins_img1 ="update `ex_question` SET `question_img`='".addslashes($uploaded_url_ques1)."' WHERE question_id='".$_POST['question_id']."'";
								 
								 mysql_query($ins_img1);
								 
								  $ins_img2 =" update `ex_questions_image` SET `question_image`='".$uploaded_url_ques1."' WHERE question_id='".$_POST['question_id']."'";
								 
								 mysql_query($ins_img1);
						 }
						 //=========================================END QUESTION IMAGE======================================================	
						 
						 //===========================FOR OPTION IMAGE=======================================
					 //OPTION 1
					 if($_FILES['opt_img_1']["name"]){
						 $uploaded_url_opt1=time().basename($_FILES['opt_img_1']["name"]);
						 $newfile1 = "question_photo/";
						 $filename1 = $_FILES['opt_img_1']['tmp_name']; // File being uploaded.
						 $filetype1= $_FILES['opt_img_1']['type'];// type of file being uploaded
						 $filesize1 = filesize($filename1); // File size of the file being uploaded.
						 $source11 = $_FILES['opt_img_1']['tmp_name'];
						 $target_path11 = $newfile1.$uploaded_url_opt1;
						// if(strtolower($filetype1) == "image/jpeg" || strtolower($filetype1) == "image/pjpeg" || strtolower($filetype1) == "image/GIF" || strtolower($filetype1) == "image/gif" || strtolower($filetype1) == "image/png")
						 //{
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
						//  }
						//  else
						//  {
						//  $file_uploaded=0;
						//  $success=0;
						//  $errors[$i++]="Location image: Only image files allowed";
						//  }
						 
						 $optimg1 = "select option_image from ex_options WHERE question_id='".$_POST['question_id']."' and opt_ids = '1'";
						 $opti1 = mysql_query($optimg1);
						
							 $o1 = mysql_fetch_array($opti1);
							 if($o1['option_image'] != ''){
							 unlink("ex_question_photo/".$o1['option_image']);
						 }
						 $ins_img1 =" update `ex_options` set `option_image`='".$uploaded_url_opt1."' where question_id='".$_POST['question_id']."' and opt_ids = '1'";
						 
							 mysql_query($ins_img1);
						 }
						 //OPTION 2
						 if($_FILES['opt_img_2']["name"]){											
						 $uploaded_url_opt2=time().basename($_FILES['opt_img_2']["name"]);
						 $newfile2 = "question_photo/";
						 $filename2 = $_FILES['opt_img_2']['tmp_name']; // File being uploaded.
						 $filetype2 = $_FILES['opt_img_2']['type'];// type of file being uploaded
						 $filesize2 = filesize($filename2); // File size of the file being uploaded.
						 $source12 = $_FILES['opt_img_2']['tmp_name'];
						 $target_path12 = $newfile2.$uploaded_url_opt2;
 
						//  if(strtolower($filetype2) == "image/jpeg" || strtolower($filetype2) == "image/pjpeg" || strtolower($filetype2) == "image/GIF" || strtolower($filetype2) == "image/gif" || strtolower($filetype2) == "image/png")
						//  {
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
						//  }
						//  else
						//  {
						//  $file_uploaded=0;
						//  $success=0;
						//  $errors[$i++]="Location image: Only image files allowed";
						//  }
						 $optimg2 = "select option_image from ex_options WHERE question_id='".$_POST['question_id']."' and opt_ids = '2'";
						 $opti2 = mysql_query($optimg2);
						
							 $o2 = mysql_fetch_array($opti2);
							 if($o2['option_image'] != ''){	 
							 unlink("ex_question_photo/".$o2['option_image']);
						 }
						 $ins_img2 =" update `ex_options` set `option_image`='".$uploaded_url_opt2."' WHERE question_id='".$_POST['question_id']."' and opt_ids = '2'";
						 
						 mysql_query($ins_img2);
						 }
						 
						 //OPTION 3
						 if($_FILES['opt_img_3']["name"]){
						 $uploaded_url_opt3=time().basename($_FILES['opt_img_3']["name"]);
						 $newfile3 = "ex_question_photo/";
						 $filename3 = $_FILES['opt_img_3']['tmp_name']; // File being uploaded.
						 $filetype3 = $_FILES['opt_img_3']['type'];// type of file being uploaded
						 $filesize3 = filesize($filename3); // File size of the file being uploaded.
						 $source13 = $_FILES['opt_img_3']['tmp_name'];
						 $target_path13 = $newfile3.$uploaded_url_opt3;
						 
						//  if(strtolower($filetype3) == "image/jpeg" || strtolower($filetype3) == "image/pjpeg" || strtolower($filetype3) == "image/GIF" || strtolower($filetype3) == "image/gif" || strtolower($filetype3) == "image/png")
						//  {	
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
						//  }
						//  else
						//  {
						//  $file_uploaded=0;
						//  $success=0;
						//  $errors[$i++]="Location image: Only image files allowed";
						//  }
						 $optimg3 = "select option_image from ex_options WHERE question_id='".$_POST['question_id']."' and opt_ids = '3'";
						 $opti3 = mysql_query($optimg3);
						
							 $o3 = mysql_fetch_array($opti3);
							 if($o3['option_image'] != ''){
							 unlink("ex_question_photo/".$o3['option_image']);
						 }
							 $ins_img3 ="update `ex_options` set `option_image`='".$uploaded_url_opt3."' WHERE question_id='".$_POST['question_id']."' and opt_ids = '3'";
							 mysql_query($ins_img3);
						 }
						 
						 //OPTION 4
						 if($_FILES['opt_img_4']["name"]){
						 $uploaded_url_opt4=time().basename($_FILES['opt_img_4']["name"]);
						 $newfile4 = "ex_question_photo/";
						 $filename4 = $_FILES['opt_img_4']['tmp_name']; // File being uploaded.
						 $filetype4 = $_FILES['opt_img_4']['type'];// type of file being uploaded
						 $filesize4 = filesize($filename4); // File size of the file being uploaded.
						 $source14 = $_FILES['opt_img_4']['tmp_name'];
						 $target_path14 = $newfile4.$uploaded_url_opt4;
						//  if(strtolower($filetype4) == "image/jpeg" || strtolower($filetype4) == "image/pjpeg" || strtolower($filetype4) == "image/GIF" || strtolower($filetype4) == "image/gif" || strtolower($filetype4) == "image/png")
						//  {	
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
						//  }
						//  else
						//  {
						//  $file_uploaded=0;
						//  $success=0;
						//  $errors[$i++]="Location image: Only image files allowed";
						//  }
						 
						 $optimg4 = "select option_image from ex_options WHERE question_id='".$_POST['question_id']."' and opt_ids = '4'";
						 $opti4 = mysql_query($optimg4);
						 $o4 = mysql_fetch_array($opti4);
						 if($o4['option_image'] != ''){
							 
							 
							 
							 unlink("ex_question_photo/".$o4['option_image']);
						 }
							 $ins_img4 ="update `ex_options` SET `option_image`='".$uploaded_url_opt4."' WHERE question_id='".$_POST['question_id']."' and opt_ids = '4'";
							 mysql_query($ins_img4);
						 }
					 //==============================END OPTION IMAGE======================================================	
					



                      "<br /> right ans".$right_ans = $_POST['right_ans_'];

						$unit_id = $_POST['unit_id'];
						

                        if($_POST['question_id'] !='')
                        {
                           $update_query = "update `ex_question` set `question_title`='".addslashes(mysql_real_escape_string($_POST['question']))."' , unit_id = '$unit_id' $files_up where question_id='".$_POST['question_id']."'  ";
							$update_quer = mysql_query($update_query);
							
                        }
                        else
                        {
                            $insert_query_extra = "insert into ex_question (`admin_id`,`unit_id`,`language_id`,`question_title`,`question_img`,`main_question_id`,`added_date`) values('".$_SESSION['admin_id']."','".$unit_id."','1','".addslashes(mysql_real_escape_string($_POST['question']))."','".$uploaded_url_ques1."','".$main_question_id."','".date('Y-m-d H:i:s')."')";
                            $insert_ptr_extra=mysql_query($insert_query_extra);
                            $question_id_new=mysql_insert_id();
						}
						

                        $sel_rec="select question_id from ex_student_paper where question_id='".$_GET['record_id']."' ";
						$ptr_unit=mysql_query($sel_rec);
                        for($k=1;$k<5;$k++)
                        {
                            $opt_id=$k;	
                            $ans ='';	
                            $option_image='';	
                            "<br />options-".$option = (($_POST['option'.$k]));	
                            
                            $option_id_new='';
                             $option_id_new=trim($_POST['option_id'.'_'.$k]);
                            $right_opt_idss=' , answer=""';
                            if($right_ans ==$k)
                            {
                                $ans ='y';
                                $opt_id=$k;
                                "<br /> right ans = >".$right_opt_idss= " , answer='".$ans."' ";
                            }
                            $question_id_ = $_POST['question_id'];
                            /////////===FOR OPTIONS EDIT START ===///
                            if($option_id_new !='')
                            {
                                '<br/>'.$update_query_option = " update `ex_options` set `option_title`='".addslashes(mysql_real_escape_string($option))."' , right_opt_id = '".$opt_id."' 
                                ".$right_opt_idss."	 where question_id='".$_POST['question_id']."' and option_id='".$option_id_new."'  ";
                                $update_quer_option = mysql_query($update_query_option);
                            }
                            else
                            {
                                ///=== New OPTIONS of New Questions====
                                "<br />".$insert_options_extra = "insert into ex_options (`admin_id`,`question_id`,`opt_ids`,`option_title`,`answer`) values('".$_SESSION['admin_id']."','".$question_id_new."','".$k."','".addslashes(mysql_real_escape_string($option))."','$ans')";
                                $insert_extra = mysql_query($insert_options_extra);
                                ///===End of New OPTIONS of New Questions====
                            }
                            ////////// OPTION EDIT END ======//
                        }					
                        $insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `admin_id`) VALUES ('add_mcq_question','Edit','".addslashes(mysql_real_escape_string ($_POST['question']))."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."')";
                        $query=mysql_query($insert);

                        ?>
                    <script>alert("Question Updated successfully..!");
                   // document.location.href="ex_add_questions.php?record_id=<?php //echo $main_question?>&unit_id=<?php //echo $_GET['unit_id']; ?>";
                    </script>
                    <?php
                    ?><div id="statusChangesDiv" title="Record Added"><center><br><p>Question Edited successfully</p></center></div>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $( "#statusChangesDiv" ).dialog({
                                                modal: true,
                                                buttons: {
                                                            Ok: function() { $( this ).dialog( "close" );}
                                                         }
                                        });
                                    });
                                 // setTimeout('document.location.href="ex_manage_question.php";');
                                </script>
                    <?php

                    }else{

                        $no_of_extra = $_POST['floor'];
						$main_question=0;
                        for($j=1;$j<=$no_of_extra;$j++)
                        {
                            
                        "<br/>".$sel_exist_ques="select question_id from ex_question where question_title='".stripslashes(html_entity_decode($_POST['question_'.$j.'']))."' and unit_id = '".$_POST['unit_id']."'";
                        $ptr_exist_ques=mysql_query($sel_exist_ques);
                        $num = mysql_num_rows($ptr_exist_ques);
                        if($num != '0')
                        {
                            $success.='11';
                            echo $errors_exist="Question already Exist. Please type another question name";
                        }else{
                        //===========================FOR QUESTION IMAGE=======================================
                        $uploaded_url_ques1='';
                        if($_FILES['ques_img_a'.$j.'']["name"])
                        {
                            $uploaded_url_ques1=rand().basename($_FILES['ques_img_a'.$j.'']["name"]);
                             $newfile = "ex_question_photo/";
                            $filename = $_FILES['ques_img_a'.$j.'']['tmp_name']; // File being uploaded.
                            $filetype = $_FILES['ques_img_a'.$j.'']['type'];// type of file being uploaded
                            $source1 = $_FILES['ques_img_a'.$j.'']['tmp_name'];
                            $target_path1 = $newfile.$uploaded_url_ques1;
                            // if(strtolower($filetype) == "image/jpeg" || strtolower($filetype) == "image/pjpeg" || strtolower($filetype) == "image/GIF" || strtolower($filetype) == "image/gif" || strtolower($filetype) == "image/png")
                            // {
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
                            // }
                            // else
                            // {
                            // 	$file_uploaded=0;
                            // 	$success=0;
                            // 	$errors[$i++]="Location image: Only image files allowed";
                            // }
                        }
                        //==============================END QUESTION IMAGE======================================================	
                        $insert_query_extra = "insert into ex_question (`admin_id`,`unit_id`,`language_id`,`question_title`,`question_img`,`main_question_id`,`added_date`) values ('".$_SESSION['admin_id']."','".$_POST['unit_id']."','1','".addslashes(mysql_real_escape_string($_POST['question_'.$j.'']))."','".addslashes($uploaded_url_ques1)."','".$main_question."','".date('Y-m-d H:i:s')."')";
											
                       // echo $insert_query_extra;
                        
                        $insert_ptr_extra=mysql_query($insert_query_extra);
                        $question_id=mysql_insert_id();
                        //if($j==0)
                        //{
                            $main_question = $question_id;
                            $update_query = "update ex_question set  main_question_id = '".$main_question."' where question_id='".$question_id."' ";
                            $ptri_upd = mysql_query($update_query);
                        //}
                        $ins_img_ques="insert into ex_questions_image (`question_id`,`question_image`) values ('".$question_id."','". $uploaded_url_ques1."')";
                        $ptr_img1=mysql_query($ins_img_ques);
                        
                         //===============================FOR OPTION IMAGE=======================================
                                //OPTION 1
                                if($_FILES['opt_img1_'.$j.'']["name"] !='')
                                {
                                    "<br/>".$uploaded_url_opt1=time().'1'.basename($_FILES['opt_img1_'.$j.'']["name"]);
                                    
                                    $newfile1 = "ex_question_photo/";
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
                                }
                                //OPTION 2			
                                if($_FILES['opt_img2_'.$j.'']["name"] !='')
                                {
                                    $uploaded_url_opt2=time().'2'.basename($_FILES['opt_img2_'.$j.'']["name"]);
                                    $newfile2 = "ex_question_photo/";
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
                                }
                                //OPTION 3
                                if($_FILES['opt_img3_'.$j.'']["name"] !='')
                                {
                                    $uploaded_url_opt3=time().'3'.basename($_FILES['opt_img3_'.$j.'']["name"]);
                                    $newfile3 = "ex_question_photo/";
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
                                }
                                
                                //OPTION 4
                                if($_FILES['opt_img4_'.$j.'']["name"] !='')
                                {
                                    $uploaded_url_opt4=time().'4'.basename($_FILES['opt_img4_'.$j.'']["name"]);
                                    $newfile4 = "ex_question_photo/";
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
                                }
                            //====================================END OPTION IMAGE======================================================	
                                
                            if($uploaded_url_opt1 !='' || $uploaded_url_opt2!='' || $uploaded_url_opt3!='' || $uploaded_url_opt4!='')
                            {
                                 $ins_img="insert into ex_option_image (`question_id`,`option_image1`,`option_image2`,`option_image3`,`option_image4`) values ('".$question_id."','".$uploaded_url_opt1."','".$uploaded_url_opt2."','".$uploaded_url_opt3."','".$uploaded_url_opt4."')";
                                $ptr_img=mysql_query($ins_img);
                                
                            }

                            $right_ans = $_POST['right_ans_'.$j];	
                            for($i=1;$i<5;$i++)
                            {
                                $opt_id='';		
                                $ans ='';	
                                $option_image='';	
                                "<br />options-".$i."".$option =(($_POST['option_'.$i.''.$j]));	
                                
                                if($i==1)
                                     "<br/>".$option_image=$uploaded_url_opt1;
                                else if($i==2)
                                     "<br/>".$option_image=$uploaded_url_opt2;
                                else if($i==3)
                                     "<br/>".$option_image=$uploaded_url_opt3;
                                else if($i==4)
                                     "<br/>".$option_image=$uploaded_url_opt4;
                                
                                if($right_ans == $i)
                                {
                                    $ans ='y';
                                    $opt_id=$i;
                                }
                                if($option !='' || $option_image !='')
                                {
                                    $insert_options_extra = "insert into ex_options (`admin_id`,`question_id`,`paper_id`,`exam_id`,`opt_ids`,`option_title`,`option_image`,`right_opt_id`,`answer`) values('".$_SESSION['admin_id']."','".$question_id."','".$_POST['paper_id']."','".$_POST['exam_id']."','".$i."','".addslashes(mysql_real_escape_string($option))."','".$option_image."','".$opt_id."','".$ans."')";
                                    $pts_option_extra = mysql_query($insert_options_extra);    
                                }
                                $insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `admin_id`) VALUES ('add_mcq_question','Add','".addslashes(mysql_real_escape_string($_POST['question_'.$j.'']))."','".$question_id."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."')";
								$query=mysql_query($insert);
                            }
                            
                        }
                        if($success!='11')
							{?>
                            <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Question added successfully</p></center></div>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $( "#statusChangesDiv" ).dialog({
                                                modal: true,
                                                buttons: {
                                                            Ok: function() { $( this ).dialog( "close" );}
                                                            }
                                        });
                                    });
                                    //setTimeout('document.location.href="ex_manage_question.php";');
                                </script>
						<?php
							}
                    }
                }
            }
            
            
        
        }
if($success==0) {
                ?>
					<tr>
					<?php if($record_id ==''){?>
						<td align="left" width="20%"> Select Subjects <span class="orange_font">*</span></td>
                    	<td width="20" style="">
                            <select id="subject_id" name="subject_id" class="input_select" onchange="select_topic(this.value)" style="width:200px">
                            <option value="">Select</option>
                            <?php
							
							$selcetexamcourse = "select subject_id,name from subject where subject_id='".$row_record['subject_id']."' ";
							$ptr_course_name=mysql_query($selcetexamcourse);
							$course_name=mysql_fetch_array($ptr_course_name);
							$course_interested=$course_name['name'];
							$select_category = "select subject_id,name from subject";
							$ptr_category = mysql_query($select_category);
							while($data_category = mysql_fetch_array($ptr_category))
							{
								$get="SELECT name,subject_id FROM subject where subject_id='".$data_category['subject_id']."' ";
								$myQuery=mysql_query($get);
                                while($row = mysql_fetch_assoc($myQuery))
								{            
									?>

									<option value = "<?php echo $row['subject_id']?>" <? if (isset($course_interested) && $course_interested == $row['name']) echo "selected";?>> <?php echo $row['name'] ?> </option>
									<?php 
								} 
							}?>
                    		</select>
                      	</td>
					<?php }?>	
					
						<td align="right" width="20%">Select Topic</td>
						<td width="20"><?php?></td>
						<td align="left" width="40%">
						<select id="unit_id" name="unit_id" class="input_select" style="width:200px" >
						
						<?php if($record_id !=''){
							$selec_question = " select * from ex_question where question_id ='".$record_id."' ";
							$c= mysql_query($selec_question);
							$cs = mysql_fetch_array($c);
							$sele_init_name="select topic_name,  topic_id  from topic where topic_id ='".$cs['unit_id']."'";
							$ptr_unit=mysql_query($sele_init_name);
							while($fetch_name=mysql_fetch_array($ptr_unit))
								{
								   
									if($fetch_name['topic_id']==$ptr_question['unit_id'])
									{
										$sel='selected="selected"';
									}
									?>
									<option value ="<?php echo $fetch_name['topic_id'] ?>" selected > <?php echo $fetch_name['topic_name'] ?> </option>
									<?php

								}
						}else{ ?>
							<option value="">Select topic</option>
						<? }?>
						</select></td>
					</tr>   
					</table>



		<!--*********************************************************Multiple*******************************************************************************--->
		<table  width="101%" >
				
                <tr>
                   <td colspan="2">
                    <table cellpadding="5" width="100%" >
					<?php if($record_id !=''){
						$selec_question = " select * from ex_question where question_id ='".$record_id."' and unit_id='".$unit_id."' ";
						$ptr_question= mysql_query($selec_question);
						$i=1;
						while($dat_question = mysql_fetch_array($ptr_question))
						{
						?>
					<tr>
					<td align="center">
					
					<div  style="padding:0; background-color:" scrolling="auto">
						<table align="center" border="0" cellspacing="15" cellpadding="0"  id="tbl" style=" border:solid #000099 1px;  background-color:white"> 
							<tr>
							<!-- <td style="padding-top:58px;">
									<div>Answer</div>
									< ?php 
								$sel_rec="select question_id from student_paper where question_id='".$dat_question['question_id']."' ";
								
								$ptr_unit=mysql_query($sel_rec);
								if(mysql_num_rows($ptr_unit))
								{
									$disabled='onclick="return false;" onkeydown="return false;" ';
									$title="can not change right ans";
								}
								"<br />".$sel_opt=" SELECT option_id,option_title,answer,opt_ids FROM `options` WHERE `question_id`=".$dat_question['question_id']." ORDER BY `option_id` ASC ";
								$ptr_opt=mysql_query($sel_opt);
								$n=1;
								$rght = 0;
								while($data_opt=mysql_fetch_array($ptr_opt))
								{
									if(1==$n){ $no= "A";}else if(2==$n){$no= "B";}elseif(3==$n){$no= "C";}elseif(4==$n){$no= "D";}
									?>
									<input type="radio" name="right_ans_" < ?php if($data_opt['answer']=="y"){ echo 'checked="checked"'; $rght=$n;}?> id="right_ans_" value="< ?php echo $n; ?>" < ?php echo $disabled?>  onclick="setRight(< ?php echo $n ?>)" /> <?php echo $no; ?>)<br /><br />
								< ?php
								$n++;
								}
								?>
								</td> -->
								<td>
									<table border="0" >
										<tr>
											<td width="125"  valign="top" >
												<div align="left">Question</div>
											</td>
											<td  colspan="3">
												<textarea id="question_1" name="question"  style="width: 96%;font-family:Arial; " size="100" class="input_textarea" ><?php echo stripslashes(html_entity_decode($dat_question['question_title'])) ?></textarea>
												<input name="question_id" type="hidden" value="<?php echo $dat_question['question_id'];?>" />
											</td>
										</tr>
										<?php 
											$sele_ques_img="select question_title,question_id,question_img from ex_question where question_id=".$dat_question['question_id']."";
											$ptr_ques=mysql_query($sele_ques_img);
											if(mysql_num_rows($ptr_ques))
											{
												$data_ques_img=mysql_fetch_array($ptr_ques);?>
                                            <tr>
                                            	<td valign="top"><div align="left">Ques. Image</div></td>
                                                <td valign="top">
												<?php 
												if($record_id && $data_ques_img['question_img'] && file_exists("ex_question_photo/".$data_ques_img['question_img']))
													echo '<img height="90px" width="90px" src="ex_question_photo/'.$data_ques_img['question_img'].'"><br>
												<a href="'.$_SERVER['PHP_SELF'].'?deleteThumbnail=1&question_id='.$data_ques_img['question_id'].'&record_id='.$record_id.'&unit_id='.$record_unit_id.'">Delete </a>/ <label for="upload-photo" style="cursor:pointer;">update</label><input type="file" name="ques_img_" style=" width: 260px;overflow:hidden;" id="upload-photo"/></td>';
												else echo '<input type="file" name="ques_img_1" style=" width: 260px;overflow:hidden;" /></td>';
												?>
                                            </tr>
											<?php
											}
											$sel_rec="select question_id from ex_student_paper where question_id='".$dat_question['question_id']."' ";
								
											$ptr_unit=mysql_query($sel_rec);
											if(mysql_num_rows($ptr_unit))
											{
												$disabled='onclick="return false;" onkeydown="return false;" ';
												$title="can not change right ans";
											}
											$sel="select option_id,option_title,answer,opt_ids,option_image from `ex_options` WHERE `question_id`=".$dat_question['question_id']." ORDER BY `option_id` ASC ";
											$ptr_option=mysql_query($sel);
											$k=1;$i=1;$n=1;
											$rght = 0;
											while($data_options=mysql_fetch_array($ptr_option))
											{
												if(1==$n){ $no= "A";}else if(2==$n){$no= "B";}elseif(3==$n){$no= "C";}elseif(4==$n){$no= "D";}
												?>
												
											<tr>
												<td  valign="top"><div align="left">Option&nbsp;<? echo $k;?></div></td>
                                                <td width="154">
												<input type="radio" name="right_ans_" <?php if($data_options['answer']=="y"){ echo 'checked="checked"'; $rght=$n;}?> id="right_ans_" value="<?php echo $n; ?>" <?php //echo $disabled?>  onclick="setRight(<?php echo $n ?>)" />
                                            	
                                                	<input type="text" name="option<?php echo $k?>"  class="input_text"   value="<?php if($_POST['option'.$k]) echo $_POST['option'.$k]; else echo stripslashes(html_entity_decode($data_options['option_title'])) ;?>" style="width: 200px; vertical-align:middle">
                                                    <input name="option_id_<?php echo $k; ?>" type="hidden" value="<?php echo $data_options['option_id'];?>" />
                                                    <?php 
												if($record_id && $data_options['option_image'] && file_exists("ex_question_photo/".$data_options['option_image']))
													echo '<img height="90px" width="90px" src="ex_question_photo/'.$data_options['option_image'].'"><br>
												<span style="text-align:right"><a href="'.$_SERVER['PHP_SELF'].'?deleteOptionThumbnail=1&question_id='.$dat_question['question_id'].'&option_id='.$data_options['option_id'].'&record_id='.$record_id.'&unit_id='.$record_unit_id.'">Delete</a> /<label for="upload-photo1" style="cursor:pointer;">update</label> <input type="file" name="opt_img_'.$k.'" style=" width: 260px;overflow:hidden;" id="upload-photo1"/></span>';
												else echo '<input type="file" name="opt_img_'.$i.'" style=" width: 260px;overflow:hidden;" />';
												?>
                                                 </td>   <input name="option_ids" id="option_ids" type="hidden" value="<?php echo $data_options['option_id']  ?>" />
                                               
                                            </tr>
												<?php// $i++; }?>
											<?php $k++;$n++;
										$i++;}?>
											
											
										<input type="hidden" name="no_of_extra_" id="extra" value="1" />

									</table>
								</td>
							</tr>
							<tr><td></td><td align="right"><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Question" name="save_changes"  /></td><td></td></tr>
						</table>
					</div>
				
						
					</td>
					</tr>
					<?php $i++; }?> <input type="hidden" name="total_number_of_questions" id="total_number_of_questions" value="<?php echo ($i-1) ?>" /><?php }else{?><input type="hidden" name="total_number_of_questions" id="total_number_of_questions" value="0" />
					<tr>
					<td align="center">
						<input type="button"  name="Add" class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" >
					<input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >
					</td>
					
					</tr>
                     <tr>
                       <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1" onKeyUp="create_floor();" value="0" />
                         <script language="javascript"> 

							function setRight(opt_no)
							{
								//opt_no = opt_no.trim();
								//alert('vv'+opt_no+'xx');
								tot=  $('option').length;
								//alert($("#lang option").text());
								 $("option").each(function() { 
								var str = $(this).text(); 
								//alert(str);
								if(str !='Language')
								{
									ss =str.trim();
								
									// $("#right_ans_"+opt_no+ss).attr('checked', 'checked');
									if(document.getElementById("right_ans_"+opt_no+ss))
									{
										document.getElementById("right_ans_"+opt_no+ss).checked = true;
									}
							}
							});
								 
							}
							
                                function floors(idss)
                                {
									
									total_number_of_questions = parseInt(document.getElementById('total_number_of_questions').value);
									
									next_quest = total_number_of_questions+1
									document.getElementById('total_number_of_questions').value =next_quest;
									
                                    var shows_data='<div id="floor_id'+idss+'" style="padding:0; background-color:" scrolling="auto"><table align="center" border="0" cellspacing="15" cellpadding="0"  id="tbl'+idss+'" style=" border:solid #000099 1px;  background-color:white"> <tr><td style="padding-top:58px;"><div></div></td><td><table border="0" ><tr><td width="125"  valign="top" ><div align="left">Question no '+idss+'</div></td><td  colspan="3"><textarea id="question_'+idss+'" name="question_'+idss+'"  style="width: 96%;font-family:Arial; " size="100" class="input_textarea" ></textarea><input name="question_id_'+next_quest+'" type="hidden" value="'+next_quest+'" /></td></tr><tr><td valign="top"><div align="left">Ques. Image</div></td><td valign="top"><input type="file" id="ques_img_a'+idss+'" name="ques_img_a'+idss+'" style=" width: 260px;overflow:hidden;" /></td></tr><tr><td  valign="top"><div align="left">Option&nbsp;1</div></td><td width="225"><input type="radio" class="ans_opt_'+idss+'" name="right_ans_'+idss+'" id="right_ans_1'+idss+'" value="1" onclick="setRight(1)" >A)<input type="text" style="width: 200px" id="option1_'+idss+'" name="option_1'+idss+'" size="10" class="input_text option_'+idss+'" /></td><td valign="top" colspan=""><input type="file" name="opt_img1_'+idss+'" id="opt_img1_'+idss+'"  title="" style=" width: 170px;overflow:hidden;" /></td></tr><tr><td width="61"  valign="top"><div align="left">Option&nbsp;2</div></td><td width="225"><input type="radio" class="ans_opt_'+idss+'" name="right_ans_'+idss+'" id="right_ans_2'+idss+'" value="2" onclick="setRight(2)"  />B)<input type="text" class="input_text option_'+idss+'" style="width: 200px" id="option2_'+idss+'" name="option_2'+idss+'" style=" width: 170px;overflow:hidden;" /></td><td valign="top" colspan=""><input type="file" name="opt_img2_'+idss+'" id="opt_img2_'+idss+'" title="" style=" width: 170px;overflow:hidden;" /></td></tr><tr><td  valign="top"><div align="left">Option&nbsp;3</div></td><td width="225"><input type="radio" class="ans_opt_'+idss+'" name="right_ans_'+idss+'" id="right_ans_3'+idss+'" value="3" onclick="setRight(3)"> C)<input type="text" style="width: 200px" id="option3_'+idss+'" name="option_3'+idss+'" size="10" class="input_text option_'+idss+'"/></td><td valign="top" colspan=""><input type="file" name="opt_img3_'+idss+'" id="opt_img3_'+idss+'" title="" style=" width: 170px;overflow:hidden;" /></td></tr><tr><td width="70"  valign="top"><div align="left">Option&nbsp;4</div></td><td width="225"><input type="radio" class="ans_opt_'+idss+'" name="right_ans_'+idss+'" id="right_ans_4'+idss+'" value="4" onclick="setRight(4)" /> D)<input type="text" style="width: 200px" id="option4_'+idss+'" name="option_4'+idss+'" size="10" class="input_text option_'+idss+'" /></td><td valign="top" colspan=""><input type="file" name="opt_img4_'+idss+'" id="opt_img4_'+idss+'" title="" style=" width: 170px;overflow:hidden;" /></td></tr><input type="hidden" name="no_of_extra_'+idss+'" id="extra" value="1" /></table></td></tr></table></div>';
                                    document.getElementById('floor').value=idss;
                                    return shows_data;
                                }
                                
                        </script>
                       
                    </tr>
                  
                 </table>
					<input type="hidden" name="floor" id="floor"  value="0" />
                            <div id="create_floor"></div>
                        </td>
                      </tr>
					    <tr><td></td><td align="right"><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Question" name="save_changes" onclick="return validation();" /></td><td></td></tr>
                    </table>
					<?php }?>
             </td>
            </tr>
			</form>
         </table>
		 
		 <?php }?>  	 
           
           <!--****************************************************************************************************************************************--->		
		
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

<script>
function select_topic(topic)
{
	var data1="subject_id="+topic;	
	 //alert(data1);
	$.ajax({
	url: "ex_show_topic.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		//alert(html);
		if(html !='')
		{
			sep=html.split("###");
			document.getElementById("unit_id").innerHTML=sep[0];
			
		}
	},
       error:function(exception){alert('Exception:'+exception);}
	});

    
	
}
</script>
<script language="javascript">
create_floor('add');
</script>
<!--footer start-->

<div id="footer"><? require("ex_include/footer.php");?></div>

<!--footer end-->

</body>

</html>

<?php $db->close();?>