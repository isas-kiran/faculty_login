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
<title>View TImetable</title>
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
    <td class="top_mid" valign="bottom"><?php include "include/course_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">	
							<?php
                          	if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
                          	{
                  				$pre_from_date=" and date_format(added_date,'%Y-%m-%d')>='".date('Y-m-d',strtotime($_REQUEST['from_date']))."'";
                           
                            }
                            else
                            {
                            	$balance=0;
                                $pre_from_date="";                            
                            }
                            $sql_records= "SELECT * FROM timetable where timetable_id=".$record_id." order by timetable_id desc";
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
                                                   
                                                    <td height="2" align="right"><?php echo $pager->renderFullNav();?></td>
                                                </tr>
                                            </table>
                                        </td></tr>
                                    <tr><td height="10" align="right">
                                    <?php
                                    echo "<input type='button' name='print' value='Print' title='Print logsheet' onclick=\"window.open('print_timetable.php?record_id=".$record_id."&action=print','View Timetable','scrollbars=yes','resizable=yes','width=900,height=600')\" style='cursor:pointer' />" ?>
                                    </td>
                                    </tr>
                                    <tr>
                                    	<td valign="top" >
                                    <table width="990" height="84" align="center" class="table">
                                    <?php
                                    	$val_record=mysql_fetch_array($all_records);
										
										$select_course = "select course_id,course_name from courses where course_id='".$val_record['course_id']."' ";
									  	$ptr_course=mysql_query($select_course);
										$data_course = mysql_fetch_array($ptr_course);
										
										?>
                                        <tr><th colspan="2"><? echo strtoupper($data_course['course_name']); ?> Timetable</th></tr>
                                    	<!--<tr style="padding-left:10px">
                                        	<td width="146"><strong>Student Name :&nbsp;&nbsp;&nbsp;</strong><?php //echo $data_enroll['name']; ?></td>
                                        	<td width="141"><strong>Course Name :&nbsp;&nbsp;&nbsp;</strong><?php //echo $data_course['course_name']; ?><input type="hidden" name="course_id" value="<?php //echo $data_course['course_id']?>" /></td>
                                        </tr>
                                        <tr>
                                       		<td><strong>Admission Date :&nbsp;&nbsp;&nbsp;</strong><?php //echo $data_enroll['added_date']; ?></td>
                                            <td><strong>Enrollment ID :&nbsp;&nbsp;&nbsp;</strong><?php //echo $data_enroll['installment_display_id']; ?></td>
                                        </tr>-->
                                    </table>
                                    </td></tr>
                                    <tr><td valign="top" >
                                    <table width="98%" align="center"  cellpadding="0" cellspacing="1"  class="table" style="width: 97%;">
								<tr align="center" class="grey_td" >
                                <!--<td width="6%" align="center" class="tr-header"><strong>Select Topic</strong><br /><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>-->
                                    <td width="5%" class="tr-header"><strong>Sr No.</strong></td>
                                    <td width="15%" class="tr-header"><strong>Days</strong></td>
                                    <td width="10%" class="tr-header"><strong>Dates</strong></td>
                                    <td width="25%" class="tr-header"><strong>Topic Name</strong></td>
                                    <td width="30%" class="tr-header"><strong>Topic Content</strong></td>
                                    <td width="10%" class="tr-header"><strong>Model Required</strong></td>
                                </tr><?php
									$j=1;
                                    $select_topic_id = " select * from timetable_topic_map where timetable_id='".$val_record['timetable_id']."' ";
									$ptr_topic_id=mysql_query($select_topic_id);
									while($data_topic_id = mysql_fetch_array($ptr_topic_id))
									{
										
										$select_topic_name = " select topic_id,topic_name,duration from topic where topic_id='".$data_topic_id['topic_id']."' ";
									  	$ptr_topic_name=mysql_query($select_topic_name);
										$data_topic_name = mysql_fetch_array($ptr_topic_name);
																				
										$listed_record_id = $data_topic_id['topic_id'];
										
										if($bgColorCounter%2==0)
                                    		$bgcolor='class="grey_td"';
                                		else
                                    		$bgcolor=""; 
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
										echo '<td align="center">Day '.$data_topic_id['day'].'</td>';
										echo '<td align="center"></td>';
										echo '<td align="center">'.$data_topic_name['topic_name'].'<input type="hidden" name="topic_id_'.$j.'" value="'.$data_topic_name['topic_id'].'"></td>';
										echo '<td align="center">'.$data_topic_id['topic_content'].'</td>'; 
										echo '<td align="center"></td>';
										echo '</tr>';
										
                                   		$bgColorCounter++;
									   	$j++;
									   	$i--;
									}
                                 	?>
                                    
                                </table>
                            </td>
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
                                        </td></tr>
                                    </table>
                                    </form><?php
                                }
								
                                else if($_GET['search'])
                                    echo'<center><br><div id="alert" style="width:80%">Records not found related to your search criteria, please try again to get more results</div><br></center>';
                                else
                                    echo'<center><br><div id="alert" style="width:30%">No Records Found</div><br></center>';
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
                            Warning! JavaScript must be enabled for proper operation of the Administrator backend.	</noscript>
                 <div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>