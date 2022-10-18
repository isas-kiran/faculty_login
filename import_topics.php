<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Import</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
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
    <td class="top_mid" valign="bottom"><?php include "include/course_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
       
           

<?php
if(isset($_POST['import_excel']))
{
	$domain_id=$_POST['domain_id'];
		
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
					for($i=3;$i<=$data->sheets[0]['numRows'];$i++)
					{										
						"<br />Topic No:".$topic_no=$data->sheets[0]['cells'][$i][1];
						"<br />Topic_name:".$topic_name=$data->sheets[0]['cells'][$i][2];
						"<br />Topic_name:".$model=$data->sheets[0]['cells'][$i][3];
						/*"<br />course_duration:".$course_duration=$data->sheets[0]['cells'][$i][4];
						"<br />course_description:". $course_description=$data->sheets[0]['cells'][$i][5];
						"<br />course_fees:".$course_fees=$data->sheets[0]['cells'][$i][6];
						"<br />subject_name:".$subject_name=$data->sheets[0]['cells'][$i][7];
						"<br />topic_name:".$topic_name=$data->sheets[0]['cells'][$i][8];
						"<br />topic_duration:". $topic_duration=$data->sheets[0]['cells'][$i][9];
						"<br />topic_description:". $topic_description=$data->sheets[0]['cells'][$i][10];*/
						//echo "<br />". $no2=$data->sheets[0]['cells'][$i][6];
					   
						
                        /*=====================================Check Existing Courses=========================================*/
						if($topic_name!='')
						{
							$insert_topic= "insert into topic (`course_domain_id`,`topic_name`,`duration`,`description`,`model_required`,`added_date`,`admin_id`,`cm_id`) values ('".$domain_id."','".trim(addslashes($data->sheets[0]['cells'][$i][2]))."','0','','".$model."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."','0')  ";
							$ptr_topic= mysql_query($insert_topic);
							$topic_id=mysql_insert_id();
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
    	<td width="30%" class="customized_select_box">Select Topic</td>
		<td width="60%" class="customized_select_box">  
			<select name="domain_id" id="domain_id" class="validate[required] input_select" style="width:400px" >  
            <option value="">Select Domain Name </option>
            <?php
            $select_category = "select * from course_domain_category order by cat_id asc";
            $ptr_category = mysql_query($select_category);
            while($data_category = mysql_fetch_array($ptr_category))
            {
                $sel='';
                if($data_category['cat_id'] == $row_record['course_domain_id'])
                {
                    $sel='selected="selected"';
                }
                echo '<option value='.$data_category['cat_id'].' '.$sel.'>'.$data_category['cat_name'].'</option>';
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