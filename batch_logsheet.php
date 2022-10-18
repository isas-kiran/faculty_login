<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Batch Logsheet</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>
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
    <!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script type="text/javascript">
       
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear',minDate: '-50Y',
        maxDate: '+2Y',});
           
            
//             $('input:radio[name=free_course][value=N]').click();
//             $('input:radio[name=discount_course][value=Y]').click();
//             $('input:radio[name=status][value=Inactive]').click();
        });
    </script>
    </head>
<body>
<?php include "include/header.php";?>

<div id="info"> 

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
    						if($_POST['save_changes'])
                        	{
							
								$action=$_POST['action'];
								$action1=$_POST['action1'];
								$course_id=$_POST['course_id'];
								echo $total_topics=$_POST['total_topic'];
								
								echo $select_enroll = " select logsheet_id from batch_logsheet where batch_id='".$record_id."' ";
								$ptr_enroll=mysql_query($select_enroll);
								if($my_query=mysql_num_rows($ptr_enroll))
								{
									$position='';
									for($i=1;$i<=$total_topics;$i++)
									{
										$student_date='';
										$faculty_date=''; 
										if($_POST['action_'.$i] !='')
										{
											$faculty_date=$_POST['faculty_sign_date_'.$i];
										}
										if($_POST['date'.$i] !='')
										{
											$date=$_POST['date'.$i];
										}
										$lab_date='';
										//echo $_POST['lab_date'.$i];
										if($_POST['lab_'.$i] !='select' )
										{
											$lab_date=$_POST['lab_date'.$i];
										}
										if($_POST['position'.$i] !='' )
										{
											$position=$_POST['position'.$i];
										}
										
										$update_query="update batch_logsheet set faculty_sign='".$_POST['action_'.$i]."',student_sign= '".$_POST['action1_'.$i]."',faculty_sign_date='".$faculty_date."',date='".$date."',lab='".$_POST['lab_'.$i]."' ,selected_topic_id = '".$_POST['chkRecords'.$i]."',stud_status='".$_POST['stud_status'.$i]."',lab_date='".$lab_date."',position='".$position."' where enroll_id='".$record_id."'  and topic_id='".$_POST['topic_id_'.$i]."'";
										$my_query_update=mysql_query($update_query);
									}
								}
								else
								{
									$position=='';
									for($i=1;$i<=$total_topics;$i++)
									{
										$student_date='';
										$faculty_date='';
										if($_POST['action_'.$i] !='')
										{
											$faculty_date=$_POST['faculty_sign_date_'.$i];
											
										}
										if($_POST['action1_'.$i] !='')
										{
											$student_date=$_POST['student_sign_date_'.$i];
										}
										$lab_date='';
										if($_POST['lab_'.$i] !='select')
										{
											$lab_date=$_POST['lab_date'.$i];
										}
										if($_POST['position'.$i] !='' )
										{
											$position=$_POST['position'.$i];
										}
										if($_POST['date'.$i] !='')
										{
											$date=$_POST['date'.$i];
										}
										
										echo "<br />".$insert_logsheet="insert into batch_logsheet (`enroll_id`,`course_id`,`topic_id`,`selected_topic_id`,`faculty_sign` ,`faculty_sign_date`, `date`,`lab`,`added_date`, `stud_status`,`lab_date`,`position`) values('$record_id','$course_id','".$_POST['topic_id_'.$i]."','".$_POST['chkRecords'.$i]."','".$_POST['action_'.$i]."','".$faculty_date."','".$date."','".$_POST['lab_'.$i]."','".date('Y-m-d H:i:s')."','".$_POST['stud_status'.$i]."','".$lab_date."','".$position."')";
										$ptr_query=mysql_query($insert_logsheet);
									}
								}
								?>
                                <script>
								//alert("Record Successfully Updated");
								</script>
								<?
                        	}
                         	?>    
                                <form method="get" name="jqueryForm" id="jqueryForm">
                                    <table align="center" border="0" width="75%"> 
                                <tr>
                                </tr>
                                </table>
                                </form>
                         
                      <?php
                       if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
                      {
                  $pre_from_date=" and date_format(added_date,'%Y-%m-%d')>='".date('Y-m-d',strtotime($_REQUEST['from_date']))."'";
                                    /*$sql_previos_total= "SELECT sum(amount) as credits FROM dd_user_payement where status='Active' and user_id='".$_SESSION['user_id']."' and debit_credit='Credit' and added_date<'".$_REQUEST['from_date']." 00:00:00'";
                                    $row_previos_total=$db->fetch_array($db->query($sql_previos_total));

                                    $sql_previos_total1= "SELECT sum(amount) as debits FROM dd_user_payement where status='Active' and user_id='".$_SESSION['user_id']."' and debit_credit='Debit' and added_date<'".$_REQUEST['from_date']." 00:00:00'";
                                    $row_previos_total1=$db->fetch_array($db->query($sql_previos_total1));
                                    $balance=$row_previos_total['credits']-$row_previos_total1['debits'];*/
                                }
                                else
                                {
                                    $balance=0;
                                    $pre_from_date="";                            
                                }
                                $sql_records= "SELECT batch_id,batch_name,added_date FROM batch where batch_id='".$record_id."'  ".$pre_keyword."  ".$_SESSION['where']." ".$select_directory."";
                                $no_of_records=mysql_num_rows($db->query($sql_records));
                                if($no_of_records)
                                {
                                    $bgColorCounter=1;
                                    if(!$_SESSION['showRecords'])
                                        $_SESSION['showRecords']=10;

                                    $query_string.="&show_records=".$showRecord;
                                    $pager = new PS_Pagination($sql_records,$_SESSION['show_records'],10,$query_string);
                                    $all_records= $pager->paginate();?>
                                    <form method="post" name="frmTakeAction">
                                    <table cellpadding="0" cellspacing="0" width="100%" border="0">
                                    <tr><td valign="middle" align="right">
                                            <table width="100%" cellpadding="0" callspacing="0" border="0">
                                                <tr>
                                                    <?php
                                                    if($no_of_records>10)
                                                    {
                                                        echo '<td width="3%" align="left">Show</td>
                                                        <td width="12%" align="left"><select class="inputSelect" name="show_records" onchange="redirect(this.value)">';

                                                        for($s=0;$s<count($show_records);$s++)
                                                        {
                                                            if($_SESSION['show_records']==$show_records[$s])
                                                                echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                            else
                                                                echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                        }
                                                        echo'</td></select>';
                                                    }
                                                    ?>
                                                   <!-- <td width="70%" align="right"><a href="javascript:void(0);" onClick="window.open('csvcompany_manage.php','win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=800,height=600,directories=no,location=no'); return false;" ><img src="images/csv.png" border="0"/></a>
    
    <img src='images/view.jpeg' title='View Invoice' border='0' 
	onclick="window.open('invoice-generate-company.php')" style='cursor:pointer' > 
    <img src='images/print1.jpeg'
								onclick="window.open('invoice-generate-company.php?action=print','View Invoice')" style='cursor:pointer'title='Print Invoice' border='0'>
                                            </td>-->
                                                    <td height="2" align="right"><?php echo $pager->renderFullNav();?></td>
                                                </tr>
                                            </table>
                                        </td></tr>
                                    <tr><td height="10" align="right">
                                    <?
                                    echo "
									<img src='images/view.jpeg' title='View Invoice' border='0' onclick=\"window.open('logsheet-generate.php?record_id=".$record_id."','View Invoice','scrollbars=yes','resizable=yes','width=900,height=600')\" style='cursor:pointer' >
										
										";
                                    ?>
                                    
                                    </td>
                                        </tr>
                                    <tr>
                                      <td valign="top"  align="center">
                                    <table width="990" height="50" align="center" class="table">
                                    <?php
									$val_record=mysql_fetch_array($all_records);
									
									 	$select_course_batch_mapping = "select c_b_id,start_date,end_date,start_time,end_time,no_of_student,status,course_id from course_batch_mapping where batch_id = '".$val_record['batch_id']."' ";                                         
										$val_course_batch = $db->fetch_array($db->query($select_course_batch_mapping));
										$c_b_id= $val_course_batch['c_b_id'];
										
										$select_course = "select course_name,course_id from courses where course_id = '".$val_course_batch['course_id']."' ";                                           
										$val_course= $db->fetch_array($db->query($select_course));
										
                                    	$select_enroll = " select enroll_id,course_id,name,added_date,installment_display_id from enrollment where enroll_id='".$record_id."' ";
									  	$ptr_enroll=mysql_query($select_enroll);
										$data_enroll = mysql_fetch_array($ptr_enroll);
										
										$select_course = " select course_id,course_name from courses where course_id='".$data_enroll['course_id']."' ";
									  	$ptr_course=mysql_query($select_course);
										$data_course = mysql_fetch_array($ptr_course);
										
										
										
										$q = mysql_query(" select topic_id from topic_map where course_id='".$data_enroll['course_id']."' ");
										$c = mysql_num_rows($q);
										
										echo '<input type="hidden" name="total_topic" value="'.$c.'"/>';
										?>
                                        <tr><th colspan="2"><? echo strtoupper($data_course['course_name']); ?>BATCH LOGSHEET</th></tr>
                                    	<tr style="padding-left:10px">
                                        	<td width="146"><strong>Batch Name :&nbsp;&nbsp;&nbsp;</strong><? echo $val_record['batch_name']; ?></td>
                                           
                                            <td width="141"><strong>Course Name :&nbsp;&nbsp;&nbsp;</strong><? echo $val_course['course_name']; ?><input type="hidden" name="course_id" value="<? echo $val_course['course_id']?>" /></td>
                                        </tr>
                                        <!--<tr>
                                        	<td><strong>Admission Date :&nbsp;&nbsp;&nbsp;</strong><? echo $data_enroll['added_date']; ?></td>
                                            <td><strong>Enrollment ID :&nbsp;&nbsp;&nbsp;</strong><? echo $data_enroll['installment_display_id']; ?></td>
                                            
                                        </tr>-->
                                    </table>
                                    
                                    </td></tr>
                                    
                                    <tr><td valign="top" >
                                    <? ?>
                                       <table width="98%" align="center"  cellpadding="0" cellspacing="1"  class="table" style="width: 97%;">
								<tr align="center" class="grey_td" >
                                <td width="6%" align="center" class="tr-header"><strong>Select Topic</strong><br /><!--<input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/>--></td>
                                    <td width="6%" class="tr-header"><strong>Sr No.</strong></td>
                                    <!--<td width="6%" class="tr-header"><strong>Position</strong></td>-->
                                    <!--<td width="8%" class="tr-header"><strong>Week 1 Date</strong></td>-->
                                    <td width="17%" class="tr-header"><strong>Topic Name</strong></td>
                                    <td width="8%"  class="tr-header"><strong>Date</strong></td>
                                   
                                    <td width="12%" class="tr-header"><strong>Faculty Sign</strong></td>
                                    <!--<td width="12%" class="tr-header"><strong>Student Sign</strong></td>-->
                                    <td width="12%" class="tr-header"><strong>Lab</strong></td>
                                </tr><?php
									$j=1;
                                    
                                    
										
										$select_topic_id = " select topic_id from topic_map where course_id='".$val_course['course_id']."' ";
									  	$ptr_topic_id=mysql_query($select_topic_id);
										while($data_topic_id = mysql_fetch_array($ptr_topic_id))
										{
										
										$select_topic_name = " select topic_id,topic_name,duration from topic where topic_id='".$data_topic_id['topic_id']."' ";
									  	$ptr_topic_name=mysql_query($select_topic_name);
										$data_topic_name = mysql_fetch_array($ptr_topic_name);
										
										$sel_logsheet="select * from batch_logsheet where batch_id='".$record_id."' and topic_id='".$data_topic_id['topic_id']."' order by position asc";
										$ptr_logsheet=mysql_query($sel_logsheet);
										$data_logsheet=mysql_fetch_array($ptr_logsheet);
										
										$listed_record_id = $data_topic_id['topic_id'];
										
										if($bgColorCounter%2==0)
                                    		$bgcolor='class="grey_td"';
                                		else
                                    		$bgcolor=""; 
										 $enroll_id=$val_record['enroll_id'];
										 $paid_totas=0;
                                        /*if($bgColorCounter%2==0)
                                            $bgclass="tr-sub_white1";
                                        else
                                            $bgclass="tr-sub1";*/
                                        include "include/paging_script.php";
										$checked='';
										if($data_logsheet['selected_topic_id'] !=0)
										{
											$checked='checked="checked"';
										}
                                        echo '<tr class="'.$bgclass.'">
										<td align="center"><input type="checkbox" '.$checked.' name="chkRecords'.$j.'" value="'.$listed_record_id.'"></td>';
                                        echo '<td align="center">'.$sr_no.'</td>';
										/*echo '<td align="center"><input type="text" size="5" name="position'.$j.'" id="position'.$j.'" value="'.$data_logsheet['position'].'"/></td>';*/
										/*echo '<td align="center">'.$data_topic_name['addded_date'].'</td>'; */
										echo '<td align="center">'.$data_topic_name['topic_name'].'<input type="hidden" name="topic_id_'.$j.'" value="'.$data_topic_name['topic_id'].'"></td>'; 
										echo '<td align="center"><input type="text" name="date'.$j.'" id="date'.$j.'" class="datepicker"></td>';
										
										if($data_logsheet['faculty_sign']=='completed')
										{
										 echo '<td align="center">';
										 echo'<img src="images/active_icon.png" width="30px" height="30px"><input type="hidden" id="action11" name="action_'.$j.'" value="completed" />
										 <input type="hidden" name=" faculty_sign_date_'.$j.'" value="'.$data_logsheet['faculty_sign_date'].'">';
                                         echo '</td>';
										}
										else
										{
											
											 echo '<td align="center">';
											 echo '<input type="checkbox" id="action11" name="action_'.$j.'" value="completed" />';
											 ?>
											 <input type="hidden" name=" faculty_sign_date_<?php echo $j ?>" value="<?php echo date('Y-m-d H:i:s') ?>">
                                             <?php
											 echo '</td>';
										}
										
										/*if($data_logsheet['student_sign']=='completed')
										{
										 echo '<td align="center">';
										 echo'<img src="images/active_icon.png" width="30px" height="30px"><input type="hidden" id="action11" name="action1_'.$j.'" value="completed" />
										 <input type="hidden" name="student_sign_date_'.$j.'" value="'.$data_logsheet['student_sign_date'].'">';
                                         echo '</td>';
										}
										else
										{
											echo '<td align="center">';
											?><input type="radio" checked="checked" name="stud_status<?php echo $j ; ?>" value="present" <?php if($data_logsheet['stud_status'.$i] =="present") echo 'checked="checked"' ;?>>Present<input type="radio" name="stud_status<?php echo $j ; ?>" value="absent" <?php if($data_logsheet['stud_status'.$i] =="absent") echo 'checked="checked"' ?>>Absent<br /><?php
											echo '<input type="checkbox" id="action11" name="action1_'.$j.'" value="completed" />';
											?>
											<input type="hidden" name="student_sign_date_<?php echo $j ?>" value="<?php echo date('Y-m-d H:i:s') ?>">
                                            
                                            <?php
											echo'</td>';
										}*/
										if($data_logsheet['lab_date']=='' || $data_logsheet['lab_date']=='0000-00-00')
										{
											echo '<input type="hidden" name="lab_date'.$j.'" value="'.date('Y-m-d').'">';
										}
										else
										{
											echo '<input type="hidden" name="lab_date'.$j.'" value="'.$data_logsheet['lab_date'].'">';
										}
										
										echo '<td align="center">';
										echo '<select name="lab_'.$j.'">';
										echo "<option value='select'>Select lab</option>";
										echo $sel_lab="select * from lab ".$_SESSION['where_cm_id']."";
										$ptr_lab=mysql_query($sel_lab);
										while($data_lab=mysql_fetch_array($ptr_lab))
										{
											if($_SESSION['type']="S")
											{
											$select_cm_id="select branch_name from site_setting where cm_id=".$data_lab['cm_id']." and type='A'";
											$ptr_cm_ic=mysql_query($select_cm_id);
											$data_cm_id=mysql_fetch_array($ptr_cm_ic);
											}
											else
											{
												$data_cm_id['branch_name']='';
											}
										?>
										<option value="<?php echo $data_lab['lab_id']; ?>"<?php if($data_logsheet["lab"] =="select") echo 'selected="selected"' ?> ><?php echo $data_lab['lab_name']." [".$data_cm_id['branch_name']."]"; ?></option>
                                        <?php
										}
										?>
										</select>
										<?php
                                        echo'</td>';
                                        echo '</tr>';
										
                                       $bgColorCounter++;
									   $j++;
									   $i--;
									
                                    }
                                 	
                                    ?>
                                     <table width="100%" align="center">
                                        	<tr  style="font-weight:bold; height:30px;">
                                    			<td align="right" colspan="3">
                                                <?php
												/*if($active_save=='yes')
												{ */
												?>
                                                <input type="submit" name="save_changes"  id="save_changes" value="Save"   /> 
                                                <?php //} ?>
                                                 </td>
                                                <td>
                                                <?
                                              echo "  <input type='button' name='print' value='Print' title='Print logsheet' onclick=\"window.open('logsheet-generate.php?record_id=".$record_id."&action=print','View Invoice','scrollbars=yes','resizable=yes','width=900,height=600')\" style='cursor:pointer' />"
											  ?>
                                                </td>
                                  			</tr>
                                        </table>
                                        </table>
                                    </td></tr>
                                    <tr><td height="10"></td></tr>
                                    <tr><td valign="middle" align="right">
                                            <table width="100%" cellpadding="0" callspacing="0" border="0">
                                                <tr>
                                                    <?php
                                                    if($no_of_records>10)
                                                    {
                                                        echo '<td width="3%" align="left">Show</td>
                                                        <td width="12%" align="left"><select class="inputSelect" name="show_records" onchange="redirect(this.value)">';

                                                        for($s=0;$s<count($show_records);$s++)
                                                        {
                                                            if($_SESSION['show_records']==$show_records[$s])
                                                                echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                            else
                                                                echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                        }
                                                        echo'</td></select>';
                                                    }
                                                    ?>
                                                    <td align="right"><?php echo $pager->renderFullNav();?></td>
                                                </tr>
                                            </table>
                                        </td></tr>
                                    </table>
                                    </form><?php
                                }
								
                                else if($_GET['search'])
                                    echo'<center><br><div id="alert" style="width:80%">Records not found related to your search criteria, please try again to get more results</div><br></center>';
                                else
                                    echo'<center><br><div id="alert" style="width:30%">No Payment history here</div><br></center>';
                            ?>
                            
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
                    <noscript>
                            Warning! JavaScript must be enabled for proper operation of the Administrator backend.				</noscript>
                 <div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>