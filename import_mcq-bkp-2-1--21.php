<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Import MCQ</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link rel="stylesheet" href="js/chosen.css" />
<script src="js/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
var pageName = "manage_product";
$(document).ready(function()
{   
	$("#subject_id").chosen({allow_single_deselect:true});
	$("#unit_id").chosen({allow_single_deselect:true});
});
</script>
<script>
function select_topic(topic)
{
	var data1="subject_id="+topic;	
	// alert(data1);
	$.ajax({
	url: "ex_show_topic.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		//alert(html);
		if(html !='')
		{
			//sep=html.split("###");
			document.getElementById("unit_ids").innerHTML=html;
			$("#unit_id").chosen({allow_single_deselect:true});
		}
	},
       error:function(exception){alert('Exception:'+exception);}
	});

}
function select_subject(topic_id)
{
	//alert(topic_id);
	var data1="topic_id="+topic_id;	
	//alert(data1);
	$.ajax({
	url: "ex_show_subject.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		//alert(html);
		if(html !='')
		{
			document.getElementById("sub_id").innerHTML=html;
		}
		$("#subject_id").chosen({allow_single_deselect:true});
	},
       error:function(exception){alert('Exception:'+exception);}
	});

}
</script>
</head>
<body>
<?php include "include/header.php";?>
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
<?php
if(isset($_POST['import_excel']))
{
	$subject_id=$_POST['subject_id'];
	$unit_id=$_POST['unit_id'];
	
    require_once 'Excel/reader.php';
    $filename = basename($_FILES['excel_file']['name']);
    move_uploaded_file($_FILES['excel_file']['tmp_name'],"excel_files/$filename");
   
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$path="excel_files/$filename";
	$data->read("excel_files/$filename");
                   
	echo "Total Sheets in this xls file: ".count($data->sheets)."<br /><br />";
	$html="<table border='1'>";
	for($i=0;$i<1;$i++) // Loop to get all sheets in a file.
	{   
					
		if(count($data->sheets[$i][cells])>0) // checking sheet not empty
		{
			echo "Sheet $i:<br /><br />Total rows in sheet $i  ".count($data->sheets[$i][cells])."<br />";
			for($j=1;$j<=count($data->sheets[$i][cells]);$j++) // loop used to get each row of the sheet
			{
				$html.="<tr>";
				//echo count($data->sheets[$i][cells][$j]);
				for($k=1;$k<=count($data->sheets[$i][cells][$j]);$k++) // This loop is created to get data in a table format.
				{
					$html.="<td>";
					$html.='R=>'.$j.'C=>'.$k.' .. '. $data->sheets[$i][cells][$j][$k];
					$html.="</td>";
					$g=1;
					$main_question='';
					for($i=3;$i<=$data->sheets[0]['numRows'];$i++)
					{										
						"<br />Ques No:".$topic_no=$data->sheets[0]['cells'][$i][1];
						"<br />Ques Name:".$ques_name=$data->sheets[0]['cells'][$i][2];
						"<br />Option 1:".$option1=$data->sheets[0]['cells'][$i][3];
						"<br />Option 2:".$option2=$data->sheets[0]['cells'][$i][4];
						"<br />Option 3:".$option3=$data->sheets[0]['cells'][$i][5];
						"<br />Option 4:".$option4=$data->sheets[0]['cells'][$i][6];
						/*"<br />subject_name:".$subject_name=$data->sheets[0]['cells'][$i][7];
						"<br />topic_name:".$topic_name=$data->sheets[0]['cells'][$i][8];
						"<br />topic_duration:". $topic_duration=$data->sheets[0]['cells'][$i][9];
						"<br />topic_description:". $topic_description=$data->sheets[0]['cells'][$i][10];*/
						//echo "<br />". $no2=$data->sheets[0]['cells'][$i][6];
					   /*=====================================Check Existing Courses=========================================*/
						if($ques_name!='')
						{
							$insert_query_extra = "insert into ex_question (`admin_id`,`unit_id`,`subject_id`,`language_id`,`question_title`,`main_question_id`,`added_date`) values ('".$_SESSION['admin_id']."','".$_POST['unit_id']."','".$_POST['subject_id']."','1','".addslashes(mysql_real_escape_string($ques_name))."','".$main_question."','".date('Y-m-d H:i:s')."')";
							$ptr_question=mysql_query($insert_query_extra);
							$ques_id=mysql_insert_id();
							
							if($i==3)
							{
								$main_question=$ques_id;
							}
							$update_query = "update ex_question set  main_question_id = '".$main_question."' where question_id='".$ques_id."' ";
                            $ptri_upd = mysql_query($update_query);
							for($t=1;$t<=4;$t++)
							{
								$ans='';
								if($t==2)
								{
									$ans='y';
								}
								$ts=$t+2;
								$insert_options_extra = "insert into ex_options (`admin_id`,`question_id`,`opt_ids`,`option_title`,`right_opt_id`,`answer`) values('".$_SESSION['admin_id']."','".$ques_id."','".$t."','".addslashes(mysql_real_escape_string($data->sheets[0]['cells'][$i][$ts]))."','2','".$ans."')";
                            	$pts_option_extra = mysql_query($insert_options_extra);
							}
						}
						/*==========================================End Course================================================*/		
						$html.="</tr>";
					}//for loop for total numrows
				}//End loop - to get data in a table format.
			}//loop used to get each row of the sheet
		}//checking sheet not empty
	}//Loop To Get To all Sheet- echo $html;
	$html="</table>";
}                   

?>
<form method="post" enctype="multipart/form-data">
	<table align="center" style="margin-top:80px;">
    <tr>
    	<td width="30%" class="customized_select_box">Select Subject</td>
		<td width="60%" class="customized_select_box" id="sub_id">  
			<select id="subject_id" name="subject_id" class="input_select" onchange="select_topic(this.value)" style="width:200px">
            <option value="">Select Subject</option>
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
					<option value="<?php echo $data_category['subject_id']?>" ><?php echo $data_category['name'] ?></option>
            	    <?php 
            	}
            	echo "</optgroup>";
			}?>
            </select>
		</td>
	</tr>
    <tr>
    <td width="30%">Select Topic</td>
    <td align="left" width="60%" id="unit_ids">
		<select id="unit_id" name="unit_id" class="input_select" style="width:200px" onchange="select_subject(this.value)" >
			<option value="">Select Topics</option>
			<?php 
			$sele_init_name="select topic_id,subject_id,course_domain_id from topic_map ";
			$ptr_unit=mysql_query($sele_init_name);
			while($fetch_name=mysql_fetch_array($ptr_unit))
			{
				$sel_topic="select topic_name,topic_id from topic where topic_id='".$fetch_name['topic_id']."'";
				$ptr_topic=mysql_query($sel_topic);
				$data_topic=mysql_fetch_array($ptr_topic);
				
				$sel_sub="select name from subject where subject_id='".$fetch_name['subject_id']."'";
				$ptr_sub=mysql_query($sel_sub);
				$data_sub=mysql_fetch_array($ptr_sub);
				
				$sel_domain="select cat_name from course_domain_category where cat_id='".$fetch_name['course_domain_id']."'";
				$ptr_domain=mysql_query($sel_domain);
				$data_domain=mysql_fetch_array($ptr_domain);
				?>
				<option value ="<?php echo $data_topic['topic_id'] ?>" > <?php echo $data_topic['topic_name'].' ('.$data_sub['name'].')'.'('.$data_domain['cat_name'].')'  ?> </option>
				<?php
			}
			?>
		</select>
	</td>
    </tr>
    <tr>
        <td><b>Import excel file</b> </td>
        <td>
		<?php
        echo '<input type="file" name="excel_file" id="excel_file" class=" input_text"></td>';
        ?>
        </td>
	</tr>
	<tr>
    	<td></td>
    	<td><input type="submit" name="import_excel" value="save" /></td>
	</tr>
</table>
</form>
            
<!-- <table align="center" border="1" >
<tr><td colspan="3"><h2>Download Formats: </h2></td></tr>
<tr><td><a href="import-course-format.xls"><u>DownLoad Excel</u></a></td></tr>
</table> -->          
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
 <div id="footer" style="margin-top:300px;"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>