<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];
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
        
<table cellspacing="0" cellpadding="0" class="table" width="98%">
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
                <td width="20%"><strong><a href="daily_full_batch_timetable.php?batch_id=<?php echo $record_id; ?>" target="_blank" >Logsheet</a></strong></td>
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
                            $select_directory='order by date asc';
							                 
                        $sql_query= "SELECT day,date FROM batch_timetable where 1 and c_b_id='".$record_id."' ".$pre_keyword." group by day ".$select_directory." "; 
                       	//echo $sql_query;
                        $no_of_records=mysql_num_rows($db->query($sql_query));
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword.'&record_id='.$_REQUEST['record_id'];
                            $query_string1=$query_string.$date_query;
                           // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
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
                            <tr align="center" class="grey_td" >
                            <!--<td width="6%" align="center" class="tr-header"><strong>Select Topic</strong><br /><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>-->
                                <td width="5%" rowspan="2" class="tr-header"><strong>Sr No.</strong></td>
                                <td width="5%" rowspan="2" class="tr-header"><strong>Days</strong></td>
                                <td width="5%" rowspan="2" class="tr-header"><strong>Logsheet</strong></td>
                                <td width="8%"  rowspan="2" class="tr-header"><strong>Dates</strong></td>
                                <td width="80%" colspan="<?php echo $col; ?>" class="tr-header"><strong>Details</strong></td>
                                
                            </tr>
                          	<tr class="grey_td" >
                            <!--<td width="5%" class="tr-header" align="center"><strong>Sr No.</strong></td>
                            <td width="10%" class="tr-header" align="center"><strong>Days</strong></td>
                            <td width="10%" class="tr-header" align="center"><strong>Dates</strong></td>-->
                            <td width="23%" class="tr-header" align="center"><strong>Topic Name</strong></td>
                            <td width="24%" class="tr-header" align="center"><strong>Topic Content</strong></td>
                            <td width="14%" class="tr-header" align="center"><strong>Topic Completed</strong></td>
                            <td width="10%" class="tr-header" align="center"><strong>Model Required</strong></td>
                            <?php
                           	if($_SESSION['type'] =='S')
                            {	
                           		?>
                            	<td width="10%" class="centerAlign"><strong>Action</strong></td>
                                <?php
                            }
                            ?>
                          	</tr>
                            <?php
							$day=1;
                            while($val_query=mysql_fetch_array($all_records))
                            {
                                $name = '';
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
								
								include "include/paging_script.php";
                                echo '<td align="center">'.$sr_no.'</td>';   
								echo '<td align="center">'.$val_query['day'].'</td>';		
								echo '<td align="center"><a href="daily_batch_timetable.php?batch_id='.$record_id.'&day='.$val_query['day'].'" target="_blank">Logsheet</a></td>';	
								$exp=explode('-',$val_query['date']);
								$new_date=$exp[2]."/".$exp[1]."/".$exp[0];
								echo '<td align="center">'.$new_date.'</td>';
								echo '<td align="center" colspan="'.$col.'">';
								
								$sele_batch="select * from batch_timetable where day='".$val_query['day']."' and c_b_id='".$record_id."' ";
								$ptr_batch=mysql_query($sele_batch);
								/*if($tot_top=mysql_num_rows($ptr_batch))
								{*/
								echo'<table width="100%;">';
									$t=1;
									while($data_batch=mysql_fetch_array($ptr_batch))
									{
										echo '<tr>';
										$listed_record_id=$data_batch['batch_timetable_map_id'];
									
										$select_topic = "select topic_name from topic where topic_id ='".$data_batch['topic_id']."' ";  
										$ptr_top=mysql_query($select_topic);        
										$val_topic= mysql_fetch_array($ptr_top);
										
										echo '<td align="center" width="30%" style="border-right:1px solid #DDDDDD !important">'.$val_topic['topic_name'].'</td>';
										echo '<td align="center" width="31%" style="border-right:1px solid #DDDDDD !important">'.stripslashes($data_batch['topic_content']).'</td>';
										if($data_batch['status']=='Completed')
										{
											$class='<img src="images/active_icon.png" title="Completed">';
										}
										else if($data_batch['date'] < date('Y-m-d') && $data_batch['status']=='')
										{
											$class='<img src="images/inactive_icon.png" title="Not Completed">';
										}
										else
											$class='<img src="images/missing.png" width="25" height="25" title="Pending">';
											
										echo '<td align="center" width="18%" style="border-right:1px solid #DDDDDD !important">'.$class.'</td>';
										echo '<td align="center" width="13%" style="border-right:1px solid #DDDDDD !important">'.$data_batch['model_required'].'</td>';
										
										if( $_SESSION['type'] =='S')
										{
											echo '<td align="center" width="7%">';
											echo '<a href="edit_batch_timetable.php?record_id='.$listed_record_id.'&batch_id='.$record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
											echo '</td>';
										}
										echo '<tr>';
									}
								//}
								echo '</table>';
								echo '</td>';
								echo '</tr>';                                
								$bgColorCounter++;
								$day++;
                            }
                            ?>
                          	<tr class="head_td">
                            	<td colspan="12">
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
