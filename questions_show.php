<?php session_start();
include '../onlinemcq/inc_classes.php';
/*$_SESSION['student_id'] = 51;
$_SESSION['name'] = 'rdds';
$_SESSION['examination_number']=16003;
$_SESSION['language_id']=3;
$_SESSION['school_code']='CH500';
*/

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script src="../js/jquery-1.11.0.min.js"></script>
<style>
#videoElement {width: 200px;height: 200px;background-color: #666;float:right; text-align:right}
#container {margin-rigth: 0px auto;width: 200px;height: 200px;border: 10px #333 solid; text-align:right}

.test, .test_2, .text {

font-size:17px !important;
}
@font-face {

 font-weight: normal;
 font-style: normal;
 
}
@font-face {

 font-weight: normal;
 font-style: normal;
}
.input_btn {
    background-color: #0066cc;
    border: medium none;
    box-shadow: 3px 3px 3px #888888;
    color: #ffffff;
    cursor: pointer;
    font-family: Arial;
    font-size: 12px;
    font-weight: bold;
    height: 31px;
}
.input_btn:hover {
	color:#333333;
}
.previous
{
	background: url(images/previous1.jpg) no-repeat;
    cursor:pointer;
    border: none;
	width:60px;
	height:40px;
}
.next
{
	background: url(images/next1.jpg) no-repeat;
    cursor:pointer;
    border: none;
	width:60px;
	height:40px;
}
.save
{
	background: url(images/save1.jpg) no-repeat;
    cursor:pointer;
    border: none;
	width:60px;
	height:40px;
}
.qs_s{ cursor:pointer}
</style><script language="javascript">
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
	//alert(total_questions_of_test);	//this answer_sheet_forms= document.answer_sheet_form;
	//alert(paper_id);
	var anser='';
	for(h=1;h<=total_questions_of_test;h++)
	{
		question_sheet_radio="answer_sheet_"+h;
		qustion_counters = "question_"+h;
		var question_id= document.getElementById(qustion_counters).value;
	//	alert(question_id);
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
		}	}	var todays_time = document.getElementById('todays_time').value;
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
function save_(paper_id,question_id)
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
							{//alert(html);	
								
							}
						  });
	
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
							url:url2, type: "get", contentType: "text/xml;charset=utf-8", data: paramss, cache: false,
							success: function (html)
							{
								//alert(html)
								if(html.trim()=='logout')
								{  alert('You can not attempt exam any more. please contact your school.!');
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
				
				$select_exams="select * from exams where (exam_number=".$_SESSION['examination_number'].") order by exams_id desc";
				$ptr_exam=mysql_query($select_exams);
				$data_ex=mysql_fetch_array($ptr_exam);
				$exam_id=$data_ex['exams_id'];
				
				$sel_exam="select count(exams_section_id) as total_ques from exams_section where (syllabus_id='".$data_ex['syllabus_id']."' and exams_id='".$data_ex['exams_id']."') and  language_id='".$_SESSION['language_id']."' "  ;
				$ptr_exams_sec=mysql_query($sel_exam);
				$data_exam_section=mysql_fetch_array($ptr_exams_sec);
				$select_paper_id = " select distinct(papers_id) as paper_id  from `exams_section` where exams_id='".$data_ex['exams_id']."' ";
				$ptr_s = mysql_query($select_paper_id);
				$data_exs = mysql_fetch_array($ptr_s);				
				$totla_qus=$data_ex['total_ques'];
				$paper_time =$total_time=$data_ex['exam_duration'];
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
$_SESSION['user_id']= $_SESSION['student_id'];
if($_GET['action']=='end_exam')

{
	$student_id=$_SESSION['user_id'];
	$paper_id	=	$_GET['exam_id'];	
	$query_for_time_lasts = " select * from  student_paper_time where paper_id='$paper_id' and  student_id='".$_SESSION['user_id']."'  " ;
					$ptr_for_times_lastess= mysql_query($query_for_time_lasts);
					if(mysql_num_rows($ptr_for_times_lastess)!=0)
					{
						while($data_time_lastess = mysql_fetch_array($ptr_for_times_lastess))
						{
							$end_times_lasatsd += $data_time_lastess['end_time'];
						}
					}

						
	$end_times_lasatsd= $paper_time*60*60;
	
    $end_exam = " update student_paper_time set  end_time = '$end_times_lasatsd' where paper_id='$paper_id' and  student_id='".$_SESSION['user_id']."' and  date='".date('Y-m-d')."' ";
	$ptrs_update = mysql_query($end_exam);
	
	$update_stud="update stud_login set status='inactive' where stud_login_id='".$_SESSION['student_id']."'";
	$ptr_up_stud=mysql_query($update_stud);
	session_destroy();
	
	?>
							<script language="javascript">
						
							document.location.href="thank_you.php?paper_id=<?php echo $paper_id ?>"
							
							</script>
<?php }
?>
<script>
/*function logout()
{
	
<?php //session_destroy(); ?>
document.location.href="student_login.php";
}*/
</script>
</head>
<body>
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
		<td width="7"><img src="images/left_top.gif" width="7" /></td>
		<td style="background:repeat-x url(images/mid_top.gif);color:#FFF" width="100%" class="headding"  ><b>Test Details</b></td>
		<td><img src="images/right_top.gif" /></td>
		</tr>
<tr>

<tr>

<td colspan="3" align="right"><a href="index.php?action=<?php echo base64_encode('logout'); ?>" style="text-decoration:none" onclick="return confirm('Are you sure want to Exit ?')" ><input type="submit" class="input_btn" name="start_exam" value="Exit" style="width:70px; height:30px;font-size:14px;  margin-left:10px; background-color:#F00"   /></a></td>

</tr>
<td style="background:repeat-y url(images/mid_left.gif)" width="7"></td>
<td valign="top" align="center">

				<table cellpadding="5" cellspacing="5" width="90%" align="center">
				<tr>
				<td width="35%" valign="top" align="center">
				
				 <input type="hidden"  id="exam_id" value="<?php echo $exam_id; ?>" />
					<table cellpadding="1" cellspacing="1" align="center" width="100%" >
                    <tr>
					<td valign="top" class="test_2" style="color:#0066cc"><b>Student Name</b></td>
					<td valign="top" class="test"  style="color:#0066cc"><?php echo $_SESSION['name']; ?></td>
					</tr>
					<tr>
					<td valign="top" class="test_2" style="color:#0066cc"><b>Exam No</b></td>
					<td valign="top" class="test"  style="color:#0066cc"><?php echo $data_ex['exam_number']; ?></td>
                    <input type="hidden" name="exam_no" id="exam_no" value="<?php echo $data_ex['exam_number']; ?>"  />
					</tr>
					<tr>
					<td valign="top" class="test_2"  style="color:#0066cc"><b>No of Questions</b></td>
					<td valign="top" class="test"  style="color:#0066cc"><?php echo $data_exam_section['total_ques']; ?>
					
					<input id='total_questions_of_paper' type="hidden" value="<?php echo $data_exam_section['total_ques'];?>" />
					</td>
					</tr>
					<tr>
					<td valign="top" class="test_2"  style="color:#0066cc"><b>Total Marks</b></td>
					<td valign="top" class="test"  style="color:#0066cc"><?php echo $data_ex['exam_mark']; ?></td>
					</tr>
					<tr>
					<td valign="top" class="test_2"  style="color:#0066cc"><b>Time (In Minutes)</b></td>
					<td valign="top" class="test"  style="color:#0066cc"><?php echo  $data_ex['exam_duration']; ?></td>
					</tr>
					</table>
					<?php

					$end_time=0;

					$today_end_time=0;

					$query_for_time = " select * from  student_paper_time where paper_id='$paper_id' and  student_id='".$_SESSION['user_id']."' " ;

					$ptr_for_times= mysql_query($query_for_time);

					if(mysql_num_rows($ptr_for_times)!=0)

					{

						while($data_time = mysql_fetch_array($ptr_for_times))

						{

							$end_time += $data_time['end_time'];

						}

						if($end_time >= ($paper_time*60*60))

						{

							?>

							<script language="javascript">

							alert("You are already attend this test..!");

							//document.location.href="exam_scor.php?paper_id=<?php echo $paper_id ?>"

							

							</script>

							<?php

						}

						else

						{

						

						$query_for_todays_time = " select * from  student_paper_time where paper_id='$paper_id' and  student_id='".$_SESSION['user_id']."' " ;

												   

							$ptr_for_todays_times= mysql_query($query_for_todays_time);

							if(mysql_num_rows($ptr_for_todays_times)!=0)

							{

								//$data_todays_time = mysql_fetch_array($ptr_for_times);

								

								//$today_end_time = $data_todays_time['end_time'];

							}

							else

							{

						   		$insert_time = " insert into student_paper_time values(0,'".$_SESSION['user_id']."','$paper_id','".date('Y-m-d H:i:s')."','','".date('Y-m-d')."') ";

								$ptrs_insert_time = mysql_query($insert_time);

							}

						}

						

						

						

					}

					else

					{

						

					  $insert_time = " insert into student_paper_time values(0,'".$_SESSION['user_id']."','$paper_id','0','','','".date('Y-m-d')."') ";

						$ptrs_insert_time = mysql_query($insert_time);

					}
					?>

					

					
					
					<input type="hidden" id="total_time" value="<?php echo  ($paper_time*60); ?>" />
					<input type="hidden" id="time_complete" value="<?php echo $end_time; ?>" />
					<input type="hidden" id="todays_time" value="0" />
					<script type="text/javascript">
    var intval=""
    var total_time = <?php echo ($paper_time); ?>;
	var copmos =  Math.floor(parseInt(document.getElementById('time_complete').value)/60);
	alert(total_time+":min Is Total Time \n"+copmos+" min Completed");
        if(intval==""){
          intval=window.setInterval("start_clock()",1000)
      }else{
          stop_Int()
      }
   
    function stop_Int(){
        if(intval!=""){
          window.clearInterval(intval)
          intval=""
         // document.getElementById('myTimer').innerHTML="Interval Stopped"
      }
    }

    function start_clock()
	{
		var total_time =  parseInt(document.getElementById('total_time').value);
		var spend_time =  parseInt(document.getElementById('time_complete').value);
		var compl= spend_time + 1;
		//alert(spend_time);
		var times = total_time -  compl;
		if(times<=0)
		{
			//alert('Time Complete');
			location.href='thank_you.php?close_exam=yes&student_id=<?php echo base64_encode($_SESSION['student_id']) ?>';
			
			
		}
		//alert(compl);
		//document.getElementById('total_time').value= times;
		var todays_total_time =  parseInt(document.getElementById('todays_time').value);
		 this.todays = todays_total_time + 1;
		
		document.getElementById('todays_time').value= todays;
		 //alert(document.getElementById('todays_time').value);
		var sec= times %60;
		minute = Math.floor(times /60);
		mins= minute;
		
		var spents = compl%60;
		min_spwnt =   Math.floor(compl/60);
		document.getElementById('time_complete').value= compl;
		
        document.getElementById('myTimer').innerHTML=mins+" : "+ sec ;
		document.getElementById('spended').innerHTML=min_spwnt+" : "+ spents ;
		
		
    }
</script>
				</td>
				<td width="78%">
				<table cellpadding="0" cellspacing="0" width="100%" align="right" style="border:1px solid #F4F4F4">
				<tr>
							<td colspan="3" height="10"></td>
							</tr>
							
							
							
							
							<tr align="center">
							<td class="text"  style="color:#0066cc"><b>Time Complete:</b></td>
							<td></td>
							<td><span id="spended" style="color:#0066cc"></span></td>
							</tr>
							<tr>
							<td colspan="3" height="5"></td>
							</tr>
							<tr>
							<td  class="test_2" align="center" height="25" bgcolor="#F4F4F4"  style="color:#0066cc"><b>Time Left:</b></td>
                            <td bgcolor="#F4F4F4"></td>
							<td align="center" bgcolor="#F4F4F4"> <span id="myTimer" style="color:#0066cc"></span></td>
							</tr>
						</table>
				
				</td>
				</tr>
                <tr><td colspan="2"><hr style="color:#0066cc"></td></tr>
                
			<tr>
            
			<td valign="top" colspan="3" align="center">
			<form name="question_from" >
			<div id="question_div">
			<?php
			$option_array = array();
			
			$y=1;
			 /*	$select_last_question = " select * from student_paper where student_id='".$_SESSION['user_id']."' and paper_id='$paper_id' order by attempt_id desc limit 0,1  ";
				$ptr_last_qust = mysql_query($select_last_question);
				if(mysql_num_rows($ptr_last_qust))
				{
				$data_last_que = mysql_fetch_array($ptr_last_qust);
				$select_option="select * from options where (answer='y' and question_id=".$data_last_que['question_id'].")";
				$ptr_ans=mysql_query($select_option);
				$data_ans=mysql_fetch_array($ptr_ans);
				
				"<br />".$question_id= $data_last_que['question_id'];
				
				$answer_option= $data_ans['option_id'];
				$select_question_last = " select question_title from question where question_id='$question_id'" ;
				$ptrs_last_que = mysql_query($select_question_last) ;
				$i=0 ;
				if(mysql_num_rows($ptrs_last_que))
				{
					echo "<input type='hidden' name='current_question' id='current_questions' value='".$question_id."' >";
				while($data_ptr_last_que = mysql_fetch_array($ptrs_last_que))
				{
					$question_title = $data_ptr_last_que['question_title'];
				}
				$select_option_lastt = " select * from options where (answer='y' and question_id=".$data_last_que['question_id'].")";
				$ptrs_option_last = mysql_query($select_option_lastt);
				$data_last_ans= mysql_fetch_array($ptrs_option_last);
				//echo $question_id;
			 "<br />".$select_question_no = " select question_id from question where unit_id='".$data_ex['unit_id']."' ";
				$ptrs_count_no = mysql_query($select_question_no);
				$x=1;
				while($data=mysql_fetch_array($ptrs_count_no))
				{
					if($question_id==$data['question_id'])
					{
						 $y=$x;
						break;
					}
					$x++;
				}
				
			}
			}
			else
			{*/
  $que_array = $_SESSION['que_array'];

  

 // echo print_r($que_array);

				 $sel_ex_ques="select question_id,unit_id from exams_section where question_id ='".$que_array[0]."' and exams_id='".$_GET['exam_id']."' ";
				$ptr_ex=mysql_query($sel_ex_ques);
				$data_ex_ques=mysql_fetch_array($ptr_ex);
				$curr_unit_id=$data_ex_ques['unit_id'];
				$select_question_first = " select question_title,question_id,question_img from question where question_id='".$data_ex_ques['question_id']."' order by question_id asc limit 0,1  " ;
				$ptrs_first_que = mysql_query($select_question_first) ;
				$i=0 ;
				$data_ptr_last_que = mysql_fetch_array($ptrs_first_que);
				
					$question_id = $data_ptr_last_que['question_id'];
					$question_title = $data_ptr_last_que['question_title'];
					$question_img= $data_ptr_last_que['question_img'];
					echo "<input type='hidden' name='current_question' id='current_questions' value='".$question_id."' >";
			//}		
					echo "<input type='hidden' name='current_unit' id='current_unit' value='".$curr_unit_id."' >";
			

			?>
			
			<table cellpadding="0" cellspacing="0" width="100%" align="center">
				<!--<tr>
				<td valign="top" colspan="3" class="test_2" height="25" bgcolor="#F4F4F4" style="color:#0066cc">
				Question <?=$y ?> of <?=$totla_qus;?> </td>
				</tr>-->
				<tr>
				<td valign="top" colspan="3" >
				<!-- Question Start-->
					
					<table cellpadding="3" cellspacing="3" class="text">
					<tr>
					<td class="test" colspan="3" style="color:#0066cc;"><b><span style=" font-size:18px;"><?=$y ?>) <?php echo stripslashes($question_title);?> <?php if($question_img !=''){ ?> <img src="../onlinemcq/question_photo/<?php echo $question_img; ?>" style="width: 150;height: 100" /><?php }?></span></b></td>
					</tr>
					<?php 

					$option_arrays = $_SESSION['option_array'];

					//echo print_r($option_arrays[0]);

						 $given_answer_option ='';
						  $select_answer_gived = " select answer_option from student_paper where student_id='".$_SESSION['student_id']."' and question_id='".$question_id."' ";
						 $ptr_given_ans= mysql_query($select_answer_gived);	
						 if(mysql_num_rows($ptr_given_ans))	
						 {
							$given_ans = mysql_fetch_array($ptr_given_ans);
						  $given_answer_option =$given_ans['answer_option'];
							
						 }	

					

					for($i=0;$i<4;$i++)

					{

					 $select_option_last = " select * from options where option_id='".$option_arrays[0][$i]."' ";
					$ptrs_option = mysql_query($select_option_last);
					

						

					$data_opt = mysql_fetch_array($ptrs_option);
					
						
					?>
					<tr>
					<td width="15" align="center">&nbsp;</td>
					<td width="25"><input type="radio" name="ans" onclick="save_answer_only();"   value="<?php echo $option_arrays[0][$i]; ?>" <?php if( $given_answer_option==$option_arrays[0][$i]) echo "checked='checked'" ;?> /></td>
					<td width="551" class="text" style="color:#0066cc"> <?=$data_opt['option_title']?> </td>
					</tr>
					<?php  }?>
                    
                    
					</table>
					
					
				<!-- Question End-->
				
				
				</td>
				</tr>
			</table>
			</div>
			</form>
			<div id="textdis"></div>
			

<!--

			<form name="answer_sheet_form" method="post">
			<div id="A_sheet" style="display:none; left: 55%; top: 150px;">
<table cellpadding="0" cellspacing="0" align="center" >
<tr>
<td colspan="3"></td>
<td></td>
</tr>
		<tr>
		<td width="7"><img src="images/left_top.gif" width="7" /></td>
		<td style="background:repeat-x url(images/mid_top.gif);" class="headding"><div style="float:left; width:120px;"></div><div style="float:left; width:25px;"><a href="#" onclick="document.getElementById('A_sheet').style.display='none';" ><img src="images/delete.gif" border="0"  /></a></div></td>
		<td><img src="images/right_top.gif" /></td>
		
		</tr>
		<tr>
		<td style="background:repeat-y url(images/mid_left.gif)"></td>
		<td valign="top" bgcolor="#ffffff">
			<div id="answer_sheet_div" style="overflow-y:scroll; height:150px;">
			
			
			<table cellpadding="3" cellspacing="3" bgcolor="#ffffff">
			<?php

/*

			$sel_exam_ques="select question_id from exams_section where exams_id='".$_GET['exam_id']."' order by question_id asc ";
			$ptr_exam_ques=mysql_query($sel_exam_ques);
			$question_counter=1;
			echo "<input type='hidden' id='total_questions_of_test' name='total_questions_of_test' value='".mysql_num_rows($ptr_exam_ques)."' >";
			while($data_exam_ques=mysql_fetch_array($ptr_exam_ques))
			{	
				$query_for_answer_sheet_option=" select question_id from question where question_id='".$data_exam_ques['question_id']."' ";
				$ptr_answer_sheet = mysql_query($query_for_answer_sheet_option);
				$sheet_data=mysql_fetch_array($ptr_answer_sheet);
				
					?>
					<tr>
					<td class="test_2"><?php echo  $question_counter ?></td>
					<?php 
					$sheet_question_id=$data_exam_ques['question_id'];
					echo "<input type='hidden' name='question_$question_counter' id='question_$question_counter' value='$sheet_question_id'>";
					
					echo $select_option_all = " select * from options where  question_id='".$sheet_question_id."' ";
					$ptrs_option_she = mysql_query($select_option_all);
					$option_no=1;
					
					echo "<input type='hidden' id='total_option_of_$question_counter' value='".mysql_num_rows($ptrs_option_she)."' >";
					while($option_data_sheet = mysql_fetch_array($ptrs_option_she))
					{
				
					// $option_data_sheet['option_id'];
					 //$option_data_sheet['option_title'];
					 $given_answer_option ='';
					echo $select_answer_gived = " select answer_option from student_paper where student_id='".$_SESSION['student_id']."' and question_id='".$sheet_question_id."' ";
					 $ptr_given_ans= mysql_query($select_answer_gived);	
					 if(mysql_num_rows($ptr_given_ans))	
					 {
					 	$given_ans = mysql_fetch_array($ptr_given_ans);
						$given_answer_option =$given_ans['answer_option'];
						
					 }					
					 ?>
					<td><input type="radio" id="answer_sheet_<?php echo $question_counter; ?>_<?php echo $option_no; ?>" name="answer_sheet_<?php echo $question_counter; ?>" value="<?php echo $sheet_question_id."_".$option_data_sheet['option_id']; ?>" 
					 <?php if( $given_answer_option==$option_data_sheet['opt_ids']) echo "checked='checked'" ;?>  /></td>
				<?php
					$option_no++;
				}
				?>
				</tr>
				<?php
				
				$question_counter++;
			
		}
*/			?>
			
			
			</table>
			
			</div>
			
			
		</td>
		<td style="background:repeat-y url(images/mid_right.gif)"></td>
		</tr>
		
		<tr><td style="background:repeat-y url(images/mid_left.gif)"></td><td align="center" ><a href="#" onclick="save_sheet(<?php echo $paper_id ?>)"><img name="save"src="images/save.gif" border="0" /></a></td><td style="background:repeat-y url(images/mid_right.gif)"></td></tr>
		<tr>
		<td><img src="images/left_botton.gif" /></td>
		<td style="background:repeat-x url(images/mid_bottom.gif)"></td>
		<td><img src="images/right_bottom.gif" /></td>
		</tr>
		</table>
		</div>
		</form>

-->

			</td>
			</tr>
				<tr>
				
				<script language="javascript">
				function clears()
				{
					document.question_from.reset();
				}
				</script>
				<td valign="top" colspan="3" class="test_2" height="25" bgcolor="#F4F4F4" align="center">
						
						<div style="float:left; width:100px;"><input type="button" title="Previous"  id="toggle" name="back" class="previous" onclick="back_question();" style="cursor:pointer" /></div>
						
						<!--<div  style="float:left; width:80px;"><img   src="images/reset_b.gif" onclick="clears();"  style="cursor:pointer"/></div>-->
						
						<div style="float:left; width:150px; color:#0066cc">Move To :<select id="question_id" name="question_id" onchange="show_question('<?php echo $data_ex['unit_id']; ?>',this.value);" style="width:100px;">
						<option value="">Question</option>
						<?php
                        for($i=0;$i<count($que_array);$i++)

						{	

                              $d=$i+1;  

                                if( $que_array[0]==$que_array[$i])

                                echo "<option value='".$que_array[$i]."' selected='selected'>Q No.".$d /*$data_ptr_last_quess['question_title']*/."</option>";

                                else

                                echo "<option value='".$que_array[$i]."'>Q No.".$d /*$data_ptr_last_quess['question_title']*/."</option>";

                        }

                        ?>			</select>			<script language="javascript">
			document.getElementById('toggle').style.visibility = 'hidden';
			function save_answer_only()
			{

				 this.que=document.getElementById('question_id').selectedIndex;
				 this.total_questions_of_paper =document.getElementById('total_questions_of_paper').value;					
				 save_('<?php echo $paper_id; ?>',que);
			}
			function next_question()
			{	 this.que=document.getElementById('question_id').selectedIndex;
				 this.total_questions_of_paper =document.getElementById('total_questions_of_paper').value;
				//alert(total_questions_of_paper);
				 next_que=que+1;
				// alert(next_que);
				 last_question=total_questions_of_paper;
				 //alert(last_question);
				 if(next_que==0) 
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
				 }
				 
				 
				 if(que !=0)
				 {
					// alert(total_questions_of_paper);
				
				 if(next_que <= total_questions_of_paper);
				 { //alert(document.getElementById('question_id').options[next_que].value);
				 	this.queselected_que=document.getElementById('question_id').options[next_que].value;
					document.getElementById('question_id').selectedIndex=next_que;
					//alert(queselected_que);
					show_question('<?php echo $paper_id; ?>',queselected_que);
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
					show_question('<?php echo $paper_id; ?>',queselected_que);
					
                    }
				 }
			
			}
			
			</script>
			</div>

<div  style="float:left; width:100px;"><input type="button" title="Next"  name="next" id="next" class="next" onclick="next_question();"  style="cursor:pointer" /></div>

            <!--<div style="float:left; width:130px;"><a href="#" onclick="javascript: show(1),show_answer_sheet(<?php //echo $_GET['exam_id']; ?>);" class="link1" id="1a" style="text-decoration:none"><input type="button" name="answer_shit" value="Review Answer" class="input_btn" onclick="javascript: show(1),show_answer_sheet(<?php //echo $data_ex['unit_id']; ?>);"  /></a></div>-->
            <div style="width:200px;" >
           
            <input type="button" name="end_test" title="Save and Exit"  onclick="return is_remain();"  class="save"  />
            </a></div>
            <script language="javascript">
			function is_remain()
			{
				yes_no =document.getElementById('rem').value;
				//alert(yes_no);
				if(yes_no=='yes')
				{
					if(confirm('There are not attended questions. Are you sure want to submit incomplete answer paper ?'))
					{
						document.location.href="questions_show.php?action=end_exam&amp;paper_id=<?php echo $_GET['exam_id']; ?>";
					}
					else
					return false;
				}
				 if( confirm('Are you sure want to submit answer paper?'))
				 {
					 document.location.href="questions_show.php?action=end_exam&amp;paper_id=<?php echo $_GET['exam_id']; ?>";
				 }
				 else
					return false;
				 				
			}
			 /*<a href="questions_show.php?action=end_exam&amp;paper_id=<?php echo $_GET['exam_id']; ?>" style="text-decoration:none" onclick="return confirm('Are you sure want to submit answer paper?')">*/
			</script>
			
				</td>
				
		</tr>
			
		</table>

</td>
</tr>
</table>

<!-- Middle End-->

<br />
<table width="95%">
<tr>
<td width="80%">
<script language="javascript">
function set_select(vals)
{
	$("#question_id").val(vals);
	show_question( <?php echo $data_ex['unit_id']; ?>,vals);

}
function check_remaining()
{
	$("#pending_question_list").html('<img src="images/loading-circle.gif" align="center">')
	$.ajax({url: "remaining_question.php?exam_id=<?php echo $_GET['exam_id']; ?>", success: function(result){
        $("#pending_question_list").html(result);
    }});

	
}

</script>
<div id="pending_question_list"><?php
echo "Que Not Attempted : ";
  $select_done = " select question_id from student_paper where exam_id ='".$_GET['exam_id']."' and  student_id='".$_SESSION['user_id']."' ";
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
	foreach($result as $x => $x_value) {
    
	echo "<span class='qs_s' onclick=\"set_select($x_value);\">".($x+1)."</span> |";
	$rem='yes';
}
	
}
else
{
	for($j=0;$j<count($que_array);$j++)
	{
		echo "<span class='qs_s' onclick=\"set_select($que_array[$j]);\">".($j+1)."</span> |";//show_question( ".$data_ex['unit_id'].",$que_array[$j])
		$rem='yes';
	}
}

if($rem=='yes')
{ echo "<input type='hidden' name='rem' value='yes' id='rem'>";  }
else
{
	echo "<input type='hidden' name='rem' value='no' id='rem'>";
}
 ?>
</div>
</td>
<td align="right">

<table align="right"><tr><td><div id="container"><div  style="width:300px; float:right"><video autoplay="true" id="videoElement"></video></div></div></td></tr></table>
</td></tr></table>
<!--<script>var video = document.querySelector("#videoElement");navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;if (navigator.getUserMedia) {navigator.getUserMedia({video: true}, handleVideo, videoError);}
function handleVideo(stream){video.src = window.URL.createObjectURL(stream);}function videoError(){alert("Need Web Camera to give exam");
  document.location.href='error.php'}</script>-->
</body></html>