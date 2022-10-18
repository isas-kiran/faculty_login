<?php include 'ex_inc_classes.php';?>
<?php include "ex_admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
     $sql_record= "SELECT * FROM ex_exams where exams_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
} 

$rowSQL = mysql_query("SELECT MAX(exams_id) as max FROM `ex_exams`" );
$row = mysql_fetch_array( $rowSQL );
$largestNumber = $row['max']+100;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php if($record_id) echo "Edit"; else echo "Add";?>
Exam</title>
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
			$("#course_id").chosen({allow_single_deselect:true});
			$("#syllabus_id").chosen({allow_single_deselect:true});
			$("#faculty_id").chosen({allow_single_deselect:true});
			$("#language_id").chosen({allow_single_deselect:true});
			$("#passfrom").chosen({allow_single_deselect:true});
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
    </script>
	<!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
	<link rel="stylesheet" href="js/chosen.css" />
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    
    <script type="text/javascript">
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({dateFormat: 'dd/mm/yy', changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
        });
    </script>
    <script>
function show_subject(subject)

	{

		var data1="show_subject=1&subject="+subject;
		 $.ajax({

		url: "ex_show_subjects.php", type: "post", data: data1, cache: false,

		success: function (html)
		{
		 	document.getElementById('show_subject').innerHTML=html;
		}

	});

}

 function show_papers()
 {
     var syllabus_id = document.getElementById('syllabus_id').value;

	 var language_id=document.getElementById('language_id').value;
	 //alert(syllabus_id);

	if(syllabus_id !='' || language_id !='' ) 
	{

	 var course="show_unit=1&syllabus_id="+syllabus_id+"&language_id="+language_id;
	 $.ajax({
		 url: "ex_show_papers.php", type: "post", data: course, chache:false,
		 success: function (chapters)
		 {			 
		
		 	document.getElementById('show_papers').innerHTML=chapters;
			total_units = document.getElementById('total_no').value;
			addition ='';
			for(i=1;i<=total_units;i++)
			{
				addition += '<div id="quest_sel_'+i+'" ></div>'; 
			}
			document.getElementById('show_ques').innerHTML=addition;
		 }

	 });

	}else{

		document.getElementById('show_papers').innerHTML='';

	}
 }
	
	//contact ='';					
function show_ques(ids)
{
	total_mbr =  document.getElementById("total_papers").value;
	//alert(total_mbr);
	
	
	for(i=1; i<=total_mbr;i++)
	{
		id="requirment_id"+i;
		//alert(id);
		if(document.getElementById(id).checked)
		{
			contact =document.getElementById(id).value;
			//contact +=',';
		}
	}
	
 	var data1="paper_ids="+contact;	
	//alert(data1);
        $.ajax({
            url: "ex_show_ques_counter.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				//alert(html);
				 
				  document.getElementById('exam_mark').value=html;
				  //$(".multiselect").multiselect();
            }
            });
}

function selectalls() 
	{
		if($("#selectall").attr("checked")==true){
		$('.case').each(function() {
		$(this).attr('checked','checked');
		showUser();
		});
		}else{
		$('.case').each(function() {
		$(this).attr('checked','');
		showUser();
		});
		}
	}
</script> 
 

 <script language="javascript" src="js/script.js"></script>
 <script language="javascript" src="js/conditions-script.js"></script>
     
      <style>	
					 
	.addBtn{background:no-repeat url(images/add.png); width:17px; border:0px; cursor:pointer;}
	.delBtn{background:no-repeat url(images/delete.png);width:17px; border:0px; cursor:pointer;}
	.editBtn{background:no-repeat url(images/edit_icon.gif); width:17px; border:0px; cursor:pointer;}
	.clrButton{background:no-repeat url(images/edit_clear.png);width:17px; border:0px; cursor:pointer;}
	.inactive{ background-color:#FFF;cursor:pointer; color:#000}
	.active{ background-color:#699;cursor:pointer; color:#FFF}
	.hidden{ display:none; width:0px; height:0px;}	
	.tbl{border-radius:3px; border:#333 solid 1px; background-color:#CCC; }
	.pointer{ cursor:pointer;}
	</style>
<script>
function validin()
{
	frm=document.jqueryForm;
	disp_error="Please Correct Following errors\n\n";
	error="";
	if(frm.syllabus_id.value=='')
	{
		disp_error +="Select Syllabus Name\n";
		document.getElementById('syllabus_id').style.border = '1px solid #f00';
		frm.syllabus_id.focus();
		error="yes";
	}
	if(frm.language_id.value=='')
	{
		disp_error +="Select Language Name\n";
		document.getElementById('language_id').style.border = '1px solid #f00';
		frm.language_id.focus();
		error="yes";
	}
	
	if(frm.school_code.value=='')
	{
		disp_error +="Enter School Code\n";
		document.getElementById('school_code').style.border = '1px solid #f00';
		frm.school_code.focus();
		error="yes";
	}
	
	if(frm.validity_fromdate.value=='')
	{
		disp_error +="Enter From Date\n";
		document.getElementById('validity_fromdate').style.border = '1px solid #f00';
		frm.validity_fromdate.focus();
		error="yes";

	}
	else
	{
		var record_ids=document.getElementById('record_id').value;
		if(record_ids =='')
		{
			if(isFeatureDate(frm.validity_fromdate.value))
			{
			}
			else
			{
				 disp_error +='Validity To Date is not Less than Todays Date \n';
				 document.getElementById('validity_fromdate').style.border = '1px solid #f00';
				 frm.validity_fromdate.focus();
	
				 error='yes';
			}
		}
	}

	if(frm.validity_todate.value=='')
	{
		disp_error +="Enter To Date\n";
		document.getElementById('validity_todate').style.border = '1px solid #f00';
		frm.validity_todate.focus();
		error="yes";
	}
	else
	{ 
		if(isValidateDate(frm.validity_fromdate.value,frm.validity_todate.value))
		{
		}
		else
		{
			disp_error +='Validity To Date is not Less than or Equal to From Date up Date\n';
			document.getElementById('validity_todate').style.border = '1px solid #f00';
			frm.validity_todate.focus();
			error='yes';
		}
	}
	if(frm.exam_number.value=='')
	{
		disp_error +="Enter Exam number\n";
		document.getElementById('exam_number').style.border = '1px solid #f00';
		frm.exam_number.focus();
		error="yes";
	}
	if(frm.passfrom.value == 0)
	{
		disp_error +='Passing grade is not to be 0\n';
		document.getElementById('passfrom').style.border = '1px solid #f00';
		frm.passfrom.focus();
		error="yes";
	}
	if(frm.exam_mark.value=='')
	{
		disp_error +="Enter Exam Mark \n";
		document.getElementById('exam_mark').style.border = '1px solid #f00';
		frm.exam_mark.focus();
		error="yes";
	}
	/*else

	{

		var chk_arr = $('input[name="requirment_id[]"]:checked').length;
		var toatal_mark=frm.exam_mark.value;
		if(chk_arr ==toatal_mark)
		{
		}
		else
		{

			disp_error +="Exam Mark and Total Selected Question are not equals \n";
			document.getElementById('exam_mark').style.border = '1px solid #f00';
			frm.exam_mark.focus();
			error="yes";
		}
	}*/

	if(frm.exam_duration.value=='')
	{
		disp_error +="Enter Exam Duration \n";
		document.getElementById('exam_duration').style.border = '1px solid #f00';
		frm.exam_duration.focus();
		error="yes";
	}
	
	if(error=="yes")
	{
		alert(disp_error);
		return false;
	}
	else
	return true;
	
}

 function isFeatureDate(value) {

      values = value.split('/');
           
        var now = new Date;
         /* New Code by Sudhir*/
			value=values[2]+'-'+values[1]+'-'+values[0];
         
        var target = new Date(value);

            //alert(value);

         
        if (target.getFullYear() > now.getFullYear()) {
            return true;
        } else if (target.getMonth() > now.getMonth()) {
            return true;
        } else if (target.getDate() >= now.getDate()) {
            return true;
        }

        return false;
    }
function isValidateDate(start_date,end_date) {

    start_dates = start_date.split('/');
	start_date=start_dates[2]+'-'+start_dates[1]+'-'+start_dates[0];
    var start_date = new Date(start_date);
	
	end_dates = end_date.split('/');
	end_date=end_dates[2]+'-'+end_dates[1]+'-'+end_dates[0];
    var end_date = new Date(end_date);

            //alert(value);
	if (start_date.getFullYear() < end_date.getFullYear()) {
		return true;
	} else if (start_date.getMonth() < end_date.getMonth()) {
		return true;
	} else if (start_date.getDate() <= end_date.getDate()) {
		return true;
	}

	return false;
}
	
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
    <td width="30" class="top_left"></td>
    <td width="988" valign="bottom" class="top_mid"><?php include "ex_include/exams_menu.php"; ?></td>
    <td width="8" class="top_right"></td>
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
						 	$exame_dates= explode('/',$_POST['validity_fromdate'],3);     
						 	$from_dates= $exame_dates[2].'-'.$exame_dates[1].'-'.$exame_dates[0]; 
						 	$exame_dates= explode('/',$_POST['validity_todate'],3);     
						 	$to_dates= $exame_dates[2].'-'.$exame_dates[1].'-'.$exame_dates[0]; 
						 
						   	$syllabus_id=$_POST['syllabus_id'];
							$course_id=$_POST['course_id'];
							$faculty_id=$_POST['faculty_id'];
						   	$language_id=$_POST['language_id']; 
						  	/* $from_date=$_POST['validity_fromdate'];
						   	$to_date=$_POST['validity_todate'];*/
	
						   	$exam_number=$_POST['exam_number'];
						   	$passfrom=$_POST['passfrom'];
						   	$passto=$_POST['passto'];
						   	$failfrom=$_POST['failfrom'];
						   	$failto=$_POST['failto'];
						   	$exam_mark=$_POST['exam_mark'];
						   	$exam_duration=$_POST['exam_duration'];
							
						  	$school_code=$_POST['school_code'];
						   	$unit_id=(true== isset($_POST['unit_id'])) ? $_POST['unit_id'] : 0;
							
							$question_id=$_POST['question_id'];
	
							$ex_number='';
							if($record_id !='')
							{
	
								$ex_number="and exams_id !='".$record_id."'";
	
							}
							if($exam_number=="")
							{
									$success=0;
	
									$errors[$i++]="Enter exam Number ";
							}
							else
							{
	
								$sel_ques="select exams_id from ex_exams where exam_number='".$exam_number."' ".$ex_number."  ";
								$my_query1=mysql_query($sel_ques);
								if(mysql_num_rows($my_query1))
								{
										$success=0;
										$errors[$i++]="Exam Number that you entered is already exist ";
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
                         </td></tr>   <br><br>  
                                <?php
                            }
                            else
                            {
                                $success=1;

							    $data_record['syllabus_id'] =$syllabus_id;
								 $data_record['course_id'] =$course_id;
								  $data_record['faculty_id'] =$faculty_id;
                                $data_record['language_id'] = $language_id;
							    $data_record['validity_fromdate'] =$from_dates; 
								$data_record['validity_todate'] =$to_dates; 
                                $data_record['exam_number'] = $exam_number;
							   //$data_record['exam_name'] = $exam_name;
							    $data_record['pass_grade_from'] =$passfrom; 
                                /*$data_record['pass_grade_to'] = $passto;
								$data_record['fail_grade_from'] =$failfrom; 
                                $data_record['fail_grade_to'] = $failto;*/
							  	$data_record['unit_id'] = $unit_id; 
							    $data_record['exam_mark'] = $exam_mark;
								$data_record['exam_duration'] = $exam_duration;
								$data_record['school_code']=$school_code;

								$paper_id=$_POST['requirment_id']; 
								//$data_records['question_id']=$question_id;								//echo $hhdhdhdhdhdhdhhdhhd;

								//echo $total_type1=$_POST['total_type1'];

								$total_ques=count($_POST['chapter_id']);

								$data_record['total_ques']=$total_ques;
								$data_record['added_date']=date('Y-m-d H:i:s');

                               if($record_id)
                               {
                                	$ptr_del_section=mysql_query($del_ex_section);
									//$update_exam = " update `exams` set `syllabus_id`='".$syllabus_id."' , `course_id`='".$course_id."', `faculty_id` = '".$faculty_id."', `unit_id`='".$_POST['unit_id']."' , `language_id` = '".$language_id."' , `validity_fromdate`='".$from_dates."' , `validity_todate`='".$to_dates."', `exam_number`='".$exam_number."', `pass_grade_from`='".$passfrom."' , `pass_grade_to`='".$passto."', `fail_grade_from`='".$failfrom."',`fail_grade_to`='".$failto."', `exam_mark`='".$exam_mark."', `exam_duration`='".$exam_duration."', `total_ques`='".$total_ques."', `school_code`='".$school_code."' where exams_id='".$record_id."'  ";
									 //$update_exam_1 = mysql_query($update_exam);
									//echo $update_exam_1;
									$where_record="exams_id='".$record_id."'";
                                    $db->query_update("ex_exams", $data_record,$where_record);
									
                                    //$record_ids=$db->query_insert("exams", $data_record);
									//$exams_id=mysql_insert_id(); 
									//====================FOR Type1 INSERT=====================================
									//for($h=0;$h<count($_POST['requirment_id']);$h++)
									//{
										$del="delete from ex_exams_section where exams_id='".$record_id."'";
										$ptr_del=mysql_query($del);
										
										"<br />".$select_unit_ids="select * from ex_papers_section where papers_id='".$_POST['requirment_id']."'";
										$ptr_unit_ids=mysql_query($select_unit_ids);
										while($data_unit_ids=mysql_fetch_array($ptr_unit_ids))
										{
											$data_record_type1['papers_id'] =$_POST['requirment_id'];
											$data_record_type1['syllabus_id'] =$syllabus_id;
											$data_record_type1['exams_id'] = $record_id;
											$data_record_type1['unit_id'] = $data_unit_ids['unit_id']; 
											$data_record_type1['language_id'] = addslashes(trim($_POST['language_id'])); 
											$data_record_type1['added_date'] = date('Y-m-d'); 
											$data_record_type1['question_id'] = $data_unit_ids['question_id'];
											$record_id1=$db->query_insert("ex_exams_section", $data_record_type1);
										}
										
										$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `admin_id`) VALUES ('add_exam','Edit','".$exam_number."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."')";
										$query=mysql_query($insert); 
									//}
		                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
									$record_ids=$db->query_insert("ex_exams", $data_record);
									$exams_id=mysql_insert_id(); 
									//====================FOR Type1 INSERT=====================================
									//for($h=0;$h<count($_POST['requirment_id']);$h++)
									//{

									$select_unit_ids="select * from ex_papers_section where papers_id='".$_POST['requirment_id']."' and language_id='".$_POST['language_id']."' ";
									$ptr_unit_ids=mysql_query($select_unit_ids);
									while($data_unit_ids=mysql_fetch_array($ptr_unit_ids))
									{								
										$data_record_type1['papers_id'] =$_POST['requirment_id'];
										$data_record_type1['syllabus_id'] =$syllabus_id;
										$data_record_type1['exams_id'] = $exams_id;
										$data_record_type1['unit_id'] = $data_unit_ids['unit_id']; 
										$data_record_type1['language_id'] = addslashes(trim($_POST['language_id'])); 
										$data_record_type1['added_date'] = date('Y-m-d'); 
										$data_record_type1['question_id'] = $data_unit_ids['question_id'];
										$record_id1=$db->query_insert("ex_exams_section", $data_record_type1);
									}
									$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `admin_id`) VALUES ('add_exam','Add','".$exam_number."','".$record_ids."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);
									//}									
									echo ' Record added successfully';
								}
                            }
                        }
                        if($success==0)
                        {                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data">
            <table border="0" cellspacing="15" cellpadding="0" width="100%">
                    <tr>
                        <td colspan="3" class="orange_font">* Mandatory Fields</td>
                    </tr>

					<tr>

<td width="30%" valign="top"> Select Cource <span class="orange_font">*</span></td>

<td width="30%" style="">
	 <select id="course_id" name="course_id" class="input_select" >

	 <option value="">Select</option>

	 <?php
	 
	 $selcetexamcourse = "select course_id,course_name from courses where course_id='".$row_record['course_id']."' ";
	 
	 $ptr_course_name=mysql_query($selcetexamcourse);
	 $course_name=mysql_fetch_array($ptr_course_name);

		 $course_interested=$course_name['course_name'];

		  $select_category = "select course_id,course_name from courses";
 $ptr_category = mysql_query($select_category);
 
 
	 
 while($data_category = mysql_fetch_array($ptr_category))
 {
	 $get="SELECT course_name,course_id FROM courses where course_id='".$data_category['course_id']."' ";

		 $myQuery=mysql_query($get );
		 
		 while($row = mysql_fetch_assoc($myQuery))

		 {
	
	 ?>

	 <option value = "<?php echo $row['course_id']?>" <? if (isset($course_interested) && $course_interested == $row['course_name']) echo "selected";?>> <?php echo $row['course_name'] ?> </option>
 <?php } }?>

   </select>

				 </td> 

				 <td width="40%"></td>

</tr>


                      <tr>

                       <td width="30%" valign="top"> Select Subject <span class="orange_font">*</span></td>

                       <td width="30%" style="">
                            <select id="syllabus_id" name="syllabus_id" class="input_select"  onChange="show_papers(this.value);">

                            <!-- <option value="">Select</option>

                            < ?php

								$sele_syllabus_name="select subject_id,name from subject where subject_id='".$row_record['syllabus_id']."' ";

								$ptr_syllabus_name=mysql_query($sele_syllabus_name);

								$data_syllabus_name=mysql_fetch_array($ptr_syllabus_name);

								$syllabus_interested=$data_syllabus_name['name'];

							  // $syllabus_namess = " select name,subject_id from subject ";

							   $ptr_syllabus_cat = mysql_query($syllabus_namess);

							   while($data_cat = mysql_fetch_array($ptr_syllabus_cat))

							   { 

								$get="SELECT name,subject_id FROM subject where subject_id='".$data_cat['subject_id']."' ";

								$myQuery=mysql_query($get);

								while($row = mysql_fetch_assoc($myQuery))

								{

							?>

                            <option value = "<?php echo $row['subject_id']?>" <? if (isset($syllabus_interested) && $syllabus_interested == $row['name']) echo "selected";?> > <?php echo $row['name'] ?> </option>
                            < ?php }

				echo " </optgroup>"; 
				   }
?> -->
						 <option value="">Select</option>
                                       <?php
                                       $course_category = "SELECT * FROM `course_domain_category` ";
                                       $ptr_course_cat = mysql_query($course_category);
                                       while($data_cat = mysql_fetch_array($ptr_course_cat))
                                       {
                                            echo " <optgroup label='".$data_cat['cat_name']."'>";
                                            $get="SELECT subject_id,name  FROM subject where course_domain_id='".$data_cat['cat_id']."' order by subject_id";
                                            $myQuery=mysql_query($get);
                                            while($row = mysql_fetch_assoc($myQuery))
                                            {
                                                $selected_course='';
                                                if($row_record['subject_id'] == $row['subject_id'])
                                                {
                                                    $selected_course='selected="selected"';
                                                }
                                            ?>
                            				<option <?php echo $selected_course; ?> value = "<?php echo $row['subject_id']?>" <? if (isset($syllabus_interested) && $syllabus_interested == $row['name']) echo "selected";?> > <?php echo $row['name'] ?> </option>
                           				<?php }
										echo " </optgroup>";
										}?>
                            				<option value="custome">select</option>

                          </select>

                                        </td> 

                                        <td width="40%"></td>

                    </tr>
					
					 
					  <tr>

                       <td width="30%" valign="top"> Select Faculty <span class="orange_font">*</span></td>

                       <td width="30%" style="">
                    	<select id="faculty_id" name="faculty_id" class="input_select" >

                    	<option value="">Select</option>
						<?php
						$select_faculty = "select admin_id,name from site_setting where 1 and system_status='Enabled'";
                        $ptr_category = mysql_query($select_faculty);
                        while($data_category = mysql_fetch_array($ptr_category))
                        {
                            
                           $get="SELECT name,admin_id FROM site_setting where admin_id='".$data_category['admin_id']."' ";

								$myQuery=mysql_query($get);
								
                                while($row = mysql_fetch_assoc($myQuery))

								{

							?>

                            <option value = "<?php echo $row['admin_id']?>" <? if (isset($faculty_interested) && $faculty_interested == $row['name']) echo "selected";?>>  <?php echo $row['name'] ?> </option>
						<?php }} ?>

                          </select>

                                        </td> 

                                        <td width="40%"></td>

                    </tr>

                    <tr>

                        <td width="20%">Select Language<span class="orange_font">*</span></td>

                                        <td width="30%" style="">

                                        <select id="language_id" name="language_id" class="input_select">

                                        <option value="">Select</option>

      									<?php

										$language_namess = " select language_name,language_id from ex_language ";

										$ptr_language_cat = mysql_query($language_namess);

										while($data_cat = mysql_fetch_array($ptr_language_cat))

										{ 

                                        	$get="SELECT language_name,language_id FROM ex_language where language_id='".$data_cat['language_id']."' order by language_id";
											$myQuery=mysql_query($get);

										 					while($row = mysql_fetch_assoc($myQuery))

															{

															?>
                            <option value = "<?php echo $row['language_id']?>" <? if ($row['language_id'] == '1') {echo "selected"; } ?>  > <?php echo $row['language_name'] ?> </option>
                            <?php }
													echo " </optgroup>";
														   }
													?>
                            
                          </select>
                                        </td> 
                                        
                                        <td width="40%"></td>
                      
                          </tr>                    <tr>
                   <td width="20%">School Code<span class="orange_font">*</span></td>
                   
                   <td width="40%" style=""><input type="text" class="validate[] input_text" name="school_code" id="school_code" value="<?php if($_POST['school_code']) echo $_POST['school_code']; else echo $row_record['school_code']; ?>" /></td> 
                    </tr>                   <tr>
                   <tr>
                        <td valign="top">Exam Validity :</td>
                       
                    </tr>
                    
               <tr>
               
                <!--td valign="top"></td-->     
                <td width="20%">From Date<span class="orange_font"></span></td>
                <td width="40%" style="">
                    <input type="text" class="input_text datepicker" name="validity_fromdate" id="validity_fromdate" 
                    value="<?php if($_POST['validity_fromdate']) echo $_POST['validity_fromdate']; else if($row_record['validity_fromdate'] !='')

					{

				$arrage_date= explode('-',$row_record['validity_fromdate'],3);     

				echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0]; }?>" />
                </td> 
                </tr>

                <tr>

                <td width="15%">To Date<span class="orange_font"></span></td>

                <td width="20%">

                    <input type="text" class="input_text datepicker" name="validity_todate" id="validity_todate" 

                    value="<?php if($_POST['validity_todate']) echo $_POST['validity_todate']; else if($row_record['validity_todate'] !='')

					{

				$arrage_date= explode('-',$row_record['validity_todate'],3);     

				echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];}?>" /> 


                </td> 

            </tr>    

             		<!--<tr>
                        <td valign="top">Exam Name<span class="orange_font">*</span></td>
                        <td style="box-shadow: 3px 3px 3px #888888;"><input type="text"  class="validate[] input_text" name="exam_name" id="exam_name" value="<?php //if ($_POST['save_changes']) echo $_POST['exam_name']; else echo $row_record['exam_name']; ?>" /></td> 
                        
                    </tr>  -->
                   
                    <tr>

                        <td height="40" valign="top">Exam Number<span class="orange_font">*</span></td>
                    <td style=""><input type="text"  class="validate[] input_text" name="exam_number" id="exam_number" value="<?php if($_POST['exam_number']) echo $_POST['exam_number']; elseif($record_id==''){ echo $largestNumber ;} else echo $row_record['exam_number'];
						?>" /></td> 
                        <?php  ?>

                    </tr>

                      <tr>
                       <td width="20%">Exam Passing (in Percentage) <span class="orange_font">*</span></td>
                        <td>
                        <select name="passfrom" id="passfrom">
						<?php 
                        for($i=0; $i<=100;$i++)
                        {?>
                            <option  value="<?php echo $i; ?>" <?php if (isset($passfrom) && $passfrom == $i) echo "selected"; elseif( $i == $row_record['pass_grade_from']) echo "selected";?> ><?php echo $i; ?></option>
                        <?php 
						}
                        ?>
                        
                      </select>

                        <span class="orange_font">(Note : Passing in Percentage)</span>

                       </td> 
                     </tr>

                <?php
				if($record_id)
				{
					
					/*  "<br/>". $select_paper="select DISTINCT(papers_id) from exams_section where exams_id='".$_GET['record_id']."'";
					$ptr_paper_ids=mysql_query($select_paper);
					 $result ='';
					while($fetch_paper_ids=mysql_fetch_array($ptr_paper_ids))
					{
					
					 "<br/>".$select_unit_ids="select COUNT(papers_section_id) as papers_section_id from papers_section where papers_id='".$fetch_paper_ids['papers_id']."'";
                       $ptr_unit_ids=mysql_query($select_unit_ids);
					   
					   while($data_unit_ids=mysql_fetch_array($ptr_unit_ids))
                        {
							 $data_unit_ids['papers_section_id'];
							
							$result += $data_unit_ids['papers_section_id'];
							
						}
						//echo $result ;
					}
					 $result; */
				}
				//echo $result;
				?>

                     <tr>

                        <td height="0" valign="top">Exam Mark<span class="orange_font">*</span></td>

                        <td style="">           

                            <input type="text"  class="input_text" name="exam_mark" id="exam_mark" onKeyPress="return isNumber(event)" value="<?php if ($_POST['save_changes']) echo $_POST['exam_mark']; else echo $row_record['exam_mark']; ?>" />

						<span class="orange_font">(Note : Please Select Paper Name First)</span>

                        </td> 

                    </tr>

                    <tr>

                        <td valign="top">Exam Duration<span class="orange_font">*</span></td>

                        <td style="">           
                          <input type="text"  class="input_text" name="exam_duration" onKeyPress="return isNumber(event)" id="exam_duration" value="<?php if ($_POST['save_changes']) echo $_POST['exam_duration']; else echo $row_record['exam_duration']; ?>" /></td><td><span class="orange_font">(In Minute)</span></td>
                    </tr>

                    <tr>

                        <td valign="top"><b>Exam Section :</b></td>

                        <td>           

                      </td> 

                    </tr>

                    <tr>

                       <?php 

					   if($record_id)
					   {?>

						   <td width="38" colspan="3">

							<div id="show_papers">

                           <?php 

							if($record_id)

							{

								$sel_unit= "select syllabus_id,language_id from ex_exams where exams_id=".$record_id." order by exams_id asc";	

								$query_unit = mysql_query($sel_unit);

								$data_unit_id=mysql_fetch_array($query_unit);

							"<br>".	$select_existing = " select DISTINCT(papers_id) from ex_papers_section  where syllabus_id='".$data_unit_id['syllabus_id']."' and language_id='".$data_unit_id['language_id']."' ";

							  	$ptr_esxit = mysql_query($select_existing);

							   	$topic_array = array();

							  	$j=0;

								while( $data_exist = mysql_fetch_array($ptr_esxit))

								{

									$topic_array[$j]=$data_exist['papers_id'];

									$j++;

								}

								$i=1;

								 $sel_topic= "select syllabus_id,exams_id,language_id from ex_exams where exams_id=".$record_id." order by exams_id asc";	

								$query_topic = mysql_query($sel_topic);

								echo '<table width="100%">';

								echo  '<tr><td width="30%">Selected Papers</td>';

								while($row_member_topic = mysql_fetch_array($query_topic))

								{

									/*$sel_top = "select DISTINCT(unit_id) from exams_section where syllabus_id='".$row_member_topic['syllabus_id']."' and exams_id=".$row_member_topic['exams_id']." order by syllabus_id asc";	 
									$query_top = mysql_query($sel_top);
									$total_no = mysql_num_rows($query_top);
									$member_result='';*/
									$sel_top = "select DISTINCT(papers_id) from ex_papers_section where syllabus_id='".$row_member_topic['syllabus_id']."' and language_id='".$row_member_topic['language_id']."' ";	 

									$query_top = mysql_query($sel_top);

									$total_no = mysql_num_rows($query_top);

									$member_result='';

									$i=1;

									$call_function ='';

									while($row_member = mysql_fetch_array($query_top))
									   {

										   $timeouts = 10000*$i;

										   $sep_unit_id=explode(",",$row_member['unit_id']);

										   $sel_unit_name="select papers_id,paper_name from ex_papers where papers_id='".$row_member['papers_id']."'";

										   $ptr_unit=mysql_query($sel_unit_name);

										   $data_unit=mysql_fetch_array($ptr_unit);
										   echo  '<td style="border:1px solid #999;">'; 

										  $checked = '';

										   if($record_id)

										   {
												$select_existing = " select DISTINCT(exams_id) from ex_exams_section where papers_id='".$row_member['papers_id']."' and exams_id=".$record_id."";

							  					$ptr_esxit = mysql_query($select_existing);

												if(mysql_num_rows($ptr_esxit))
												{
													
												   $data_units=mysql_fetch_array($ptr_esxit);
													$checked=" checked='checked'";

													// $call_function .= " setTimeout(show_ques($i), $timeouts); ";
												}
										   }
											$sel_lang="select language_id,language_name,language_code from ex_language where language_id='".$row_member_topic['language_id']."'";       
											$ptr_lang=mysql_query($sel_lang);                      
											$data_lang=mysql_fetch_array($ptr_lang);
										   echo  "<input type='radio' name='requirment_id' onclick='show_ques(this.value);' value='".$row_member['papers_id']."' id='requirment_id".$i."'   class='case' $checked /> ".$data_unit['paper_name']."".$data_lang['language_code']." ";
										   //onClick='show_ques($i)'

                                            

										   echo  '</td>';
										   if($i%4==0)
										   echo  '</tr><tr><td width=30%></td>';  
										   $i++;
										  
										}
										
								}

									

									echo '</table>';

									

							}
							?>
                           </div>
                           </td>
						   
						<?php

						

						echo "<input type='hidden' name='total_papers' id='total_papers' value='$total_no' />";
						echo "<input type='hidden' name='record_id' id='record_id' value='".$record_id."' />";
						}
						else
						{?>
							<td width="38%" colspan="3">
                           		<div id="show_papers"></div>
                               <input type='hidden' name='record_id' id='record_id' value='' />
                        	</td>
						<?php }
					   ?>
                       
                    </tr>
                    
                    
                    <tr>
                        <td colspan="3">           
                      
                          <div id="show_ques">

                          <?php

                        if($record_id)
					   {

						    for($i=1;$i<=$total_no;$i++)

						  { ?>

                           <div id="quest_sel_<?php echo $i;?>" ></div>

                           <?php

						  }

						   

					   }?>
                			</div>
                          
                      </td> 
                      
                    </tr><br /><br />
                    <tr>
                        <td>&nbsp;</td>
                        <td >
                        <?php
						if ($record_id && $_GET['view']==1)
						{?>
                        
                        <?php } 
						else
						{
						?>
                        <input type="submit" onClick="return validin();" class="input_btn" value="<?php if ($record_id && $_GET['view']==0) echo "Update"; else echo "Add"; ?> Exam" name="save_changes"  /></td>
                        <?php } ?>
                    </tr>
                </table>
        </form>
        </td></tr>
<?php
                        }   ?>
	 
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
<script language="javascript">
/*create_floor('add');
create_type1('add_type1');
create_type2('add_type2');*/

//create_floor_dependent();
</script>
<?php
 if($record_id)
 {
	?>
    <script>
	<?php

	echo $call_function;

	?>

	</script>
    <?php  
 }
 ?>
</body>
</html>
<?php $db->close();?>