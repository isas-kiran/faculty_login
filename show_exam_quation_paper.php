<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php session_start();
	require("include/config.php");
	
	if($_SESSION['user_name']=="")
	{
		?>
			<!--<script language="javascript">
			window.location='login.php';
			</script>-->
		<?
	}
	$msg="";
	if(isset($_GET['msg']) && $_GET['msg']!=="")
	{
		$msg=$_GET['msg'];
	}
	//=======Delete Profile=========/// 
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
   <style>
body{ font-size:12px !important; color:#333333 !important; margin:0px !important; background-color: #}


.inputSelect{background-color: #b7edfb !important;
    border: 1px none !important;
    border-radius: 5px !important;
    color: #666666 !important;
    padding: 3px !important;
    width: 100% !important;}
</style>
<script language="javascript">
	function valid()
	{
		if(document.frm_site.name.value=="")
		{
			alert("Please Enter Site Name!");
			document.frm_site.name.focus();
			return false;
		}
		if(document.frm_site.user.value=="")
		{
			alert("Please Enter Username!");
			document.frm_site.user.focus();
			return false;
		}
		if(document.frm_site.pass.value=="")
		{
			alert("Please Enter Password!");
			document.frm_site.pass.focus();
			return false;
		}
		if((document.frm_site.email.value.indexOf('@') < 0) || (document.frm_site.email.value.indexOf('.') < 0))
		{
			alert("Please Enter Valid Email-ID!");
			document.frm_site.email.focus();
			return false;
		}
		if((document.frm_site.contact.value.indexOf('@') < 0) || (document.frm_site.contact.value.indexOf('.') < 0))		
		{
			alert("Please Enter Valid Contact Email-ID!");
			document.frm_site.contact.focus();
			return false;
		}
		if(document.frm_site.url1.value.indexOf('.') < 0 )
		{
			alert("Please Enter Site URL!");
			document.frm_site.url1.focus();
			return false;
		}
	}
	
	
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
</script>

<script type="text/javascript">        
        function submitAction(action)
        {
            var chks = document.getElementsByName('chkRecords[]');
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
            }
            
            document.getElementById('formAction').value=action;
            if(action=="delete")
            {
                if(confirm("Are you sure, you want to delete selected records?"))
                    document.frmTakeAction.submit();
                else
                {
                    $('#selAction').val('');
                    return false;
                }
            }
            else
                document.frmTakeAction.submit();
        }
        function redirect1(value,value1)
        {
            window.location.href=value+value1;
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
                    {}
                    if($success==0)
                    {
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data">
	<table width="100%"  style="border:1px solid #000">
<tr align="center"><td><?php
                    if($_POST['formAction'])
                    {
                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $del_record_id=$_POST['chkRecords'][$r];
								

                                $sql_record= "SELECT question_id FROM quation_add_to_paper where question_id='".$del_record_id."'";
								$ptr_sql=mysql_query($sql_record);
                                if(mysql_num_rows($ptr_sql))
                                {
                                $delete_record='delete from quation_add_to_paper WHERE question_id = "'.$del_record_id.'"';
                                $db->query($delete_record);
								
								}
                                }
                            ?><div id="msgbox" style="width: 30%;">Selected Quation records are deleted successfully</div>              <?php
                        }
                   }
                    if($_REQUEST['changeStatus'] && $_REQUEST['value'])
                    {
                        $update_query1="update ".$GLOBALS["pre_db"]."transaction set status='".$_REQUEST['value']."' where transaction_id='".$_REQUEST['changeStatus']."'";
                        //echo $update_query1;
                        $db->query($update_query1);
                        ?>
                        <div id="statusChangesDiv" title="Status Changed"><center><br/><p>Status changed successfully</p></center></div>
                        <script type="text/javascript">
                            $("#statusChangesDiv").dialog();
                        </script>
                        <?php
                    }
                    ?></td></tr>

  <input type="hidden" name="formAction" id="formAction" value=""/>
<tr>
<td>
<?php 
 $record_id=$_GET['paper_id'];
?>
<? 
   $select_quationpapaer="select * from paper  where paper_id='".$record_id."'";
   $ptr_quation_paper=mysql_query($select_quationpapaer);
  
  	   while($val_quation=mysql_fetch_array($ptr_quation_paper))
	   {
		  $val_quation['question_title'];
		  
		 $exam_id=$val_quation['exam_id'];
		 $subject_id=$val_quation['subject_id'];
		  
		$selec_class_name="select * from exam where exam_id='".$exam_id."' ";
		$ptr_class_name=mysql_query($selec_class_name);
		$val_class_name=mysql_fetch_array($ptr_class_name);
		$exam_name=$val_class_name['exam_name'];
	
		$selec_subject_name="select * from  subject where subject_id='".$subject_id."' ";
		$ptr_subject_name=mysql_query($selec_subject_name);
		$val_subject_name=mysql_fetch_array($ptr_subject_name);
		$subject_name=$val_subject_name['name'];
		
		  
	    ?> 
<table width="100%" height="127"  align="center"  style="border:1px solid #000;background-color:#FFF !important;" >
<tr>
<td width="20%" style="text-align:right;">
<b>Class Name:</b> <? echo $class_name ?>
</td>
<td align="center">
<b>Exam Name:</b><? echo ucwords($exam_name);?>
</td>
<td width="20%"><b>Time:</b></td>
</tr>
<tr>
<td align="left"  style="text-align:right">
<b>Division Name:</b> <? echo $division_name ?>
</td>
<td align="center">
<b>Subject Name: </b><? echo $subject_name ?>

</td>
<td><b>Total Marks:</b> <?php echo $marks; ?></td>
</tr>
</table>


</td>
</tr>
<tr>
<td>
</td>
</tr>
<tr>
<td>
<table width="100%" align="center" style="border:1px solid #000;background-color:#FFF !important; background-position: center top !important; background-repeat: no-repeat !important;">

<tr>
<td width="2%" class="th_blue_bold1">
</td><td></td>
<td style="text-align:right" colspan="2">   
<a href="manage_paper.php" style="text-decoration:none"><input type="button" name="back" value="Back"/></a> <a href="show_ans_sheet_paper.php?paper_id=<? echo $record_id;?>" style="text-decoration:none"> <input type="button" name="answer_sheet" value="Answer Sheet"/></a></td>
<td>
                          <select name="selAction" id="selAction" class="inputSelect" 
                          onChange="Javascript:submitAction(this.value);">
                          <option value="">-Operation-</option>
                          <option value="delete">Delete</option>
                          </select></td>
                          <td  class="th_blue_bold1" align="center"></td>
</tr>



<tr style="background-color:#CCC">
<td width="2%" class="th_blue_bold1">
<input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td><td></td>
<td style="text-align:center">Questions</td>
<td>Answers</td>
<td  class="th_blue_bold1" align="center">Action</td>
</tr>

 <? 
      
	      /*$selec_subject_nam="SELECT question.question_id, options.question_id, question.subject_id,question.question_title,
	      question.mark FROM question, options WHERE question.subject_id = '".$record_id."' AND 
		  question.question_id = options.question_id";
		  
	  	$ptr_subject_name=mysql_query($selec_subject_nam);*/
		
	  // mysql_num_rows($ptr_subject_name);
	  
	   $selec_subject_name="select * from  quation_add_to_paper where  `paper_id`='".$record_id."'";
		
	  	$ptr_subject_name=mysql_query($selec_subject_name);
		$i=1;
		while($val_subject_name=mysql_fetch_array($ptr_subject_name))
		{
			
		$quation_id=$val_subject_name['question_id'];
		$listed_record_id=$val_subject_name['question_id'];
		
 ?>
	    
        <tr valign="middle">
        <td ><input type="checkbox" name="chkRecords[]" value= "<?php echo $listed_record_id; ?>" /></td>
		<td width="2%" height="65"> <? echo $i; ?>)</td>
        <? 
		$select_quation_name="select * from question where question_id='".$quation_id."'";
		$ptr_quation_name=mysql_query($select_quation_name);
		$val_quation_name=mysql_fetch_array($ptr_quation_name);
		$subject_name=$val_quation_name['question_title'];
		$marks=$val_quation_name['mark'];
		
		?>
	 	<td width="80%"><b><? echo ucfirst($subject_name); echo  '<br>'; echo '<hr >'; ?></b>
        </td>
        <td width="7%" style="text-align:center"><? echo "Marks: ".$marks; ?></td>
         <?
		echo '<td width="10%" align="center">
<a href="create_question.php?record_id='.$listed_record_id.'&subject_id='.$_GET['subject_id'].'&topic_id='.$_GET['topic_id'].'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&subject_id='.$_GET['subject_id'].'&topic_id='.$_GET['topic_id'].'">
<img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;                    
 </td>';
		?>
        </tr>
        <tr>
        <td></td>
        <td></td>
        <td>
        <table width="100%">
        <tr>
        <?
          $selec_subject_nam="SELECT question.question_id, options.question_id,options.option_title,options.answer
		  FROM question, options WHERE question.question_id = '".$quation_id."' AND 
		  question.question_id = options.question_id";
		  $ptr_subject=mysql_query($selec_subject_nam);
		  $j=1;
		 while( $val_option=mysql_fetch_array($ptr_subject))
		 {
		  $option_title=$val_option['option_title'];
		  $ans=$val_option['answer'];
		  ?>
        
        <td></td>
        <td width="2%"><?php echo $j; ?>)</td>
       <td align="left" ><?php echo $option_title; ?></td>
       
       <td><input type="radio" <?php if ($ans=='y') echo 'checked=checked'?> /></td>
		
         <? $j++; } ?>	
         
         </table>
         </td>
         <td></td>
         <td></td>
    	</tr>
		<? $i++ ;}?>
<?  } ?>
</table>

</td>
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