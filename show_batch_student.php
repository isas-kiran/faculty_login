<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM student_course_batch_map where c_b_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
	
	$select_course_id="select course_id,batch_name from course_batch_mapping where c_b_id ='".$row_record['c_b_id']."' ";
	$data_course_id = $db->fetch_array($db->query($select_course_id));
	$batch_name= $data_course_id['batch_name'];
	
	$select_course_name = "select course_name from courses where course_id = '".$data_course_id['course_id']."' ";          
	$data_course_name= $db->fetch_array($db->query($select_course_name));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Show Batch Student</title>
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
                                $sql_query= "SELECT s_c_b_id FROM student_course_batch_map where s_c_b_id ='".$del_record_id."'";
                                if(mysql_num_rows($db->query($sql_query)))
								{  
									$delete_query="delete from student_course_batch_map where s_c_b_id='".$del_record_id."'";
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
							setTimeout('document.location.href="show_batch_student.php?record_id=<?php echo $_REQUEST['c_b_id']; ?>";',500);
                            </script>
                        	<?php                            
                        }                       
                    }
                    if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
                    {
                        $del_record_id=$_REQUEST['record_id'];
                        $sql_query= "SELECT s_c_b_id FROM student_course_batch_map where s_c_b_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {                           
                        	$delete_query="delete from student_course_batch_map where s_c_b_id='".$del_record_id."'";
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
							setTimeout('document.location.href="show_batch_student.php?record_id=<?php echo $_REQUEST['c_b_id']; ?>";',200);
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
    <td colspan="15">
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
                <td width="20%">Batch Name : <?php echo $batch_name; ?></td>
                <td width="20%">Course Name : <?php echo $data_course_name['course_name']; ?></td>
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
                            $select_directory='order by s_c_b_id asc';                      
                           
						$sql_query= "SELECT * FROM student_course_batch_map where 1 and c_b_id='".$record_id."' ".$pre_keyword." ".$select_directory.""; 
                       	//echo $sql_query;
						$ptr_query=mysql_query($sql_query);
                        $no_of_records=mysql_num_rows($ptr_query);
                        if($no_of_records)
                        {
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
                            <td width="10%" align="center"><strong>Student Name</strong></td>
                            <td width="10%" align="center"><strong>Student Course Name</strong></td>
                            
                            <?php
                           	/*if($_SESSION['type'] =='S')
                            {*/	
                           		?>
                            	<td width="5%" class="centerAlign"><strong>Action</strong></td>
                                <?php
                            //}
                            ?>
                          	</tr>
                            <?php
							$i=1;
                            while($val_query=mysql_fetch_array($ptr_query))
                            {
                                $name = '';
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                

                                $listed_record_id=$val_query['s_c_b_id']; 		
								
								$select_name = "select name from enrollment where enroll_id ='".$val_query['enroll_id']."' ";
                                $data_name = $db->fetch_array($db->query($select_name));
								
								$select_course = "select course_name from courses where course_id = '".$val_query['course_id']."' ";          
                                $val_course= $db->fetch_array($db->query($select_course));
								
                                
								
                                include "include/paging_script.php";
                                if($_SESSION['type'] =='S')
								{
                                	echo '<tr '.$bgcolor.' >
                                    <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
								}	  
                                echo '<td align="center">'.$i.'</td>';  
								echo '<td align="center">'.$data_name['name'].'</td>'; 
								echo '<td align="center">'.$val_course['course_name'].'</td>'; 
								
								/*if( $_SESSION['type'] =='S')
								{*/
                                	echo '<td align="center">';
									echo '<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&c_b_id='.$record_id.'&page='.$_REQUEST['page'].'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';

                                	echo '</td>';
								//}
                                echo '</tr>';                                
                                $i++;
                            }
                            ?>
                          	<tr class="head_td">
                            	<td colspan="15">
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
