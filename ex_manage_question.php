<?php include 'ex_inc_classes.php';?>
<?php include "ex_admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
<title>Manage Question</title> 
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "ex_include/headHeader.php";?>
<?php include "ex_include/functions.php"; ?>
<?php include "ex_include/ps_pagination.php"; ?>
<link rel="stylesheet" href="js/chosen.css" type="text/css" />
<script src="js/chosen.jquery.js" type="text/javascript"></script>
    
    <script type="text/javascript">
	var pageName = "manage_question";
	$(document).ready(function()
	{   
		$("#syllabus_id").chosen({allow_single_deselect:true});
		$("#selAction1").chosen({allow_single_deselect:true});
		$("#selAction").chosen({allow_single_deselect:true});
	});
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
                if(confirm("Are you sure, you want to delete Main question, All subquestion for this question automatically deleted(s)?"))
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
        	alert(value);
           	alert(value1);
            window.location.href=value+value1;
        }
        function validationToDelete(type)
        {
            if(confirm("Are you sure, you want to delete selected record(s)?"))
                return true;
            else
                return false;
        }
		function validationToDeleteMain(type)
        {
            if(confirm("Are you sure, you want to delete Main question, All subquestion for this question automatically deleted(s)?"))
                return true;
            else
                return false;
        }
    </script>
     <script>
    function showpaper(countert)
    {
	    var x = document.getElementById('cont_'+countert).value;
		//alert(x);
		alert(x);
	}
	/*function update_pos(pos)
	{
		separate= pos.split('_');
		if(confirm(" Do you really want to set the position to "+separate[0]))
		{
			document.location.href="manage_question.php?action=update_pos&question_id="+separate[1]+"&question_pos="+separate[0];
		}
	}*/
    </script>
</head>
<body>
<?php
function transliterateString($txt) {
    $transliterationTable = array('á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'ă' => 'a', 'Ă' => 'A', 'â' => 'a', 'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A', 'ā' => 'a', 'Ā' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE', 'ḃ' => 'b', 'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c', 'Ĉ' => 'C', 'č' => 'c', 'Č' => 'C', 'ċ' => 'c', 'Ċ' => 'C', 'ç' => 'c', 'Ç' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd', 'Ḋ' => 'D', 'đ' => 'd', 'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ĕ' => 'e', 'Ĕ' => 'E', 'ê' => 'e', 'Ê' => 'E', 'ě' => 'e', 'Ě' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ė' => 'e', 'Ė' => 'E', 'ę' => 'e', 'Ę' => 'E', 'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F', 'ƒ' => 'f', 'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g', 'Ĝ' => 'G', 'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g', 'Ģ' => 'G', 'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i', 'Į' => 'I', 'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J', 'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l', 'Ĺ' => 'L', 'ľ' => 'l', 'Ľ' => 'L', 'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L', 'ṁ' => 'm', 'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n', 'Ņ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', 'ő' => 'o', 'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o', 'Ơ' => 'O', 'ö' => 'oe', 'Ö' => 'OE', 'ṗ' => 'p', 'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r', 'Ř' => 'R', 'ŗ' => 'r', 'Ŗ' => 'R', 'ś' => 's', 'Ś' => 'S', 'ŝ' => 's', 'Ŝ' => 'S', 'š' => 's', 'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S', 'ş' => 's', 'Ş' => 'S', 'ș' => 's', 'Ș' => 'S', 'ß' => 'SS', 'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't', 'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T', 'ŧ' => 't', 'Ŧ' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ŭ' => 'u', 'Ŭ' => 'U', 'û' => 'u', 'Û' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U', 'ų' => 'u', 'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U', 'ü' => 'ue', 'Ü' => 'UE', 'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w', 'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W', 'ý' => 'y', 'Ý' => 'Y', 'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'ź' => 'z', 'Ź' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z', 'Ż' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b', 'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g', 'Г' => 'g', 'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'E', 'ё' => 'e', 'Ё' => 'E', 'ж' => 'zh', 'Ж' => 'zh', 'з' => 'z', 'З' => 'z', 'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k', 'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm', 'н' => 'n', 'Н' => 'n', 'о' => 'o', 'О' => 'o', 'п' => 'p', 'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's', 'т' => 't', 'Т' => 't', 'у' => 'u', 'У' => 'u', 'ф' => 'f', 'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c', 'Ц' => 'c', 'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh', 'Ш' => 'sh', 'щ' => 'sch', 'Щ' => 'sch', 'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '', 'Ь' => '', 'э' => 'e', 'Э' => 'e', 'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja', 'Я' => 'ja', 'ï' =>'e');
    $new_str=str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);
	return $new_str;
}
?>
<?php include "include/header.php"; ?>
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
    <td class="top_mid" valign="bottom"><?php include "ex_include/exams_menu.php";?></td>
	<td class="top_right"></td>
  </tr>
  <?php       
	/*if($_GET['action']=='update_pos')
	{
					$question_id= $_GET['question_id'];	
					$question_pos= $_GET['question_pos'];	
					$query_update = "update question set question_pos='".$question_pos."' where question_id='".$question_id."'";
					$update_pos = mysql_query($query_update);
					 ?>
					<div id="statusChangesDiv1" title="Status Changed"><center><br/><p>Member Position changed successfully</p></center></div>
					<script type="text/javascript">
					$("#statusChangesDiv1").dialog({  modal: true, buttons: { Ok: function() { $( this ).dialog( "close" ); } } });
					</script>
					<?php
				}*/

		?>
<?php if($_POST['formAction'])
{
	if($_POST['formAction']=="delete")
    {
    	for($r=0;$r<count($_POST['chkRecords']);$r++)
        {
			$del_record_id=$_POST['chkRecords'][$r];
			$sel_rec="select question_id from ex_question where main_question_id='".$del_record_id."' ";
			$db1=mysql_query($sel_rec);
			$tot = mysql_num_rows($db1);
			if($tot)
			{
				while($data_quesy=mysql_fetch_array($db1))
				{
					$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `admin_id`) VALUES ('manage_mcq_question','Delete','".$data_quesy['paper_name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert);
					
					$delete_query="delete from ex_question where question_id ='".$data_quesy['question_id']."' ";
					$db->query($delete_query);   
					$sel_map="delete from ex_options where question_id='".$data_quesy['question_id']."'";
					$ptr_map=mysql_query($sel_map); 
				}
			}
			else
			{
				$sel_rec="select question_id from ex_question where question_id='".$del_record_id."' ";
				$db2=mysql_query($sel_rec);
				if(mysql_num_rows($db2))
				{
					while($data_quesy=mysql_fetch_array($db2))
					{
						$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `admin_id`) VALUES ('manage_mcq_question','Delete','".$data_quesy['paper_name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."')";
						$query=mysql_query($insert);
					
						$delete_query="delete from ex_question where question_id ='".$data_quesy['question_id']."' ";
						$db->query($delete_query);   
						$sel_map="delete from ex_options where question_id='".$data_quesy['question_id']."'";
						$ptr_map=mysql_query($sel_map); 
					}
				}
			}
			/* $sql_query= "SELECT question_id FROM question where (question_id =".$del_record_id."  and  main_question_id = '".$del_record_id."' )";
			$ptrs = mysql_query($sql_query);
			$tot_2 =mysql_num_rows($ptrs);
		   	if($tot_2 ==0 && $tot ==0 )
				{       
					$delete_query="delete from question where question_id ='".$del_record_id."' ";
					$db->query($delete_query);   
					$sel_map="delete from option where question='".$del_record_id."'";
					$ptr_map=mysql_query($sel_map);   
				}*/
		}
		?>
		<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record(s) deleted successfully</p></center></div>
        <script type="text/javascript">
        // $("#statusChangesDiv").dialog();
            $(document).ready(function() {
                $( "#statusChangesDiv" ).dialog({
                        modal: true,
                        buttons: {
                                    Ok: function() { $( this ).dialog( "close" );}
                                 }
                });
            });
        </script>
		<?php                            
    }                       
}
if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'] && $_REQUEST['main_ques'])
{
	$del_record_id=$_REQUEST['record_id'];
	$sel_ques="select question_id from ex_question where main_question_id='".$del_record_id."'";
	$ptr_sel=mysql_query($sel_ques);
	while($data_sel_ques=mysql_fetch_array($ptr_sel))
	{
		"<br>".$del_ques="delete from ex_question where question_id='".$data_sel_ques['question_id']."'";
		$ptr_del=mysql_query($del_ques);
		"<br>".$del_ques="delete from ex_papers_section where question_id='".$data_sel_ques['question_id']."'";
		$ptr_del=mysql_query($del_ques);
		 "<br>".$del_oipt="delete from ex_options where question_id='".$data_sel_ques['question_id']."'";
		$ptr_opt=mysql_query($del_oipt);
		"<br>".$del_ques_img="delete from ex_questions_image where question_id='".$data_sel_ques['question_id']."'";
		$ptr_del=mysql_query($del_ques_img);
	}
	?>
	<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record deleted successfully</p></center></div>
	<script type="text/javascript">
	// $("#statusChangesDiv").dialog();
		$(document).ready(function() {
			$( "#statusChangesDiv" ).dialog({
					modal: true,
					buttons: {
								Ok: function() { $( this ).dialog( "close" );}
							 }
			});
		});
	</script>
	<?php
	}
	if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'] && $_REQUEST['sub_ques'])
	{
		$del_record_id=$_REQUEST['record_id'];
		$sel_ques="select question_id from ex_question where question_id='".$del_record_id."'";
		$ptr_sel=mysql_query($sel_ques);
		while($data_sel_ques=mysql_fetch_array($ptr_sel))
		{
			$del_ques="delete from ex_question where question_id='".$data_sel_ques['question_id']."'";
			$ptr_del=mysql_query($del_ques);
			$del_ques="delete from ex_papers_section where question_id='".$data_sel_ques['question_id']."'";
			$ptr_del=mysql_query($del_ques);;
			$del_oipt="delete from ex_options where question_id='".$data_sel_ques['question_id']."'";
			$ptr_opt=mysql_query($del_oipt);
			$del_ques_img="delete from ex_questions_image where question_id='".$data_sel_ques['question_id']."'";
			$ptr_del=mysql_query($del_ques_img);
		}
		?>
		<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record deleted successfully</p></center></div>
		<script type="text/javascript">
			$(document).ready(function() {
				$( "#statusChangesDiv" ).dialog({
						modal: true,
						buttons: {
									Ok: function() { $( this ).dialog( "close" );}

								 }
				});

			});
		</script>
		<?php
}
?>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
<table cellspacing="0" cellpadding="0" class="table" width="95%">
  <tr class="head_td">
    <td colspan="12">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                <td width="10%">
                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                <option value="">-Operation-</option>
                                <option value="delete">Delete</option>
                        </select>
                </td>
                <td width="15%">
                <!-- < ?php 
						  echo "Select Subject. :";
echo ' <select name="syllabus_id" id="selAction" onchange="redirect1(\'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?&unit_id='.$_GET['unit_id'].'&language_id='.$_GET['language_id'].'&syllabus_id=\',this.value)" style="width:60px" >';
                            echo '<option value="">Select Subject</option>';
						  	$selec_que="SELECT  DISTINCT(subject_id) FROM topic_map where 1";
	  						$ptr_que=mysql_query($selec_que);
						  	while($val_ques=mysql_fetch_array($ptr_que))
							{
								$select_unit_name=mysql_query("select name from subject where subject_id ='".$val_ques['subject_id']."'");
								if(mysql_num_rows($select_unit_name))
								{
									$val_unit=mysql_fetch_array($select_unit_name);
									$lang_id=$val_ques['subject_id'];
									$sel_lan="select * from subject where subject_id='".$lang_id."'";
									$ptr_lang=mysql_query($sel_lan);
									$data_lang=mysql_fetch_array($ptr_lang);
									?>
										<option value="<?php //echo $val_ques['subject_id']; ?>" <?php //if ($_REQUEST['syllabus_id']==$val_ques['subject_id']) echo "selected" ?>><?php //echo $val_unit['name']; ?></option>
									< ?php
								}
							}
                          ?>
                          </select> -->
						<?php
						 echo '<select name="syllabus_id" id="syllabus_id" style="width: 150px; " onchange="redirect1(\'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?&unit_id='.$_GET['unit_id'].'&language_id='.$_GET['language_id'].'&syllabus_id=\',this.value)" style="width:60px">';
					
				echo '<option value="">Select</option>';
			  
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
					   if($_REQUEST['syllabus_id'] == $row['subject_id'])
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
                <td width="15%">
                <?php 
							$concat_syll ='';
							if($_REQUEST['syllabus_id'] !='' )
							{
							   $concat_syll =" and subject_id='".$_REQUEST['syllabus_id']."' ";
							}
							
							echo ' <select name="unit_id" id="selAction1"  style="width: 150px;" onchange="redirect1(\'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?language_id='.$_GET['language_id'].'&syllabus_id='.$_GET['syllabus_id'].'&unit_id=\',this.value)" style="width:80px" >';
                            echo '<option value="">Select topic</option>';
						  	$selec_que="SELECT  DISTINCT(topic_id) FROM topic_map where 1 ".$concat_syll."";
	  						$ptr_que=mysql_query($selec_que);
						  	while($val_ques=mysql_fetch_array($ptr_que))
							{
								$select_unit_name=mysql_query("select * from topic where topic_id ='".$val_ques['topic_id']."'");
								if(mysql_num_rows($select_unit_name))
								{
									$val_unit=mysql_fetch_array($select_unit_name);
									$lang_id=$val_ques['language_id'];
									$sel_lan="select * from language where language_id='".$lang_id."'";
									$ptr_lang=mysql_query($sel_lan);
									$data_lang=mysql_fetch_array($ptr_lang);
									?>
									<option value="<?php echo $val_ques['topic_id']; ?>" <?php if ($_REQUEST['unit_id']==$val_ques['topic_id']) echo "selected" ?>><?php echo $val_unit['topic_name']; ?></option>
									<?php
								}
							}
							?>
							</select>
						</td>
						<td>
						<!-- <?php 
				 		// $concat_unit ='';
						// if($_GET['unit_id'] !='' )
						// {
						//    $concat_unit = " and unit_id='".$_GET['unit_id']."' ";
						// }
						// echo "Select Lang.: ";
						// echo ' <select name="language_id" id="selAction" onchange="redirect1(\'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?unit_id='.$_GET['unit_id'].'&syllabus_id='.$_GET['syllabus_id'].'&language_id=\',this.value)" style="width:80px" >';
						
						// echo '<option value=""> Select Lang</option>';
						// $selec_que="select distinct(language_id) from question where 1 ".$concat_unit."";
	  					// $ptr_que=mysql_query($selec_que);
						// while($val_ques=mysql_fetch_array($ptr_que))
						// {
						// 	$lang_id=$val_ques['language_id'];
                        //     $sel_lan="select * from language where language_id='".$lang_id."'";
                        //     $ptr_lang=mysql_query($sel_lan);
						// 	$data_lang=mysql_fetch_array($ptr_lang);
						// 	?>
						// 	<option value="<?php //echo $data_lang['language_id']; ?>" <?php //if ($_REQUEST['language_id']==$data_lang['language_id']) echo "selected" ?>><?php //echo $data_lang['language_name']; ?></option>
						// 	<?php
						// }
                        // $lang_name=$data_lang['language_name'];
                        ?>
                        </select> -->
                </td>
                <td>
                 <?php 
						echo "Search Criteria: ";
						echo ' <select name="search_criteria" id="selAction" style="width:100px" >';
                        echo '<option value="">Search By</option>';
							     $concat ='';
								 if($_GET['unit_id'] !='' )
								 {
								   $concat = " and unit_id='".$_GET['unit_id']."' ";
								 }
								 $concat1 ='';
								 if($_GET['language_id'] !='' )
								 {
								   $concat1 = " and language_id='".$_GET['language_id']."' ";
								 }
								 ?>
                                 <option value="question_id"  <?php if($_GET['search_criteria'] && $_GET['search_criteria']=="question_id") echo 'selected="selected"'; ?>>Question No.</option>
                                 <option value="question_title" <?php if($_GET['search_criteria'] && $_GET['search_criteria']=="question_title") echo 'selected="selected"'; ?>>Question Title</option>
                                 <option value="right_answer" <?php if($_GET['search_criteria'] && $_GET['search_criteria']=="right_answer") echo 'selected="selected"'; ?>>Right Answer</option>
                                 <option value="unit_name" <?php if($_GET['search_criteria'] && $_GET['search_criteria']=="unit_name") echo 'selected="selected"'; ?>>Unit Name</option>
                                 <option value="language_name" <?php if($_GET['search_criteria'] && $_GET['search_criteria']=="language_name") echo 'selected="selected"'; ?>>Language Name</option>
                                 
                                <?php
								/*$selec_que="select distinct(main_question_id) as question_id from question where 1 ".$concat." ".$concat1."";
								$ptr_que=mysql_query($selec_que);
								while($val_ques=mysql_fetch_array($ptr_que))
								{
								$question_id=$val_ques['question_id'];
								?>
	
									<option value="<?php echo $val_ques['question_id']; ?>" <?php if ($_REQUEST['question_id']==$val_ques['question_id']) echo "selected" ?>><?php echo $val_ques['question_id']; ?></option>
								<?php
								}*/
								$lang_name=$data_lang['language_name'];
                          		?>
                          </select>
              </td>
              <td class="leftAlign" > 
              <table border="0" cellspacing="0" cellpadding="0" align="right">
              <tr>
              <td>
			  <?php if($_GET['unit_id']|| $_GET['syllabus_id']){?>
			  <a href="all_ques_list.php?syllabus_id=<?php echo $_GET['syllabus_id']; ?>&unit_id=<?php echo $_GET['unit_id'] ?>" target="_blank">
			  
			  <input class="input_btn" type="button" name="print" value="Print" style="width:50px"/></a>
			  <?php }else{?>
				<a href="all_ques_list.php" target="_blank">
			  
			  <input class="input_btn" type="button" name="print" value="Print" style="width:50px"/></a>
			  <?php }?>

			  <?php if($_GET['unit_id']|| $_GET['syllabus_id']){?>
			  <a href="report_all_ques_ans_mgmt.php?syllabus_id=<?php echo $_GET['syllabus_id']; ?>&unit_id=<?php echo $_GET['unit_id'] ?>" target="_blank">
			  
			  <input class="input_btn" type="button" name="printa" value="Print with ans" style="width:70px"/></a>
			  <?php }else{?>
				<a href="report_all_ques_ans_mgmt.php" target="_blank">
			  
			  <input class="input_btn" type="button" name="printa" value="Print with ans" style="width:70px"/></a>
			  <?php }?>
			  </td>
			  <td class="width5"></td>
                <td><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                <td class="width2"></td>
                <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
              </tr>
              </table>	
                </td>
            </tr>
        </table>
        </form>	
    </td>
  </tr>
  <?php
						// $search_query1='';
						// if($_REQUEST['unit_id']!='')
						// {
						// 	$unit_ids=$_REQUEST['unit_id'];
						// 	$search_query1=" and u.unit_id='".$_GET['unit_id']."' ";
						// }
						// $search_query2='';
						// if($_REQUEST['language_id']!='')
						// {
						// 	$language_ids=$_REQUEST['language_id'];
						// 	 $search_query2=" and l.language_id='".$_GET['language_id']."' ";
						// }
						/*$search_query3='';
						if($_GET['question_id']!='')
						{
							 $search_query3=" and main_question_id='".$_GET['question_id']."' ";
						}*/
						
						if($_REQUEST['search_criteria'] !='')
							$search_criteria=trim($_REQUEST['search_criteria']);
						else
							$search_criteria='';

                        if($_REQUEST['keyword']!="Keyword" || $_REQUEST['keyword']!='')
						{
                            $keyword=trim($_REQUEST['keyword']);
							if($keyword && $search_criteria=="question_id")
							 	$pre_keyword="and (q.main_question_id = '".$keyword."') ";
							else if($keyword && $search_criteria=="question_title")
								$pre_keyword="and (q.question_title like '%".$keyword."%') ";
							else if($keyword && $search_criteria=="right_answer")
								$pre_keyword="and (o.option_title like '%".$keyword."%' and o.answer='y') ";
							//else if($keyword && $search_criteria=="unit_name")
								//$pre_keyword="and (u.unit like '%".$keyword."%') ".$search_query1." ".$search_query2."";
							//else if($keyword && $search_criteria=="language_name")
								//$pre_keyword="and (l.language_name like '%".$keyword."%') ".$search_query1." ".$search_query2."";	
							else if($search_criteria=='' && $keyword)
                            $pre_keyword=" and (q.question_title like '%".$keyword."%' or o.option_title like '%".$keyword."%')";
						}
                        else
						{
                            $pre_keyword="";
						}

                        if($_REQUEST['page'])
                            $page=$_REQUEST['page'];
                        else
                            $page=0;
							
                        if($_REQUEST['show_records'])
                            $show=$_REQUEST['show'];
                        else
                            $show=0;

                        if($_GET['order']=='asc')
                        {
                            $order='desc';
                            $img = "<img src='images/sort_up.png' border='0'>";
                        }
                        else if($_GET['order']=='desc')
                        {
                            $order='asc';
                            $img = "<img src='images/sort_down.png' border='0'>";
                        }
                        else
                            $order='desc';

                        if($_GET['orderby']=='name' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='name'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
							if($_GET['syllabus_id']!='')
							{
								$sub_query1=" and subject_id='".$_GET['syllabus_id']."' ";
							}
							if($_GET['unit_id']!='')
							{
								 $sub_query1=" and unit_id='".$_GET['unit_id']."' ";
							}
							if($_GET['language_id']!='')
							{
								 $sub_query2=" and language_id='".$_GET['language_id']."' ";
							}
							if($_GET['question_id']!='')
							{
								 $sub_query3=" and main_question_id='".$_GET['question_id']."' ";
							}
							
							$select_directory='order by question_id desc';
							if($pre_keyword=='')     
                            	$sql_query= "SELECT * FROM ex_question where 1 ".$sub_query1." ".$sub_query2." ".$sub_query3." ".$select_directory.""; 
							else
								 $sql_query= "SELECT distinct(q.question_id) as question_id  FROM ex_question q, ex_options o where 1 ".$pre_keyword." and q.question_id=o.question_id "; 

                        $no_of_records=mysql_num_rows($db->query($sql_query));

                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            $query_string='&keyword='.$keyword.'&unit_id='.$_REQUEST['unit_id'].'&syllabus_id='.$_REQUEST['syllabus_id'].'&search_criteria='.$search_criteria;
                            $query_string1=$query_string.$date_query;
                           // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
							
                            ?>
                          <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                                                         <input type="hidden" name="formAction" id="formAction" value=""/>
                          <tr class="grey_td" >
                            <td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
                            <td width="5%" align="center"><strong>Sr. No.</strong></td>
                            <td width="7%" align="center"><strong>Main Question</strong></td>
                            <td width="23%"><strong>Question</strong></td>
                            <td width="17%"><strong>Right Ans.</strong></td>
                            <td width="14%"><strong>Topic Name</strong></td>
                            <td width="14%"><strong>Subject Name</strong></td>
                            <td width="14%"><strong>Domain Name</strong></td>
                            <td width="13%" align="center"><strong> Question added paper(s) counter</strong></td>
                            <td width="8%" align="center"><strong>Language</strong></td>
                            <td width="8%" align="center"><strong>Added Date</strong></td>
                            <td width="8%" class="centerAlign"><strong>Action</strong></td>
                          </tr>
                            <?php
                            while($val_query=mysql_fetch_array($all_records))
                            {
								
								
								
								$question_id = $val_query['question_id'];
								
								$select_question="SELECT * FROM ex_question where question_id='".$question_id."' ";
								$query_question=mysql_query($select_question);
								$fetch_question=mysql_fetch_array($query_question);
								
								//$question_title=transliterateString($fetch_question['question_title']);
								$question_title=$fetch_question['question_title'];
								
								$select_unit_name=mysql_query("select * from topic where topic_id ='".$fetch_question['unit_id']."'");
								$val_unit=mysql_fetch_array($select_unit_name); 
								
                                $name = '';
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                $listed_record_id=$val_query['question_id']; 
								$unit_id=$val_query['unit_id']; 
                                include "ex_include/paging_script.php";
                                echo '<tr '.$bgcolor.' >';
								
								$sel_rec_check="select question_id from ex_student_paper where question_id='".$question_id."' ";
								$tot_check = mysql_num_rows($db->query($sel_rec_check));
                                
								$sql_query_checkbox= "SELECT question_id FROM ex_question where (question_id ='".$question_id."'  and  main_question_id = '".$question_id."' )";
								$ptrs_check = mysql_query($sql_query_checkbox);
							    $tot_check2 =mysql_num_rows($ptrs_check);
								
								$count_quation="select  main_question_id from ex_question where question_id='".$val_query['question_id']."'";
								$ptr_count=mysql_query($count_quation);
								$count_quetions=mysql_num_rows($ptr_count);
								$data_main_ques=mysql_fetch_array($ptr_count);
								
								/*$cnt_ques= "select question_id from question where main_question_id='".$data_main_ques['main_question_id']."'";
								$ptr_cnt=mysql_query($cnt_ques);
								$cnt=mysql_num_rows($ptr_cnt);*/
								
								$sel_rec="select question_id from ex_student_paper where question_id='".$val_query['question_id']."' ";
								$ptr_unit=mysql_query($sel_rec);
								$ques_exis_cnt=mysql_num_rows($ptr_unit);
								
								"<br/>".$sel_exist_rec="select question_id from ex_exams_section where question_id='".$val_query['question_id']."' ";
								$ptr_exst_rec=mysql_query($sel_exist_rec);
								$ques_cnt=mysql_num_rows($ptr_exst_rec);
								if($tot_check2 ==0 && $tot_check ==0 )
								{
									 $disabled='';
								}
								else
								{
									 $disabled='onclick="return false;" onkeydown="return false;"';
								}
								$main_id='';
								if($data_main_ques['main_question_id'] == $val_query['question_id'])
								{
									$main_id='<span class="orange_font">*</span>';
								}
                                echo'<td align="center">';
								//echo $ques_exis_cnt."-".$ques_cnt."-".$data_main_ques['main_question_id']."==".$val_query['question_id'];
								if($ques_exis_cnt==0 )
								{
									/*if($cnt <= 1)
									{*/
										if($ques_cnt ==0)
										{
											if($data_main_ques['main_question_id'] == $val_query['question_id'])
											{
											// 	echo "M.Q.";
											// }
											// else
											// {
												echo '<input type="checkbox" name="chkRecords[]" value="'.$question_id.'" />';
											}
										}
									//}
								}
								else
								{
								}
								echo '</td>';
								echo '<td align="center">'.$sr_no.'.'.$main_id.'</td>';
								echo '<td align="center">'.$fetch_question['main_question_id'].'</td>'; 
								$subject_id= $val_query['subject_id'];
								$topic_id= $val_query['chapter_id'];
								echo '<td>';
								echo '<table width="100%">';
								echo '<tr>';
								echo '<td width="40%">'.stripslashes(html_entity_decode($question_title)).'</td>';
								$img='';
								if($fetch_question['question_img']!='')
								{
									$img='<img src="ex_question_photo/'.stripslashes($fetch_question['question_img']).'" height="40" width="40"/>';
									echo '<td width="40%">'.$img.'</td>';
								}
								echo '</tr>';
								echo '</table>';
								echo '</td>';
								$sel_lang1="select language_name,language_code from ex_language where language_id='1'";
								$my_query1=mysql_query($sel_lang1);
								$datat_query1=mysql_fetch_array($my_query1);
								
								$sel_right_option="select * from ex_options where question_id=".$val_query['question_id']." and answer='y' ";
								$my_right_option=mysql_query($sel_right_option);
								$datat_right_option=mysql_fetch_array($my_right_option);
								
								echo '<td>'.stripslashes(html_entity_decode($datat_right_option['option_title'])).'</td>';
								echo '<td>'.$val_unit['topic_name'].' - '.$val_unit['topic_id'].'</td>';
								
								$sel_subj="select topic_id,subject_id,course_domain_id from topic_map where topic_id='".$fetch_question['unit_id']."' ";
								$ptr_subj=mysql_query($sel_subj);
								$data_subj=mysql_fetch_array($ptr_subj);
								
								$sel_sub="select name from subject where subject_id='".$data_subj['subject_id']."'";
								$ptr_sub=mysql_query($sel_sub);
								$data_sub=mysql_fetch_array($ptr_sub);
								
								$sel_domain="select cat_name from course_domain_category where cat_id='".$data_subj['course_domain_id']."'";
								$ptr_domain=mysql_query($sel_domain);
								$data_domain=mysql_fetch_array($ptr_domain);
								
								echo '<td>'.$data_sub['name'].'</td>';
								
								echo '<td>'.$data_domain['cat_name'].'</td>';
								
								$question_count=0;
								$sel_paper="select question_id, papers_id from ex_papers_section where question_id=".$val_query['question_id']."";
								$my_query1=mysql_query($sel_paper);
								$question_count=mysql_num_rows($my_query1);
								$conc='';
								$paper_name='';
								$titl='';
								if($question_count)
								{
									$titl ='title="click to view paper(s) name"  style="cursor:pointer" ';
									while($fetch_paper=mysql_fetch_array($my_query1))
									{
										
										$select_paper_name="select paper_name from ex_papers where papers_id ='".$fetch_paper['papers_id']."'";
										$query_fetch=mysql_query($select_paper_name);
										$val_paper=mysql_fetch_array($query_fetch); 
										$paper = $val_paper['paper_name'];
										$paper_name .=$paper ;
										$paper_name .="\n";
									}
									$conc = 'onclick="showpaper('.$bgColorCounter.');"';
								}
								echo'<input type="hidden" name="paper" id="cont_'.$bgColorCounter.'" value="'.$paper_name.'" />'; 
								echo '<td align="center"><span '.$conc.' ' .$titl.' >'.$question_count.'</span></td>';
								echo '<td align="center">'.$datat_query1['language_name'].'</td>';
								echo '<td align="center">'.$fetch_question['added_date'].'</td>';
								echo '<td align="center">';
								echo '<table width="80%">
								<tr>
								<td width="50%">
								<a href="ex_add_questions.php?record_id='.$val_query['question_id'].'&unit_id='.$fetch_question['unit_id'].'"><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;';

								echo "</td><td width='50%'> ";
								//echo $ques_exis_cnt."-".$ques_cnt."-".$data_main_ques['main_question_id']."==".$val_query['question_id'];
								if($ques_exis_cnt==0 )
								{
									/*if($cnt <= 1)
									{*/
										if($ques_cnt ==0)
										{
											if($data_main_ques['main_question_id'] == $val_query['question_id'])
											{
												//echo "<br />hi";
												echo '<a onclick="return validationToDeleteMain(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&main_ques=1&record_id='.$val_query['question_id'].'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
											}
											else
											{
												// echo '<td align="center"> 
												echo '<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&sub_ques=1&record_id='.$val_query['question_id'].'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
											}
										}
									//}
								}
								echo ' </td></tr></table></td>';
								echo '</td>';
                                echo '</tr>';
                                $bgColorCounter++;
								//}
                            }
                            ?>
<tr class="head_td">
    <td colspan="12">
       <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <?php
                if($no_of_records>10)
				{
					echo '<td width="3%" align="left">Show</td>
					<td width="20%" align="left"><select class="input_select_login" name="show_records" onchange="redirect(this.value)">';
					$show_records=array(0=>'10',1=>'20','50','100','200');
					for($s=0;$s<count($show_records);$s++)
					{
						if($_SESSION['show_records']==$show_records[$s])
							echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
						else
							echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
					}
					echo'</td></select>';
				}
				echo '<td width="75%" align="right">'.$pager->renderFullNav().'</td>';
                ?>    
			</tr>
        </table>                         
    </td>
    </tr>
    </form>
    <?php } 
      else
        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No course found related to your search criteria, please try again</div><br></td></tr>';?>
      <tr>
      	<td colspan="10"><span class="orange_font">Note -:  * questions are main question and it has subquestions</span></td>
     </tr>
</table>
	</td>
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
<div id="footer">
<?php include "ex_include/footer.php"; ?>
</div>
<!--footer end-->
</body>
</html>
