<?php include 'ex_inc_classes.php';?>
<?php include "ex_admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
$exam_no=$_GET['exam_no'];
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM grade where grade_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
Manage Individual Student Report</title>
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
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
    </script>
    
<!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
   <!-- <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    
    <script type="text/javascript">
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
        });
    </script>-->
    <script>
function show_subject(subject)
{
	//alert(subject);
	var data1="show_subject=1&subject="+subject;
	 $.ajax({
	url: "ex_show_subjects.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
	 document.getElementById('show_subject').innerHTML=html;
	}
	});
}
</script>    
<script type="text/javascript">

function changeFunc(id) 
{
var course="show_report=1&student_id="+id;
 //$("#total_quations").val($("#totla_q_"+unit_id).val());
// alert()
stud_id=document.getElementById("student_id").value=id;
//alert(stud_id);
 $.ajax({
	 url: "ex_show_report.php", type: "post", data: course, chache:false,
	 success: function (chapters)
	 {
		 document.getElementById('show_report').innerHTML=chapters;
	 }
 });
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
    <td class="top_mid" valign="bottom"><?php include "ex_include/exams_menu.php"; ?></td>
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
                            $grade=$_POST['grade'];
                            $from=$_POST['from'];
							$to=$_POST['to'];
                            
                            if($grade=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter Language name ";
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
                                $data_record['grade'] =$grade;
                                $data_record['from'] =$from; 
								$data_record['to'] =$to; 
                              
                               if($record_id)
                                {
                                    $where_record="grade_id='".$record_id."'";
                                    $db->query_update("grade", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $record_id=$db->query_insert("grade", $data_record);
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                                }
                            }
                        }
                        if($success==0)
                        {
                        
                        ?>
                         <form method="get" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data">
            <tr><td>
       
            <table border="0" cellspacing="15" cellpadding="0" width="100%">
                    <tr>
                        <td colspan="3" class="orange_font">* Mandatory Fields</td>
                    </tr>
                    <tr>
                       <td width="20%">Examination Number<span class="orange_font">*</span></td>
                        <td width="14%" style=""><input type="text"  class="validate[required] input_text" name="exam_no" id="exam_no" value="<?php if ($_POST['exam_no']) echo $_POST['exam_no']; else echo $_GET['exam_no']; ?>" style="width:160px; height:26px" /></td> 
                        <td width="66%"><input type="submit" class="input_btn" value="Search" name="save_changes"  /></td>
                    </tr>
                    <tr>
                    	<td width="20%"><span class="orange_font"></span></td>
                         <td width="14%">
                        <!-- <input type="checkbox" name="analyst_sheet" <?php //if($_GET['analyst_sheet']=="on") echo 'checked="checked"';?> /> Examination Analyst Sheet<br />
                         <input type="checkbox" name="summeryreport" <?php //if($_GET['summeryreport']=="on") echo 'checked="checked"';?> / > Exam Summery Report<br />-->
                         <!--<input type="checkbox" name="disclaimer" <?php //if($_GET['disclaimer']=="on") echo 'checked="checked"';?> /> View Exam Details<br />-->
                         <!--<input type="checkbox" name="student_report" <?php //if($_GET['student_report']=="on") echo 'checked="checked"';?> /> Student Report of Question and Answer-->
                         </td>
                    </tr>
                    <input type="hidden" name="student_id" id="student_id" value="<?php echo $_POST['student_id']; ?>"/>
                    
                    <?php 
					if($_GET['exam_no'])
		  			{
					?>
                    <tr>
                   <?php  $sele_stud="select name, stud_login_id ,pass,examination_number from ex_stud_login where examination_number='".$_GET['exam_no']."' and status='inactive' ";
			?>
                        <td>Select Student</td>
                        <td ><select name="student" class="student validate[required] input_select" onchange="changeFunc(this.value);">
                <option value="select_student">Select Student</option>
                <?php
				//$sele_stud="select name, stud_login_id ,pass,examination_number from stud_login where examination_number='".$_GET['exam_no']."' and  exam_stoped ='yes' and  status='inactive' ";
				$ptr_stud=mysql_query($sele_stud);
				if(mysql_num_rows($ptr_stud))
				{
					while($data_stud=mysql_fetch_array($ptr_stud))
					{
                        $sel_exam_ques="select Distinct(student_id) from ex_student_paper where exam_no='".$data_stud['examination_number']."' and student_id='".$data_stud['stud_login_id']."'  order by attempt_id desc";
                        
						$ptr_ques=mysql_query($sel_exam_ques);
						$total_questions=mysql_num_rows($ptr_ques);
						if($total_questions)
						{
							echo '<option value="'.$data_stud['stud_login_id'].'">'.stripslashes($data_stud['name']).' &nbsp;('.$data_stud['pass'].' )'.'</option>';
						}
					}
				}
				?>
                </select></td>
                        
                    </tr>
                    <?php }?>
                </table>
        
        
        </td></tr>
         <?php 
		  if($_GET['exam_no'])
		  {
		  ?>
          
          
          <tr>
          <td colspan="3" style="padding-bottom:30px">
          <div id="show_report"></div>
          </td></tr>
          
           <!--<tr>
                <td align="center" colspan="3">
                <?php
				//echo $_POST['student_id'];
				/*echo "
					<input class='input_btn' type='button' name='print' value='Print' title='View Invoice' border='0' 
					onclick=\"window.open('student_report_print.php?exam_no=".$_GET['exam_no']."&student_id=".$_POST['student_id']."','View Invoice','scrollbars=yes','resizable=yes','width=900,height=600')\" style='cursor:pointer' >
					
					";*/
				?>
        </tr>-->
          
           <?php } ?> 
           
          </form>
            
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
</body>
</html>
<?php $db->close();?>