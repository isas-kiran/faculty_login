<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Subject</title>
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
                                $sql_query= "SELECT subject_id FROM ".$GLOBALS["pre_db"]."subject where subject_id ='".$del_record_id."'";
                                if(mysql_num_rows($db->query($sql_query)))
								{                                                
									$delete_query="delete from ".$GLOBALS["pre_db"]."subject where subject_id='".$del_record_id."'";
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
                        $sql_query= "SELECT subject_id FROM ".$GLOBALS["pre_db"]."subject where subject_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {                           
                        	$delete_query="delete from ".$GLOBALS["pre_db"]."subject where subject_id='".$del_record_id."'";
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
        
<table cellspacing="0" cellpadding="0" class="table" width="95%">
  <tr class="head_td">
    <td colspan="8">
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
                <!--<td>
                    <select name="free_course" id="free_course" class="input_select_login" style="width: 150px; ">
                                <option value="">-Course Type-</option>
                                <option value="Y">Free Course</option>
                                <option value="N">Paid Course</option>
                        </select>
                </td>-->
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
							$select_name = "select course_id,course_name from courses where (course_name like '%".$keyword."%')";                                           
							if(mysql_num_rows($db->query($select_name)))
							{
								$val_name = $db->fetch_array($db->query($select_name));
								$name_to_array = "or course_name like concat(concat('%',".$val_name['course_id']."),'%') ";
							}
							$pre_keyword=" and (name like '%".$keyword."%' || description like '%".$keyword."%') ";
						}                            
                        else
                            $pre_keyword="";
                        
                        /*if($_REQUEST['free_course'])
                             $pre_keyword="  and (free_course ='".$_REQUEST['free_course']."')";
                            else 
                             $pre_keyword="";*/

                        if($_REQUEST['page'])
                            $page=$_REQUEST['p
							age'];
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

                        if($_GET['orderby']=='course_name' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='course_name'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                            $select_directory='order by subject_id desc';  
						
						$sql_query= "SELECT subject_id,name,description,course_domain_id FROM subject where 1 ".$pre_keyword."  ".$select_directory." "; 
							
                       
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
    <td width="10%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
    <td width="10%" align="center"><strong>Sr. No.</strong></td>
    <td width="18%"><strong>Domin Name</strong></td>
    <td width="26%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=name".$query_string;?>" class="table_font"><strong>Subject Name</strong></a> <?php echo $img1;?></td>
   <!-- <td width="15%"><strong>Course Name</strong></td>-->
    <!--<td width="20%"><strong>Suject Fees</strong></td>-->
    <td width="18%"><strong>Subject Description</strong></td>
    <td width="20%"><strong>Total Topics</strong></td>
	<?php
	if($_SESSION['type']=="S")
	{?>
		<td width="16%" class="centerAlign"><strong>Action</strong></td>
	<?php } ?>
	</tr>
                            <?php

                            while($val_query=mysql_fetch_array($all_records))
                            {
                                $name = '';
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                
                                $listed_record_id=$val_query['subject_id']; 
                                  
                                $arr=explode(",", $val_query['staff_id']);
                                for($i=0;$i<=count($arr);$i++)
                                {
                                    $select_name = "select staff_id,staff_name from staff_regi where staff_id = '".$arr[$i]."' ";                                           
                                    $val_name = $db->fetch_array($db->query($select_name));
                                    if($val_name['staff_name'])
                                    {
                                        $name .=$val_name['staff_name'].', ';
                                    }                                    
                                }
                                $names = rtrim($name, ", ");
                                
                                include "include/paging_script.php";
                                
                                echo '<tr '.$bgcolor.' >
                                      <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
                                echo '<td align="center">'.$sr_no.'</td>';                
								$select_domain="select cat_name from course_domain_category where cat_id='".$val_query['course_domain_id']."'";
								$ptr_domain = mysql_query($select_domain);
								$data_domain= mysql_fetch_array($ptr_domain);                
								echo '<td >'.$data_domain['cat_name'].'</td>';
                                echo '<td ><a href="subject_add.php?record_id='.$listed_record_id.'" class="table_font">'.$val_query['name'].'</a></td>';
                               
                                echo '<td >'.$val_query['description'].'</td>';
								
								$select_teacher="select access_id from topic_map where subject_id='".$listed_record_id."'";
								$ptr_faculty = mysql_query($select_teacher);
								$total_topics= mysql_num_rows($ptr_faculty);
								
                                echo '<td >'.$total_topics.'</td>';
								if($_SESSION['type']=="S")
								{
									echo '<td align="center"><a href="subject_add.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;';
									$select_id = "select topic_id from topic where subject_id = '".$listed_record_id."' ";  
									$ptr_id=mysql_query($select_id);
									$data_id=mysql_fetch_array($ptr_id);
									
									$select_subid = "select topic_id from topic_map where subject_id = '".$listed_record_id."' ";  
									$ptr_subid=mysql_query($select_subid);
									$data_subid=mysql_fetch_array($ptr_subid);
									
									if($data_id['topic_id'] =='' && $data_subid['topic_id']=='')
									{  echo '<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>';
									}
									
									echo '&nbsp;&nbsp;';

									echo '</td>';
                                }
								echo '</tr>';
                                                                
                                $bgColorCounter++;
                            }
                                ?>
  <tr class="head_td">
    <td colspan="8">
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
    </tr></form>
      <?php } 
      else
        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No course found related to your search criteria, please try again</div><br></td></tr>';?>
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
