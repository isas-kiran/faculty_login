<?php include 'inc_classes.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>My Answers</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/iCheck/all.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
   
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    .example-modal .modal {
      position: relative;
      top: auto;
      bottom: auto;
      right: auto;
      left: auto;
      display: block;
      z-index: 1;
    }

    .example-modal .modal {
      background: transparent !important;
    }
  </style>
<script language="javascript">
function show(id)
{
	if(document.getElementById('A_sheet').style.display=='none')
		document.getElementById('A_sheet').style.display='block';		
	else	
		document.getElementById('A_sheet').style.display='none';
}

function save_sheet(paper_id)
{
	var total_questions_of_test = document.getElementById('total_questions_of_test').value;
	var anser='';
	for(h=1;h<=total_questions_of_test;h++)
	{
		question_sheet_radio="answer_sheet_"+h;
		qustion_counters = "question_"+h;
		var question_id= document.getElementById(qustion_counters).value;
		//alert(question_id);
		var total_question_option = "total_option_of_"+h;
		total_options_of_question = document.getElementById(total_question_option).value;
		//alert(total_options_of_question);
		for(g=1;g <= total_options_of_question ; g++)
		{
			option_id="answer_sheet_"+h+"_"+g;
			var values_checked = document.getElementById(option_id).checked;
			if(values_checked == true)
			{
				value_chekd=document.getElementById(option_id).value;
				anser += value_chekd+",";				//alert('yes');
			}
		}	
	}	
	var todays_time = document.getElementById('todays_time').value;
	var current_questions= document.getElementById('current_questions').value;
	var current_unit= document.getElementById('current_unit').value;
	var parameters="answers="+anser+"&paper_id="+paper_id+'&todays_time='+todays_time+"&current_questions="+current_questions+"&current_unit="+current_unit;
	//alert(parameters);
	var url = "dynamic_content/save_answer_sheet.php";
	
	document.getElementById('A_sheet').style.display='none';
	loadXMLDocUserPaging(url , parameters);
}
function loadXMLDocUserPaging(url, parameters)
{
	if (window.XMLHttpRequest)
	{
		req = new XMLHttpRequest();
		req.onreadystatechange = processReqChangeUserPaging;
		req.open("POST", url, true);
		req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		req.setRequestHeader("Content-length", parameters.length);
		req.setRequestHeader("Connection", "close");
		req.send(parameters);
		// branch for IE/Windows ActiveX version
	}
	else if (window.ActiveXObject)
	{
		req = new ActiveXObject("Microsoft.XMLHTTP");
		if (req)
		{
			req.onreadystatechange = processReqChangeUserPaging;
			req.open("POST", url, true);
			req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			req.setRequestHeader("Content-length", parameters.length);
			req.setRequestHeader("Connection", "close");
			req.send(parameters);
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
			document.getElementById('question_div').innerHTML = urlpath;
		}
		else
		{
			alert("There was a problem retrieving the XML data:\n" + req.statusText);
		}
	}
}function show_answer_sheet(paper_ids)
{
	this.paper_ids=paper_ids;
	//var url1="dynamic_content/show_answer_sheet.php?paper_ids="+paper_ids+"&dummy=" + new Date().getTime();
	//alert(url1);
	var url1 = "dynamic_content/show_answer_sheet.php";
	var todays_time = document.getElementById('todays_time').value;
	var params = "paper_ids="+paper_ids+'&todays_time='+todays_time;
	
	
	document.getElementById('answer_sheet_div').innerHTML = "<br><br><br><img src='images/loading-circle.gif' align='middle'>";
	
	loadXMLDocUserPaging_for_state(url1,params);
}
function loadXMLDocUserPaging_for_state(url1,params)
{
	this. params = params;
	if (window.XMLHttpRequest)
	{
		
		req1 = new XMLHttpRequest();
		req1.onreadystatechange = processReqChangeUserPaging_state;
		req1.open("POST", url1, true);
		req1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		req1.setRequestHeader("Content-length", params.length);
		req1.setRequestHeader("Connection", "close");
		req1.send(params);
		
	}
	else if (window.ActiveXObject)
	{
		req1 = new ActiveXObject("Microsoft.XMLHTTP");
		if (req1)
		{
			//alert(url1);
			req1.onreadystatechange= processReqChangeUserPaging_state;
			req1.open("POST", url1, true);
			req1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			req1.setRequestHeader("Content-length", params.length);
			req1.setRequestHeader("Connection", "close");
			req1.send(params);
		}
	}
}

function processReqChangeUserPaging_state()
{
	if (req1.readyState == 4)
	{
		if (req1.status == 200)
		{
			response1 = req1.responseXML.documentElement;
			var urlpath1='';
			for(var x = 0; response1.getElementsByTagName('urlpath1')[0].childNodes[x]; x++ )
			urlpath1 = urlpath1.concat(response1.getElementsByTagName('urlpath1')[0].childNodes[x].data);			
			document.getElementById('answer_sheet_div').innerHTML = urlpath1;
		}	
		else
		{
			alert("There was a problem retrieving the XML data:\n" + req1.statusText);
		}
	}
}//========================================
function save_(paper_id,question_id,total)
{
	this.question_id=question_id;
	this.paper_id=paper_id;  
	if(question_id !='')
	{
		this.exam_id = document.getElementById('exam_id').value;
		if(document.question_from.ans)
		{
			for (var i=0; i < document.question_from.ans.length; i++)
		 	{
				if (answer=document.question_from.ans[i].checked)
		  		{
		  			var rad_val = document.question_from.ans[i].value;
					//alert(rad_val);
		  		}
			}
		}
		if(rad_val==null)
		{
			rad_val='';
		}
		this.exam_no= document.getElementById('exam_no').value;
		//alert(current_questions);
		this.current_questions= document.getElementById('current_questions').value;
		//alert(current_questions);
		this.time_complete= document.getElementById('time_complete').value;
		//alert(time_complete);
		var total_questions = document.getElementById('total_questions_of_paper').value ;
		//alert(total_questions);
		var todays_time = document.getElementById('todays_time').value;
		//alert(todays_time);
		//document.getElementById('current_questions').value= question_id;
		var url2="dynamic_content/save_question_only.php";
		var randomnumber = Math.floor(Math.random()*1000001)
		var paramss = "exam_no="+exam_no+"&question_id="+question_id+"&paper_id="+paper_id+"&total_questions="+total_questions+"&answer="+rad_val+"&exam_id="+exam_id+"&end_time="+time_complete+"&current_questions="+current_questions+"&todays_time="+todays_time+"&randomnumber="+randomnumber;
		//alert(paramss);
		//loadXMLDocUserPaging_for_calender(url2,paramss);
	 	$.ajax({
			url:url2, type: "get", data: paramss, cache: false,
			success: function (html)
			{
				//alert(html);	
			}
		});
		//if(Number(question_id)==Number(total))
		//{
		check_remaining();
		//}
	}
}

function show_question(paper_id,question_id)
{
	que_ind=document.getElementById('question_id').selectedIndex;
	total_ques_no =document.getElementById('total_questions_of_paper').value;
	//alert(que_ind);
	if(que_ind==1) 
	{
		document.getElementById('toggle').style.visibility = 'hidden';
		document.getElementById('next').style.visibility = 'visible';
	} 
	else if(que_ind==total_ques_no)
	{
		document.getElementById('toggle').style.visibility = 'visible';
		document.getElementById('next').style.visibility = 'hidden';
	}
	else
	{
		document.getElementById('toggle').style.visibility = 'visible';
		document.getElementById('next').style.visibility = 'visible';
	}
	//alert(question_id);
    this.question_id=question_id;
	this.paper_id=paper_id;
	  
	if(question_id !='')
	{
		 this.exam_id = document.getElementById('exam_id').value;
		 if(document.question_from.ans)
		 {
	 		for (var i=0; i < document.question_from.ans.length; i++)
		 	{
	   			if (answer=document.question_from.ans[i].checked)
		  		{
		  			var rad_val = document.question_from.ans[i].value;
					//alert(rad_val);
		  		}
	 		}
		}
		if(rad_val==null)
		{
			rad_val='';
		}
		this.exam_no= document.getElementById('exam_no').value;
		//alert(current_questions);
		this.current_questions= document.getElementById('current_questions').value;
		//alert(current_questions);
		this.time_complete= document.getElementById('time_complete').value;
		//alert(time_complete);
		var total_questions = document.getElementById('total_questions_of_paper').value ;
		//alert(total_questions);
		var todays_time = document.getElementById('todays_time').value;
		//alert(todays_time);
		document.getElementById('current_questions').value= question_id;
		var url2="dynamic_content/show_ques.php";
		var randomnumber = Math.floor(Math.random()*1000001)
		var paramss = "exam_no="+exam_no+"&question_id="+question_id+"&paper_id="+paper_id+"&total_questions="+total_questions+"&answer="+rad_val+"&exam_id="+exam_id+"&end_time="+time_complete+"&current_questions="+current_questions+"&todays_time="+todays_time+"&randomnumber="+randomnumber+"&que_ind="+que_ind;
   		//alert(paramss);
		document.getElementById('question_div').innerHTML = "<br><br><br><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/loading-circle.gif' align='middle'>";
		//loadXMLDocUserPaging_for_calender(url2,paramss);
		$.ajax({
			url:url2, type: "get", contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15", headers: { Accept : "text/plain; charset=ISO-8859-15","Content-Type": 	"text/plain; charset=utf-8"}, data: paramss, cache: false,
			success: function (html)
			{
				//alert(html)
				if(html.trim()=='logout')
				{  
					alert('You can not attempt exam any more. please contact your school.!');
					document.location.href='index.php?action=<?php echo base64_encode('logout'); ?>';	
				}
				else
				//document.getElementById('question_div').innerHTML=html;
				$("#question_div").html(html);
				check_remaining()
			}
		});
	}
}
</script>

<?php
				
	$select_exams="select * from ex_exams where exam_number='".$_REQUEST['exams_id']."' order by exams_id desc";
	$ptr_exam=mysql_query($select_exams);
	$data_ex=mysql_fetch_array($ptr_exam);
	
	$syllabus_id=$data_ex['syllabus_id'];
	$exam_id=$data_ex['exams_id'];
	
	$sel_exam="select count(exams_section_id) as total_ques from ex_exams_section where (syllabus_id='".$data_ex['syllabus_id']."' and exams_id='".$data_ex['exams_id']."') "  ;
	$ptr_exams_sec=mysql_query($sel_exam);
	$data_exam_section=mysql_fetch_array($ptr_exams_sec);
	
	$select_paper_id = " select distinct(papers_id) as paper_id  from `ex_exams_section` where exams_id='".$data_ex['exams_id']."' ";
	$ptr_s = mysql_query($select_paper_id);
	$data_exs = mysql_fetch_array($ptr_s);		
			
	$totla_qus=$data_ex['total_ques'];
	$paper_time =$data_ex['exam_duration'];
	$total_time=$data_ex['exam_duration'];
	$paper_id =$data_exs['paper_id'];
	/*$paper_id = $_GET['exams_id'];
	$select_paper_detail  = " select * from question_paper where que_papaer_id='$paper_id' ";
	$ptr_paper = mysql_query($select_paper_detail);
	$data_paper = mysql_fetch_array($ptr_paper);
	$paper_title	=  $data_paper['que_paper_name'];
	$description	=  $data_paper['description'];
	//$paper_time = $data_paper['toatal_time'];
	$paper_time = 60;
	$subject_id= $data_paper['subject_id'];
	$total_mark =$data_paper['total_mark'];*/

?>
<?php
function transliterateString($txt) {
   /* $transliterationTable = array('Ã¡' => 'a', 'Ã' => 'A', 'Ã ' => 'a', 'Ã' => 'A', 'Ä' => 'a', 'Ä' => 'A', 'Ã¢' => 'a', 'Ã' => 'A', 'Ã¥' => 'a', 'Ã' => 'A', 'Ã£' => 'a', 'Ã' => 'A', 'Ä' => 'a', 'Ä' => 'A', 'Ä' => 'a', 'Ä' => 'A', 'Ã€' => 'ae', 'Ã' => 'AE', 'ÃŠ' => 'ae', 'Ã' => 'AE', 'áž' => 'b', 'áž' => 'B', 'Ä' => 'c', 'Ä' => 'C', 'Ä' => 'c', 'Ä' => 'C', 'Ä' => 'c', 'Ä' => 'C', 'Ä' => 'c', 'Ä' => 'C', 'Ã§' => 'c', 'Ã' => 'C', 'Ä' => 'd', 'Ä' => 'D', 'áž' => 'd', 'áž' => 'D', 'Ä' => 'd', 'Ä' => 'D', 'Ã°' => 'dh', 'Ã' => 'Dh', 'Ã©' => 'e', 'Ã' => 'E', 'Ãš' => 'e', 'Ã' => 'E', 'Ä' => 'e', 'Ä' => 'E', 'Ãª' => 'e', 'Ã' => 'E', 'Ä' => 'e', 'Ä' => 'E', 'Ã«' => 'e', 'Ã' => 'E', 'Ä' => 'e', 'Ä' => 'E', 'Ä' => 'e', 'Ä' => 'E', 'Ä' => 'e', 'Ä' => 'E', 'áž' => 'f', 'áž' => 'F', 'Æ' => 'f', 'Æ' => 'F', 'Ä' => 'g', 'Ä' => 'G', 'Ä' => 'g', 'Ä' => 'G', 'Ä¡' => 'g', 'Ä ' => 'G', 'Ä£' => 'g', 'Ä¢' => 'G', 'Ä¥' => 'h', 'Ä€' => 'H', 'Ä§' => 'h', 'ÄŠ' => 'H', 'Ã­' => 'i', 'Ã' => 'I', 'Ã¬' => 'i', 'Ã' => 'I', 'Ã®' => 'i', 'Ã' => 'I', 'Ã¯' => 'i', 'Ã' => 'I', 'Ä©' => 'i', 'Äš' => 'I', 'Ä¯' => 'i', 'Ä®' => 'I', 'Ä«' => 'i', 'Äª' => 'I', 'Äµ' => 'j', 'ÄŽ' => 'J', 'Ä·' => 'k', 'Ä¶' => 'K', 'Äº' => 'l', 'Ä¹' => 'L', 'ÄŸ' => 'l', 'Äœ' => 'L', 'ÄŒ' => 'l', 'Ä»' => 'L', 'Å' => 'l', 'Å' => 'L', 'á¹' => 'm', 'á¹' => 'M', 'Å' => 'n', 'Å' => 'N', 'Å' => 'n', 'Å' => 'N', 'Ã±' => 'n', 'Ã' => 'N', 'Å' => 'n', 'Å' => 'N', 'Ã³' => 'o', 'Ã' => 'O', 'Ã²' => 'o', 'Ã' => 'O', 'ÃŽ' => 'o', 'Ã' => 'O', 'Å' => 'o', 'Å' => 'O', 'Ãµ' => 'o', 'Ã' => 'O', 'Ãž' => 'oe', 'Ã' => 'OE', 'Å' => 'o', 'Å' => 'O', 'Æ¡' => 'o', 'Æ ' => 'O', 'Ã¶' => 'oe', 'Ã' => 'OE', 'á¹' => 'p', 'á¹' => 'P', 'Å' => 'r', 'Å' => 'R', 'Å' => 'r', 'Å' => 'R', 'Å' => 'r', 'Å' => 'R', 'Å' => 's', 'Å' => 'S', 'Å' => 's', 'Å' => 'S', 'Å¡' => 's', 'Å ' => 'S', 'á¹¡' => 's', 'á¹ ' => 'S', 'Å' => 's', 'Å' => 'S', 'È' => 's', 'È' => 'S', 'Ã' => 'SS', 'Å¥' => 't', 'Å€' => 'T', 'á¹«' => 't', 'á¹ª' => 'T', 'Å£' => 't', 'Å¢' => 'T', 'È' => 't', 'È' => 'T', 'Å§' => 't', 'ÅŠ' => 'T', 'Ãº' => 'u', 'Ã' => 'U', 'Ã¹' => 'u', 'Ã' => 'U', 'Å­' => 'u', 'Å¬' => 'U', 'Ã»' => 'u', 'Ã' => 'U', 'Å¯' => 'u', 'Å®' => 'U', 'Å±' => 'u', 'Å°' => 'U', 'Å©' => 'u', 'Åš' => 'U', 'Å³' => 'u', 'Å²' => 'U', 'Å«' => 'u', 'Åª' => 'U', 'Æ°' => 'u', 'Æ¯' => 'U', 'ÃŒ' => 'ue', 'Ã' => 'UE', 'áº' => 'w', 'áº' => 'W', 'áº' => 'w', 'áº' => 'W', 'Åµ' => 'w', 'ÅŽ' => 'W', 'áº' => 'w', 'áº' => 'W', 'Ãœ' => 'y', 'Ã' => 'Y', 'á»³' => 'y', 'á»²' => 'Y', 'Å·' => 'y', 'Å¶' => 'Y', 'Ã¿' => 'y', 'Åž' => 'Y', 'Åº' => 'z', 'Å¹' => 'Z', 'ÅŸ' => 'z', 'Åœ' => 'Z', 'ÅŒ' => 'z', 'Å»' => 'Z', 'ÃŸ' => 'th', 'Ã' => 'Th', 'Âµ' => 'u', 'Ð°' => 'a', 'Ð' => 'a', 'Ð±' => 'b', 'Ð' => 'b', 'Ð²' => 'v', 'Ð' => 'v', 'Ð³' => 'g', 'Ð' => 'g', 'ÐŽ' => 'd', 'Ð' => 'd', 'Ðµ' => 'e', 'Ð' => 'E', 'Ñ' => 'e', 'Ð' => 'E', 'Ð¶' => 'zh', 'Ð' => 'zh', 'Ð·' => 'z', 'Ð' => 'z', 'Ðž' => 'i', 'Ð' => 'i', 'Ð¹' => 'j', 'Ð' => 'j', 'Ðº' => 'k', 'Ð' => 'k', 'Ð»' => 'l', 'Ð' => 'l', 'ÐŒ' => 'm', 'Ð' => 'm', 'Ðœ' => 'n', 'Ð' => 'n', 'ÐŸ' => 'o', 'Ð' => 'o', 'Ð¿' => 'p', 'Ð' => 'p', 'Ñ' => 'r', 'Ð ' => 'r', 'Ñ' => 's', 'Ð¡' => 's', 'Ñ' => 't', 'Ð¢' => 't', 'Ñ' => 'u', 'Ð£' => 'u', 'Ñ' => 'f', 'Ð€' => 'f', 'Ñ' => 'h', 'Ð¥' => 'h', 'Ñ' => 'c', 'ÐŠ' => 'c', 'Ñ' => 'ch', 'Ð§' => 'ch', 'Ñ' => 'sh', 'Ðš' => 'sh', 'Ñ' => 'sch', 'Ð©' => 'sch', 'Ñ' => '', 'Ðª' => '', 'Ñ' => 'y', 'Ð«' => 'y', 'Ñ' => '', 'Ð¬' => '', 'Ñ' => 'e', 'Ð­' => 'e', 'Ñ' => 'ju', 'Ð®' => 'ju', 'Ñ' => 'ja', 'Ð¯' => 'ja', 'Â¿Âœ' =>'Ã©', 'Â¿' =>'Ã©');
    $new_str=str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);*/
	return $txt;
}
$_SESSION['user_id']= $_SESSION['student_id'];
if($_GET['action']=='end_exam')
{
	$student_id=$_SESSION['student_id'];
	
	//$paper_id=$_GET['exam_id'];	
	$query_for_time_lasts="select * from ex_student_paper_time where paper_id='".$paper_id."' and student_id='".$_SESSION['student_id']."'" ;
	$ptr_for_times_lastess= mysql_query($query_for_time_lasts);
	if(mysql_num_rows($ptr_for_times_lastess)!=0)
	{
		while($data_time_lastess=mysql_fetch_array($ptr_for_times_lastess))
		{
			$end_times_lasatsd=$data_time_lastess['end_time'];
		}
	}
	$end_times_lasatsd= $paper_time*60*60;
    //$end_exam = "update student_paper_time set end_time = '".$end_times_lasatsd."' where paper_id='".$paper_id."' and  student_id='".$_SESSION['student_id']."' and  date='".date('Y-m-d')."' ";
	 $end_exam="update ex_student_paper_time set end_time='".$end_times_lasatsd."' where paper_id='".$paper_id."' and  student_id='".$_SESSION['student_id']."' ";
	$ptrs_update = mysql_query($end_exam);
	
	$update_stud="update ex_stud_login set status='inactive' where stud_login_id='".$_SESSION['student_id']."'";
	$ptr_up_stud=mysql_query($update_stud);
	//session_destroy();
	
	?>
	<script language="javascript">
	document.location.href="thank_you.php?exam_no=<?php echo $_REQUEST['exams_id']; ?>";
	</script>
	<?php 
}
?>
<script>
function confirm_msg()
{
	$.confirm({
		
				'title'		: 'Are you sure want to Exit ?',
				'content'	: '',
				'message'	: '',
				'buttons'	: {
					'Ok'	: {
						'class'	: 'blue',
						'action': function(){
							document.location.href="index.php?action=<?php echo base64_encode('logout'); ?>";
						}
					},
					'No'	: {
						'class'	: 'gray',
						'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
					}
				}
				/*title: 'Are you sure want to Exit ?',
				content: '',
				buttons: 
				{
					confirm: function () {
						document.location.href="index.php?action=<?php //echo base64_encode('logout'); ?>";
					},
					cancel: function () {
						//action: function(){}
					},
				
				}*/
			});
}
/*function logout()
{
	
<?php //session_destroy(); ?>
document.location.href="student_login.php";
}*/
</script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php //include "include/header-main.php"; ?>
  <!-- Left side column. contains the logo and sidebar -->
  <?php //include "include/menu_left.php"; ?>
  <!-- Content Wrapper. Contains page content -->
    <!-- Left side column. contains the logo and sidebar -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left:0px !important">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="text-align:center;display: inline-flex; width:100%">
    	<div class="col-md-2">
        	<img src="images/logo.jpg" width="90px" height="60px" style="margin: 5px 5px 5px 5px; float:left"/>
        </div>
        <div class="col-md-10">
            <h3 class="box-title" style="margin-top:7px !important">ISAS BEAUTY SCHOOL</h3>
        </div>
      <!--<h1>
        Holiday List
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>-->
    </section>
	<?php
	/*if($_GET['action']!='end_exam')
	{
		$end_time=0;
		$today_end_time=0;
		 $query_for_time = "select * from  ex_student_paper_time where paper_id='".$paper_id."' and  student_id='".$_SESSION['student_id']."' " ;
		$ptr_for_times= mysql_query($query_for_time);
		if(mysql_num_rows($ptr_for_times)!=0)
		{
			$data_time = mysql_fetch_array($ptr_for_times);
			//$end_time = $data_time['end_time'];	//26-3-18
			$end_time=$data_time['exam_completed_time'];		
			if($end_time >= ($paper_time*60*60))
			{
				?>
				<script language="javascript">
				alert("You are already attend this test..!");
				//document.location.href="exam_scor.php?paper_id=<?php //echo $paper_id ?>"					
				</script>
				<?php
			}
			else
			{
				 $query_for_todays_time = " select * from  ex_student_paper_time where paper_id='".$paper_id."' and  student_id='".$_SESSION['student_id']."' " ;
				$ptr_for_todays_times= mysql_query($query_for_todays_time);
				if(mysql_num_rows($ptr_for_todays_times)!=0)
				{
					//$data_todays_time = mysql_fetch_array($ptr_for_times);
					//$today_end_time = $data_todays_time['end_time'];
				}
				else
				{
					 $insert_time = "insert into ex_student_paper_time(`student_id`,`paper_id`,`start_time`,`date`) values('".$_SESSION['user_id']."','".$paper_id."','".date('Y-m-d H:i:s')."','".date('Y-m-d')."') ";
					$ptrs_insert_time = mysql_query($insert_time);
				}
			}
		}
		else
		{
		$insert_time ="insert into ex_student_paper_time (`student_id`,`paper_id`,`start_time`,`date`) values('".$_SESSION['user_id']."','".$paper_id."','".date('Y-m-d H:i:s')."','".date('Y-m-d')."') ";
			$ptrs_insert_time = mysql_query($insert_time);
		}
	}*/
	//echo "<br/>-->".$end_time."<br/>";
	?>
	<input type="hidden" id="total_time" value="<?php echo $paper_time*60; ?>" />
	<input type="hidden" id="time_complete" value="<?php if($end_time!='') echo $end_time; else echo'0'; ?>" />
	<input type="hidden" id="todays_time" value="<?php if($end_time >0) echo $end_time; else echo "0"; ?>" />
	<script type="text/javascript">
	/*var intval="";
	var total_time = '<?php //echo $paper_time; ?>';
	var copmos =  Math.floor(parseInt(document.getElementById('time_complete').value)/60);
	//alert(total_time+":min Is Total Time \n"+copmos+" min Completed");
	if(intval==""){
		intval=window.setInterval("start_clock()",1000)
	}else{
		  stop_Int()
	}
	function stop_Int(){
		if(intval!=""){
		  window.clearInterval(intval)
		  intval=""
		}
	}
	function start_clock()
	{
		var total_time =  parseInt(document.getElementById('total_time').value);
		//alert("total"+total_time);
		var spend_time =  parseInt(document.getElementById('time_complete').value);
		//alert("spend"+spend_time);
		var compl= spend_time + 1;
		//alert("compl"+compl);
		var times = total_time -  compl;
		//alert("left"+times)
		if(times<=0)
		{
			//change today
			alert('Time Complete');
			location.href='thank_you.php?exam_no=<?php //echo $_GET['exams_id']; ?>';
		}
		//alert(compl);
		//document.getElementById('total_time').value= times;
		var todays_total_time =parseInt(document.getElementById('todays_time').value);
		this.todays = todays_total_time +	 1;
		
		document.getElementById('todays_time').value= todays;
		//alert(document.getElementById('todays_time').value);
		var sec= times %60;
		minute = Math.floor(times /60);
		mins= minute;
		
		var spents = compl%60;
		min_spwnt =   Math.floor(compl/60);
		document.getElementById('time_complete').value= compl;
		//alert(mins+" : "+ sec);
		//alert(min_spwnt+" : "+ spents);
		document.getElementById('myTimer').innerHTML=mins+" : "+ sec ;
		document.getElementById('spended').innerHTML=min_spwnt+" : "+ spents ;
	}*/
	</script>
    <!-- Main content -->
    <section class="content">
      <!-- /.box -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-12">
          <!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">
            <div class="box-header with-border" >
            	<div class="row invoice-info">
                    <div class="col-sm-6 invoice-col">
                      <input type="hidden"  id="exam_id" value="<?php echo $exam_id; ?>" />
                      <strong>Student Name : </strong><?php echo $_SESSION['name'].' - '.$_SESSION['student_id']; ?><input type="hidden" name="student_id" id="student_id" value="<?php echo $_SESSION['student_id']; ?>" /><br/>
                      <strong>Exam No : </strong><?php echo $data_ex['exam_number']; ?><input type="hidden" name="exam_no" id="exam_no" value="<?php echo $data_ex['exam_number']; ?>"  /><br/>
                      <strong>No of Questions : </strong><?php echo $data_exam_section['total_ques']; ?><input id='total_questions_of_paper' type="hidden" value="<?php echo $data_exam_section['total_ques'];?>" /><br/>
                      <strong>Time Left : </strong> <span id="myTimer" style="color:#300"></span>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6 invoice-col">
                      <strong>Total Marks : </strong><?php echo $data_ex['exam_mark']; ?><br/>
                      <strong>Time (In Minutes) : </strong><?php echo  $data_ex['exam_duration']; ?><br/>
                      <strong>Time Complete : </strong><span id="spended" style="color:#300"></span><br/>
                    </div>
                    <!--<div class="col-sm-2 invoice-col">
                    <input type="button" value="Exit" class="btn btn-danger" name="start_exam" onclick="confirm_msg()" style="margin-left:10px;"/>
                    </div>-->
                    <!-- /.col -->
                  </div>
              	<!--<div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>-->
            </div>
            <!-- /.box-header -->
            <form name="question_from" >
                <div id="question_div">
                	<?php
					$option_array = array();
					$y=1;
					
					$que_array =$_SESSION['que_array'];
					if($_GET['question_id']!='')
					{
						$ques_ids=$_GET['question_id'];
					}
					else
					{
						$ques_ids=$que_array[0];
					}
					$sel_ex_ques="select question_id,unit_id from ex_exams_section where question_id ='".$ques_ids."' and exams_id='".$data_ex['exams_id']."' ";
					$ptr_ex=mysql_query($sel_ex_ques);
					$data_ex_ques=mysql_fetch_array($ptr_ex);
					$curr_unit_id=$data_ex_ques['unit_id'];
							
					$select_question_first ="select question_title,question_id,question_img from ex_question where question_id='".$data_ex_ques['question_id']."' order by question_id asc limit 0,1  " ;
					$ptrs_first_que = mysql_query($select_question_first) ;
					$i=0 ;
					$data_ptr_last_que = mysql_fetch_array($ptrs_first_que);
					
					$question_id = $data_ptr_last_que['question_id'];
					$question_title = stripslashes(html_entity_decode(($data_ptr_last_que['question_title'])));
					$question_img= trim($data_ptr_last_que['question_img']);
					echo "<input type='hidden' name='current_question' id='current_questions' value='".$question_id."' >";
					echo "<input type='hidden' name='current_unit' id='current_unit' value='".$curr_unit_id."' >";
							
					$option_arrays = $_SESSION['option_array'];
					if($_GET['ques_no']!='')
					{
						$ques_no=$_GET['ques_no'];
					}
					else
						$ques_no=1;
					?>
                    <div class="box-body">
                        <div class="box box-success">
                            <div class="box-header">
                              <h3 class="box-title"><?php echo $ques_no; ?>) <?php echo $question_title;?> <?php if($question_img !=''){ ?> <img src="../faculty_login/ex_question_photo/<?php echo $question_img; ?>" height="100" width="100" /><?php }?></h3>
                            </div>
                            <div class="box-body">
                              <!-- Minimal style -->
                              <div class="form-group">
                              	<?php 
								$given_answer_option ='';
								$select_answer_gived = "select answer_option from ex_student_paper where student_id='".$_SESSION['student_id']."' and question_id='".$question_id."' ";
								$ptr_given_ans= mysql_query($select_answer_gived);	
								if(mysql_num_rows($ptr_given_ans))	
								{
									$given_ans = mysql_fetch_array($ptr_given_ans);
									$given_answer_option =$given_ans['answer_option'];
								}	
								for($i=0;$i<4;$i++)
								{
									$select_option_last="select * from ex_options where option_id='".$option_arrays[$ques_no-1][$i]."' ";
									$ptrs_option = mysql_query($select_option_last);
									$data_opt = mysql_fetch_array($ptrs_option);
									
									$option_title=stripcslashes(html_entity_decode($data_opt['option_title']));
									$color="";
									if($data_opt['option_id']==$data_mys_exam['answer_option']) 
									{
										$sel='checked="checked"'; 
										$color="red";
									}
									if($data_opt['option_id']==$data_mys_exam['answer_option'] && $data_opt['answer']=='y') 
									{ 
										$color="green";
										$ans_cnt +=1;
									}
									if($data_opt['answer']=='y') 
									{ 
										$color="green";
									}
									?>
									<label>
                                  	<input type="radio" name="ans" disabled value="<?php echo $option_arrays[$ques_no-1][$i]; ?>" <?php if( $given_answer_option==$option_arrays[$ques_no-1][$i]) echo "checked='checked'" ;?>><!--class="minimal" style="position: absolute; opacity: 0;"-->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <span style="color:<?php echo $color; ?>"><?php echo $option_title; ?></span>
                                  <?php if($data_opt['option_image'] !=''){ ?> <!--<img src="../onlinemcq/question_photo/<?php //echo $data_opt['option_image']; ?>" /> 4/3/19--><?php // }?> <?php if (file_exists('../dubai.isasbeautyschool.org/question_photo/'.$data_opt['option_image'].'')) { ?> <img src="../dubai.isasbeautyschool.org/question_photo/<?php echo $data_opt['option_image']; ?>" width="100" height="100"/><?php }} ?>
                                </label>
                                <br />
									<?php  
								}?>
                                
                              </div>
                              <!-- checkbox -->
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                            	<div class="col-xs-12">
                                  	<button type="button" onclick="back_question();" id="toggle" name="back" class="btn btn-primary pull-left" style="margin: 10px; margin-right:30px !important; cursor:pointer"><i class="fa fa-reply"></i>&nbsp;&nbsp; Back</button>
                                  	<button type="button" name="next" id="next" onclick="next_question();" class="btn btn-primary pull-left"  style="margin: 10px;cursor:pointer">
                                    <i class="fa  fa-share"></i>&nbsp;&nbsp; Next 
                                  	</button>
                                    <div class="pull-left" style="margin-left: 5px; margin:10px">
                                      <select id="question_id" class="form-control" name="question_id" onchange="move_question(this.value);" style="width:100px;">
                                        <option value="">Question</option>
                                        <?php
                                        for($i=0;$i<count($que_array);$i++)
                                        {	
                                            $d=$i+1;  
                                            $sel="";
                                            if($_GET['ques_no']!='')	
                                            {
                                                if($_GET['ques_no']==$d)
                                                {
                                                  $sel="selected='selected'";
                                                }
                                                else
                                                {
                                                    $sel="";
                                                }
                                            }
                                            if($i==0)
                                            echo "<option value='".$que_array[$i]."' selected='selected' >Q No.".$d."</option>";
                                            else
                                            echo "<option value='".$que_array[$i]."' ".$sel.">Q No.".$d."</option>";
                                        }
                                        ?>	</select>
                                    </div>
                                    <!--<input type="button" data-toggle="modal" data-target="#modal-danger" name="end_test" title="Save and Exit" class="btn btn-success pull-left" value="Save and Exit" style="margin: 10px;">--> <!--onclick="return is_remain();"-->
                                     <!--<a href="invoice-print.html" target="_blank" style="margin-right: 5px;" class="btn btn-danger pull-right"><i class="fa fa-print"></i> Exit</a>-->
                                     <!--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger"> Launch Danger Modal </button>-->
                              </div>
                            </div>
                        </div>
                      <!-- /.table-responsive -->
                    </div>
                </div>
            </form>
            <div id="textdis"></div>
            <script language="javascript">
            function clears()
            {
                document.question_from.reset();
            }
            </script>
            <script language="javascript">
				<?php
				if($ques_no==1 || $ques_no=='')
				{
					?>
					document.getElementById('toggle').style.visibility = 'hidden';
					<?php
				}
				?>
				function save_answer_only()
				{
					this.que=document.getElementById('question_id').selectedIndex;
					this.total_questions_of_paper =document.getElementById('total_questions_of_paper').value;					
					save_('<?php echo $paper_id; ?>',que,total_questions_of_paper);
				}
				function next_question()
				{	 
					this.que=document.getElementById('question_id').selectedIndex;
					//alert("current-"+que);
					this.total_questions_of_paper =document.getElementById('total_questions_of_paper').value;
					//alert("Total-"+total_questions_of_paper);
					next_que=que+1;
					//alert("next_ques-"+next_que);
					last_question=total_questions_of_paper;
					//alert(last_question);
					/* if(next_que==0) 
					{
						document.getElementById('toggle').style.visibility = 'hidden';
					 } 
					 else
					 {
						document.getElementById('toggle').style.visibility = 'visible';
					 }
					 
					 if(next_que==last_question) 
					 {
						document.getElementById('next').style.visibility = 'hidden';
					 } 
					 else 
					 {
						document.getElementById('next').style.visibility = 'visible';
					 }*/
					 if(next_que==1) 
					 {
						document.getElementById('toggle').style.visibility = 'hidden';
					 } 
					 else
					 {
						document.getElementById('toggle').style.visibility = 'visible';
					 }
					 if(next_que <= total_questions_of_paper) 
					 {
						document.getElementById('next').style.visibility = 'visible';
					 } 
					 else
					 {
						 document.getElementById('next').style.visibility = 'hidden';
						 setTimeout('document.location.href="thank_you.php?action=end_exam&amp;paper_id=<?php echo $_GET['exam_id'];?>";',1000);
					 }
					 
					if(que !=0)
					{
						// alert(total_questions_of_paper);
						if(next_que <= total_questions_of_paper);
						{ 
							this.queselected_que=document.getElementById('question_id').options[next_que].value;
							student_id=document.getElementById('student_id').value;
							time_complete_1=document.getElementById('time_complete').value;
							paper_id=document.getElementById('exam_id').value;
							
							var url2="dynamic_content/save_time.php";
							var paramss ="student_id="+student_id+"&time_complete="+time_complete_1+"&paper_id="+paper_id;
							//alert(paramss);
							$.ajax({
								url:url2, type: "post", data: paramss, cache: false,
								success: function (html)
								{
									//alert(html);
									//check_remaining();
									setTimeout('document.location.href="show_my_ans.php?exams_id=<?php echo $_GET['exams_id']; ?>&syllabus_id=<?php echo $syllabus_id; ?>&exam_id=<?php echo $_GET['exam_id']; ?>&question_id='+queselected_que+'&ques_no='+next_que+'";');	
								},    
								error: function( req, status, err ) {
									console.log( 'something went wrong', status, err );
									alert('something went wrong'+ status + err); 
									//check_remaining();
									setTimeout('document.location.href="show_my_ans.php?exams_id=<?php echo $_GET['exams_id']; ?>&syllabus_id=<?php echo $syllabus_id; ?>&exam_id=<?php echo $_GET['exam_id']; ?>&question_id='+queselected_que+'&ques_no='+next_que+'";',1000);
								} 
							});
							
							//show_question('<?php //echo $paper_id; ?>',queselected_que);
						}
					}
				}
				function move_question(ques_no)
				{	 
					this.que=document.getElementById('question_id').selectedIndex;
					this.total_questions_of_paper =document.getElementById('total_questions_of_paper').value;
					next_que=que;
					last_question=total_questions_of_paper;
					 
					if(next_que==1) 
					{
						document.getElementById('toggle').style.visibility = 'hidden';
					} 
					else
					{
						document.getElementById('toggle').style.visibility = 'visible';
					}
					if(next_que <= total_questions_of_paper) 
					{
						document.getElementById('next').style.visibility = 'visible';
					} 
					else
					{
						document.getElementById('next').style.visibility = 'hidden';
					}
					 
					if(que !=0)
					{
						// alert(total_questions_of_paper);
						if(next_que <= total_questions_of_paper);
						{ 
							//alert(document.getElementById('question_id').options[next_que].value);
							//this.queselected_que=document.getElementById('question_id').options[next_que].value;
							//alert(queselected_que);
							//document.getElementById('question_id').selectedIndex=next_que;
							//alert(queselected_que);
							
							student_id=document.getElementById('student_id').value;
							time_complete=document.getElementById('time_complete').value;
							paper_id=document.getElementById('exam_id').value;
							
							var url2="dynamic_content/save_time.php";
							var paramss ="student_id="+student_id+"&time_complete="+time_complete+"&paper_id="+paper_id;
							//alert(paramss);
							$.ajax({
								url:url2, type: "post", data: paramss, cache: false,
								success: function (html)
								{
									//alert(html);
									//check_remaining();
									setTimeout('document.location.href="show_my_ans.php?exams_id=<?php echo $_GET['exams_id']; ?>&syllabus_id=<?php echo $syllabus_id; ?>&exam_id=<?php echo $_GET['exam_id']; ?>&question_id='+ques_no+'&ques_no='+next_que+'";');
								},    
								error: function( req, status, err ) {
									console.log( 'something went wrong', status, err );
									alert('something went wrong'+ status + err); 
									//check_remaining();
									setTimeout('document.location.href="show_my_ans.php?exams_id=<?php echo $_GET['exams_id']; ?>&syllabus_id=<?php echo $syllabus_id; ?>&exam_id=<?php echo $_GET['exam_id']; ?>&question_id='+ques_no+'&ques_no='+next_que+'";',1000);
								} 
							});
							//show_question('<?php //echo $paper_id; ?>',queselected_que);
						}
					}
				}
				function back_question()
				{	
					 this.que=document.getElementById('question_id').selectedIndex;
					 next_que=que-1;
					 //alert(next_que);
					 if(next_que==1) 
					 {
						document.getElementById('toggle').style.visibility = 'hidden';
						document.getElementById('next').style.visibility = 'visible';
					 } 
					 else 
					 {
						document.getElementById('toggle').style.visibility = 'visible';
						document.getElementById('next').style.visibility = 'visible';
					 }
					 this.queselected_que=document.getElementById('question_id').options[next_que].value;
	
					//alert(queselected_que);
	
					 this.total_questions_of_paper =document.getElementById('total_questions_of_paper').value;
					 if(que>=total_questions_of_paper);
					 {
						if(que>1)
						{
							document.getElementById('question_id').selectedIndex=next_que;
							
							student_id=document.getElementById('student_id').value;
							time_complete=document.getElementById('time_complete').value;
							paper_id=document.getElementById('exam_id').value;
							
							var url2="dynamic_content/save_time.php";
							var paramss ="student_id="+student_id+"&time_complete="+time_complete+"&paper_id="+paper_id;
							//alert(paramss);
							$.ajax({
								url:url2, type: "post", data: paramss, cache: false,
								success: function (html)
								{
									setTimeout('document.location.href="show_my_ans.php?exams_id=<?php echo $_GET['exams_id']; ?>&syllabus_id=<?php echo $syllabus_id; ?>&exam_id=<?php echo $_GET['exam_id']; ?>&question_id='+queselected_que+'&ques_no='+next_que+'";');
								},    
								error: function( req, status, err ) {
									console.log('something went wrong', status, err);
									alert('something went wrong'+ status + err); 
									setTimeout('document.location.href="show_my_ans.php?exams_id=<?php echo $_GET['exams_id']; ?>&syllabus_id=<?php echo $syllabus_id; ?>&exam_id=<?php echo $_GET['exam_id']; ?>&question_id='+queselected_que+'&ques_no='+next_que+'";',1000);
								} 
							});
							
							//show_question('<?php //echo $paper_id; ?>',queselected_que);
						
						}
					}
				}
				</script>
            	<script language="javascript">
				function submit_exam()
				{
					document.location.href="show_my_ans.php?action=end_exam&amp;paper_id=<?php echo $_GET['exam_id'];?>&exams_id=<?php echo $_REQUEST['exams_id']; ?>";
				}
                function is_remain()
                {
                    yes_no =document.getElementById('rem').value;
                    //alert(yes_no);
                    var quess ='';
                    if(yes_no=='yes')
                    {
                        //There are not attended questions. Are you sure want to submit incomplete answer paper ?
                        ques= document.getElementsByClassName("qs_s");
                        var lengths1=ques.length;
                        //alert(lengths1);
                        for(var i=0; i<lengths1;i++)
                        {
                            var quess =quess + ques[i].innerHTML;
                            var quess= quess + "?";
                            if(i!= lengths1-1)
                            {
                                var quess= quess + ",  ";
                            }			
                        }
                        //alert(quess);
                        $.confirm({	
                            'title'		: quess,
                            'content'	: '',
                            'message'	: '',
                            'buttons'	: {
                                'Ok'	: {
                                    'class'	: 'blue',
                                    'action': function(){
                                        document.location.href="show_my_ans.php?action=end_exam&amp;paper_id=<?php echo $_GET['exam_id'];?>&exams_id=<?php echo $_REQUEST['exams_id']; ?>";
                                    }
                                },
                                'No'	: {
                                    'class'	: 'gray',
                                    'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
                                }
                            }
                            /*title: '',
                            content: quess,
                            buttons: 
                            {
                                confirm: function () {
                                    document.location.href="show_my_ans.php?action=end_exam&amp;paper_id=<?php //echo $_GET['exam_id']; ?>";
                                },
                                cancel: function () {
                                    //action: function(){}
                                },
                            
                            }*/
                        });
                        /*if(confirm(quess))//
                        {
                            document.location.href="show_my_ans.php?action=end_exam&amp;paper_id=<?php //echo $_GET['exam_id']; ?>";
                        }
                        else
                        return false;*/
                    }
                    else if(yes_no=='no')
                    {
                        $.confirm({
                            
                            'title'		: quess,
                                'content'	: '',
                                'message'	: '',
                                'buttons'	: {
                                    'Ok'	: {
                                        'class'	: 'blue',
                                        'action': function(){
                                            document.location.href="show_my_ans.php?action=end_exam&amp;paper_id=<?php echo $_GET['exam_id']; ?>&exams_id=<?php echo $_REQUEST['exams_id']; ?>";
                                        }
                                    },
                                    'No'	: {
                                        'class'	: 'gray',
                                        'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
                                    }
                                }
                                
                            /*title: '',
                            content: quess,
                            buttons: {

                                confirm: function () {
                                   document.location.href="show_my_ans.php?action=end_exam&amp;paper_id=<?php //echo $_GET['exam_id']; ?>";
                                },
                                cancel: function () {
                                   // action: function(){}
                                },
                                
                            }*/
                        });
                        
                        /*if( confirm())
                        {
                            document.location.href="show_my_ans.php?action=end_exam&amp;paper_id=<?php //echo $_GET['exam_id']; ?>";
                        }
                        else
                            return false;*/
                    }
                                    
                }
				function save_time()
				{
					student_id=document.getElementById('student_id').value;
					time_complete=document.getElementById('time_complete').value;
					paper_id=document.getElementById('exam_id').value;
					
					var url2="dynamic_content/save_time.php";
					var paramss ="student_id="+student_id+"&time_complete="+time_complete+"&paper_id="+paper_id;
					//alert(paramss);
					$.ajax({
						url:url2, type: "post", data: paramss, cache: false,
						success: function (html)
						{
							//alert(html);
						}
					});
					
				}
				
				function set_select(vals)
				{
					$("#question_id").val(vals);
					show_question('<?php echo $data_ex['unit_id']; ?>',vals);
				
				}
				function check_remaining()
				{
					/*$("#pending_question_list").html('<img src="images/loading-circle.gif" align="center">')
					$.ajax({url: "remaining_question.php?exam_id=<?php //echo $_GET['exam_id']; ?>", success: function(result){
						$("#pending_question_list").html(result);
					}});*/
				}
                 /*<a href="show_my_ans.php?action=end_exam&amp;paper_id=<?php //echo $_GET['exam_id']; ?>" style="text-decoration:none" onclick="return confirm('Are you sure want to submit answer paper?')">*/
                </script>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
            	<div id="pending_question_list">
				<?php
                /*echo "Que Not Attempted : ";
                  $select_done = " select question_id from ex_student_paper where exam_id ='".$_GET['exam_id']."' and  student_id='".$_SESSION['student_id']."' ";
                $ptr_done = mysql_query($select_done);
                $rem='no';
                if(mysql_num_rows($ptr_done))
                {
                    $pending_array= array();
                    $done_array= array();
                    $i=0;
                    while($data_solve = mysql_fetch_array($ptr_done))
                    {
                        $done_array[$i]= $data_solve['question_id'];
                        $i++;
                    }
                    $result = array_diff($que_array, $done_array);
                    //echo count($result);
                    foreach($result as $x => $x_value) 
                    {
                        $ques_nos=$x+1;
                        echo "<a href='show_my_ans.php?exams_id=".$_GET['exams_id']."&syllabus_id=".$syllabus_id."&exam_id=".$_GET['exam_id']."&question_id=".$x_value."&ques_no=".$ques_nos."'><span class='qs_s' id='qs_s' >".($x+1)."</span></a> |";
                        $rem='yes';
                    }
                }
                else
                {
                    for($j=0;$j<=count($que_array);$j++)
                    {
                        $ques_nos=$j+1;
                        echo "<a href='show_my_ans.php?exams_id=".$_GET['exams_id']."&syllabus_id=".$syllabus_id."&exam_id=".$_GET['exam_id']."&question_id=".$x_value."&ques_no=".$ques_nos."' onclick='return save_time()'><span class='qs_s' id='qs_s' >".($j+1)."</span></a> |";//show_question( ".$data_ex['unit_id'].",$que_array[$j])
                        $rem='yes';
                    }
                }*/
                
                if($rem=='yes')
                { 
                    echo "<input type='hidden' name='rem' value='yes' id='rem'>";  
                }
                else
                {
                    echo "<input type='hidden' name='rem' value='no' id='rem'>";
                }
                
                if($data_exam_section['total_ques']==$ques_no)
                {
                    ?>
                    <script>
                    document.getElementById('next').style.visibility = 'hidden';
                    </script>
                    <?php
                }
                ?>
                <div class="modal modal-danger fade" id="modal-danger">
                    <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Are you sure want to submit the exam ?</h4>
                          </div>
                          <!--<div class="modal-body">
                            <p>One fine body&hellip;</p>
                          </div>-->
                          <div class="modal-footer">
                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">No</button>
                            <button type="button" class="btn btn-outline" onClick="return submit_exam()">Yes</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                	</div>
                </div>
              <!--<a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
              <a href="javascript:void(0)" class	="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>-->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
	  </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include "include/footer-main.php"; ?>
</div>

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
</body>
</html>