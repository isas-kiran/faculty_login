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
<title>Todays Report</title>
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
    <!--End multiselect -->
     <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script type="text/javascript">
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear',dateFormat: 'dd-mm-yy'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
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
								 $action2=$_POST['action2'];
								 $action3=$_POST['action3'];
								 $action4=$_POST['action4'];
								 $course_id=$_POST['course_id'];
								 $total_student=$_POST['total_student'];
								 $enroll_id=$_POST['enroll_id'];
								
								
							     $select_enroll = "select report_id from todays_report";
								$ptr_enroll=mysql_query($select_enroll);
								if($total_studentss=mysql_num_rows($ptr_enroll))
								{
									//$course_id='';
									//echo "<br/>".$total_studentss;
									for($i=1;$i<=$total_student;$i++)
									{
										//$course_id='';
										//echo $course_id;
										//$student_date='';
										//$faculty_date=''; 
										if($_POST['action_'.$i] !='')
										{
											//$faculty_date=$_POST['faculty_sign_date_'.$i];
										}
										if($_POST['action1_'.$i] !='')
										{
											//$student_date=$_POST['student_sign_date_'.$i];
										}
										if($_POST['action2_'.$i] !='')
										{
											//$faculty_date=$_POST['faculty_sign_date_'.$i];
										}
										if($_POST['action3_'.$i] !='')
										{
											//$faculty_date=$_POST['faculty_sign_date_'.$i];
										}
										if($_POST['action4_'.$i] !='')
										{
											//$faculty_date=$_POST['faculty_sign_date_'.$i];
										}
										$repeat_date='';
										//echo $_POST['repeat_date'.$i];
										if($_POST['repeated_'.$i] !='No' )
										{
											$repeat_date=$_POST['repeat_date'.$i];
										}
										//if($_POST['position'.$i] !='' )
										//{
											//$position=$_POST['position'.$i];
										//}
										"<br/>".$course_id=$_POST['course_id_'.$i];
										 "<br />". $update_query="update todays_report set faculty_sign='".$_POST['action_'.$i]."',student_sign= '".$_POST['action1_'.$i]."',uniform='".$_POST['action2_'.$i]."',latemark='".$_POST['action3_'.$i]."',mobile_submit='".$_POST['action4_'.$i]."',repeated='".$_POST['repeated_'.$i]."' ,stud_status='".$_POST['stud_status'.$i]."' where enroll_id='".$_POST['enroll_id_'.$i]."' and course_id='".$course_id."'  ";
										$my_query_update=mysql_query($update_query);
									}
								}
								else
								{
									$course_id='';
									//echo $total_student;
									for($i=1;$i<=$total_student;$i++)
									{
										//$student_date='';
										//$faculty_date='';
										if($_POST['action_'.$i] !='')
										{
											//$faculty_date=$_POST['faculty_sign_date_'.$i];
											
										}
										if($_POST['action1_'.$i] !='')
										{
											//$student_date=$_POST['student_sign_date_'.$i];
										}
										if($_POST['action2_'.$i] !='')
										{
											//$student_date=$_POST['student_sign_date_'.$i];
										}
										if($_POST['action3_'.$i] !='')
										{
											//$student_date=$_POST['student_sign_date_'.$i];
										}
										if($_POST['action4_'.$i] !='')
										{
											//$student_date=$_POST['student_sign_date_'.$i];
										}
										$repeat_date='';
										if($_POST['repeated_'.$i] !='No')
										{
											//$repeat_date=$_POST['repeat_date'.$i];
										}
										//if($_POST['position'.$i] !='' )
										//{
										//	$position=$_POST['position'.$i];
										//}
										 "<br/>".$course_id=$_POST['course_id_'.$i];
										
										
										"<br />".$insert_logsheet="insert into todays_report (`enroll_id`,`course_id`,`faculty_sign` ,`student_sign` ,`uniform`,`latemark`,`mobile_submit`,`repeated`,`added_date`,`stud_status`) 
										values('".$_POST['enroll_id_'.$i]."','$course_id','".$_POST['action_'.$i]."','".$_POST['action1_'.$i]."','".$_POST['action2_'.$i]."','".$_POST['action3_'.$i]."','".$_POST['action4_'.$i]."','".$_POST['repeated_'.$i]."','".date('Y-m-d')."','".$_POST['stud_status'.$i]."')";
										
										$ptr_query=mysql_query($insert_logsheet);
									}
								}
								
								?>
                                <script>
								alert("Record Successfully Updated");
								</script>
								<?
                        	}
                                
                         	?>      
                                <form method="get" name="jqueryForm" id="jqueryForm">
                                    <table align="center" border="0" width="75%"> 
                                <tr>
                                <!--<td width="30%" > <input type="text" name="bill_id" class="input defaultText" id="bill_id" title="Bill Number" value="<?php// if($_REQUEST['enroll_id']!="Bill Number") echo $_REQUEST['enroll_id'];?>"> </td>-->
                                 <!--<td width="10%" > <select name="customer_id">
                                 <option value="">Select Student</option>
                                 <?php
								 /*$select_customers = " select enroll_id as user_id ,name from enrollment order by name asc  ";
								 $ptr_customer = mysql_query($select_customers);
								 while($data_customer = mysql_fetch_array($ptr_customer))
								 {	$selecteds='';
									 if($record_id==$data_customer['user_id'])
									 $selecteds = '  selected="selected" ';
									echo "<option value='".$data_customer['user_id']."' $selecteds >".$data_customer['name']."</option>";	 
								 }*/
								 ?>
                                 </select>
                                  </td>-->
                                 
                                    
                                    <!--<td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                                    <td width="20%"></td>-->
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
                               
									
                                $sql_records= "SELECT enroll_id, name,course_id FROM enrollment ".$pre_from_date." ".$pre_to_date." ";
                               // $ptr_records=mysql_query($sql_records);
							   // while($data_records = mysql_fetch_array($ptr_records))								
								//{
									//$sel= "select course_name from courses where course_id='".$data_records['course_id']."'";
								//}
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
                                    
                                    <tr><td height="10" align="right">
                                    <?
                                    echo "
										<img src='images/view.jpeg' title='View Invoice' border='0' 
										onclick=\"window.open('logsheet-generate.php?record_id=".$record_id."','View Invoice','scrollbars=yes','resizable=yes','width=900,height=600')\" style='cursor:pointer' >
										
										";
                                    ?>
                                    
                                    </td>
                                        </tr>
                                    <tr>
                                      <td valign="top" >
                                    <table width="990" height="84" align="center" class="table">
                                    <?php
                                    	$select_enroll = " select enroll_id,course_id,installment_display_id,added_date,name from enrollment  ";
									  	$ptr_enroll=mysql_query($select_enroll);
										$total_stud = mysql_num_rows($ptr_enroll);
										$data_enroll = mysql_fetch_array($ptr_enroll);
										
										$select_course = " select course_id,course_name from courses where course_id='".$data_enroll['course_id']."' ";
									  	$ptr_course=mysql_query($select_course);
										$data_course = mysql_fetch_array($ptr_course);
										
										/*$select_topic_id = " select COUNT(topic_id) as total_topic from topic_map where course_id='".$data_enroll['course_id']."' ";
									  	$total_topic=mysql_fetch_object($select_topic_id);
										echo $total_topic->total_topic;*/
										
										$q = mysql_query(" select topic_id from topic_map where course_id='".$data_enroll['course_id']."' ");
										$c = mysql_num_rows($q);
										
										echo '<input type="hidden" name="total_student" value="'.$total_stud.'"/>';
										?>
                                        <tr><th colspan="2"><? echo strtoupper($data_course['course_name']); ?> LOGSHEET</th></tr>
                                    	<tr style="padding-left:10px">
                                        	<td width="146"><strong>Student Name :&nbsp;&nbsp;&nbsp;</strong><? echo $data_enroll['name']; ?></td>
                                           
                                            <td width="141"><strong>Course Name :&nbsp;&nbsp;&nbsp;</strong><? echo $data_course['course_name']; ?><input type="hidden" name="course_id" value="<? echo $data_course['course_id']?>" /></td>
                                        </tr>
                                        <tr>
                                        	<td><strong>Admission Date :&nbsp;&nbsp;&nbsp;</strong><? echo $data_enroll['added_date']; ?></td>
                                            <td><strong>Enrollment ID :&nbsp;&nbsp;&nbsp;</strong><? echo $data_enroll['installment_display_id']; ?></td>
                                            
                                        </tr>
                                    </table>
                                    
                                    </td></tr>
                                    
                                    <tr><td valign="top" >
                                    <? ?>
                                       <table width="98%" align="center"  cellpadding="0" cellspacing="1"  class="table" style="width: 97%;">
								<tr align="center" class="grey_td" >
                               <!-- <td width="6%" align="center" class="tr-header"><strong>Select Topic</strong><br /><!--<input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/>-->
                                    <td width="6%" class="tr-header"><strong>Sr No.</strong></td>
                                    <!--<td width="6%" class="tr-header"><strong>Position</strong></td>-->
                                    <td width="8%" class="tr-header"><strong>Student Name</strong></td>
                                    <td width="17%" class="tr-header"><strong>Course Name</strong></td>
                                   
                                    <td width="12%" class="tr-header"><strong>Faculty Sign</strong></td>
                                    <td width="12%" class="tr-header"><strong>Student Sign</strong></td>
									<td width="8%"  class="tr-header"><strong>Uniform</strong></td>
									<td width="8%"  class="tr-header"><strong>LateMark</strong></td>
									<td width="8%"  class="tr-header"><strong>Mobile Submit</strong></td>
                                    <td width="12%" class="tr-header"><strong>SMS & Mail</strong></td>
                                </tr><?php
							     
									$j=1;
                                   while( $val_record=mysql_fetch_array($all_records))
									{
                                    
										
										//$select_topic_id = " SELECT name,course_id FROM enrollment where course_id='".$data_enroll['course_id']."'";
									  	//$ptr_topic_id=mysql_query($select_topic_id);
										//while($data_topic_id = mysql_fetch_array($ptr_topic_id))i
										
									    $select_topic_name = " select course_name from courses where course_id='".$val_record['course_id']."' ";
									  	$ptr_topic_name=mysql_query($select_topic_name);
										$data_topic_name = mysql_fetch_array($ptr_topic_name);
										
										$sel_logsheet="select * from todays_report where enroll_id='".$val_record['enroll_id']."' ";
										$ptr_logsheet=mysql_query($sel_logsheet);
										$data_logsheet=mysql_fetch_array($ptr_logsheet);
										
										//$listed_record_id = $data_topic_id['topic_id'];
										
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
                                        echo '<tr class="'.$bgclass.'">';
                                        echo '<td align="center">'.$sr_no.'</td>';
										/*echo '<td align="center"><input type="text" size="5" name="position'.$j.'" id="position'.$j.'" value="'.$data_logsheet['position'].'"/></td>';*/
										echo '<td align="center">'.$val_record['name'].'<input type="hidden" name="enroll_id_'.$j.'" value="'.$val_record['enroll_id'].'"></td>'; 
										//echo '<td align="center">'.$data_topic_name['course_name'].'<input type="hidden" name="topic_id_'.$j.'" value="'.$data_topic_name['topic_id'].'"></td>'; 
										echo '<td align="center">'.$data_topic_name['course_name'].'<input type="hidden" name="course_id_'.$j.'" value="'.$val_record['course_id'].'"></td>';
										
										if($data_logsheet['faculty_sign']=='completed')
										{
										 echo '<td align="center">';
										 echo'<img src="images/active_icon.png" width="30px" height="30px"><input type="hidden" id="action11" name="action_'.$j.'" value="completed" />';
										 
										 
                                         echo '</td>';
										}
										else
										{
											
											 echo '<td align="center">';
											 echo '<input type="checkbox" id="action11" name="action_'.$j.'" value="completed" />';
											 ?>
											 <!--<input type="text" name="faculty_sign_date_<?php //echo $j ?>" value="<?php //if($_POST['faculty_sign_date_'.$j]) echo $_POST['faculty_sign_date_'.$j]; else echo $data_logsheet['faculty_sign_date']; ?>" class="datepicker">-->
                                             
                                             <?php
											 echo '</td>';
										}
										
										if($data_logsheet['student_sign']=='completed')
										{
										 echo '<td align="center">';
										 echo'<img src="images/active_icon.png" width="30px" height="30px"><input type="hidden" id="action11" name="action1_'.$j.'" value="completed" />';
										 
                                         echo '</td>';
										}
										else
										{
											echo '<td align="center">';
											?><input type="radio" checked="checked" name="stud_status<?php echo $j ; ?>" value="present" <?php if($data_logsheet['stud_status'.$i] =="present") echo 'checked="checked"' ;?>>Present<input type="radio" name="stud_status<?php echo $j ; ?>" value="absent" <?php if($data_logsheet['stud_status'.$i] =="absent") echo 'checked="checked"' ?>>Absent<br /><?php
											echo '<input type="checkbox" id="action11" name="action1_'.$j.'" value="completed" />';
											?>
											<!--<input type="hidden" name="student_sign_date_<?php //echo $j ?>" value="<?php //echo date('Y-m-d H:i:s') ?>">-->
                                            
                                            <?php
											echo'</td>';
										}
										if($data_logsheet['uniform']=='completed')
										{
										echo '<td align="center">';
										echo'<img src="images/active_icon.png" width="30px" height="30px"><input type="hidden" id="action11" name="action2_'.$j.'" value="completed" />';
										 
										 
                                         echo '</td>';
										}
										else
										{
											echo '<td align="center">';
										    echo '<input type="checkbox" id="action11" name="action2_'.$j.'" value="completed" />';
										echo '</td>';
										}	 
											 
										if($data_logsheet['latemark']=='completed')
										{
										echo '<td align="center">';
										echo'<img src="images/active_icon.png" width="30px" height="30px"><input type="hidden" id="action11" name="action3_'.$j.'" value="completed" />';
										 
										 
                                         echo '</td>';
										}
										else
										{
											echo '<td align="center">';
										    echo '<input type="checkbox" id="action11" name="action3_'.$j.'" value="completed" />';
										echo '</td>';
										}	 
										
										if($data_logsheet['mobile_submit']=='completed')
										{
										echo '<td align="center">';
										echo'<img src="images/active_icon.png" width="30px" height="30px"><input type="hidden" id="action11" name="action4_'.$j.'" value="completed" />';
										
										 
                                         echo '</td>';
										}
										else
										{
											echo '<td align="center">';
										    echo '<input type="checkbox" id="action11" name="action4_'.$j.'" value="completed" />';
										echo '</td>';
										}	 
										
										
										if($data_logsheet['repeat_date']=='' || $data_logsheet['repeat_date']=='0000-00-00')
										{
											echo '<input type="hidden" name="repeat_date'.$j.'" value="'.date('Y-m-d').'">';
										}
										else
										{
											echo '<input type="hidden" name="repeat_date'.$j.'" value="'.$data_logsheet['repeat_date'].'">';
										}
										echo '<td align="center">';
										echo '<select name="repeated_'.$j.'">';
										?>
										<option value="No"<?php if($data_logsheet["repeated"] =="No") echo 'selected="selected"' ?> >No</option>
										<option value="Uniform" <?php if($data_logsheet["repeated"] =="Uniform") echo 'selected="selected"' ?>>Uniform</option>
										<option value="Latemark" <?php if($data_logsheet["repeated"] =="Latemark") echo 'selected="selected"' ?>>Latemark</option>
										<option value="Absent" <?php if($data_logsheet["repeated"] =="Absent") echo 'selected="selected"' ?>>Absent</option>
										<option value="Mobile" <?php if($data_logsheet["repeated"] =="Mobile") echo 'selected="selected"' ?>>Mobile</option>
										
										</select>
                                        <?php
										echo'</td>';
                                        echo '</tr>';
										
                                       $bgColorCounter++;
									   $j++;
									   $i--;
									
                                    }
                                 	
                                    ?>
                                    </table>
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
                                      </tr>
                                    
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
                                        </td>
                                      </tr>
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