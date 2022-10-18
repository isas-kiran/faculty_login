<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT subject_id,chapter_id FROM forms where form_id='".$record_id."'";
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
		function show_activity(menu_type)
			{
				var menu = menu_type;
	//alert("this is first");
	var url="show_activity_only.php";
    url=url+"?activity_type="+menu;
	//alert(url);
	//document.getElementById('txtHint').innerHTML = "<p>Please Wait....</p>";
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
{
	//alert(document.getElementById('subject_id').value);
	
	if(document.getElementById('exam').value=='')
	{
		alert('please select Exam');
		return false
	}
	if(document.getElementById('exam_status').value=='' )
	{
		alert('please  Select Exam is main or Practice');
		return false
	}
	
	if(document.getElementById('datepicker1').value=='')
	{
		alert('please Insert Paper Date');
		return false
	}
	if(document.getElementById('paper_time').value=='')
	{
		alert('please Insert Time');
		return false
	}
	if(document.getElementById('paper_time').value=='')
	{
		alert('please Insert Time');
		return false
	}
	return true;
}

</script>
<script>
function count_cklick()
        {
            var chks = document.getElementsByName('chkRecords[]');
			//alert(chks);
			
			
			//$('.myCheckbox').attr('checked','checked');
			
				
			/*
			$('.myCheckbox').attr('checked','checked');
			records=document.getElementById('chkRecords[]').value;
			alert(records);
            var hasChecked = false;
            for (var i = 0; i < chks.length; i++)
            {
                if (chks[i].checked)
                {
                    hasChecked = true;
                    break;
                }
            }
            if (hasChecked == false)
            {
                alert("Please select at least one record to do operation");
                $('#selAction').val('');
                return false;
            }*/
}
</script>

<script>
function counter_check(id)
{
	id= '#'+id;
	//$(id).attr('checked',true);
	previous = parseInt($('#total_checked_question').val());
	
	total_qution=document.getElementById('total_quations').value;
	//alert(total_qution);
	if(total_qution=='')
	{
		alert('Please enter the quation count the quations first');
	}
	if(previous>=total_qution)
	$(id).removeAttr('checked');	
	else
	{	
	if($(id).is(':checked'))
	previous=	previous+1;
	else
	previous= previous-1;
	$('#total_checked_question').val(previous);
	}
	 total_counter=($('#total_checked_question').val());
	// alert(total_counter);
	if(total_qution == total_counter )
	{
		alert('finished select quation');
	}
	//alert($('#total_checked_question').val());
//	document.getElementById("txtHint").innerHTML="";
}
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
xmlhttp.open("GET","quation_show.php?q="+str,true);
xmlhttp.send();
}
</script>   
<script>
function showsubject_name(course_id)
		{
		var data1="showsubject_name=1&course_id="+course_id;
		//alert(data1);
		 $.ajax({
            url: "show_subjectss.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				 document.getElementById('subject_div').innerHTML=html;
			}
			});
		}
		
function show_chapter(subject_id)
 {
	 //alert(subject_id);
	 var course="show_chapter=1&subject_id="+subject_id;
	 $("#total_quations").val($("#totla_q_"+subject_id).val());
	 
	// alert()
	 totla_q_3
	 
	 $.ajax({
		 url: "show_chapter_inchekbox.php", type: "post", data: course, chache:false,
		 success: function (chapters)
		 {
			 document.getElementById('show_chapter').innerHTML=chapters;
		 }
	 });
 }
 


	</script> 
    <script>
	function validme()
	 {
		 //alert("hi");
		 frm = document.jqueryForm;
		 error='';
		 disp_error = 'Clear The Following Errors : \n\n';

		 if(frm.paper_title.value=='')
		 {
			 disp_error +='Enter Question Name\n';
			 error='yes';
	     }
		
		 if(frm.exam_id.value=='select')
		 {
			 disp_error +='Please Select Exam name\n';
			 error='yes';
	     }
		 
		  if(frm.course_id.value=='select')
		 {
			 disp_error +='Please Select Course Name \n';
			 error='yes';
	     }
		
		 if(frm.subject_id.value=='select')
		 {
			 disp_error +='Please Select Subject Name \n';
			 error='yes';
	     }
		
				 
		if($('input[name=select_question]:checked').length<=0)
		{
		 disp_error +='Question type not selected \n'; 
		  error='yes';
		}
		 
		 if(error=='yes')
		 {
			 alert(disp_error);
			 return false;
		 }
		 else
		 return true;
	 }
    </script>
<script type="text/javascript">
	function show() { document.getElementById('show_chapter').style.display = 'block'; document.getElementById("total_checked_question").disabled = true; }
	function hide() { document.getElementById('show_chapter').style.display = 'none'; document.getElementById("total_checked_question").disabled = false; }
	
	
function cal_total()
{
	total_quest= parseInt(document.getElementById("total_checked_question").value)
	//alert(total_quest);
	var total_ques1= parseInt(document.getElementById("total_quations").value)
	//alert(total_ques1);
	
	
	var sel_type= $('[name=select_question]:checked').val();
	//alert(sel_type);
	if(sel_type == 'manual')
	{
		total_topics = $("#total_topics").val();
		total=0;
		for(id=1;id<=total_topics;id++)
		{
			var el = 'chapter_id'+id;
			//alert(el);
			if( document.getElementById(el).checked && $("#selected_question"+id).val() !='')
			{
				var total_ques= document.getElementById("total_question_"+id).value
				if(total_ques <parseInt($("#selected_question"+id).val()))
				{
					$("#selected_question"+id).val('')=0;
				}
				var total = (total + parseInt($("#selected_question"+id).val()));
				alert(total);
				
			}
			else
			{
				//alert('Please check topic first');
			 $("#selected_question"+id).val('');
			}
				
		}
		
		$("#total_checked_question").val(total);
	}
	else
	{
		
		if(total_quest > parseInt(document.getElementById("total_quations").value))
		{
		//document.getElementById("total_checked_question").value=0;
		$("#total_checked_question").val('')=0;
		}
	
	}
}	
	
function del_not(chap_id, i)
{
	total=0;
	//alert(chap_id);

	var el = 'selected_question'+i;
	//alert(document.getElementById(el).value);
	if( document.getElementById(el).checked)
	{
	var total = total + document.getElementById("selected_question"+i).val;
	alert(total);
	}
	
	else
		document.getElementById("selected_question"+i).value=chap_id;
	//alert (document.getElementById("selected_question"+i).value);
	
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
                        $subject_id=$_POST['subject_id'];
						$course_id=$_POST['course_id'];
						//echo $_POST['total_quation_id'];
                      
                        if($subject_id =="")
                        {
                                $success=0;
                                $errors[$i++]="Please Select Subject";
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
							
                            
					if(addslashes($_POST['paper_title']) !="")
					{			
						if($record_id)
						{
				 //   $_POST['paper_time'];
				/*	$tan_date=explode('/',$_POST['paper_time'],3);
					$paper_time=$tan_date[2].''.$tan_date[0].''.$tan_date[1];*/
	
			$update_record="UPDATE `paper` SET `exam_id`='".$_POST['exam_id']."','".$_POST['add_class_id']."',`subject_id`='".$_POST['subject_id']."',`course_id`='".$_POST['course_id']."',`paper_title`='".$_POST['paper_title']."',`description`='".$_POST['description']."',`paper_time`='".$_POST['paper_time']."',`total_time`='".$_POST['total_time']."',`total_mark`='".$_POST['total_mark']."',`paper_date`='".$_POST['paper_date']."',`exam_status`='".$_POST['exam_status']."', paper_start_timing='".$_POST['paper_start_timing']."' WHERE paper_id='".$record_id."'";
		$ptr_update_query=mysql_query($update_record);
						$msg= "<center><font color='red'>Record Updated  successfully...!</font></center>";
						
						}
						else 
						{
							 $check_exist = "select paper_id from  paper where paper_title ='".addslashes($_POST['paper_title'])."' 
							 and exam_id='".$_POST['exam_id']."' ";
							
							$ptr_check = mysql_query($check_exist);
							$count = mysql_num_rows($ptr_check);
							if($count !=0)
							{
								?>
								<script>
								alert("Paper Already exist. Change Name Or Change Exam....!");
								</script>
                                <?php
								$msg= "<center><font color='red'></font></center>";
								//$msg= "<center><font color='red'>Paper Already Exist...!</font></center>";
                                
							}
							else
							{
								$tan_date=explode('/',$_POST['paper_date'],3);
								$paper_date=$tan_date[2].'-'.$tan_date[0].'-'.$tan_date[1];
									
								$insert_query = "insert into paper (`admin_id`,`exam_id`,`add_class_id`,`subject_id`,`course_id`,`paper_title`,`description`,`select_question`,`paper_time`,`paper_date`,`paper_start_timing`,`total_time`,`total_mark`,`created_date`,`exam_status`) values('".$_SESSION['admin_id']."','".$_POST['exam_id']."','".$_POST['add_class_id']."','".$_POST['subject_id']."',
								'".$_POST['course_id']."', '".addslashes($_POST['paper_title'])."','".addslashes($_POST['description'])."','".$_POST['select_question']."',
								'".$_POST['paper_time']."','".$paper_date."','".$_POST['paper_start_timing']."','".$_POST['total_time']."','".$_POST['total_mark']."','".date('Y-m-d')."','".$_POST['exam_status']."')";
								$insert_ptr=mysql_query($insert_query);
								$insert_ptr_id=mysql_insert_id();
							 // echo $_POST['quation_id'.$i] ;
								/*$total_quation_id = $_POST['total_quation_id'];
								for($i=1;$i<=$total_quation_id;$i++)
								{
								   if($_POST['quation_id'.$i] !='')
								   {
									$insert_quations="insert into quation_add_to_paper 
									values(0,'".$_SESSION['admin_id']."','".$insert_ptr_id."','".$_POST['subject_id']."','".$_POST['course_id']."','".$_POST['quation_id'.$i]."','')";
									$ptr_inser_quetion=mysql_query($insert_quations);
									$msg= "<center><font color='green'>Paper Added successfully..!</font></center>";
								   }
							   }*/
							   if($_POST['select_question']=='manual')
							   {
							  // echo $_POST['chapter_id'][0];
							   for($h=0;$h<count($_POST['chapter_id']);$h++)
								{
									$insert_into_question_subject_topic_map = " insert into question_subject_topic_map(`paper_id`,`subject_id`, `topic_id`,`selected_question`)
									values('$insert_ptr_id', '".$_POST['subject_id']."','".$_POST['chapter_id'][$h]."','".$_POST[$_POST['chapter_id'][$h]]."' )  ";
									$ptr_insert_c = mysql_query($insert_into_question_subject_topic_map);
									
									if($_POST[$_POST['chapter_id'][$h]] !='')
									$limit = "limit 0,".$_POST[$_POST['chapter_id'][$h]]." ";
									else
									$limit='';
									 '<br>'.$select_question_id="select question_id,chapter_id,subject_id from question where subject_id='".$_POST['subject_id']."' and chapter_id='".$_POST['chapter_id'][$h]."' ORDER BY rand() $limit ";
									$ptr_ques_id=mysql_query($select_question_id);
									$cnt_ques=mysql_num_rows($ptr_ques_id);
									while($data_ques_id=mysql_fetch_array($ptr_ques_id))
									{
										
											 '<br>'.$insert_quations="insert into quation_add_to_paper() values 
											(0,'".$_SESSION['admin_id']."','".$insert_ptr_id."','".$data_ques_id['subject_id']."','".$data_ques_id['chapter_id']."','".$data_ques_id['question_id']."','')";
											$ptr_inser_quetion=mysql_query($insert_quations);
											
											 $update_question="update question set course_id=".$_POST['course_id'].",exam_id=".$_POST['exam_id']." where subject_id=".$data_ques_id['subject_id']."";
						 $ptr_update=mysql_query($update_question);
										
									}
									$msg= "<center><font color='green'>Paper Added successfully..!</font></center>";
								}
							 
							   }	//$_POST['select_question']==manual
							   else
							   {
									 '<br>'.$insert_into_question_subject_topic_map = " insert into question_subject_topic_map(`paper_id`,`subject_id`,`selected_question`)
									values('$insert_ptr_id', '".$_POST['subject_id']."','".$_POST['total_checked_question']."')  ";
									$ptr_insert_c = mysql_query($insert_into_question_subject_topic_map);
									
									
									 '<br>'.$select_question_id="select question_id,chapter_id,subject_id from question where subject_id='".$_POST['subject_id']."' ORDER BY rand()  limit 0,".$_POST['total_checked_question']." ";
									$ptr_ques_id=mysql_query($select_question_id);
									$cnt_ques=mysql_num_rows($ptr_ques_id);
									while($data_ques_id=mysql_fetch_array($ptr_ques_id))
									{
											 '<br>'.$insert_quations="insert into quation_add_to_paper values 
											(0,'".$_SESSION['admin_id']."','".$insert_ptr_id."','".$data_ques_id['subject_id']."','','".$data_ques_id['question_id']."','')";
											$ptr_inser_quetion=mysql_query($insert_quations);
											
											  $update_question="update question set course_id=".$_POST['course_id'].",exam_id=".$_POST['exam_id']." where subject_id=".$data_ques_id['subject_id']."";
						 $ptr_update=mysql_query($update_question);
											
									}
									$msg= "<center><font color='green'>Paper Added successfully..!</font></center>";
							   }
						  }
							
						}
					}
					else
					{
						$msg= "<center><font color='red'>Paper Name Should Not Blank...!</font></center>";
					}
					
		             echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                        }
                    }
                    if($success==0)
                    {
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
            <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
            <tr>
                <td width="20%">Question Paper Name  <span class="orange_font">*</span></td>
                <td width="40%">
                  <input type="text" name="paper_title" id="paper_title"  class="input_text" value="<? if($_POST['paper_title']== '' ) 
					  { echo $val_record_paper['paper_title']; }else { echo $_POST['paper_title']; } ?>"/> <td width="40%"></td>
            </tr>
             <tr>
                <td width="20%">Discription </td>
                <td width="40%">
                     <textarea name="description" rows="1" class="input_textarea" cols="50" ><? if($_POST['description']== '') 
					  { echo $val_record_paper['description']; }else { echo $_POST['description']; } ?></textarea></td>
            </tr>
            
            <tr>
            <td width="20%">Select Exam<span class="orange_font">*</span></td>
            <td width="40%" >
                    <select name="exam_id" id="exam_id" class="validate[required] input_select" >  
                        <option value="select"> Select Exam </option>
                         <?php
					  $select_detail = " select exam_id,exam_name from exam ";
					  $ptrs_exam = mysql_query($select_detail);
					   while($data_exam = mysql_fetch_array($ptrs_exam))
					   {		
					    if(($_POST['submit'] && $_POST['exam_id']==$data_exam['exam_id']) ||
                             (!$_POST['submit'] && $val_record_paper['exam_id']==$data_exam['exam_id']))
                            {
                            echo "<option selected='selected' value=".$data_exam['exam_id'].">
                            ".$data_exam['exam_name']."</option>";
                            }
                            else				   
					   	echo "<option value='".$data_exam['exam_id']."'>".$data_exam['exam_name']."</option>";
					   }
					  ?>   
                    </select>
                    </td> 
                <td width="40%"></td>
            </tr>
            <tr>
            <td width="20%">Select Course<span class="orange_font">*</span></td>
            <td width="40%" >
                    <select name="course_id" id="course_id" class="validate[required] input_select">  
                        <option value="select"> Select Course </option>
                        <?php
														   $course_category = " select category_name,category_id from course_category ";
														   
														   $ptr_course_cat = mysql_query($course_category);
														   while($data_cat = mysql_fetch_array($ptr_course_cat))
														   {
															   echo " <optgroup label='".$data_cat['category_name']."'>";
														
                                        					$get="SELECT course_name,course_id FROM courses where category_id='".$data_cat['category_id']."' order by course_id";
										 					$myQuery=mysql_query($get);
										 					while($row = mysql_fetch_assoc($myQuery))
															{
																
															?>
                            <option value = "<?php echo $row['course_id']?>" <? if (isset($course_interested) && $course_interested == $row['course_name']) echo "selected";?> > <?php echo $row['course_name'] ?> </option>
                            <?php }
													echo " </optgroup>";
														   }
													
                            ?>        
                    </select>
                    </td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Select Questions <span class="orange_font">*</span></td>
                <td width="40%">
                    <input type="radio" name="select_question" onclick="hide();" <?php if($val_record_paper['select_question']=='automatic') { echo 'checked="checked"'; }  ?> value="automatic"  id='select_question'/>Automatic   &nbsp; &nbsp; 
                    <input type="radio" id='select_question' name="select_question" onclick="show();" <?php if ($val_record_paper['select_question']=='manual') { echo 'checked="checked"'; } ?> value="manual"  />Manual  </td> 
                <td width="40%"></td>
            </tr>
            <tr>
            <td width="20%">Select Subject<span class="orange_font">*</span></td>
            <td width="40%" >
                    <select name="subject_id" id="subject_id" class="validate[required] input_select" onchange="show_chapter(this.value); ">  
                        <option value="select"> Select Subject </option>
                        <?php
                            $select_category = "select subject_id,name,subject_id from subject order by subject_id asc";
                            $ptr_category = mysql_query($select_category);
                            while($data_category = mysql_fetch_array($ptr_category))
                            {
								
								 $select_question = "  select question_id from question where subject_id='".$data_category['subject_id']."'  ";
								 $ptr_sub_qur = mysql_query($select_question);
								
                                if($data_category['subject_id'] == $row_record['subject_id'])
                                    echo '<option value='.$data_category['subject_id'].' selected="selected">'.$data_category['name'].' (total ques => '.mysql_num_rows($ptr_sub_qur).')'.'</option>';
                                else
                                    echo '<option value='.$data_category['subject_id'].'>'.$data_category['name'].' (total ques => '.mysql_num_rows($ptr_sub_qur).')'.'</option>';
                            }
                            ?>          
                    </select>
                    <?php
					$ptr2 = mysql_query($select_category);
					while($data_category2 = mysql_fetch_array($ptr2))
                            {
								$select_question2 = "  select question_id from question where subject_id='".$data_category2['subject_id']."'  ";
								 $ptr_sub_qur2 = mysql_query($select_question2);

					 echo "<input type='hidden' name='totla_q_".$data_category2['subject_id']."' id='totla_q_".$data_category2['subject_id']."' value='".mysql_num_rows($ptr_sub_qur2)."'>";  }
					?>
                    </td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Total Marks<span class="orange_font">*</span></td>
                <td width="40%" ><input type="text" name="total_mark" id="total_mark" class="input_text" value="" style="width:140px" /></td> 
                <td width="40%"></td>
            </tr>
             <tr>
                <td width="20%">Total Time<span class="orange_font">*</span></td>
                <td width="40%" ><input type="text" name="total_time" id="total_time" class="input_text" style="width:140px" value="" /></td> 
                <td width="40%"></td>
            </tr>
             <tr>
                <td colspan="3">
                <div id="show_chapter" style="display:none">
                </div>
                <input type="hidden" name="topic_id" id="topic_id" value="<? echo $row_record['chapter_id']; ?>" />
                </td>
            </tr>
           
           <!-- <tr>
                <td width="20%">Select Option <span class="orange_font">*</span></td>
                <td width="40%">
                    <input type="radio" name="exam_status" <?php if($val_record_paper['exam_status']=='main') { echo 'checked="checked"'; } ?> value="main"  id='exam_status2'/>Main Paper   &nbsp; &nbsp; 
                    <input type="radio" id='exam_status' name="exam_status" <?php if ($val_record_paper['exam_status']=='test') { echo 'checked="checked"'; } ?> value="test"  />Test Exam  </td> 
                <td width="40%"></td>
            </tr>-->
             <!--<tr>
                <td width="20%">Paper Date<span class="orange_font">*</span></td>
                <td width="40%">
                <input type="text" name="paper_date" id="datepicker" title="Paper Date" readonly="1" 
                      class="datepicker  suggestionsinput  input_text" placeholder="Exam Date" value="<? if($_POST['paper_date']== '') 
					  { echo $val_record_paper['paper_date']; }else { echo $_POST['paper_date']; } ?>" >
                <td width="40%"></td>
            </tr>
             <tr>
                <td width="20%">Paper Starting Time  <span class="orange_font">*</span></td>
                <td width="40%">
                  <input type="text" name="paper_start_timing" id="paper_start_timing"  class="input_text" value="<? if($_POST['paper_start_timing']== '' ) 
					  { echo $val_record_paper['paper_start_timing']; }else { echo $_POST['paper_start_timing']; } ?>"/><br />(write down the exam or paper start timing)
                                     <td width="40%"></td>
            </tr>
             <tr>
                <td width="20%">Paper Duration (Time)<span class="orange_font">*</span></td>
                <td width="40%">
                      <input type="text" name="paper_time" id="paper_time" value="<? if($_POST['paper_date']== '') 
					  { echo $val_record_paper['paper_time']; }else { echo $_POST['paper_time']; } ?>" class="input_text"/>(in Minute) </td>
            </tr>-->
            
            <tr>
                <td width="20%">Total Question <span class="orange_font"></span></td>
                <td width="20%" colspan="2"><input type="text" name="total_quations" id="total_quations" class="input_text" style="width:140px"  value="" />	&nbsp; Selected Quetions &nbsp; 
                      <input type="text"  name="total_checked_question"id="total_checked_question" class="input_text" style="width:140px" onkeyup="cal_total()" value="" /> </td>
            </tr>
           
                
               
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" class="input_btn" onclick="return validme()" value="Add" name="save_changes" /></td>
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