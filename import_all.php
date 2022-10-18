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
	$branch_name=$_POST['branch_name'];
	if($_SESSION['type']=='S')
	{
		$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
		$ptr_branch=mysql_query($sel_branch);
		$data_branch=mysql_fetch_array($ptr_branch);
		$cm_id=$data_branch['cm_id'];
		
	}	
	else
	{
		$branch_name1=$_SESSION['branch_name'];
		$cm_id=$_SESSION['cm_id'];
	}
	
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
										
										
                                       
                                 		 "<br />course_category:".$course_category=$data->sheets[0]['cells'][$i][2];
                                         "<br />course_name:".$course_name=$data->sheets[0]['cells'][$i][3];
                                       	 "<br />course_duration:".$course_duration=$data->sheets[0]['cells'][$i][4];
                                       	 "<br />course_description:". $course_description=$data->sheets[0]['cells'][$i][5];
										 "<br />course_fees:".$course_fees=$data->sheets[0]['cells'][$i][6];
                                       	 "<br />subject_name:".$subject_name=$data->sheets[0]['cells'][$i][7];
                                       	 "<br />topic_name:".$topic_name=$data->sheets[0]['cells'][$i][8];
                                       	 "<br />topic_duration:". $topic_duration=$data->sheets[0]['cells'][$i][9];
										 "<br />topic_description:". $topic_description=$data->sheets[0]['cells'][$i][10];
                                       	//echo "<br />". $no2=$data->sheets[0]['cells'][$i][6];
                                       
                                     $cat_id='';  
									 $course_id='';$course_id1='';
									 $subject_id='';$subject_id1='';$subject_id12='';
									 $topic_id='';$topic_id1='';$topic_id2='';$topic_id22='';
                                /*=====================================Check Existing Courses=========================================*/
								
								"<br/>".$select_cours_cat= "select category_id,category_name from course_category where category_name='".trim($data->sheets[0]['cells'][$i][2])."' ".$_SESSION['where']." ";
                                $ptr_cours_cat= mysql_query($select_cours_cat);
								if(mysql_num_rows($ptr_cours_cat) =='' || mysql_num_rows($ptr_cours_cat) ==0)
								{
									if(trim($data->sheets[0]['cells'][$i][2]) !='')
									{
										"<br/>".$insert_cours_cat= "insert into course_category (`category_name`,`admin_id`,`cm_id`) values ('".trim($data->sheets[0]['cells'][$i][2])."','".$_SESSION['admin_id']."','".$cm_id."')  ";
                                		$ptr_cat= mysql_query($insert_cours_cat);
										$cat_id=mysql_insert_id();
										
										$insert_courses= "insert into courses (`category_id`,`course_name`,`course_duration`,`course_description`,`course_price`,`added_date`,admin_id,cm_id) values ('".$cat_id."','".trim($data->sheets[0]['cells'][$i][3])."','".trim($data->sheets[0]['cells'][$i][4])."','".trim($data->sheets[0]['cells'][$i][5])."','".trim($data->sheets[0]['cells'][$i][6])."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."','".$cm_id."')";
                                		$ptr_courses= mysql_query($insert_courses);
										$course_id=mysql_insert_id();
										
										$insert_subject= "insert into subject (`course_id`,`name`,`added_date`,`admin_id`,`cm_id`) values ('".$course_id."','".trim($data->sheets[0]['cells'][$i][7])."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."','".$cm_id."')  ";
                                		$ptr_subject= mysql_query($insert_subject);
										$subject_id=mysql_insert_id();
										
										$insert_topic= "insert into topic (`subject_id`,`topic_name`,`duration`,`description`,`added_date`,`admin_id`,`cm_id`) values ('".$subject_id."','".trim($data->sheets[0]['cells'][$i][8])."','".trim($data->sheets[0]['cells'][$i][9])."','".trim($data->sheets[0]['cells'][$i][10])."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."','".$cm_id."')  ";
                                		$ptr_topic= mysql_query($insert_topic);
										$topic_id=mysql_insert_id();
										
										$insert_topic_map= "insert into topic_map (`topic_id`,`subject_id`,`course_id`,`added_date`,`admin_id`,`cm_id`) values ('".$topic_id."','".$subject_id."','".$course_id."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."','".$cm_id."')  ";
                                		$ptr_topic_map= mysql_query($insert_topic_map);
										
									}
								}
								else
								{
									$data_cours_cat=mysql_fetch_array($ptr_cours_cat);
									$select_cours1= "select course_id,course_name from courses where course_name='".trim($data->sheets[0]['cells'][$i][3])."' and category_id='".$data_cours_cat['category_id']."' ".$_SESSION['where']." ";
									$ptr_cours1t= mysql_query($select_cours1);
									if(mysql_num_rows($ptr_cours1t) =='' || mysql_num_rows($ptr_cours1t) ==0)
									{
										$insert_courses1= "insert into courses (`category_id`,`course_name`,`course_duration`,`course_description`,`course_price`,`added_date`,admin_id,cm_id) values ('".$data_cours_cat['category_id']."','".trim($data->sheets[0]['cells'][$i][3])."','".trim($data->sheets[0]['cells'][$i][4])."','".trim($data->sheets[0]['cells'][$i][5])."','".trim($data->sheets[0]['cells'][$i][6])."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."','".$cm_id."')  ";
										$ptr_courses1= mysql_query($insert_courses1);
										$course_id1=mysql_insert_id();
										
										$insert_subject1= "insert into subject (`course_id`,`name`,`added_date`,`admin_id`,`cm_id`) values ('".$course_id1."','".trim($data->sheets[0]['cells'][$i][7])."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."','".$cm_id."')  ";
                                		$ptr_subject1= mysql_query($insert_subject1);
										$subject_id1=mysql_insert_id();
										
										$insert_topic1= "insert into topic (`subject_id`,`topic_name`,`duration`,`description`,`added_date`,`admin_id`,`cm_id`) values ('".$subject_id1."','".trim($data->sheets[0]['cells'][$i][8])."','".trim($data->sheets[0]['cells'][$i][9])."','".trim($data->sheets[0]['cells'][$i][10])."','".date('Y-m-d H:i:s')."','".$cm_id."')  ";
                                		$ptr_topic1= mysql_query($insert_topic1);
										$topic_id1=mysql_insert_id();
										
										$insert_topic_map1= "insert into topic_map (`topic_id`,`subject_id`,`course_id`,added_date,admin_id,cm_id) values ('".$topic_id1."','".$subject_id1."','".$course_id1."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."','".$cm_id."')  ";
                                		$ptr_topic_map1= mysql_query($insert_topic_map1);
									}
									else
									{
										$data_cours1=mysql_fetch_array($ptr_cours1t);
										$select_subject= "select subject_id,name from subject where name='".trim($data->sheets[0]['cells'][$i][7])."' and course_id='".$data_cours1['course_id']."' ".$_SESSION['where']." ";
										$ptr_subject= mysql_query($select_subject);
										if(mysql_num_rows($ptr_subject) =='' || mysql_num_rows($ptr_subject) ==0)
										{
											$insert_subject12= "insert into subject (`course_id`,`name`,`added_date`,`admin_id`,`cm_id`) values ('".$data_cours1['course_id']."','".trim($data->sheets[0]['cells'][$i][7])."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."','".$cm_id."')  ";
											$ptr_subject12= mysql_query($insert_subject12);
											$subject_id12=mysql_insert_id();
											
											$insert_topic2= "insert into topic (`subject_id`,`topic_name`,`duration`,`description`,`added_date`,`admin_id`,`cm_id`) values ('".$subject_id12."','".trim($data->sheets[0]['cells'][$i][8])."','".trim($data->sheets[0]['cells'][$i][9])."','".trim($data->sheets[0]['cells'][$i][10])."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."')  ";
											$ptr_topic2= mysql_query($insert_topic2);
											$topic_id2=mysql_insert_id();
											
											$insert_topic_map3= "insert into topic_map (`topic_id`,`subject_id`,`course_id`,`added_date`,`admin_id`,`cm_id`) values ('".$topic_id2."','".$subject_id12."','".$data_cours1['course_id']."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."','".$cm_id."')  ";
											$ptr_topic_map3= mysql_query($insert_topic_map3);
										}
										else
										{
											$data_subject=mysql_fetch_array($ptr_subject);
											$select_topic= "select topic_id,topic_name from topic where topic_name='".trim($data->sheets[0]['cells'][$i][8])."' and subject_id='".$data_subject['subject_id']."' ".$_SESSION['where']." ";
											$ptr_topic= mysql_query($select_topic);
											if(mysql_num_rows($ptr_topic) =='')
											{
												$insert_topic22= "insert into topic (`subject_id`,`topic_name`,`duration`,`description`,`added_date`,`admin_id`,`cm_id`) values ('".$data_subject['subject_id']."','".trim($data->sheets[0]['cells'][$i][8])."','".trim($data->sheets[0]['cells'][$i][9])."','".trim($data->sheets[0]['cells'][$i][10])."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."','".$cm_id."')  ";
												$ptr_topic22= mysql_query($insert_topic22);
												$topic_id22=mysql_insert_id();
												
												$insert_topic_map31= "insert into topic_map (`topic_id`,`subject_id`,`course_id`,added_date,admin_id,cm_id) values ('".$topic_id22."','".$data_subject['subject_id']."','".$data_cours1['course_id']."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."','".$cm_id."')  ";
												$ptr_topic_map31= mysql_query($insert_topic_map31);
											}
											else
											{
												//echo"<br />". "Allready exist-: '".trim($data->sheets[0]['cells'][$i][8])."' ";
											}
										}
										
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
<?php 
if($_SESSION['type']=='S')
{
	?>
	  <tr>
		<td>Select Branch</td>
		<td>
			<?php 
            if($_REQUEST['record_id'])
            {
                $sel_cm_id="select branch_name from site_setting where cm_id=".$row_record['cm_id']." ";
                $ptr_query=mysql_query($sel_cm_id);
                $data_branch_nmae=mysql_fetch_array($ptr_query);
            }
            $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
            $query_branch = mysql_query($sel_branch);
            $total_Branch = mysql_num_rows($query_branch);
            echo '<table width="100%"><tr><td>'; 
            echo ' <select id="branch_name" name="branch_name" >';
            while($row_branch = mysql_fetch_array($query_branch))
            {
                ?>
                <option value="<?php echo $row_branch['branch_name'];?>" <?php if ($_POST['branch_name'] ==$row_branch['branch_name']) echo 'selected="selected"'; else if($row_branch['branch_name']==$data_branch_nmae['branch_name']) echo 'selected="selected"' ?> /><?php echo $row_branch['branch_name']; ?> 
        
                </option>
                <?php
            }
            echo '</select>';
            echo "</td></tr></table>";
            ?>
		</td>
	</tr>
	<?php }  
	else { ?>
	   <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
	 <?php 
}?>
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
            
 <table align="center" border="1" >
<tr><td colspan="3"><h2>Download Formats: </h2></td></tr>
<tr><td><a href="import-course-format.xls"><u>DownLoad Excel</u></a></td></tr>



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
 <div id="footer" style="margin-top:300px;"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>