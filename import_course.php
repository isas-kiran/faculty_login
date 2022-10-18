<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Import</title>
<link href="../../safar-live/Admin/css/style.css" rel="stylesheet" type="text/css" />
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
                                       
                                      /* echo "<br />Subject:".$pm10=$data->sheets[0]['cells'][$i][2];
                                       echo "<br />Topic:".$pm2_5=$data->sheets[0]['cells'][$i][3];
                                       echo "<br />Duration:".$co=$data->sheets[0]['cells'][$i][4];
                                       echo "<br />Description:". $o3=$data->sheets[0]['cells'][$i][5];*/
                                       //echo "<br />". $no2=$data->sheets[0]['cells'][$i][6];
                                       
                                       
                                        //==========================$STAFF ID==================================================
                                $select_subject= "select subject_id,name from  subject where name='".trim($data->sheets[0]['cells'][$i][2])."'  ";
                                $ptr_subject= mysql_query($select_subject);
								$data_subject=mysql_fetch_array($ptr_subject);
								if(mysql_num_rows($ptr_subject) =='')
								{
									if(trim($data->sheets[0]['cells'][$i][2]) !='')
									{
									 $query="INSERT INTO subject(`name`,`admin_id`,`added_date`)
									 VALUES('".trim($data->sheets[0]['cells'][$i][2])."','". $_SESSION['admin_id']."','".date('Y-m-d H:i:s')."')";
									 $db->query($query);
									 $subject_id=mysql_insert_id();
									 
									 $query_topic="INSERT INTO topic(`subject_id`,`topic_name`,`duration`,`admin_id`,`added_date`)
									 VALUES('".$subject_id."','".trim($data->sheets[0]['cells'][$i][3])."','".trim($data->sheets[0]['cells'][$i][4])."','". $_SESSION['admin_id']."','".date('Y-m-d H:i:s')."')";
									 $db->query($query_topic);
									 
									 //echo "<br />Subject and Topic inserted Successfully";
									}
									
								}
								else
								{
									$sel_topic="SELECT `topic_id`, `topic_name` from `topic` where `subject_id`='".$data_subject['subject_id']."' and topic_name='".trim($data->sheets[0]['cells'][$i][3])." '";
									$my_topic=mysql_query($sel_topic);
									$row_topic=mysql_fetch_array($my_topic);
									if(mysql_num_rows($my_topic) =='')
									{
										if(trim($data->sheets[0]['cells'][$i][3]) !='')
										{
										 $query_topic_new="INSERT INTO topic(`subject_id`,`topic_name`,`duration`,`admin_id`,`added_date`)
										 VALUES('".$data_subject['subject_id']."','".trim($data->sheets[0]['cells'][$i][3])."','".trim($data->sheets[0]['cells'][$i][4])."','". $_SESSION['admin_id']."','".date('Y-m-d H:i:s')."')";
									 	$db->query($query_topic_new);
										}
										//echo"<br />Topic Inserted successfully";
									}
									else
									{
										echo "<br />Subject and topic allready exist ";
									}
									
								}
                                
								 $html.="</tr>";
                            }//subject
                        }
                    }
                   
                }
            }//echo $html;
                     $html="</table>";
}                   

?>


<form method="post" enctype="multipart/form-data">
<table align="center" style="margin-top:80px;">
<tr>
             <td><b>Import excel file</b> </td>
             <td>
            <?php
           
         
                echo '<input type="file" name="excel_file" id="excel_file" class=" input_text"></td>';
            ?>
             </td>
</tr>
            
<tr>
             <td>
             </td>
            
             <td><input type="submit" name="import_excel" value="save" /></td>
</tr>
             </table>
             </form>
            
           
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