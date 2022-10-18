<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php
if(isset($_GET['batch_id']))
$record_id = $_GET['batch_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Daily Batch Time Table</title>
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
    <style>
	.table td {
		height: 0px !important;
		padding: 0px !important;
		border-right:1px black !important;
	}
	</style>
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
    <td class="top_mid" valign="bottom"><?php include "include/course_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
    				<?php 
					if($_POST['formAction'])
                    {
                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $del_record_id=$_POST['chkRecords'][$r];
                                $sql_query= "SELECT batch_timetable_map_id FROM batch_timetable where batch_timetable_map_id ='".$del_record_id."'";
                                if(mysql_num_rows($db->query($sql_query)))
								{                                                
									$delete_query="delete from batch_timetable where batch_timetable_map_id='".$del_record_id."'";
									$db->query($delete_query);                
								}
                            }
                            ?>
                            <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record(s) deleted successfully</p></center></div>
							<script type="text/javascript">
                            // $("#statusChangesDiv").dialog();
                                $(document).ready(function() {
                                    $( "#statusChangesDiv" ).dialog({
                                            modal: true,
                                            buttons: {
                                                        Ok: function() { $( this ).dialog( "close" );}
                                                     }
                                    });
                                });
                            </script>
                        	<?php                            
                        }                       
                    }
                    if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
                    {
                        $del_record_id=$_REQUEST['record_id'];
                        $sql_query= "SELECT batch_timetable_map_id FROM batch_timetable where batch_timetable_map_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {                           
                        	$delete_query="delete from batch_timetable where batch_timetable_map_id='".$del_record_id."'";
                        	$db->query($delete_query);
							
                            ?>
                            <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record deleted successfully</p></center></div>
                            <script type="text/javascript">
                            // $("#statusChangesDiv").dialog();
                                $(document).ready(function() {
                                    $( "#statusChangesDiv" ).dialog({
                                            modal: true,
                                            buttons: {
                                                        Ok: function() { $( this ).dialog( "close" );}
                                                     }
                                    });
                                });
                            </script>
                            <?php
                        }
                    }
                    ?>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
        <table cellspacing="0" cellpadding="0" class="" width="99%">
          <tr class="head_td">
            <td colspan="15">
                <form method="get" name="search">
                    <table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
                          <tr>
                            <td class="width5"></td>
                            <!--<td width="20%">
                                    <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                            <option value="">-Operation-</option>
                                            <option value="delete">Delete</option>
                                    </select>
                           </td>-->
                            <td width="20%">Export in <?php echo '<a href="excel_batch_timetable.php?record_id='.$record_id.'" ><img src="images/excel.png" width="30px" height="30px"></a>'; ?></td>
                            <td class="rightAlign" > 
                                <table border="0" cellspacing="0" cellpadding="0" align="right">
                          <tr>
                          <td></td>
                          <td class="width5"></td>
                            <td><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                            <td class="width2"></td>
                            <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
                          </tr>
                                </table>	
                            </td>
                        </tr>
                    </table>
                    
                    
                </form>	
            </td>
		  </tr>
		  <?php
                        /*if($_REQUEST['keyword']!="Keyword")
                            $keyword=trim($_REQUEST['keyword']);
                        if($keyword)
						{                            
							$select_name="select batch_id from batch where (batch_name like '%".$keyword."%')";                                           
							if(mysql_num_rows($db->query($select_name)))
							{
								$val_name=$db->fetch_array($db->query($select_name));
								$name_to_array = "or batch_name like concat(concat('%',".$val_name['batch_id']."),'%') ";
							}
							$category = '';
							$select_category="select batch_id from batch where batch_name like '%".$keyword."%' ";
							if(mysql_num_rows($db->query($select_category)))
							{
								$val_category_name=$db->fetch_array($db->query($select_category));
								$category="or batch_id = '".$val_category_name['batch_id']."' ";
							}
							
							$pre_keyword=" and (batch_name like '%".$keyword."%')";
						}                            
                        else
                            $pre_keyword="";*/
                        
                       /* if($_REQUEST['page'])
                            $page=$_REQUEST['page'];
                        else
                            $page=0;
                        
                        if($_REQUEST['show_records'])
                            $show=$_REQUEST['show'];
                        else
                            $show=0;

                        if($_GET['order']=='asc')
                        {
                            $order='desc';
                            $img = "<img src='images/sort_up.png' border='0'>";
                        }
                        else if($_GET['order']=='desc')
                        {
                            $order='asc';
                            $img = "<img src='images/sort_down.png' border='0'>";
                        }
                        else
                            $order='desc';

                        if($_GET['orderby']=='batch_id' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='batch_id'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else*/
                            
						$select_directory='order by date asc';
                        $sql_batch_tt= "SELECT day,date,c_b_id FROM batch_timetable where 1 and c_b_id='".$record_id."' ".$pre_keyword." group by day ".$select_directory." "; 
						$ptr_batch_tt=mysql_query($sql_batch_tt);
						$day=1;
						$tot_days=mysql_num_rows($ptr_batch_tt);
						while($data_batch_tt=mysql_fetch_array($ptr_batch_tt))
						{
							$sql_query= "SELECT * FROM student_course_batch_map where 1 and c_b_id='".$data_batch_tt['c_b_id']."' ".$pre_keyword." "; 
							$db_query=mysql_query($sql_query);
							$no_of_records=mysql_num_rows($db_query);
							if($no_of_records)
							{
								$bgColorCounter=1;
								?>
								<form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
								<input type="hidden" name="formAction" id="formAction" value=""/>
								<?php
								if($_SESSION['type']=='S')
								{
									$col='5';
								}
								else
									$col='4';
								?>
                                <tr>
                                    <td colspan="<?php echo $tot_days; ?>">
                                        <table cellspacing="0" cellpadding="0" class="table" width="100%" style="margin: 0px !important;page-break-before: always" >
                                            <tr>
                                                <td colspan="<?php echo $tot_days; ?>">
                                                    <table border="0" cellspacing="0" cellpadding="0" width="99%" align="center" class="table" >
                                                        <?php
                                                        $select_details="SELECT day,date FROM batch_timetable where 1 and c_b_id='".$record_id."' group by day ";
                                                        $ptr_b_details=mysql_query($select_details);
                                                        $data_b_details= mysql_fetch_array($ptr_b_details);
                                                        
                                                        $exp=explode('-',$data_batch_tt['date']);
                                                        $new_date=$exp[2]."/".$exp[1]."/".$exp[0];
                                                        
                                                        $select_batch1="SELECT * FROM course_batch_mapping where 1 and c_b_id='".$record_id."' ";
                                                        $ptr_batch1=mysql_query($select_batch1);
                                                        $data_batch1= mysql_fetch_array($ptr_batch1);
                                                        
                                                        $select_course = "select course_name from courses where course_id = '".$data_batch1['course_id']."' ";          
                                                        $val_course= $db->fetch_array($db->query($select_course));
                                                        
                                                        $select_staff= "select name from site_setting where admin_id = '".$data_batch1['staff_id']."' ";          
                                                        $val_staff= $db->fetch_array($db->query($select_staff));
                                        
                                                        ?>
                                                        <tr style="padding-left:10px">
                                                            <td width="50%"><strong>Date :&nbsp;&nbsp;&nbsp;</strong><?php echo $new_date; ?></td>
                                                            <td width="50%"><strong>Day :&nbsp;&nbsp;&nbsp;</strong><?php echo $data_batch_tt['day']; ?></td>
                                                        </tr>
                                                        <tr style="padding-left:10px">
                                                            <td width="50%"><strong>Batch Name :&nbsp;&nbsp;&nbsp;</strong><?php echo $data_batch1['batch_name'] . '( '.$val_course['course_name'].' )'; ?></td>
                                                            <td width="50%"><strong>Faculty Name :&nbsp;&nbsp;&nbsp;</strong><?php echo $val_staff['name']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" width="100%"><strong>Topics :&nbsp;&nbsp;&nbsp;</strong><?php //echo $data_enroll['added_date']; 
                                                                $sele_batch="select * from batch_timetable where day='".$data_batch_tt['day']."' and c_b_id='".$record_id."' ";
                                                                $ptr_batch=mysql_query($sele_batch);
                                                                $t=1;
                                                                $topics_name='';
                                                                while($data_batch=mysql_fetch_array($ptr_batch))
                                                                {
                                                                    $listed_record_id=$data_batch['batch_timetable_map_id'];
                                                                    $select_topic = "select topic_name from topic where topic_id ='".$data_batch['topic_id']."' ";  
                                                                    $ptr_top=mysql_query($select_topic);        
                                                                    $val_topic= mysql_fetch_array($ptr_top);
                                                                    $topics_name .=$val_topic['topic_name'].', ';
                                                                }
                                                                echo $topics_name;
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <?php
                                            echo '<tr class="'.$bgclass.'">';
                                            echo '<td align="center" width="15%" class="grey_td" style="font-size:16px;font-weight:600; height:35px !important; margin:5px!important; ">Student Name</td>';   
                                            while($val_query=mysql_fetch_array($db_query))
                                            {
                                                $name = '';
                                                if($bgColorCounter%2==0)
                                                    $bgcolor='class="grey_td"';
                                                else
                                                    $bgcolor="";                
                                                
                                                include "include/paging_script.php";
                                                $select_name = "select name from enrollment where enroll_id ='".$val_query['enroll_id']."' ";
                                                $data_name = $db->fetch_array($db->query($select_name));
                                                
                                                
                                                echo '<td align="center" class="grey_td" style="font-size:16px;font-weight:600; height:15px !important; width:60px !important; margin:5px!important; writing-mode: sideways-lr;text-orientation: mixed;">'.$data_name['name'].'</td>';   
                                                
                                                $bgColorCounter++;
                                                
                                            }
                                            echo '<td align="center" class="grey_td" style="font-size:16px;font-weight:600; height:15px !important; width:60px !important; margin:5px!important; writing-mode: sideways-lr;text-orientation: mixed;"></td>';   
                                            echo '<td align="center" class="grey_td" style="font-size:16px;font-weight:600; height:15px !important; width:60px !important; margin:5px!important; writing-mode: sideways-lr;text-orientation: mixed;"></td>';   
                                            echo '<td align="center" class="grey_td" style="font-size:16px;font-weight:600; height:15px !important; width:60px !important; margin:5px!important; writing-mode: sideways-lr;text-orientation: mixed;"></td>';   
                                            echo '</tr>';
                                            ?>
                                            <tr align="center" class="grey_td" >
                                                <td width="5%" class="tr-header"><strong>Present Absent</strong></td>
                                                <?php 
                                                $total_studs=$no_of_records+3;
                                                for($i=0;$i<$total_studs;$i++)
                                                {
                                                    ?>
                                                    <td width="" ></td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            <tr align="center" class="grey_td" >
                                                <td width="5%" class="tr-header"><strong>Came on time</strong></td>
                                                <?php 
                                                for($i=0;$i<$total_studs;$i++)
                                                {
                                                    ?>
                                                    <td width=""></td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            <tr align="center" class="grey_td" >
                                                <td width="5%" class="tr-header"><strong>Phone Submitted</strong></td>
                                                <?php 
                                                for($i=0;$i<$total_studs;$i++)
                                                {
                                                    ?>
                                                    <td width="" ></td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            <tr align="center" class="grey_td" >
                                                <td width="5%" class="tr-header"><strong>Groomed?</strong></td>
                                                <?php 
                                                for($i=0;$i<$total_studs;$i++)
                                                {
                                                    ?>
                                                    <td width="" ></td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            <tr align="center" class="grey_td" >
                                                <td width="5%" class="tr-header"><strong>Proper Uniform</strong></td>
                                                <?php 
                                                for($i=0;$i<$total_studs;$i++)
                                                {
                                                    ?>
                                                    <td width="" ></td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            <tr align="center" class="grey_td" >
                                                <td width="5%" class="tr-header"><strong>Bags under desk</strong></td>
                                                <?php 
                                                for($i=0;$i<$total_studs;$i++)
                                                {
                                                    ?>
                                                    <td width="" ></td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            <tr align="center" class="grey_td" >
                                                <td width="5%" class="tr-header"><strong>Misbehave in class</strong></td>
                                                <?php 
                                                for($i=0;$i<$total_studs;$i++)
                                                {
                                                    ?>
                                                    <td width="" ></td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            <tr align="center" class="grey_td" >
                                                <td width="5%" class="tr-header"><strong>Class team work</strong></td>
                                                <?php 
                                                for($i=0;$i<$total_studs;$i++)
                                                {
                                                    ?>
                                                    <td width="" ></td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            <tr align="center" class="grey_td" >
                                                <td width="5%" class="tr-header"><strong>Class Cleanliness</strong></td>
                                                <?php 
                                                for($i=0;$i<$total_studs;$i++)
                                                {
                                                    ?>
                                                    <td width="" ></td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            <tr align="center" class="grey_td" >
                                                <td width="5%" class="tr-header"><strong>Forms filled for absent/Late</strong></td>
                                                <?php 
                                                for($i=0;$i<$total_studs;$i++)
                                                {
                                                    ?>
                                                    <td width=""></td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            <tr align="center" class="grey_td" >
                                                <td width="5%" class="tr-header" style="height: 100px !important;" ><strong>Student Sign</strong></td>
                                                <?php 
                                                for($i=0;$i<$total_studs;$i++)
                                                {
                                                    ?>
                                                    <td width=""></td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            <tr align="center" class="grey_td" >
                                                <td width="5%" class="tr-header" style="height: 100px !important;" ><strong>Faculty Sign</strong></td>
                                                <?php 
                                                for($i=0;$i<$total_studs;$i++)
                                                {
                                                    ?>
                                                    <td width=""></td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            <!--<tr class="head_td">
                                                <td colspan="12">
                                                    <table cellspacing="0" cellpadding="0" width="100%">
                                                    <tr>
                                                        <?php
                                                        /*if($no_of_records>10)
                                                        {
                                                            echo '<td width="3%" align="left">Show</td>
                                                            <td width="20%" align="left"><select class="input_select_login" name="show_records" onchange="redirect(this.value)">';
                                                            $show_records=array(0=>'10',1=>'20','50','100');
                                                            for($s=0;$s<count($show_records);$s++)
                                                            {
                                                                if($_SESSION['show_records']==$show_records[$s])
                                                                    echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                                else
                                                                    echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                            }
                                                            echo'</td></select>';
                                                        }
                                                        echo '<td width="75%" align="right">'.$pager->renderFullNav().'</td>';*/
                                                        ?>
                                                    </tr>
                                                    </table>                         
                                                </td>
                                            </tr>-->
                                        </table>
                                    </td>
                                </tr>
                                    </form>
                                    
							<?php 
						}
						$day++;
					
					}
					?>
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
<div id="footer">
<?php include "include/footer.php"; ?>
</div>
<!--footer end-->
</body>
</html>
