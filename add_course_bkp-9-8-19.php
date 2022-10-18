<?php session_start();?>
<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
//echo $_REQUEST['record_id'];
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT course_id,course_name,course_description,course_duration,category_id,course_price,total_ques,is_parent FROM courses where course_id='".$record_id."' ";
	
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
	<link rel="stylesheet" href="js/chosen.css" />
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <!--<link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />-->
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
    <!--<script type="text/javascript" src="multifilter/assets/prettify.js"></script>-->
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
		$("#category_id").chosen({allow_single_deselect:true});
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
function removeSelected(a)
{
	//alert(a);
	hide1=a;
	idsn="selected"+hide1;
	$('#'+idsn).remove();
}
function hideSelected(a)
{
	total_cnt=document.getElementById("total_count").innerHTML;
	count=parseInt(total_cnt-1);
	document.getElementById("total_count").innerHTML=count;
	document.getElementById("total_ques_cnt").value=count;
	hide1=a.id;
	
	idsn="selected"+hide1;
	$('#'+idsn).remove();
	if(document.getElementById(hide1))
	{
		document.getElementById(hide1).style.display="block";
	}
	seprates=hide1.split("qs");
	$(":checkbox[id='chapter_id"+seprates[1]+"']").attr("checked", false);  
}
no=0;
function select_me(ids)
{
	total_count='';
	divId="selected"+ids;
	//no= parseInt(no + 1);
	seps=ids.split("qs");
	var_sep =document.getElementById(ids).innerHTML;
	sep = var_sep.split('<?php echo '<span id="course"></span>'; ?>');
	new_id="<input type='hidden' name='topics[]' id='topics' value='"+seps[1]+"'>";
	var selected_subject_name= document.getElementById("selected_subjects"+seps[1]).value;
	img = '<img src="images/delete.gif" height="20" width="20" onclick="hideSelected('+ids+')" id="'+ids+'">';
	
	//if($('input[value='+seps[1]+']').attr('checked', false))		
	{
		if(document.getElementById(ids))
			document.getElementById(ids).style.display="none";
	}
	//alert(sep[1]);
	var topic_name=sep[1].split(".")[1];
	document.getElementById('selected_topic').innerHTML=document.getElementById('selected_topic').innerHTML+'<div id="'+divId+'" style="clear: both;"><table width="100%"><tr><td width="8%" align="center">'+seps[1]+'.</td><td align="center" width="10%">'+selected_subject_name+'</td><td width="65%" align="center">'+topic_name+'</td><td width="9%" align="center">'+img+sep[2]+'</td></tr></table>'+new_id+'</div>';
	
	//alert(Number(document.jqueryForm.new_selected.length))
	
	total_count = document.getElementsByName("topics[]").length;
	if(total_count)
	{
	document.getElementById("total_count").innerHTML=total_count;
	document.getElementById("total_ques_cnt").value=total_count;
	}
}
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
function counter_check(id)
{
	//alert(id);
	total_prices='total_prices';
	fee_id = 'fees_'+id;
	id= '#'+id;
	//$(id).attr('checked',true);
	previous = parseInt($('#total_checked_questions').val());
	//alert(previous);
	total_qution=document.getElementById('trotot').value;
	fees_value= parseInt(document.getElementById(fee_id).value);
	sub_fee= parseInt(document.getElementById('sub_fee').value);
	/*if(previous>=total_qution)
	$(id).removeAttr('checked');	
	else
	{	*/
	if($(id).is(':checked'))
	{
		previous=	previous+1;
		sub_fee = (sub_fee)+(fees_value);
	}
	else
	{
		previous= previous-1;
		sub_fee = (sub_fee)-(fees_value);
	}
	//}
	$('#total_checked_questions').val(previous);
	total_counter=($('#total_checked_questions').val());
	$('#total_checked_question').val(previous);
	$('#sub_fee').val(sub_fee);
	// document.getElementById(
	//alert(total_counter);
	toal_fees=$('#sub_fee').val();
	total_pricess= parseInt(document.getElementById(total_prices).value);
	if(total_pricess > toal_fees)
	{
		$('#toal_fees').val(toal_fees);
	}
	else
	{
		$('#toal_fees').val(total_pricess);
	}
}
</script>
<script type="text/javascript">
jQuery(document).ready( function() {
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
});
</script>
<style type="text/css">
	.multiselect {
    	width: 844px;
        height: 200px;
	}
</style>
<link type="text/css" href="js/multiselect/css/ui.multiselect.css" rel="stylesheet" />
<link type="text/css" href="js/development-bundle/themes/base/jquery.ui.theme.css" rel="stylesheet" />
<script type="text/javascript" src="js/multiselect/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/multiselect/js/plugins/localisation/jquery.localisation-min.js"></script>
<script type="text/javascript" src="js/multiselect/js/plugins/scrollTo/jquery.scrollTo-min.js"></script>
<script type="text/javascript" src="js/multiselect/js/ui.multiselect.js"></script>
<script type="text/javascript">
$(function(){
	$.localise('ui-multiselect', {/*language: 'en',*/ path: 'js/locale/'});
    $(".multiselect").multiselect();
});
function alls()
{
	total_selected = document.jqueryForm.sel2.length;
	//cities_selected
	last_counter = total_selected-1;
	appended = '';
	for(x=0;x<total_selected;x++)
	{
		//alert(document.jqueryForm.sel2.options[x].value);
		appended += document.jqueryForm.sel2.options[x].value
		if(x !=last_counter)
		{
			appended += ",";
		}	
		document.getElementById('cities_selected').value= appended;
	}
	//alert(document.getElementById('cities_selected').value);
	return true;
}
var NS4 = (navigator.appName == "Netscape" && parseInt(navigator.appVersion) < 5);
function addOption(theSel, theText, theValue)
{
  var newOpt = new Option(theText, theValue);
  var selLength = theSel.length;
  theSel.options[selLength] = newOpt;
}
function deleteOption(theSel, theIndex)
{ 
  var selLength = theSel.length;
  if(selLength>0)
  {
    theSel.options[theIndex] = null;
  }
}

function moveOptions(theSelFrom, theSelTo, operations)
{
	var selLength = theSelFrom.length;
	var selectedText = new Array();
	var selectedValues = new Array();
	var selectedCount = 0;
	var i;
	// Find the selected Options in reverse order
	// and delete them from the 'from' Select.
	z='no';
	for(i=selLength-1; i>=0; i--)
	{
		if(theSelFrom.options[i].selected)
		{
			if(confirm("do you really wanto to "+operations+" " +theSelFrom.options[i].text +" city?"))
		 	{
				selectedText[selectedCount] = theSelFrom.options[i].text;
		  		selectedValues[selectedCount] = theSelFrom.options[i].value;
				deleteOption(theSelFrom, i);
		  		z='yes';
			}
			selectedCount++;
    	}
	}
	// Add the selected text/values in reverse order.
	// This will add the Options to the 'to' Select
	// in the same order as they were in the 'from' Select.
	if(z=='yes')
	{
		for(i=selectedCount-1; i>=0; i--)
		{
			addOption(theSelTo, selectedText[i], selectedValues[i]);
		}
	}
	if(NS4) history.go(0);
}
</script>

<script>
function myfunction()
{
	x = document.getElementById('member_contact');
	//alert(x);
	x.value=''; 
}
//function selectalls() 
//{
	/*$("#checkAll").change(function ()
	{
		$("input:checkbox").prop('checked', $(this).prop("checked"));
		showUser();
	});	*/
	/*if($("#selectall").attr("checked")==true)
	{
		$('.case').each(function()
		{
			$(this).attr('checked','checked');
			showUser();
		});
	}
	else
	{
		$('.case').each(function() {
		$(this).attr('checked','');
		showUser();
		});
	}*/
//}
function showUser()
{
    total_subject =  document.getElementById("total_subject").value;
	contact ='';
    for(i=1; i<=total_subject;i++)
    {
    	id="requirment_id"+i;
		if(document.getElementById(id).checked)
	 	{
     		addition += '<div id="quest_sel_'+i+'" ></div>';
	 		document.getElementById('show_ques').innerHTML=addition;
	  		contact +=document.getElementById(id).value;
	  		contact +=',';
	  	}
	}
 	var data1="subject_ids="+contact;
    $.ajax({
	url: "get_subject.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		//alert(html);
		document.getElementById('topic_list').innerHTML=html;				
		document.getElementById("topic_list").style.width = "800px";
		document.getElementById("topic_list").style.height = "400px";
		//$(".multiselect").multiselect();
	}
	});
}
function searchTopic()
{
	question_val='';
	
	//var top_id= document.getElementById("topic_id").value;
	//var sub_id= document.getElementById("subject_id").value;
	var searchques= document.getElementById("search").value;
	var searchkeyword= document.getElementById("keyword").value;
	
	var sep='';
	var selc='';
	var keyword='';
	if(searchques !='' && searchkeyword!='')
	{
		if(document.getElementsByName("topics[]"))
		{
			var fav_count = document.getElementsByName("topics[]");
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
		if(searchques=="topic_no")
		{
			var keyword="&topic_no="+searchkeyword;	
		}
		else if(searchques=="topic_name")
		{
			var keyword="&topic_name="+searchkeyword;	
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

		var data1="subject_ids="+unit_selected+keyword+question_vals;	
		//alert(data1);
		$.ajax({
		url: "show_ques.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			if(sep)
			{
			for(i=1;i<=document.getElementById('total_subject').value;i++)
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
}
function resetTopic()
{
	document.getElementById("search").selectedIndex = "0";
	document.getElementById("keyword").value = "";
}
function show_ques(ids)
{ 
	//alert(ids)
	question_val='';
	if(document.jqueryForm.topics)
	{
		var fav_count = document.jqueryForm.topics.length;
		//alert(fav_count);
		for(i=0;i<fav_count;i++)
		{
			question_val =question_val + document.jqueryForm.topics[i].value;
			if(i!=(fav_count-1))
			question_val =question_val+",";
		}
	}
	is ='requirment_id'+ids;
	total_subject =  document.getElementById("total_subject").value;
	que_div = 'quest_sel_'+ids;
	//alert(que_div);
    var searchques= document.getElementById("search").value;
	var searchkeyword= document.getElementById("keyword").value;
	var keywod='';
	if(searchques!='' && searchkeyword!='')
	{
		if(searchques=="topic_no")
		{
			var keywod="&topic_no="+searchkeyword;	
		}
		else
		{
			var keywod="&topic_name="+searchkeyword;	
		}
	}
	question_vals="&question_vals="+question_val;
	//contact ='';
     //for(i=1; i<=total_subject;i++)
	//{
		//id="requirment_id"+i;
		//if(document.getElementById(id).checked)
			//{
				//contact +=document.getElementById(id).value;
				//contact +=',';
			//}
	//}
	if(document.getElementById(is).checked)
    {
		////alert("hello");
		contact= document.getElementById(is).value;
 	    var data1="subject_ids="+contact+keywod+question_vals;	;	
	   	//alert(data1);
        $.ajax({
            url: "show_ques.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				document.getElementById(que_div).innerHTML=html;
				//alert(html);
            }
            });
	}
	else
	{
		document.getElementById(que_div).innerHTML='';
	}
}


</script>

<script>
$(document).ready(function()
{
    $('.check:button').toggle(function()
	{
        $('input:checkbox').attr('checked','checked');
        $(this).val('uncheck all');
		show_ques();
    },function()
	{
        $('input:checkbox').removeAttr('checked');
        $(this).val('check all'); 
		show_ques();       
    });
});
</script>
<script>
function courses_type(value)
{
	if(value=="parent")
	{
		document.getElementById('course_parent').style.display="block";
		document.getElementById('course_child').style.display="none";
	}
	else
	{
		document.getElementById('course_child').style.display="block";
		document.getElementById('course_parent').style.display="none";
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
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/course_menu.php"; ?></td>
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
			$course_name=$_POST['course_name'];
			$course_description = $_POST['course_description'];
			$course_duration=$_POST['course_duration'];
			$course_level=$_POST['course_level'];
			//$course_video=$_POST['course_video'];
			//$course_pdf=$_POST['course_pdf'];  
			$total_ques=$_POST['total_ques'];
			$staff_idsss=@implode(",",$_POST['staff_id']);                        
			$course_duration=$_POST['course_duration'];
			//$course_id = $_POST['course_id'];
			$category_id = $_POST['category_id'];
			
			$course_price = $_POST['course_price'];
			$subject=@implode(",",$_POST['requirment_id']); 
			$total_subject=@implode(",",$_POST['total_subject']);
			$discountss=$_POST['discount'];                        
			$start_date=$_POST['start_date'];
			$end_date=$_POST['end_date'];
			$topics = $_POST['topics'];
			$status=$_POST['status'];
			$course_type=$_POST['course_type'];
			$child_course_id=$_POST['child_course_id'];
			if($course_name =="")
			{
					$success=0;
					$errors[$i++]="Enter course name";
			}
			if($record_id=='')
			{
				$select_course="select course_name from courses where course_name='".$course_name."' ";
				$query_course=mysql_query($select_course);
				if(mysql_num_rows($query_course))
				{
					$success=0;
					$errors[$i++]="Course Name Already Exist. ";
				}
			}
			if($course_duration =="")
			{
					$success=0;
					$errors[$i++]="Enter course duration";
			}   
			$uploaded_url="";
			/* if(count($errors)==0 && $_FILES['course_video']["name"])
			{
				if($record_id)
				{
					$update_news="update courses set course_video='' where course_id='".$record_id."'";
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
							exec("ffmpeg -i " . $thump_target_path . " " . $options . " " . $thumbpath, $output);                                                        exec("ffmpeg -i ".$thump_target_path." ".$optionsSWF." ".$thumbpathSWf, $outputs);
							exec("ffmpeg -i ".$thump_target_path." ".$optionsMP4." ".$thumbpathMpp, $outputss);
							//print_r($output); 
						}
						else
						{
							$file_uploaded=0;
							$success=0;
							$errors[$i++]="There are some errors while uploading video, please try again";                                                    }
					}
					else
					{
						$file_uploaded=0;
						$success=0;
						$errors[$i++]="Invalid file format..";
					}
				}
			}*/
			$uploaded_url1="";
			/*if(count($errors)==0 && $_FILES['course_pdf']["name"])
			{
				if($record_id)
				{
					$update_news="update courses set course_pdf='' where course_id='".$record_id."'";
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
			}*/
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
				if($_POST['course_url'] != '')
				{
				   if(strpos($_POST['course_url'],"<iframe")!==false)
				   {
					  // echo '1'.'<br />';
					   $ex=explode("/", $_POST['course_url']);
					   $ex1=explode('"', $ex[4]);
					   $data_record['course_url']= $ex1[0];   //$data_record1['course_url'] =   nl2br($_POST['course_url']);
				   }
				   else if(strpos($_POST['course_url'],"http://")!==false || strpos($_POST['course_url'],"https://")!==false)
				   {
					   $ex=explode("/", $_POST['course_url']);                              
					   if($ex[2]=='youtu.be')
					   {
						   $data_record['course_url']= $ex[3];                                    
					   }
					   else
					   {                                   
							$ex1=explode('=', $ex[3]);
							$data_record['course_url']=$ex1[1];
					   }
				   }
				}
				$data_record['admin_id'] = $_SESSION['admin_id'];
				$data_record['cm_id'] = $_SESSION['cm_id'];
				$data_record['course_url_img']=$thumbfile;
				$data_record['course_name'] =$course_name;
				$data_record['course_description'] = $course_description;
				$data_record['course_duration'] = $course_duration;
				$data_record['category_id'] =$category_id;
			   
				$data_record['course_price'] = $course_price;
				$total_ques=count($_POST['topics']);
				$data_record['added_date'] = date('Y-m-d H:i:s');
				$data_record['total_ques']= $total_ques;
				$data_record['subject_id']=$subject;
				if($course_type=="parent")
					$data_record['is_parent']="y";
				else
					$data_record['is_parent']="n";
				//==========================END TOPIC ID===============================*/
				/* if($file_uploaded)
					$data_record['course_video'] =$uploaded_url;*/
				//if($file_uploaded1)
					//$data_record['course_pdf'] =$uploaded_url1;
				$data_record['staff_id'] =$staff_idsss;
				if($record_id)
				{
					$where_record=" course_id='".$record_id."'";   

					$db->query_update("courses", $data_record,$where_record);  
					$del_old_rec  = " delete from topic_map where $where_record  ";
					$ptr_deleted = mysql_query($del_old_rec);
					
					$update_course="update courses set parent_id='0' where parent_id='".$record_id."'";
					$update_courses = mysql_query($update_course);
					if($course_type=="parent")
					{
						$del_query="delete from courses_map where course_parent_id='".$record_id."'";
						$ptr_delete=mysql_query($del_query);
						
						for($i=0;$i<count($child_course_id);$i++)
						{
							$update_course="update courses set parent_id='".$record_id."' where course_id='".$child_course_id[$i]."'";
							$update_courses= mysql_query($update_course);
							
							$ins_parent="insert into courses_map(`course_id`,`course_parent_id`) values('".$child_course_id[$i]."','".$record_id."')";
							$ptr_parent=mysql_query($ins_parent);
						}
					}
					else
					{
						for($i=0;$i<count($topics);$i++)
						{
							$selet_query_for_subject_id = " select subject_id from topic where topic_id ='".$topics[$i]."' ";
							$ptr_subj = mysql_query($selet_query_for_subject_id);
							$data_sub = mysql_fetch_array($ptr_subj);
							$insert_into_topic_map=  " insert into topic_map (	topic_id, course_id, admin_id, cm_id, added_date, subject_id) values('".$topics[$i]."','".$record_id."',	'".$_SESSION['admin_id']."','".$_SESSION['cm_id']."','".date('Y-m-d H:i:s')."','".$data_sub['subject_id']."')";
							$insertt_top_map = mysql_query($insert_into_topic_map);
						}
					}
					$sql_query1= "SELECT course_name FROM courses where course_id ='".$record_id."'";
					$query=mysql_query($sql_query1);
					$fetch=mysql_fetch_array($query);
													
					$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_course','Edit','".$fetch['course_name']."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert);
					?><div id="statusChangesDiv" title="Record added"><center><br><p>Record added successfully</p></center></div>
						<script type="text/javascript">
						$(document).ready(function() {
							$( "#statusChangesDiv" ).dialog({
								modal: true,
								buttons: {
											Ok: function() { $( this ).dialog( "close" );}
										 }
							});
						});
						setTimeout('document.location.href="course_manage.php";',500);
						</script>
					<?php
				}
				else
				{
					$where_admin_id="admin_id='".$_SESSION['admin_id']."'";
					$courses_id=$db->query_insert("courses", $data_record);  
					
					if($course_type=="parent")
					{
						for($i=0;$i<count($child_course_id);$i++)
						{
							"<br/>".$update_course="update courses set parent_id='".$courses_id."' where course_id='".$child_course_id[$i]."'";
							$update_courses = mysql_query($update_course);
							
							$ins_parent="insert into courses_map(`course_id`,`course_parent_id`) values('".$child_course_id[$i]."','".$courses_id."')";
							$ptr_parent=mysql_query($ins_parent);
						}
					}
					else
					{
						for($i=0;$i<count($topics);$i++)
						{
							$selet_query_for_subject_id = " select subject_id from topic where topic_id ='".$topics[$i]."' ";
							$ptr_subj = mysql_query($selet_query_for_subject_id);
							$data_sub = mysql_fetch_array($ptr_subj);
							$insert_into_topic_map=  " insert into topic_map (	topic_id, course_id, admin_id, added_date, subject_id) values('".$topics[$i]."','".$courses_id."','".$_SESSION['admin_id']."','".date('Y-m-d H:i:s')."','".$data_sub['subject_id']."')";
							$insertt_top_map = mysql_query($insert_into_topic_map);
						}
					}
					
					$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_course','Add','".$course_name."','".$courses_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert);
					?><div id="statusChangesDiv" title="Record added"><center><br><p>Record added successfully</p></center></div>
						<script type="text/javascript">
							$(document).ready(function() {
								$( "#statusChangesDiv" ).dialog({
										modal: true,
										buttons: {
													Ok: function() { $( this ).dialog( "close" );}
												 }
								});
								
							});
						setTimeout('document.location.href="course_manage.php";',500);
						</script>
					<?php
				}
				$discount['discount']=$discountss;
				$discount['start_date']=$start_date;
				$discount['end_date']=$end_date;
				$discount['status']=$status;
//                            $discount['for_edit']=$_POST['discount_course'];
				if($courses_id)
					$discount['course_id']=$courses_id;
				else 
					$discount['course_id']=$record_id;
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
			<form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data">
			<table border="0" cellspacing="15" cellpadding="0" width="100%">
			<tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
			<tr>
				<td width="12%">Course Category<span class="orange_font">*</span></td>
				<td width="38%" >
				<select name="category_id" id="category_id" class="validate[required] input_select" >  
					<option value=""> Select Category</option>
					<?php
						$select_category = "select category_id,category_name from course_category  order by category_id asc";
						$ptr_category = mysql_query($select_category);
						/*$data_c=mysql_fetch_array($ptr_category);
						$corse_name=$data_c['category_id'];*/
						while($data_category = mysql_fetch_array($ptr_category))
						{
							if($data_category['category_id'] == $row_record['category_id'])
								echo '<option value='.$data_category['category_id'].' selected="selected">'.$data_category['category_name'].'</option>';
							else
								echo '<option value='.$data_category['category_id'].'>'.$data_category['category_name'].'</option>';
						}
						?>        
				</select>
				</td> 
            </tr>
			<tr>
                <td width="12%">Select Category<span class="orange_font"></span></td><? //echo $row_record['course_name'];?>
                <td width="38%">
                    Is parent<input type="radio" class="validate[required] input_radio" onchange="courses_type('parent');" name="course_type" id="course_type" value="parent" <?php if($_POST['course_type']=="parent") echo 'checked="checked"'; else if($row_record['is_parent']=="y") echo 'checked="checked"' ; ?>  />
					Is child<input type="radio" class="validate[required] input_radio" onchange="courses_type('child');" name="course_type" id="course_type" value="child" <?php if($_POST['course_type']=="child") echo 'checked="checked"'; else if($row_record['is_parent']=="n" || $row_record['is_parent']=="") echo 'checked="checked"' ; ?>  />
                </td> 
            </tr>
			<tr>
                <td width="12%">Course Name<span class="orange_font">*</span></td><? //echo $row_record['course_name'];?>
                <td width="38%">
                    <input type="text" class="validate[required] input_text" name="course_name" id="course_name" value="<?php if($_POST['save_changes']) echo $_POST['course_name']; else echo $row_record['course_name'];?>" />
                </td> 
            </tr> 	
			<tr>
				<td colspan="3">
					<div id="course_parent" <?php if($_POST['course_type']=="parent") echo 'style="display:block"'; else if($row_record['is_parent']=="y") echo 'style="display:block"'; else echo'style="display:none"' ; ?>>
						<table width="100%">
							<tr>
								<td width="14%">Select Course<span class="orange_font">*</span></td>
								<td width="90%" >
								<?php
								$sel_tel = "select course_id,course_name from courses order by course_id asc";	 
								$query_tel = mysql_query($sel_tel);
								$i=1;
								$total_subject = mysql_num_rows($query_tel);
								$member_result='';
								echo '<table width="100%">';
								echo '<tr><td><input type="button" class="check" value="check all" /></td>
								</tr>';//<td><input type="checkbox" name="chkAll" id="checkAll" onclick="selectalls();"/>Check All</td>   
								echo  '<tr>';
								///-======= Existing course code===
								if($record_id)
								{ 
									$select_existing = " select course_id from courses where parent_id='".$record_id."' ";
									$ptr_esxit = mysql_query($select_existing);
									$course_array = array();
									$j=0;
									while( $data_exist = mysql_fetch_array($ptr_esxit))
									{
										$course_array[$j]=$data_exist['course_id'];
										$j++;
									}
								}
								///=== Emd pf existing course code==
								while($row_member = mysql_fetch_array($query_tel))
								{
									echo  '<td style="border:1px solid #999;">'; 
									$checked= '';
									if($record_id)
									{
										if(in_array($row_member['course_id'], $course_array))
										{
											$checked=" checked='checked'";
										}
									}
									echo  "<input type='checkbox' name='child_course_id[]'  value='".$row_member['course_id']."' id='child_course_id$i' class='case' $checked /> ".$row_member['course_name']." ";
									echo  '</td>';
									if($i%7==0)
										echo  '<tr></tr>';  
									$i++;
								}
								echo "<input type='hidden' name='total_subject' id='total_subject' value='$total_subject' />";	
								//echo' <input type="hidden" name="total_subject" value="'.($i-1).'" id="total_subject" />';
								echo '</table>';
								?>
								</td> 
								<!--<td width="40%" align="left"> <div id=total_fees></div></td>-->
							</tr> 
						</table>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<div id="course_child" <?php if($_POST['course_type']=="child") { echo 'style="display:block"';} else if($row_record['is_parent']=="n") {echo 'style="display:block"';} else {echo 'style="display:block"';} ?>>
						<table width="100%">
							<tr>
								<td width="14%">Select Subject<span class="orange_font">*</span></td>
								<td width="90%" >
								<?php
								$sel_tel = "select subject_id,name from subject order by subject_id asc";	 
								$query_tel = mysql_query($sel_tel);
								$i=1;
								$total_subject = mysql_num_rows($query_tel);
								$member_result='';
								echo '<table width="100%">';
								echo '<tr><td><input type="button" class="check" value="check all" /></td>
								</tr>';//<td><input type="checkbox" name="chkAll" id="checkAll" onclick="selectalls();"/>Check All</td>   
								echo  '<tr>';
								///-======= Existing course code===
								if($record_id)
								{ 
									$select_existing = " select subject_id,topic_id from topic_map where course_id='".$record_id."' ";
									$ptr_esxit = mysql_query($select_existing);
									$subject_array = array();
									$topic_array = array();
									$j=0;
									while( $data_exist = mysql_fetch_array($ptr_esxit))
									{
										$subject_array[$j]=$data_exist['subject_id'];
										$topic_array[$j]=$data_exist['topic_id'];
										$j++;
									}
								}
								///=== Emd pf existing course code==
								while($row_member = mysql_fetch_array($query_tel))
								{
									echo  '<td style="border:1px solid #999;">'; 
									$checked= '';
									$style='';
									if($record_id)
									{
										if(in_array($row_member['subject_id'], $subject_array))
										{
											//$checked=" checked='checked'";
											$style="style='font-size:13px;font-weight:700'";
										}
									}
									echo  "<input type='checkbox' name='requirment_id[]'  value='".$row_member['subject_id']."' id='requirment_id$i' onClick='show_ques($i)' class='case' $checked  /> <span $style>".$row_member['name']."</span> ";
									echo  '</td>';
									if($i%7==0)
										echo  '<tr></tr>';  
									$i++;
								}
								echo "<input type='hidden' name='total_subject' id='total_subject' value='$total_subject' />";	
								//echo' <input type="hidden" name="total_subject" value="'.($i-1).'" id="total_subject" />';
								echo '</table>';
							?>
								</td> 
							<!--<td width="40%" align="left"> <div id=total_fees></div></td>-->
							</tr> 
							<tr>
								<td width="10%">Search<span class="orange_font">*</span></td>
								<td colspan="3">           
								<select name="search" id="search">
								<option value="">Select</option>
								<option value="topic_no">Topic No.</option>
								<option value="topic_name">Topic Name</option>
								</select>
								<input type="text" style="width:230px" class="input_text" name="keyword" id="keyword" />
								<input type="button" id="btnShow" name="search_button" value="Search" class="input_btn" onclick="searchTopic()"  />
								<input type="button" name="reset" value="Reset" class="input_btn" onclick="resetTopic()"  />
								</td> 
							</tr>
							<tr>
                        <td height="0" valign="top">Selected Topic<span class="orange_font"></span></td>
                        
                  		<td colspan="4">
                        Total selected topic: <span id="total_count"><?php if($record_id){ echo $row_record['total_ques'];} ?></span><br /><br />
                        <input type="hidden" name="total_ques_cnt" id="total_ques_cnt"  value="<?php if($record_id){ echo $row_record['total_ques'];} ?>" />
                        <table width=100% style="border:1px solid; margin:0; padding:0" class="table">
							<tr>
								<td width="10%" align="center">Topic. No.</td>
								<td width="10%">Subject Name</td>
								<td width="70%" align="center">Topic Title</td>
								<td width="10%" align="center">Remove</td>
							</tr>     
                            <tr><td colspan="4">   
                            <div name="selected_topic"  id="selected_topic" style="width:100%;" cols="">
                            <?php if($record_id)
							{
								$sel_topic= "select topic_id from topic_map where course_id=".$record_id." order by topic_id asc";	
								$query_topic = mysql_query($sel_topic);	
                                while($row_member_topic = mysql_fetch_array($query_topic))
                                {
                                   $sel_top = "select * from topic where topic_id='".$row_member_topic['topic_id']."' order by topic_id asc";	 
                                    $query_top = mysql_query($sel_top);
                                    $total_subject = mysql_num_rows($query_top);
                                    $conc_unit ='';
                                    $c=1;
                                    while($row_memberx = mysql_fetch_array($query_top))
                                    {
                                        $conc_unit .= " subject_id ='".$row_memberx['subject_id']."' ";
                                        if($c !=$total_subject)
                                        $conc_unit .= " or ";
                                        $c++;
										//}
										$member_result='';
										$i=1;
										$n=1;
										$call_function ='';
										$sele_init_name="select name,subject_id from subject where 1 and ( $conc_unit ) order by subject_id asc";
										$ptr_unit=mysql_query($sele_init_name);
										while($row_member = mysql_fetch_array($ptr_unit))
										{ 
											if(in_array($row_member['subject_id'],$subject_array))
											{
                                          
												// $sel_contact= "SELECT * FROM topic where subject_id='".$row_member['subject_id']."'order by topic_id asc ";	 
												// $query_contact = mysql_query($sel_contact);
												// $i=1;
												// $total_contact = mysql_num_rows($query_contact);
												//$member_result='';
												//$i=1;
												// while($row_contact = mysql_fetch_array($query_contact))
												//{
													$checked='';
													// $seleexam_se="select * from topic_map where topic_id='".$row_contact['topic_id']."' and 			course_id='$record_id' ";
													//$ptr_ex=mysql_query($seleexam_se);
													//$tot_ques=mysql_num_rows($ptr_ex);
													//if($tot_ques !=0 || $tot_ques !='')
												//{
													?>
												<div id="selectedqs<?php echo $row_member_topic['topic_id']; ?>" style="clear: both;">
													<table width="100%">
														<tbody>
															<tr>
																<td width="9%" align="center"><?php echo $row_member_topic['topic_id']; ?>.</td>
																<td width="10%" align="center"><?php echo $row_member['name']; ?>.</td>
																<td width="65%" align="center"><?php echo $row_memberx['topic_name']; ?></td>
																<td width="9%" align="center">
																<img id="qsimg<?php echo $row_member_topic['topic_id']; ?>" src="images/delete.gif" onclick="removeSelected('qs<?php echo $row_member_topic['topic_id']; ?>')" width="20" height="20">
																</td>
															</tr>
														</tbody>
													</table>
													<input id="topics" name="topics[]" value="<?php echo $row_member_topic['topic_id']; ?>" type="hidden">
												</div>
												<?php
											}
                                        //}
                                        $i++;
                                        //}
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
							$sel_topic= "select topic_id from topic_map where course_id=".$record_id." order by topic_id asc";	
							$query_topic = mysql_query($sel_topic);	
							while($row_member_topic = mysql_fetch_array($query_topic))
							{
							 $sel_top = "select subject_id from topic where topic_id='".$row_member_topic['topic_id']."' order by topic_id asc";	 
								$query_top = mysql_query($sel_top);
								$total_subject = mysql_num_rows($query_top);
								$conc_unit ='';
								$c=1;
								while($row_memberx = mysql_fetch_array($query_top))
								{
									$conc_unit .= " subject_id ='".$row_memberx['subject_id']."' ";
									if($c !=$total_subject)
									$conc_unit .= " or ";
									$c++;
								}
								$member_result='';
								$i=1;
								$n=1;
								$call_function ='';
								$sele_init_name="select subject_id,name from subject where 1 and ( $conc_unit ) order by subject_id asc";
								$ptr_unit=mysql_query($sele_init_name);
								while($row_member = mysql_fetch_array($ptr_unit))
								{ 
									?><div id="quest_sel_<?php echo $n;?>" >
									<?php
									if(in_array($row_member['subject_id'],$subject_array))
									{
										echo "<table width='100%'>";
										echo "<tr>";							   
										echo "<td width='9%' valign='top'>Select Topic from ".$row_member['name']."<span class='orange_font'>*</span></td>";
										echo "<td width='41%' >";
										$sel_contact = "SELECT * FROM topic where subject_id='".$row_member['subject_id']."'order by topic_id asc ";	 
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
											$seleexam_se="select * from topic_map where topic_id='".$row_contact['topic_id']."' and course_id='$record_id'";
											$ptr_ex=mysql_query($seleexam_se);
											$tot_ques=mysql_num_rows($ptr_ex);
											if($tot_ques !=0 || $tot_ques !='')
											{
												$display="style='display:none'";
											}
											echo  "<td id='qs".$row_contact['topic_id']."' ".$display."><input type='checkbox' name='chapter_id[]' onclick='select_me(\"qs".$row_contact['topic_id']."\")' value='".$row_contact['topic_id']."' id='chapter_id$i' class='case ".$row_contact['topic_id']."' style='vertical-align:top'/><span id='course'></span>".$row_contact['topic_id'].". ".$row_contact['topic_name']." ";
											echo "<span id='course'></span><input type='hidden' name='selected_subject' id='selected_subjects".$row_contact['topic_id']."' value='".$row_member['name']."' >";
											
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
						<!--<div id="topic_list" style='overflow:auto;' >Select Subject first....!</div>-->
                        <div id="show_search_result"></div>
                      	</td> 
                    </tr>
						</table>
					</div>
				</td>
			</tr>
            <tr>
                <td width="12%">Course Duration<span class="orange_font">*</span></td>
                <td width="38%"><input type="text" class="validate[required] input_text" name="course_duration" id="member_contact" value="<?php if($_POST['save_changes']) echo $_POST['course_duration']; else echo $row_record['course_duration'];?>" /></td> 
                <td width="40%"></td>
            </tr>
            <tr>
            <td width="12%" valign="top">Course Description <!--span class="orange_font">*</span --></td>
            <td colspan="2">
			<script src="ckeditor/ckeditor.js"></script>
                <textarea name="course_description" id="course_description"><?php if ($_POST['course_description']) echo stripslashes($_POST['course_description']); else echo $row_record['course_description']; ?></textarea>
            <script>
                CKEDITOR.replace( 'course_description' );
            </script>
                </td> 
            </tr>
            <tr>
                <td width="12%"><div id="coursess" class="coursess" >Course Fees</div>(Non Taxeble fees)</td>
                <td width="38%"><div id="coursess" class="coursess" >
                    <input type="text" class="input_text" name="course_price" id="course_price" value="<?php if($_POST['save_changes']) echo $_POST['course_price']; else echo $row_record['course_price'];?>" />
                </div>
                </td>                
            </tr>
            <tr>
                <td></td>
                <td colspan="2">
                    <div id="discount" class="discount" style="display:none" >
                        <table border="0" cellspacing="15" cellpadding="0"  width="40%" >
                            <tr>
                                <td >Discount</td>
                                <td >
                                    <input type="text" class="input_text" name="discount" id="discount" value="<?php if($_POST['save_changes']) echo $_POST['discount']; else echo $val_coupon['discount'];?>" />
                                </td>
                            </tr>
                            <tr>
                                <td>Start Date</td>
                                <td>
                                    <input type="text" class="validate[required] input_text datepicker" name="start_date" id="start_date" readonly="true" value="<?php if($_POST['save_changes']) echo $_POST['start_date']; else echo $val_coupon['start_date'];?>" />
                                </td>
                            </tr>
                            <tr>
                                <td>End Date</td>
                                <td>
                                    <input type="text" class="validate[required] input_text datepicker" name="end_date" id="end_date" readonly="true" value="<?php if($_POST['save_changes']) echo $_POST['end_date']; else echo $val_coupon['end_date'];?>" />
                                </td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>                                    
                                    <input type="radio" name="status" id="status"  value="Active" <?php if($_POST['status'] == 'Active' || $val_coupon['status'] == 'Active') echo 'checked="checked"';?>/>Active  &nbsp; &nbsp; 
                                    <input type="radio" name="status" id="status"  value="Inactive" <?php if($_POST['status'] == 'Inactive' || $val_coupon['status'] == 'Inactive') echo 'checked="checked"';?>/>Inactive 
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>                
            </tr>
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
<script>
 total_subject = document.getElementById('total_subject').value;
 addition ='';
 for(i=1;i<=total_subject;i++)
 {
	addition += '<div id="quest_sel_'+i+'" ></div>'; 
 }
 document.getElementById('show_ques').innerHTML=addition;
 <?php
 if($record_id !='')
 {
	?>
	//var course_type=document.getElementById('course_type').value;
	var course_type=$("input[id='course_type']:checked").val();
	//alert(course_type);
	courses_type(course_type);
	<?php
 }
 ?>
</script>
</body>
</html>
<?php $db->close();?>