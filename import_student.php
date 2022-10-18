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
    <td class="top_mid" valign="bottom"><?php include "include/student_menu.php"; ?></td>
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
                                    for($i=2;$i<=$data->sheets[0]['numRows'];$i++)
                                    {
										
										
                                       
                                 		 "<br />added_date:".$added_date=$data->sheets[0]['cells'][$i][2];
                                         "<br />name:".$name=$data->sheets[0]['cells'][$i][3];
                                       	 "<br />cm_id:".$cm_id=$data->sheets[0]['cells'][$i][4];
                                       	 "<br />contact:". $contact=$data->sheets[0]['cells'][$i][5];
										 "<br />mail:".$mail=$data->sheets[0]['cells'][$i][7];
                                       	 "<br />course_id:".$course_id=$data->sheets[0]['cells'][$i][8];
                                       	 "<br />installment_display_id:".$installment_display_id=$data->sheets[0]['cells'][$i][10];
                                       	 "<br />address:". $address=$data->sheets[0]['cells'][$i][11];
										 "<br />paid_type:". $paid_type=$data->sheets[0]['cells'][$i][12];
										 "<br />total_fees:". $total_fees=$data->sheets[0]['cells'][$i][13];
										 "<br />net_fees:". $net_fees=$data->sheets[0]['cells'][$i][13];
										 "<br />balance_amt:". $balance_amt=$data->sheets[0]['cells'][$i][20];
                                       	
										
										
										"<br />contact2:". $contact2=$data->sheets[0]['cells'][$i][6];
									   "<br />enroll_date:". $enroll_date=$data->sheets[0]['cells'][$i][9];
									  echo  "<br />date:". $date=$data->sheets[0]['cells'][$i][14];
									   "<br />cash:". $cash=$data->sheets[0]['cells'][$i][15];
									   "<br />check_amt:". $check_amt=$data->sheets[0]['cells'][$i][16];
									   "<br />check_no:". $check_no=$data->sheets[0]['cells'][$i][17];
									   "<br />certificate_issue_date:". $certificate_issue_date=$data->sheets[0]['cells'][$i][23];
									   "<br />enrollment_no:". $enrollment_no=$data->sheets[0]['cells'][$i][24];
									   "<br />certificate_name:". $certificate_name=$data->sheets[0]['cells'][$i][25];
									   "<br />grade:". $grade=$data->sheets[0]['cells'][$i][26];
									   "<br />certi_date_from_to:". $certi_date_from_to=$data->sheets[0]['cells'][$i][27];
									   
									   
									   
                                       
                                     
                                /*=====================================Check Existing Courses=========================================*/
								
							    $select_cours_id= "select course_id,course_name from courses where course_name like '%".trim($data->sheets[0]['cells'][$i][8])."%' ";
                                $ptr_cours_id= mysql_query($select_cours_id);
								$course_fetch_id=mysql_fetch_array($ptr_cours_id);
								
							 
								
								
								if($data->sheets[0]['cells'][$i][4]=='Pune')
								{
								  $cm_id='2';	
								}
								else
								{
								 	$cm_id='3';
								}
								
								$added_date = explode('.', $data->sheets[0]['cells'][$i][2]);
                                $new_added_date = $added_date[2].'-'.$added_date[1].'-'.$added_date[0];
								
								
								/*$name = explode(' ', $data->sheets[0]['cells'][$i][3]);
								echo'<br/>'. $firstname=$name[0];
								echo'<br/>'. $middlename=$name[1];
								echo'<br/>'. $lastname=$name[2];*/
								
								/*=====================================Check Existing inquiry=========================================*/	
								
								 $select_inquiry= "select firstname, mobile1 from inquiry where firstname like '%".trim($data->sheets[0]['cells'][$i][3])."%' and mobile1 like '%".trim($data->sheets[0]['cells'][$i][5])."%' ";
                                $ptr_inquiry= mysql_query($select_inquiry);
								if(mysql_num_rows($ptr_inquiry) =='' || mysql_num_rows($ptr_inquiry) ==0)

								{
								
								$insert_inquiry= "insert into inquiry (`firstname`,`address`,`mobile1`,`mobile2`,`email_id`,`course_interested`,`course_id`,`total_fees`,`added_date`,`cm_id`) values ('".trim($data->sheets[0]['cells'][$i][3])."','".trim($data->sheets[0]['cells'][$i][11])."','".trim($data->sheets[0]['cells'][$i][5])."','".trim($data->sheets[0]['cells'][$i][6])."','".trim($data->sheets[0]['cells'][$i][7])."','".trim($data->sheets[0]['cells'][$i][8])."','".$course_fetch_id['course_id']."','".trim($data->sheets[0]['cells'][$i][13])."','".$new_added_date."','".$cm_id."')  ";
                                		$ptr_inquiry= mysql_query($insert_inquiry);
										$inquiry_id=mysql_insert_id();
								}
										
										
										/*=====================================Check Existing students=========================================*/	
								
								 '<br>'. $select_student= "select name, contact from stud_regi where name like '%".trim($data->sheets[0]['cells'][$i][3])."%' and contact like '%".trim($data->sheets[0]['cells'][$i][5])."%' ";
                                $ptr_student= mysql_query($select_student);
								if(mysql_num_rows($ptr_student) =='' || mysql_num_rows($ptr_student) ==0)

								{
								 
										
										$insert_student_regi= "insert into stud_regi (`cm_id`,`name`,`address`,`contact`,`mail`,`added_date`) values ('".$cm_id."','".trim($data->sheets[0]['cells'][$i][3])."','".trim($data->sheets[0]['cells'][$i][11])."','".trim($data->sheets[0]['cells'][$i][5])."','".trim($data->sheets[0]['cells'][$i][7])."','".$new_added_date."')  ";
											$ptr_student_regi= mysql_query($insert_student_regi);
								            
								}
								$student_regi_id=mysql_insert_id();
								
								
								/*=====================================Check Existing enrollment=========================================*/	
								
								 '<br>'. $select_enrollment= "select name, contact, course_id from enrollment where name like '%".trim($data->sheets[0]['cells'][$i][3])."%' and contact like '%".trim($data->sheets[0]['cells'][$i][5])."%' ";
                                $ptr_enrollment= mysql_query($select_enrollment);
								if(mysql_num_rows($ptr_enrollment) =='' || mysql_num_rows($ptr_enrollment) ==0)

								{		

								 $insert_cours_cat= "insert into enrollment (`student_id`,`name`,`cm_id`,`contact`,`mail`,`course_id`,`installment_display_id`,`address`,`paid_type`,`total_fees`,`net_fees`,`balance_amt`,`added_date`, `old_student`) values ('".$student_regi_id."','".trim($data->sheets[0]['cells'][$i][3])."','".$cm_id."', '".trim($data->sheets[0]['cells'][$i][5])."', '".trim($data->sheets[0]['cells'][$i][7])."' ,'".$course_fetch_id['course_id']."','".trim($data->sheets[0]['cells'][$i][10])."','".trim($data->sheets[0]['cells'][$i][11])."','".trim($data->sheets[0]['cells'][$i][12])."','".trim($data->sheets[0]['cells'][$i][13])."','".trim($data->sheets[0]['cells'][$i][13])."','".trim($data->sheets[0]['cells'][$i][20])."','".$new_added_date."','Y')";
                                		$ptr_cat= mysql_query($insert_cours_cat);
										
								}
								$enroll_id=mysql_insert_id();
										
									 $enroll_date = explode('.', $data->sheets[0]['cells'][$i][9]);
                                     $new_enroll_date = $enroll_date[2].'-'.$enroll_date[1].'-'.$enroll_date[0];	
									 
									 $date = explode('/', $data->sheets[0]['cells'][$i][14]);
                                     $new_date1 = $date[2].'-'.$date[1].'-'.$date[0];
									 
									
									  $certificate_issue_date = explode('.', $data->sheets[0]['cells'][$i][23]);
									 
                                      $new_certificate_issue_date = $certificate_issue_date[2].'-'.$certificate_issue_date[1].'-'.$certificate_issue_date[0];
								
									 
									/*=====================================Check Existing other_info=========================================*/	
								
								 $select_other_info= "select enroll_id, contact from other_info where  enroll_id='".$enroll_id."' and contact like '%".trim($data->sheets[0]['cells'][$i][6])."%'   "; 
                                $ptr_other_info= mysql_query($select_other_info);
								if(!mysql_num_rows($ptr_other_info))

								{ 
                                  
										
										 $insert_other_info= "insert into other_info (`enroll_id`,`contact`,`enroll_date`,`date`,`cash`,`check_amt`,`check_no`,`certificate_issue_date`,`enrollment_no`,`certificate_name`,`grade`,`added_date` ) values ('".$enroll_id."', '".trim($data->sheets[0]['cells'][$i][6])."','".$new_enroll_date."', '".$new_date1."', '".trim($data->sheets[0]['cells'][$i][15])."' ,'".trim($data->sheets[0]['cells'][$i][16])."','".trim($data->sheets[0]['cells'][$i][17])."','".$new_certificate_issue_date."','".trim($data->sheets[0]['cells'][$i][24])."','".trim($data->sheets[0]['cells'][$i][25])."','".trim($data->sheets[0]['cells'][$i][26])."','".$new_added_date."')";
                                		$ptr_other_info= mysql_query($insert_other_info);
										
								}
										
									
									/*=====================================Check Existing certificate=========================================*/	
								
								 $select_certificate= "select student_id, enroll_id, course_id from certificate where student_id='".$student_regi_id."' and enroll_id='".$enroll_id."'  "; //and course_id='".$course_fetch_id['course_id']."'
                                $ptr_certificate= mysql_query($select_certificate);
								if(mysql_num_rows($ptr_certificate) =='' || mysql_num_rows($ptr_certificate) ==0)

								{	
									
										$insert_certificate= "insert into certificate (`student_id`,`enroll_id`,`course_id`,`certificate_issue_date`,`grade`,`certi_date_from_to`,`added_date` ) values ('".$student_regi_id."','".$enroll_id."','".$course_fetch_id['course_id']."','".$new_certificate_issue_date."','".trim($data->sheets[0]['cells'][$i][26])."','".trim($data->sheets[0]['cells'][$i][27])."', '".$new_added_date."')";
                                		$ptr_certificate= mysql_query($insert_certificate);
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
 <div id="footer" style="margin-top:300px;"><?php require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>