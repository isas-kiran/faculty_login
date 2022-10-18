<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM ex_student_exam_registration where id='".$record_id."'";
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
<title>
<?php if($record_id) echo "Edit"; else echo "Add";?> student for exam</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link rel="stylesheet" href="js/chosen.css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
	<!--<script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
	<script type="text/javascript">
	jQuery(document).ready( function() 
	{
		// binds form submission and fields to the validation engine
		jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
		$("#search").chosen({allow_single_deselect:true});
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
	
	var question_title=sep[1].split(".")[1];
	document.getElementById('selected_students').innerHTML=document.getElementById('selected_students').innerHTML+'<div id="'+divId+'" style="clear: both;"><table width="100%"><tr><td width="9%" align="center">'+seps[1]+'</td><td align="center" width="10%">'+sep[1]+'</td><td width="65%" align="left">'+question_title+'</td><td width="9%" align="center">'+img+sep[2]+'</td></tr></table>'+new_id+'</div>';
	
	//alert(sep[1]);
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
	var searchques= document.getElementById("search").value;
	var searchkeyword = document.getElementById("keyword").value;
	var keyword='';
	if(searchques !='')
	{
		if(searchques=="enroll_no")
		{
			var keyword="&enroll_id="+searchkeyword;	
		}
		else if(searchques=="st_name")
		{
			var keyword="&name="+searchkeyword;	
		}
		else if(searchques=="sel_batch")
		{
			var batch_id=document.getElementById("course_batch_id").value;
			var keyword="&batch_id="+batch_id;
		}
		else
			var keyword="";
		
		var data1=keyword;	
		//alert(data1);
		$.ajax({
			url: "ex_show_student.php", type: "post", data: data1, cache: false,
			success: function (html)
			{
				document.getElementById('show_search_result').innerHTML =html;
			}
		});
	}
	else
	{
		alert("Please select search by..");
	}
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
	total_mbr =document.getElementById("total_unit").value;
	record_id =document.getElementById("record_id").value;

	//var language_id=document.getElementById('language_id').value;
	que_div='quest_sel_'+ids;
	
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
	}
	else
	{
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
	function get_batch(vals)
	{
		if(vals=='sel_batch')
		{
			var ex_data="action=get_batch_details&batch_sel="+vals;
			$.ajax({
			url: "ex_ajax.php",type:"post", data: ex_data,cache: false,
			success: function(retbank)
			{
				document.getElementById("batch_id").innerHTML=retbank;
				$("#course_batch_id").chosen({allow_single_deselect:true});
			}
			});
		}
		else
		{
			document.getElementById("batch_id").innerHTML='<input type="text" style="width:330px" class="input_text" name="keyword" id="keyword" />';
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
    <td width="988" valign="bottom" class="top_mid"><?php include "include/exams_menu.php"; ?></td>
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
			$ex_number='';
			//echo $enroll_id;
			if($record_id)
			{
				$ex_number="and id !='".$record_id."'";
			}
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
				$data_record['exam_no']=$exam_no;
				$data_record['enroll_no']=$_POST['enroll_id'];
				$data_record['course_id']=$_POST['course_id'];
				$data_record['pwd']=$pwd;
				$data_record['date_added']=date('Y-m-d');
				$total_ques=count($_POST['new_selected']);

				//echo $total_ques;
				//if($record_id)
				//{
				//	"<br />".$del_ex_section="delete from papers_section where papers_id='".$record_id."'";
				//	$ptr_del_section=mysql_query($del_ex_section);

				 //   $update_mcq_paper = " update `student_exam_registration` set `exam_no`='".$exam_no."' , `enroll_id`='".$enroll_id."' , `course_id` = '".$course_id."' , `pwd`='".$pwd."' where id='".$record_id."'  ";
				//	$update_quer_paper = mysql_query($update_mcq_paper);
				for($h=0;$h<count($_POST['new_selected']);$h++)
				{
					$exam_no = $_GET['exam_no'];
					$p = $_POST['new_selected'][$h];
					$pass = $exam_no.'.'.$p;
					$data_record_type1['exam_no'] =$_GET['exam_no'];
					$data_record_type1['enroll_no'] =$_POST['new_selected'][$h];
					$data_record_type1['course_id'] =$_POST['course_id'][$h];
					$data_record_type1['pwd'] =$pass;
					$data_record_type1['date_added'] =date('Y-m-d');

					$data_record_type2['examination_number'] =$_GET['exam_no'];
					$data_record_type2['enroll_no'] =$_POST['new_selected'][$h];
					$data_record_type2['course_id'] =$_POST['course_id'][$h];
					$data_record_type2['pass'] =$pass;
					$data_record_type2['added_date'] =date('Y-m-d');

					$record_ids2=$db->query_insert("ex_stud_login", $data_record_type2);

					$sel = "select enroll_no from ex_student_exam_registration where enroll_no='".$_POST['new_selected'][$h]."' and exam_no='".$exam_no."'";
					$c = mysql_query($sel);
					$cs = mysql_fetch_array($c);
					if($cs['enroll_no'])
					{
						$update_mcq_paper = "update `ex_student_exam_registration` set `exam_no`='".$exam_no."', `enroll_no`='".$_POST['new_selected'][$h]."', `course_id` = '".$_POST['course_id'][$h]."' , `pwd`='".$pass."' where enroll_no='".$_POST['new_selected'][$h]."'  ";
						$update_quer_paper = mysql_query($update_mcq_paper);
					}
					else
					{
						$record_ids=$db->query_insert("ex_student_exam_registration", $data_record_type1);
					}
					$exams_id=mysql_insert_id();
				}
				$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `admin_id`) VALUES ('add_mcq_paper','Add','".$paper_name."','".$record_ids."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."')";
				$query=mysql_query($insert);
				echo ' Record added successfully';  
			}
		}
		if($success==0)
		{
			?>
			<tr><td>
        	<form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data">
            	<table border="0" cellspacing="15" cellpadding="0" width="100%">
					<tr>
                        <td height="0" width="15%" valign="top">Search <span class="orange_font"></span></td>
                  		<td align="center" width="20%">           
                            <select name="search" id="search" onChange="get_batch(this.value)" style="width: 250px !important">
                            	<option value="">Select</option>
                                <option value="enroll_no">Enter Enrollment No</option>
                                <option value="st_name">Enter Student Name</option>
								<option value="sel_batch">Select Batch</option>
                            </select>
						</td>
						<td colspan="2" align="left" width="60%">
							<span id="batch_id">
								<input type="text" style="width:330px" class="input_text" name="keyword" id="keyword" />	
							</span>
							&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="button" id="btnShow" style="width:100px" name="search_button" value="Search" class="input_btn" onclick="searchQuestion()">
                  		</td> 
                    </tr>
                    <tr>
                        <td height="0" valign="top">Selected student<span class="orange_font"></span></td>
                    	<td colspan="4">
                        Total selected students: <span id="total_count"><?php if($record_id){ echo $row_record['total_ques'];} ?></span><br /><br />
                        <input type="hidden" name="total_ques_cnt" id="total_ques_cnt"  value="<?php if($record_id){ echo $row_record['total_ques'];} ?>" />
                        	<table width=100% style="border:1px solid; margin:0; padding:0" class="table">
								<tr>
									<td width="10%" align="center">Enroll number</td><td width="10%">Student Name</td>
									<td width="70%" align="center">course</td><td width="10%" align="center">Remove</td>
								</tr>     
                            	<tr>
									<td colspan="4">   
                            		<div name="selected_students"  id="selected_students" style="width:100%;" cols="">
									</div>
                            		</td>
                            	</tr>
                            </table>
                    	</td> 
                    </tr>
                   	<tr>
                    	<td colspan="3">
                        	<div id="show_ques">
                        	</div>
                        	<div id="show_search_result"></div>
                      	</td> 
                    </tr>
					<br /><br />
                    <tr>
                        <td>&nbsp;</td>
                        <td ><input type="submit" onclick="return validin();" class="input_btn" value="<?php if ($record_id) echo "Update"; else  echo "Add"; ?> Student" name="save_changes"  /></td>
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
<script language="javascript">
/*create_floor('add');
create_type1('add_type1');
create_type2('add_type2');*/
//create_floor_dependent();
</script>
</body>
</html>