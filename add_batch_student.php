<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
echo date('m/d/Y H:i:s', 1541843467); 
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM course_batch_mapping where c_b_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Student For Batch</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
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
<!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
<link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
<script src="js/development-bundle/ui/jquery.ui.core.js"></script>
<script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>

<script>
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
	$(":checkbox[value='"+seprates[1]+"']").attr("checked", false);  
}
no=0;
function select_me(ids)
{
	//alert(ids);
	total_count='';
	divId="selected"+ids;
	//no= parseInt(no + 1);
	seps=ids.split("qs");
	sep = (document.getElementById(ids).innerHTML).split('<?php
	$strs = explode('Firefox',$_SERVER['HTTP_USER_AGENT']);if($strs[1]){echo '<input type="hidden" name="split">';}else{ echo '<input type="hidden" name="split">';} 
	?>');
	new_id="<input type='hidden' name='new_selected[]' id='new_selected' value='"+seps[1]+"'>";
	var selected_course_id= document.getElementById("selected_units"+seps[1]).value;
	var selected_enroll_id= document.getElementById("selected_enroll"+seps[1]).value;
	img = '<img src="images/delete.gif" height="20" width="20" onclick="hideSelected('+ids+')" id="'+ids+'">';
	if($('input[value='+seps[1]+']').attr('checked', false))		
	{
		if(document.getElementById(ids))
			document.getElementById(ids).style.display="none";
	}
	//alert(sep[1]);
	var quest=sep[1].split("-");
	var course_name=quest[1];
	var name=quest[0];
	document.getElementById('selected_questions').innerHTML=document.getElementById('selected_questions').innerHTML+'<div id="'+divId+'" style="clear: both;"><table width="100%" style="border:solid 1px #DDDDDD;border-collapse: collapse; margin:0; padding:0;" border="1"><tr><td align="center" width="10%">'+selected_enroll_id+'</td><td width="40%" align="center">'+name+'.</td><td width="40%" align="left">'+course_name+'</td><td width="9%" align="center">'+img+sep[2]+'</td></tr></table>'+new_id+'</div>';
	
	//alert(question_title);
	//alert(selected_unit_name);
	
	total_count = document.getElementsByName("new_selected[]").length;
	if(total_count)
	document.getElementById("total_count").innerHTML=total_count;
	document.getElementById("total_ques_cnt").value=total_count;
}

function searchQuestion()
{
	question_val='';
	var searchques= document.getElementById("search_id").value;
	var searchkeyword= document.getElementById("keyword").value;
	var keyword='';
	if(searchques !='' && searchkeyword!='')
	{
		
		if(searchques=="question_no")
		{
			var keyword="&enroll_id="+searchkeyword;	
		}
		else if(searchques=="ques_title")
		{
			var keyword="&name="+searchkeyword;	
		}
		else
		{
			var keyword="&keyword=''";
		}
		var data1=keyword;	
		$.ajax({
		url: "show_student.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			document.getElementById('show_search_result').innerHTML =html;	
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
		alert(fav_count);
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

	//var language_id=document.getElementById('language_id').value;
	que_div = 'quest_sel_'+ids;
	
	var searchques= document.getElementById("search_id").value;
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
	
	//question_vals="&question_vals="+question_val;
	if(document.getElementById(is).checked)
    {
		contact= document.getElementById(is).value;
 	   var data1="course_id="+contact+"&record_id="+record_id+"&enroll_no="+enroll_no+keywod;
		//var data1=keyword;	   
	   	alert(data1);
        $.ajax({
            url: "show_student.php", type: "post", data: data1, cache: false,
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
function validme()
{
	frm = document.jqueryForm;
	error='';
	disp_error = 'Clear The Following Errors : \n\n';
	if(frm.total_ques_cnt.value=='')
	{
		disp_error +='Please select at least one Student\n';
		document.getElementById('total_ques_cnt').style.border = '1px solid #f00';
		error='yes';
	}
	
	if(error=='yes')
	{
		alert(disp_error);
		return false;
	}
	else
	{ 
		return send();
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
    <td width="988" valign="bottom" class="top_mid"><?php include "include/course_menu.php"; ?></td>
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
            				
            if(count($errors))
            {
                ?>
                <tr><td> <br></br>
                <table align="left" style="text-align:left;" class="alert">
                    <tr><td><strong>Please correct the following errors</strong><ul>
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
                $total_ques=count($_POST['new_selected']);
                for($h=0;$h<$total_ques;$h++)
                {
                    $p = $_POST['new_selected'][$h];				
                    $data_record_type1['c_b_id'] =$row_record['c_b_id'];
					$data_record_type1['batch_id'] =$row_record['batch_name'];
                    $data_record_type1['enroll_id'] =$_POST['new_selected'][$h];
                    $data_record_type1['student_course_id'] =$_POST['course_id'][$h];
					$data_record_type1['course_id'] =$row_record['course_id'];
                    $data_record_type1['admin_id'] =$row_record['admin_id'];
					$data_record_type1['cm_id'] =$row_record['cm_id'];
                    $data_record_type1['added_date'] =date('Y-m-d');
                    
                    $record_ids=$db->query_insert("student_course_batch_map", $data_record_type1);
                    $exams_id=mysql_insert_id(); 
                }
					
                $insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `admin_id`) VALUES ('add_batch_student','Add','".$exams_id."','".$row_record['c_b_id']."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."')";
                $query=mysql_query($insert);
                echo ' Record added successfully';  
            }
        }

        if($success==0)
        {
	    	?>
	        <tr><td>
    		<form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data" onSubmit="return validme()">
            	<table border="0" cellspacing="15" cellpadding="0" width="100%">
                	<tr>
                        <td height="0" valign="top">Search <span class="orange_font"></span></td>
                  		<td colspan="3">           
                            <select name="search" id="search_id">
                            	<option value="">Select</option>
                                <option value="question_no">Enroll_no</option>
                                <option value="ques_title">Student Name</option>
                            </select>
                            <input type="text" style="width:230px" class="input_text" name="keyword" id="keyword" />
                            <input type="button" id="btnShow" name="search_button" value="Search" class="input_btn" onclick="searchQuestion()"  />
                            <input type="button" name="reset" value="Reset" class="input_btn" onclick="resetQuestion()"  />
                  		</td> 
                    </tr>
                    <tr>
                        <td height="0" valign="top">Selected student<span class="orange_font"></span></td>
                  		<td colspan="4">
                        Total selected students: <span id="total_count"><?php if($record_id){ echo $row_record['total_ques'];} ?></span><br /><br />
                        <input type="hidden" name="total_ques_cnt" id="total_ques_cnt"  value="<?php if($record_id){ echo $row_record['total_ques'];} ?>" />
                        	<table width=100% style="border:1px solid; margin:0; padding:0" class="table"><tr><td width="10%" align="center">Enroll number</td><td width="40%">Student Name</td><td width="40%" align="center">Course Name</td><td width="10%" align="center">Remove</td></tr>     
                            <tr><td colspan="4">   
                            <div name="selected_questions" id="selected_questions" style="width:100%;" cols="">
                            </div>
                            </td>
                            </tr>
                             
                        	</table>
                    	</td> 
                    </tr>
                   	<tr>
                        <td colspan="5">
                        <div id="show_search_result"></div>
                      	</td> 
                    </tr>
					<br /><br />
                    <tr>
                        <td>&nbsp;</td>
                        <td ><input type="submit" onclick="return validin();" class="input_btn" value="<?php echo "Add"; ?> Student" name="save_changes"  /></td>
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
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
<script language="javascript">
/*create_floor('add');
create_type1('add_type1');
create_type2('add_type2');*/
//create_floor_dependent();
</script>
</body>
</html>
<?php $db->close();?>