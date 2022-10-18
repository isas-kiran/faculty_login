<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];

if(isset($_GET['course_id']))
$course_id = $_GET['course_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Batch Time Table</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
    <script type="text/javascript" src="../js/common.js"></script>
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
                if(confirm("Are you sure, you want to delete selected record(s)?"))
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
            //alert(value);
           // alert(value1);
            window.location.href=value+value1;
        }
        function validationToDelete(type)
        {
            if(confirm("Are you sure, you want to delete selected record(s)?"))
                return true;
            else
                return false;
        }
    </script>
</head>
<body>
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
    <td class="top_mid" valign="bottom"><?php include "include/student_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
		<?php
        $sql_query_std= "SELECT * FROM student_course_batch_map where 1 and enroll_id='".$record_id."' and course_id='".$course_id."' order by c_b_id asc"; 
        $ptr_query_std=mysql_query($sql_query_std);
        $no_of_std_records=mysql_num_rows($ptr_query_std);
        
        if($no_of_std_records)
        {
			$data_std_rec=mysql_fetch_array($ptr_query_std);
			
			$sql_query= "SELECT * FROM batch_timetable where 1 and c_b_id='".$data_std_rec['c_b_id']."' order by day asc"; 
			$ptr_query=mysql_query($sql_query);
			$no_of_records=mysql_num_rows($ptr_query);
			$bgColorCounter=1;
			
			$select_c_b_id = "select * from course_batch_mapping where c_b_id ='".$data_std_rec['c_b_id']."' ";
            $data_batch = $db->fetch_array($db->query($select_c_b_id));
            ?>
            <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
            <input type="hidden" name="formAction" id="formAction" value=""/>
            <table cellpadding="0" cellspacing="0" width="100%" border="0">  
				<tr>
                	<td height="5" align="right" style="padding:20px">
                    <?php
                    //echo "<img src='images/view.jpeg' title='View Invoice' border='0' onclick=\"window.open('logsheet-generate.php?record_id=".$record_id."','View Invoice','scrollbars=yes','resizable=yes','width=900,height=600')\" style='cursor:pointer' >";
                    ?>
                    <?php echo '<a href="excel_batch_timetable.php?record_id='.$record_id.'" ><img src="images/excel.png" width="30px" height="30px"></a>'; ?>
                    </td>
                </tr>
                <tr>
                	<td valign="top" align="center">
                    	<table width="95%" height="50" align="center" class="table">
                        <?php
                        $select_enroll = " select enroll_id,course_id,name,added_date,installment_display_id from enrollment where enroll_id='".$record_id."' ";
                        $ptr_enroll=mysql_query($select_enroll);
                        $data_enroll = mysql_fetch_array($ptr_enroll);
						
                        $select_course = " select course_id,course_name from courses where course_id='".$course_id."' ";
                        $ptr_course=mysql_query($select_course);
                        $data_course = mysql_fetch_array($ptr_course);
						
						$select_course_enroll = " select course_id,course_name from courses where course_id='".$data_enroll['course_id']."' ";
                        $ptr_course_enroll=mysql_query($select_course_enroll);
                        $data_course_enroll = mysql_fetch_array($ptr_course_enroll);
						
						$select_staff= "selectname from site_setting where admin_id='".$data_batch['staff_id']."' ";
                        $ptr_staff=mysql_query($select_staff);
                        $data_staff= mysql_fetch_array($ptr_staff);
						
                        /*$select_topic_id = " select COUNT(topic_id) as total_topic from topic_map where course_id='".$data_enroll['course_id']."' ";
                        $total_topic=mysql_fetch_object($select_topic_id);
                        echo $total_topic->total_topic;*/
						/*$q = mysql_query(" select topic_id from topic_map where course_id='".$data_enroll['course_id']."' ");
						$c = mysql_num_rows($q);
						echo '<input type="hidden" name="total_topic" value="'.$c.'"/>';*/
						?>
                            <tr><th colspan="3" height="5"><?php echo strtoupper($data_course['course_name']); ?> LOGSHEET</th></tr>
                            <tr style="padding-left:10px">
                                <td><strong>Student Name :&nbsp;&nbsp;&nbsp;</strong><?php echo $data_enroll['name']; ?></td>
                                <td><strong>Course Name :&nbsp;&nbsp;&nbsp;</strong><?php echo $data_course_enroll['course_name']; ?><input type="hidden" name="course_id" value="<?php echo $data_course['course_id']?>" /></td>
                                <td><strong>Batch ID :&nbsp;&nbsp;&nbsp;</strong><? echo $data_batch['batch_name']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Admission Date :&nbsp;&nbsp;&nbsp;</strong><? echo $data_enroll['added_date']; ?></td>
                                <td><strong>Enrollment ID :&nbsp;&nbsp;&nbsp;</strong><? echo $data_enroll['installment_display_id']; ?></td>
                                <td><strong>Batch Start Date :&nbsp;&nbsp;&nbsp;</strong><? echo $data_batch['start_date']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Faculty Name :&nbsp;&nbsp;&nbsp;</strong><? echo $data_staff['name']; ?></td>
                                <td><strong>Vatch Category :&nbsp;&nbsp;&nbsp;</strong><? echo $data_batch['batch_category']; ?></td>
                                <td><strong>Batch End Date :&nbsp;&nbsp;&nbsp;</strong><? echo $data_batch['end_date']; ?></td>
                            </tr>
                       	</table>
                    </td>
                </tr>
                <tr>
                	<td valign="top" >
                    	<table width="98%" align="center"  cellpadding="0" cellspacing="1"  class="table" style="width: 97%;">
                        	<tr class="grey_td" >
                            	<td width="4%" class="tr-header" align="center"><strong>Sr No.</strong></td>
                            	<td width="8%" class="tr-header" align="center"><strong>Days</strong></td>
                            	<td width="8%" class="tr-header" align="center"><strong>Dates</strong></td>
                            	<td width="15%" class="tr-header" align="center"><strong>Topic Name</strong></td>
                            	<td width="25%" class="tr-header" align="center"><strong>Topic Content</strong></td>
                                <td width="10%" class="tr-header" align="center"><strong>Attendence</strong></td>
                                <td width="10%" class="tr-header" align="center"><strong>Latemark</strong></td>
                                <td width="10%" class="tr-header" align="center"><strong>Uniform absence</strong></td>
                                <td width="10%" class="tr-header" align="center"><strong>Mobile not submited</strong></td>
                            	<td width="10%" class="tr-header" align="center"><strong>Model Required</strong></td>
                            	<?php
                           		/*if($_SESSION['type'] =='S')
                            	{	
                           			?>
                            		<td width="5%" class="centerAlign"><strong>Action</strong></td>
                                	<?php
                            	}*/
                            	?>
                          	</tr>
                            <?php
							$day=1;
                            while($val_query=mysql_fetch_array($ptr_query))
                            {
                                $name = '';
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                

                                $listed_record_id=$val_query['batch_timetable_map_id']; 
								
								$batch_id= $data_batch['c_b_id'];
								
								$select_topic = "select topic_name from topic where topic_id = '".$val_query['topic_id']."' ";          
                                $val_topic= $db->fetch_array($db->query($select_topic));
								
								$select_att = "select * from student_attendence where enroll_id ='".$record_id."' and course_batch_id='".$val_query['c_b_id']."' and DATE(attendence_date)='".$val_query['date']."' ";
								$ptr_att=mysql_query($select_att);
                                $val_attendence= mysql_fetch_array($ptr_att);
								
                                include "include/paging_script.php";
                                echo '<td align="center">'.$bgColorCounter.'</td>';   
								echo '<td align="center">'.$val_query['day'].'</td>';
								$exp=explode('-',$val_query['date']);
								$new_date=$exp[2]."/".$exp[1]."/".$exp[0];
								echo '<td align="center">'.$new_date.'</td>';
								echo '<td align="center">'.$val_topic['topic_name'].'</td>';
                                echo '<td align="center">'.stripslashes($val_query['topic_content']).'</td>';
								if($val_attendence['attendence']=='absent')
								{
									$class='style="color:red;font-weight:600"';
								}
								else if($val_attendence['attendence']=='present')
								{
									$class='style="color:green;font-weight:600"';
								}
								
								if($val_attendence['latemark']=='no')
								{
									$imgClass='<img src="images/inactive_icon.png">';
								}
								else
									$imgClass='';
								
								if($val_attendence['uniform']=='no')
								{
									$uniClass='<img src="images/inactive_icon.png">';
								}
								else
									$uniClass='';
									
								if($val_attendence['mobile_submit']=='no')
								{
									$mobClass='<img src="images/inactive_icon.png">';
								}
								else
									$mobClass='';
									
								echo '<td align="center" '.$class.'>'.strtoupper($val_attendence['attendence']).'</td>';
								echo '<td align="center" >'.$imgClass.'</td>';
								echo '<td align="center" >'.$uniClass.'</td>';
								echo '<td align="center" >'.$mobClass.'</td>';
                                echo '<td align="center">'.$val_query['model_required'].'</td>';
                                
                               	/*if( $_SESSION['type'] =='S')
								{
                                	echo '<td align="center">';
									echo '<a href="add_batch.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
                                	echo '</td>';
								}*/
                                echo '</tr>';                                
                                $bgColorCounter++;
								$day++;
                            }
                            ?>
                        </table>
                    </td>
                </tr>
                <tr>
                	<td height="10"></td>
                </tr>  
            </table>
        	</form><?php
		} 
		else
			echo '<tr><td class="text" align="center" colspan="5"><br><div class="msgbox" style="width:50%;">No Logsheet Found for this Student, Please add this student in batch</div><br></td></tr>';?>
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
<?php include "include/footer.php"; ?>
</div>
<!--footer end-->
</body>
</html>