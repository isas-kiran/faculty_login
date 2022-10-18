<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Batch</title>
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
    <td class="top_mid" valign="bottom"><?php include "include/course_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
    				<?php if($_POST['formAction'])
                    {
                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $del_record_id=$_POST['chkRecords'][$r];
                                $sql_query= "SELECT c_b_id FROM ".$GLOBALS["pre_db"]."course_batch_mapping where c_b_id ='".$del_record_id."'";
                                if(mysql_num_rows($db->query($sql_query)))
								{  
									$delete_query="delete from course_batch_mapping where c_b_id='".$del_record_id."'";
									$db->query($delete_query);
									
									$delete_query_batch="delete from student_course_batch_map where c_b_id='".$del_record_id."'";
									$db->query($delete_query_batch);          
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
                        $sql_query= "SELECT c_b_id FROM course_batch_mapping where c_b_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {                           
                        	$delete_query="delete from course_batch_mapping where c_b_id='".$del_record_id."'";
							$db->query($delete_query);
							
							$delete_query_batch="delete from student_course_batch_map where c_b_id='".$del_record_id."'";
							$db->query($delete_query_batch);
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
        
<table cellspacing="0" cellpadding="0" class="table" width="95%">
  <tr class="head_td">
    <td colspan="17">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                <td width="20%">
                <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                    <option value="">-Operation-</option>
                    <option value="delete">Delete</option>
                </select>
                </td>
                
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
                        if($_REQUEST['keyword']!="Keyword")
                            $keyword=trim($_REQUEST['keyword']);
                        if($keyword)
						{                            
							$select_name = "select batch_id from batch where (batch_name like '%".$keyword."%')";                                           
							if(mysql_num_rows($db->query($select_name)))
							{
								$val_name = $db->fetch_array($db->query($select_name));
								$name_to_array = "or batch_name like concat(concat('%',".$val_name['batch_id']."),'%') ";
							}
							$category = '';
							$select_category = "select batch_id from batch where batch_name like '%".$keyword."%' ";
							if(mysql_num_rows($db->query($select_category)))
							{
								$val_category_name = $db->fetch_array($db->query($select_category));
								$category = "or batch_id = '".$val_category_name['batch_id']."' ";
							}
							$pre_keyword=" and (batch_name like '%".$keyword."%')";
						}                            
                        else
                            $pre_keyword="";
                        
                        if($_REQUEST['page'])
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
                        else
                            $select_directory='order by c_b_id desc';                      
                            $sql_query= "SELECT * FROM course_batch_mapping where 1  ".$pre_keyword."  ".$_SESSION['where']." ".$select_directory.""; 
                       //echo $sql_query;
                        $no_of_records=mysql_num_rows($db->query($sql_query));
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword;
                            $query_string1=$query_string.$date_query;
                           // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
                            <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                            <input type="hidden" name="formAction" id="formAction" value=""/>
                          	<tr class="grey_td" >
                          	<?php
                           	if( $_SESSION['type'] =='S')
                            {	
                           		?>
                            	<td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
                            	<?php
                            }
                            ?>
                            <td width="5%" align="center"><strong>Sr. No.</strong></td>
                            <td width="6%" align="center"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=s_c_b_id".$query_string;?>" class="table_font"><strong>Batch ID</strong></a> <?php echo $img1;?></td>
                            <td width="6%" align="center"><strong>Batch ID</strong></td>
                            <td width="10%" align="center"><strong>Course Name</strong></td>
                            <td width="10%" align="center"><strong>Batch Start-End Date</strong></td>
                            <td width="8%" align="center"><strong>Batch Start-End Time</strong></td>
                            <td width="5%" align="center"><strong>Total Student</strong></td>
                            <td width="6%" align="center"><strong>Faculty Name</strong></td>
                            <td width="5%" align="center"><strong>Status</strong></td>
                            <td width="5%" align="center"><strong>Add Student</strong></td>
                            <td width="5%" align="center"><strong>Show Student</strong></td>
                            <td width="5%" align="center"><strong>View Timetable</strong></td>
                            <td width="5%" align="center"><strong>Add Holiday</strong></td>
                            <td width="5%" align="center"><strong>Change Topic/Day</strong></td>
                            <td width="6%" align="center"><strong>Added date</strong></td>
                            <?php
                           	if($_SESSION['type'] =='S')
                            {	
                           		?>
                            	<td width="5%" class="centerAlign"><strong>Action</strong></td>
                                <?php
                            }
                            ?>
                          	</tr>
                            <?php
                            while($val_query=mysql_fetch_array($all_records))
                            {
                                $name = '';
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                

                                $listed_record_id=$val_query['c_b_id']; 								
                                								
								$select_course = "select course_name from courses where course_id = '".$val_query['course_id']."' ";          
                                $val_course= $db->fetch_array($db->query($select_course));
								
                                include "include/paging_script.php";
                                if($_SESSION['type'] =='S')
								{
                                	echo '<tr '.$bgcolor.' >
                                    <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
								}	  
                                echo '<td align="center">'.$sr_no.'</td>';   
								if( $_SESSION['type'] =='S')
								{
                                	echo '<td align="center"><a href="batch_logsheet.php?record_id='.$listed_record_id.'&course_batch_id='.$val_query['c_b_id'].'" class="table_font">'.$val_query['batch_name'].'</a></td>';
								}
								else
								{
									echo '<td align="center">'.$val_query['batch_name'].'</td>';
								}
								$sel_b_t="select * from batch_time where batch_time_id='".$val_query['batch_time_id']."'";
								$ptr_b_t=mysql_query($sel_b_t);
								$data_b_t=mysql_fetch_array($ptr_b_t);
								
								echo '<td align="center">'.$val_query['batch_type'].'</td>';
								echo '<td align="center">'.$val_course['course_name'].'</td>';
                                echo '<td align="center">Start Date-'.$val_query['start_date'].'<br/>End Date-'.$val_query['end_date'].'</td>';
                                echo '<td align="center">'.$data_b_t['batch_time'].'</td>';
                                
								$sel_studen="select s_c_b_id from student_course_batch_map where c_b_id='".$val_query['c_b_id']."'";
								$ptr_std=mysql_query($sel_studen);
								$total_std=mysql_num_rows($ptr_std);
								
                               	echo '<td align="center">'.$total_std.'</td>';
						
								$data_staff="select name from  site_setting where admin_id ='".$val_query['staff_id']."' ";
								$ptr_staff=mysql_query($data_staff);
								$val_staff=mysql_fetch_array($ptr_staff);
								echo '<td align="center">'.$val_staff['name'].'</td>';
								
								if($val_query['status']=='not_started')
								{
									$status= str_replace("not_started","Not Started",$val_query['status']);
								}
								
								echo '<td align="center">'.$status.'</td>';
								echo '<td align="center">';
								echo '<a href="add_batch_student.php?record_id='.$listed_record_id.'" target="_blank" >Add Student</a>';
								echo '</td>';
								echo '<td align="center">';
								echo '<a href="show_batch_student.php?record_id='.$listed_record_id.'" target="_blank" >Show Student</a>';
								echo '</td>';
								echo '<td align="center">';
								echo '<a href="batch_timetable.php?record_id='.$listed_record_id.'" target="_blank" ><img src="images/gst1.png" class="example-fade" original-title="View Timetable" width="21" height="21"></a>';
								echo '</td>';
								echo '<td align="center">';
								echo '<a href="edit_batch_date.php?record_id='.$listed_record_id.'" target="_blank" ><img src="images/gst1.png" class="example-fade" original-title="Add holiday" width="21" height="21"></a>';
								echo '</td>';
								echo '<td align="center">';
								echo '<a href="change_batch_day.php?record_id='.$listed_record_id.'" target="_blank" ><img src="images/gst1.png" class="example-fade" original-title="Change Day" width="21" height="21"></a>';
								echo '</td>';
								echo '<td align="center">'.$val_query['added_date'].'</td>';

								if( $_SESSION['type'] =='S')
								{
                                	echo '<td align="center">';

						      		/*
									?>
                                	<img src="images/view.png"title='<?
									$open_tab="select * from  course_batches where  course_id ='".$listed_record_id."' ";
									$ptr_uery=mysql_query($open_tab);
									$sr=1;
									while($val_qusddery=mysql_fetch_array($ptr_uery))
									{
										echo	$sr.")"; echo	$val_qusddery['batch_name'];
							     		$sr++; 
									} ?>' class="example-fade"/>
                                  	<?php
									echo '<img src="images/discount_off.png" title="'.$val_qusddery['discount'].' Discount. Valid Date start='.$val_qusddery['start_date'].' end ='.$val_qusddery['end_date'].'  " class="example-fade"/>&nbsp;&nbsp;';*/
									echo '<a href="add_batch.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';

                                	echo '</td>';
								}
                                echo '</tr>';                                
                                $bgColorCounter++;
                            }
                            ?>
                          	<tr class="head_td">
                            	<td colspan="17">
                               		<table cellspacing="0" cellpadding="0" width="100%">
                                    <tr>
										<?php
                                        if($no_of_records>10)
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
                                        echo '<td width="75%" align="right">'.$pager->renderFullNav().'</td>';
                                        ?>
                                    </tr>
                                	</table>                         
                            	</td>
                        	</tr>
                    		</form>
      					<?php 
					} 
					else
						echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No Batch found related to your search criteria, please try again</div><br></td></tr>';?>
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
