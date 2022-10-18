<?php include 'ex_inc_classes.php';?>
<?php include "ex_admin_authentication.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM ex_papers where papers_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}
if($_REQUEST['record_id']) 
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM ex_papers_section where papers_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_records=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
<?php if($record_id) echo "Edit"; else echo "Add";?> MCQ Paper</title>
<?php include "ex_include/headHeader.php";?>
<?php include "ex_include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
	<link rel="stylesheet" href="js/chosen.css" />
	<script src="js/chosen.jquery.js" type="text/javascript"></script>
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            // binds form submission and fields to the validation engine
			$("#syllabus_id").chosen({allow_single_deselect:true});
			$("#language_id").chosen({allow_single_deselect:true});
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
    </script>
    <!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <link rel="stylesheet" href="js/chosen.css" />
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
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
        });
    </script>
<script>
function hideSelected(a)
{
	total_cnt=document.getElementById("total_count").innerHTML;
	count=parseInt(total_cnt-1);
	document.getElementById("total_count").innerHTML=count;
	document.getElementById("total_ques_cnt").value=count;
	$("#exam_mark").val(count);
	hide1=a.id;
	
	idsn="selected"+hide1;
	$('#'+idsn).remove();
	if(document.getElementById(hide1))
	{
		document.getElementById(hide1).style.display="block";
	}
	seprates=hide1.split("qs");
	$(":checkbox[value='"+seprates[1]+"']").attr("checked", false);  
}
no=0;
function select_me(ids)
{
	
	total_count='';
	divId="selected"+ids;
	//no= parseInt(no + 1);
	seps=ids.split("qs");
	sep = (document.getElementById(ids).innerHTML).split('<?php
	$strs = explode('Firefox',$_SERVER['HTTP_USER_AGENT']);if($strs[1]){echo '<input type="hidden" name="split">';}else{ echo '<input type="hidden" name="split">';} 
	?>');
	new_id="<input type='hidden' name='new_selected[]' id='new_selected' value='"+seps[1]+"'>";
	var selected_unit_name= document.getElementById("selected_units"+seps[1]).value;
	img = '<img src="images/delete.gif" height="20" width="20" onclick="hideSelected('+ids+')" id="'+ids+'">';
	if($('input[value='+seps[1]+']').attr('checked', false))		
	{
		if(document.getElementById(ids))
			document.getElementById(ids).style.display="none";
	}
	//alert(sep[1]);
	var question_title=sep[1].split(".")[1];
	document.getElementById('selected_questions').innerHTML=document.getElementById('selected_questions').innerHTML+'<div id="'+divId+'" style="clear: both;"><table width="100%"><tr><td width="10%" align="center">'+seps[1]+'.</td><td align="center" width="20%">'+selected_unit_name+'</td><td width="50%" align="center">'+question_title+'</td><td width="9%" align="center">'+new_id+''+img+sep[2]+'</td></tr></table></div>';
	
	//alert(Number(document.jqueryForm.new_selected.length))
	
	total_count = document.getElementsByName("new_selected[]").length;
	if(total_count)
	document.getElementById("total_count").innerHTML=total_count;
	document.getElementById("total_ques_cnt").value=total_count;
	$("#exam_mark").val(total_count);
}
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
function show_unit()
{
     var syllabus_id = document.getElementById('syllabus_id').value;
	 var language_id=document.getElementById('language_id').value;

	//alert(syllabus_id);
	if(syllabus_id !='' || language_id !='')
	{
	 var course="show_unit=1&syllabus_id="+syllabus_id;
	//alert(course);
	 $.ajax({
		 url: "ex_show_unit.php", type: "post", data: course, chache:false,
		 success: function (chapters)
		 {
			 //alert(chapters);
			 document.getElementById('show_unit').innerHTML=chapters;
			 total_units = document.getElementById('total_no').value;
			 addition ='';
			 for(i=1;i<=total_units;i++)
			 {
				addition += '<div id="quest_sel_'+i+'" ></div>'; 
			 }
			 document.getElementById('show_ques').innerHTML=addition;

		 }

	 });
	}else
	{
		document.getElementById('show_unit').innerHTML='';
	}

}

function searchQuestion()
{
	question_val='';
	
	record_id = document.getElementById("record_id").value;
	var lang_id=document.getElementById("language_id").value;
	var syll_id= document.getElementById("syllabus_id").value;
	var searchques= document.getElementById("search").value;
	var searchkeyword= document.getElementById("keyword").value;
	
	var sep='';
	var selc='';
	var keyword='';
	if(searchques !='' && searchkeyword!='')
	{
		if(document.getElementsByName("new_selected[]"))
		{
			var fav_count = document.getElementsByName("new_selected[]");
			for(i=0;i<fav_count.length;i++)
			{
				question_val =question_val + (fav_count[i].value) ;
				if(i!=(fav_count.length-1))
				question_val =question_val+",";
			}
		}
		question_vals="&question_vals="+question_val;
		
		/*if(searchques!='' && searchkeyword!='')
		{*/
			if(searchques=="question_no")
			{
				var keyword="&question_no="+searchkeyword;	
			}
			else if(searchques=="ques_title")
			{
				var keyword="&question_title="+searchkeyword;	
			}
			else
			{
				var keyword="&keyword=''";
			}
			
			
	
			var checkboxes = document.getElementsByName('requirment_id[]');
			var total_checked = document.getElementsByName('requirment_id[]').length;
			
			//========================
			var vals = "";
			unit_selected ='';
			for (var i=0, n=checkboxes.length;i<n;i++) 
			{
				if (checkboxes[i].checked) 
				{
					vals = checkboxes[i].value;
					var sep =(checkboxes[i].id).split('requirment_id');
					unit_selected = unit_selected + vals+',';
				}
			}
			
			
			if(sep)
				selc ='quest_sel_'+sep[1];
	
			var data1="ques_ids="+unit_selected+"&record_id="+record_id+"&syllabus_id="+syll_id+"&language_id="+lang_id+keyword+question_vals;	
			//alert(data1);
			$.ajax({
			url: "ex_show_ques.php", type: "post", data: data1, cache: false,
			success: function (html)
			{
				if(sep)
				{
				for(i=1;i<=document.getElementById('total_unit').value;i++)
				{
					selc2 ='quest_sel_'+i;
					document.getElementById(selc2).innerHTML ='';
				}
				document.getElementById(selc).innerHTML =html;
				}
				else if(!sep)
				{
					document.getElementById('show_search_result').innerHTML =html;
					}
			}
			});
	}
	else
	{
		alert("Please select search category or enter search text");
	}
	//=================
	
}
function resetQuestion()
{
	document.getElementById("search").selectedIndex = "0";
	document.getElementById("keyword").value = "";
}

function show_ques(ids)
{ 
	
	question_val='';
	if(document.jqueryForm.new_selected)
	{
		var fav_count = document.jqueryForm.new_selected.length;
		//alert(fav_count);
		for(i=0;i<fav_count;i++)
		{
			question_val =question_val + document.jqueryForm.new_selected[i].value;
			if(i!=(fav_count-1))
			question_val =question_val+",";
		}
	}
	is ='requirment_id'+ids;
	total_mbr =  document.getElementById("total_unit").value;
	record_id =   document.getElementById("record_id").value;

	var language_id=document.getElementById('language_id').value;
	que_div = 'quest_sel_'+ids;
	
	var searchques= document.getElementById("search").value;
	var searchkeyword= document.getElementById("keyword").value;
	var keywod='';
	if(searchques!='' && searchkeyword!='')
	{
		if(searchques=="question_no")
		{
			var keywod="&question_no="+searchkeyword;	
		}
		else
		{
			var keywod="&question_title="+searchkeyword;	
		}
	}
	
	question_vals="&question_vals="+question_val;
	if(document.getElementById(is).checked)
    {
		contact= document.getElementById(is).value;
 	    var data1="ques_ids="+contact+"&record_id="+record_id+"&language_id="+language_id+keywod+question_vals;	
	   //	alert(data1);
        $.ajax({
            url: "ex_show_ques.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
					//alert(html);
				  document.getElementById(que_div).innerHTML =html;
            }
            });
	}
	else
	{
		document.getElementById(que_div).innerHTML='';
	}
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
	if(frm.paper_name.value=='')
	{
		disp_error +="Enter Paper Name\n";
		document.getElementById('paper_name').style.border = '1px solid #f00';
		frm.paper_name.focus();
		error="yes";
	}
	if(frm.syllabus_id.value=='')
	{
		disp_error +="Select Syllabus Name\n";
		document.getElementById('syllabus_id').style.border = '1px solid #f00';
		frm.syllabus_id.focus();
		error="yes";
	}
	if(frm.language_id.value=='')
	{
		disp_error +="Select language Name\n";
		document.getElementById('language_id').style.border = '1px solid #f00';
		frm.language_id.focus();
		error="yes";
	}
	if(frm.exam_mark.value=='')
	{
		disp_error +="Enter Exam Mark \n";
		document.getElementById('exam_mark').style.border = '1px solid #f00';
		frm.exam_mark.focus();
		error="yes";
	}
	else
	{
		chk_arr = parseInt(frm.exam_mark.value);
		var toatal_mark=parseInt(document.getElementById("total_ques_cnt").value);
		//alert(toatal_mark);
		if(chk_arr != toatal_mark)
		{
			disp_error +="Exam Mark and Total Selected Question are not equals \n";
			document.getElementById('exam_mark').style.border = '1px solid #f00';
			frm.exam_mark.focus();
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
function isFeatureDate(value) {
        var now = new Date;
        var target = new Date(value);
        if (target.getFullYear() > now.getFullYear()) {
            return true;
        } else if (target.getMonth() > now.getMonth()) {
            return true;
        } else if (target.getDate() >= now.getDate()) {
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
<script>
function CheckAll(chk)
{
	if ($('#Check_All').attr('checked'))
	{
		for (i = 0; i < chk.length; i++)
		chk[i].checked = true ;
		
	}
	else{
		for (i = 0; i < chk.length; i++)
		chk[i].checked = false ;
	}
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
			$paper_name=$_POST['paper_name'];
			$syllabus_id=$_POST['syllabus_id'];
			$language_id=$_POST['language_id']; 
			$exam_mark=$_POST['exam_mark'];
			$unit_id=$_POST['unit_id'];
			
			$question_id=$_POST['question_id'];
			$ex_number='';
			if($record_id)
			{
				$ex_number="and papers_id !='".$record_id."'";
			}					
			if($paper_name=="")
			{
				$success=0;
				$errors[$i++]="Enter Paper Name ";
			}
			else
			{
				$sel_ques="select papers_id from ex_papers where paper_name='".$paper_name."'";
				$my_query1=mysql_query($sel_ques);
				if(mysql_num_rows($my_query1))
				{
					$success=0;
					$errors[$i++]="Paper Name that you entered is already exist ";
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
				$data_record['paper_name'] =$paper_name;
				$data_record['syllabus_id'] =$syllabus_id;
				$data_record['language_id'] = $language_id;
				$data_record['unit_id'] = $_POST['unit_id']; 

				$data_record['paper_mark'] = $exam_mark;
				$total_ques=count($_POST['new_selected']);
				$data_record['added_date']=date('Y-m-d');
				$data_record['total_ques']=$total_ques;
				if($record_id)
				{
					"<br />".$del_ex_section="delete from ex_papers_section where papers_id='".$record_id."'";
					$ptr_del_section=mysql_query($del_ex_section);
					
					$update_mcq_paper = " update `ex_papers` set `paper_name`='".$paper_name."' , `syllabus_id`='".$syllabus_id."' , `unit_id` = '".$_POST['unit_id']."' , `language_id`='".$language_id."' , `paper_mark`='".$exam_mark."', `total_ques`='".$total_ques."' where papers_id='".$record_id."'  ";
					$update_quer_paper = mysql_query($update_mcq_paper);
					//====================FOR Type1 INSERT=====================================
					for($h=0;$h<count($_POST['new_selected']);$h++)
					{									
						$select_unit_ids="select unit_id from ex_question where question_id='".$_POST['new_selected'][$h]."'";
						$ptr_unit_ids=mysql_query($select_unit_ids);
						$data_unit_ids=mysql_fetch_array($ptr_unit_ids);
						$data_record_type1['syllabus_id'] =$syllabus_id;
						$data_record_type1['papers_id'] = $record_id;
						$data_record_type1['unit_id'] = $data_unit_ids['unit_id']; 
						$data_record_type1['language_id'] = addslashes(trim($_POST['language_id'])); 
						$data_record_type1['added_date'] = date('Y-m-d'); 
						$data_record_type1['question_id'] =$_POST['new_selected'][$h];
						$record_id1=$db->query_insert("papers_section", $data_record_type1);
					}
					$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `admin_id`) VALUES ('add_mcq_paper','Edit','".$paper_name.",'".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert);
					echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';	
				}
				else
				{
					$record_ids=$db->query_insert("ex_papers", $data_record);
					$exams_id=mysql_insert_id(); 
					//====================FOR Type1 INSERT=====================================
					for($h=0;$h<count($_POST['new_selected']);$h++)
					{
						$select_unit_ids="select unit_id from ex_question where question_id='".$_POST['new_selected'][$h]."'";
						$ptr_unit_ids=mysql_query($select_unit_ids);
						$data_unit_ids=mysql_fetch_array($ptr_unit_ids);

						$data_record_type1['syllabus_id'] =$syllabus_id;
						$data_record_type1['papers_id'] = $exams_id;
						$data_record_type1['unit_id'] = $data_unit_ids['unit_id']; 
						$data_record_type1['language_id'] = addslashes(trim($_POST['language_id'])); 
						$data_record_type1['added_date'] = date('Y-m-d'); 
						"<br />".$data_record_type1['question_id'] = $_POST['new_selected'][$h];
						$record_id1=$db->query_insert("ex_papers_section", $data_record_type1);
					}
					$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `admin_id`) VALUES ('add_mcq_paper','Add','".$paper_name."','".$record_ids."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert);
					echo ' Record added successfully';  
				}
			}
		}
		if($success==0)
		{
			?>
            <tr><td>
        <form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data">
            <table border="0" cellspacing="15" cellpadding="0" width="100%">
                  	<tr>
                        <td colspan="3" class="orange_font">* Mandatory Fields</td>
                    </tr>
					<tr>
                    	<td width="147" valign="top"> Enter Paper Name <span class="orange_font">*</span></td>
                    	<td width="449" style=""><input type="text" name="paper_name" id="paper_name" class="input_text" value="<?php if($_POST['paper_name']) echo $_POST['paper_name']; else echo $row_record['paper_name']; ?>"/></td>
                    </tr>
                      <tr>
                   		<td width="147" valign="top">Select Subjects <span class="orange_font">*</span></td>
                    	<td width="449" style="">
                            <select id="syllabus_id" name="syllabus_id" class="input_select" onChange="show_unit();">
                            <option value="">Select</option>
                            <?php
							$course_domain="select cat_name,cat_id from course_domain_category ";
							$ptr_domain= mysql_query($course_domain);
							while($data_domain= mysql_fetch_array($ptr_domain))
							{
								echo "<optgroup label='".$data_domain['cat_name']."'>";
								$select_category = "select subject_id,name from subject where course_domain_id='".$data_domain['cat_id']."'";
								$ptr_category = mysql_query($select_category);
								while($data_category = mysql_fetch_array($ptr_category))
								{
									?>
									<option value="<?php echo $data_category['subject_id']?>"><?php echo $data_category['name']; ?></option>
									<?php 
								}
								echo "</optgroup>";
							}?>
							</select>
                      	</td> 
                        <td width="247"></td>
                    </tr>
                    <tr>
                        <td width="147">Select Language<span class="orange_font">*</span></td>
                        <td width="449" style="">
                        <select id="language_id" name="language_id" class="input_select" >
						<option value="">Select</option>
						<?php
						$sele_language_name="select language_id,language_name from ex_language where language_id='".$row_record['language_id']."'";
						$ptr_language_name=mysql_query($sele_language_name);
						$data_language_name=mysql_fetch_array($ptr_language_name);
						$language_interested=$data_language_name['language_name'];
						$language_namess = " select language_name,language_id from ex_language ";
						$ptr_language_cat = mysql_query($language_namess);
						while($data_cat = mysql_fetch_array($ptr_language_cat))
						{ 
							$get="SELECT language_name,language_id FROM ex_language where language_id='".$data_cat['language_id']."' order by language_id";
							$myQuery=mysql_query($get);
							while($row = mysql_fetch_assoc($myQuery))
							{
						?>
                        		<option value = "<?php echo $row['language_id']?>" <? if ($row['language_id'] == '1') {echo "selected"; } ?> > <?php echo $row['language_name'] ?> </option>
					<?php	}
							echo " </optgroup>";
						}
						?>
                        </select>
                        </td> 
                        <td width="247"></td>
                    </tr>
                    <tr>
                        <td height="0" valign="top">Paper Mark<span class="orange_font">*</span></td>
                        <td style=""><span style="">
            <input type="text"  class="input_text" name="exam_mark" id="exam_mark" onkeypress="return isNumber(event)" value="<?php if ($_POST['save_changes']) echo $_POST['exam_mark']; else echo $row_record['paper_mark']; ?>" />
            </span></td> 
                    </tr>
                    
                    <tr>
                  <?php 
					   if($record_id)
					   {?>
						   <td colspan="3"><div id="show_unit"></div>
                           <?php 
							if($record_id)
							{
								//$sel_unit= "select syllabus_id from exams where exams_id=".$record_id." order by exams_id asc";	
								$sel_unit= "select syllabus_id from ex_exams  order by exams_id asc";
								$query_unit = mysql_query($sel_unit);
								$data_unit_id=mysql_fetch_array($query_unit);
								//$select_existing = " select DISTINCT(unit_id) from papers_section  where syllabus_id='".$data_unit_id['syllabus_id']."' ";
								$select_existing = " select DISTINCT(unit_id) from ex_papers_section  where papers_id='".$record_id."' ";  
								$ptr_esxit = mysql_query($select_existing);
							   	$topic_array = array();
							  	$j=0;
								while( $data_exist = mysql_fetch_array($ptr_esxit))
								{
									$topic_array[$j]=$data_exist['unit_id'];
									$j++;
								}
								$i=1;
								$sel_topic= "select syllabus_id,papers_id from ex_papers where papers_id=".$record_id." order by papers_id asc";	
								$query_topic = mysql_query($sel_topic);
								echo '<table width="100%">';
								echo  '<tr><td width="18%">Selected topic</td>';
                                $selected_unit_array = array();
								while($row_member_topic = mysql_fetch_array($query_topic))
								{
									$sel_telx = "select topic_id from topic_map where subject_id='".$row_member_topic['syllabus_id']."' ";	 
									$query_telx = mysql_query($sel_telx);
									$total_no = mysql_num_rows($query_telx);
									$conc_unit ='';
									$c=1;
									while($row_memberx = mysql_fetch_array($query_telx))
									{
										$conc_unit .= " topic_id ='".$row_memberx['topic_id']."' ";
										if($c !=$total_no)
										$conc_unit .= " or ";
										$c++;
									}
									$sel_top = "select topic_id from topic_map where subject_id='".$row_member_topic['syllabus_id']."' ";	 
									$query_top = mysql_query($sel_top);
									$total_no = mysql_num_rows($query_top);
									$member_result='';
									$i=1;
									$call_function ='';
									$timeouts = 10000*$i;
									$sel_unit_name="select topic_id,topic_name from topic where 1 and $conc_unit  order by topic_id asc";
									$ptr_unit=mysql_query($sel_unit_name);
									while($data_unit=mysql_fetch_array($ptr_unit))
									{
										$sep_unit_id=explode(",",$data_unit['topic_id']);
										echo  '<td style="border:1px solid #999;">'; 
										$checked = '';
										if($record_id)
										{
											$select_existing = " select DISTINCT(unit_id) from ex_papers_section  where unit_id='".$data_unit['topic_id']."' and papers_id=".$record_id." ";
											$ptr_esxit = mysql_query($select_existing);
											if(mysql_num_rows($ptr_esxit))
											{
												$data_units=mysql_fetch_array($ptr_esxit);
												$checked=" checked='checked'";
												$call_function .= " setTimeout(show_ques($i), $timeouts); ";
												$selected_unit_array[count($selected_unit_array)]=$data_unit['topic_id'];
											}
										}
										echo"<input type='checkbox' name='requirment_id[]'  value='".$data_unit['topic_id']."' id='requirment_id$i'  onClick='show_ques($i)' class='case' $checked /> ".$data_unit['topic_name']." ";
										echo  '</td>';
										if($i%4==0)
										echo  '</tr><tr><td width=18%></td>';  
										$i++;
									}
								}
								echo '</table>';
							}
							?>
                           </td>
							<?php
							echo "<input type='hidden' name='total_unit' id='total_unit' value='$total_no' />";
							echo "<input type='hidden' name='record_id' id='record_id' value='$record_id' />";
						}
						else
						{?>
							<td width="271" colspan="3">
                           		<div id="show_unit"></div>
                               <input type='hidden' name='record_id' id='record_id' value='' />
                        	</td>
						<?php }?>
                    </tr>
                    <tr>
                        <td height="0" valign="top">Search <span class="orange_font"></span></td>
                  		<td colspan="3">           
                            <select name="search" id="search">
                            	<option value="">Select</option>
                                <option value="question_no">Question No.</option>
                                <option value="ques_title">Question Title</option>
                            </select>
                            <input type="text" style="width:230px" class="input_text" name="keyword" id="keyword" />
                            <input type="button" id="btnShow" name="search_button" value="Search" class="input_btn" onclick="searchQuestion()"  />
                            <input type="button" name="reset" value="Reset" class="input_btn" onclick="resetQuestion()"  />
                  		</td> 
                    </tr>
                    <tr>
                        <td height="0" valign="top">Selected Question<span class="orange_font"></span></td>
                        
                  		<td colspan="4">
                        Total selected question: <span id="total_count"><?php if($record_id){ echo $row_record['total_ques'];} ?></span><br /><br />
                        <input type="hidden" name="total_ques_cnt" id="total_ques_cnt"  value="<?php if($record_id){ echo $row_record['total_ques'];} ?>" />
                        	<table width=100% style="border:1px solid; margin:0; padding:0" class="table"><tr><td width="10%" align="center">Ques. No.</td><td width="20%">Topic Name</td><td width="50%" align="center">Question Title</td><td width="9%" align="center">Remove</td></tr>     
                            <tr><td colspan="4">   
                                <div name="selected_questions"  id="selected_questions" style="width:100%;" cols="">
                                <?php 
                                if($record_id)
                                {
                                    $sel_topic= "select syllabus_id,papers_id from ex_papers where papers_id=".$record_id." order by papers_id asc";	
                                    $query_topic = mysql_query($sel_topic);	
                                    while($row_member_topic = mysql_fetch_array($query_topic))
                                    {
                                        
                                        $sel_top = "select topic_id from topic_map where subject_id='".$row_member_topic['syllabus_id']."' ";	 
                                        $query_top = mysql_query($sel_top);
                                        $total_no = mysql_num_rows($query_top);
                                        $conc_unit ='';
                                        $c=1;
                                        while($row_memberx = mysql_fetch_array($query_top))
                                        {
                                            $conc_unit .= " topic_id ='".$row_memberx['topic_id']."' ";
                                            if($c !=$total_no)
                                            $conc_unit .= " or ";
                                            $c++;
                                        }
                                        $member_result='';
                                        $i=1;
                                        $n=1;
                                        $call_function ='';
                                        $sele_init_name="select topic_name,topic_id from topic where 1 and ( $conc_unit ) order by topic_name asc";
                                        $ptr_unit=mysql_query($sele_init_name);
                                        while($row_member = mysql_fetch_array($ptr_unit))
                                        { 
                                            if(in_array($row_member['topic_id'],$selected_unit_array))
                                            {
                                                $sel_contact = "select * from ex_question where unit_id='".$row_member['topic_id']."'  order by question_id asc ";	 
                                                $query_contact = mysql_query($sel_contact);
                                                $i=1;
                                                $total_contact = mysql_num_rows($query_contact);
                                                $member_result='';
                                                $i=1;
                                                while($row_contact = mysql_fetch_array($query_contact))
                                                {
                                                    $checked='';
                                                    $seleexam_se="select * from ex_papers_section where question_id='".$row_contact['question_id']."' and papers_id='$record_id' ";
                                                    $ptr_ex=mysql_query($seleexam_se);
                                                    $tot_ques=mysql_num_rows($ptr_ex);
                                                    if($tot_ques !=0 || $tot_ques !='')
                                                    {
                                                        ?>
                                                        <div id="selectedqs<?php echo $row_contact['question_id']; ?>" style="clear: both;">
                                                        <table width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td width="9%" align="center"><?php echo $row_contact['question_id']; ?>.</td>
                                                                    <td width="10%" align="center"><?php echo $row_member['topic_name']; ?>.</td>
                                                                    <td width="65%" align="center"><?php echo $row_contact['question_title']; 
                                                                    if($row_contact['question_img'])
                                                                    {?>
                                                                        <img src='ex_question_photo/<?php echo $row_contact['question_img'] ?>' height='50' width='50'>
                                                                        <?php
                                                                    }
                                                                    ?></td>
                                                                    <td width="9%" align="center">
                                                                    <img id="qsimg<?php echo $row_contact['question_id']; ?>" src="images/delete.gif" onclick="hideSelected(qs<?php echo $row_contact['question_id']; ?>)" width="20" height="20">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <input id="new_selected" name="new_selected[]" value="<?php echo $row_contact['question_id']; ?>" type="hidden">
                                                        </div>
                                                        <?php
                                                    }
                                                    $i++;
                                                }
                                            }
                                            $n++;
                                        }
                                    }
                                } ?> 
                                </div>
                            </td>
                            </tr>
                             
                        	</table>
                    	</td> 
                    </tr>
                    <tr>
                        <td colspan="3"><!-- <input type="text"  class="input_text" name="question_id" id="question_id" value="<--?php if ($_POST['save_changes']) echo $_POST['question_id']; else echo $row_records['question_id']; ?>" />-->
                        <div id="show_ques">
                        <?php
                      	if($record_id)
					   	{
							$sel_topic= "select syllabus_id,papers_id from ex_papers where papers_id=".$record_id." order by papers_id asc";	
							$query_topic = mysql_query($sel_topic);	
							while($row_member_topic = mysql_fetch_array($query_topic))
							{
								$sel_top = "select topic_id from topic_map where subject_id='".$row_member_topic['syllabus_id']."' ";	 
								$query_top = mysql_query($sel_top);
								$total_no = mysql_num_rows($query_top);
								$conc_unit ='';
								$c=1;
								while($row_memberx = mysql_fetch_array($query_top))
								{
									$conc_unit .= " topic_id ='".$row_memberx['topic_id']."' ";
									if($c !=$total_no)
									$conc_unit .= " or ";
									$c++;
								}
								$member_result='';
								$i=1;
								$n=1;
								$call_function ='';
								$sele_init_name="select topic_name,  topic_id  from topic where 1 and ( $conc_unit ) order by topic_name asc";
								$ptr_unit=mysql_query($sele_init_name);
								while($row_member = mysql_fetch_array($ptr_unit))
								{ 
									?><div id="quest_sel_<?php echo $n;?>" >
									<?php
									if(in_array($row_member['topic_id'],$selected_unit_array))
									{
										echo "<table width='100%'>";
										echo "<tr>";							   
										echo "<td width='9%' valign='top'>Select Question from ".$row_member['topic_name']."<span class='orange_font'>*</span></td>";
										echo "<td width='41%' >";
										$sel_contact = "SELECT * FROM ex_question where unit_id='".$row_member['topic_id']."'  order by question_id asc ";	 
										$query_contact = mysql_query($sel_contact);
										$i=1;
										$total_contact = mysql_num_rows($query_contact);
										$member_result='';
										echo '<table width="100%">';
										echo  '<tr>';
										$i=1;
										while($row_contact = mysql_fetch_array($query_contact))
										{
											$checked='';
											$display='';
											$seleexam_se="select * from ex_papers_section where question_id='".$row_contact['question_id']."' and papers_id='$record_id' ";
											$ptr_ex=mysql_query($seleexam_se);
											$tot_ques=mysql_num_rows($ptr_ex);
											if($tot_ques !=0 || $tot_ques !='')
											{
												$display="style='display:none'";
											}
											echo  "<td id='qs".$row_contact['question_id']."' ".$display."><input type='checkbox' name='chapter_id[]' onclick='select_me(\"qs".$row_contact['question_id']."\")' value='".$row_contact['question_id']."' id='chapter_id$i' class='case ".$row_contact['question_id']."' style='vertical-align:top'/><input type='hidden' name='split'>".$row_contact['question_id'].". ".$row_contact['question_title']." ";
											echo "<input type='hidden' name='split'><input type='hidden' name='selected_unit' id='selected_units".$row_contact['question_id']."' value='".$row_member['topic_name']."' >";
											
											if($row_contact['question_img'])
											{?>
												<img src='ex_question_photo/<?php echo $row_contact['question_img'] ?>' height='50' width='50'>
												<?php
											}
											echo  '</td>';
											if($i%2==0)
											echo  '</tr><tr>';  
											$i++;
										}
										echo "</tr></table></td></tr></table><hr />";
									}
									?></div>
									<?php $n++;
								}
							}
						}?>
						</div>
                        <div id="show_search_result"></div>
                      	</td> 
                    </tr><br /><br />
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" onclick="return validin();" class="input_btn" value="<?php if ($record_id) echo "Update"; else  echo "Add"; ?> MCQ Paper" name="save_changes"  /></td>
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
	//echo $call_function;
	?>
	</script>
    <?php  
 }
 ?>
</body>
</html>
<?php $db->close();?>