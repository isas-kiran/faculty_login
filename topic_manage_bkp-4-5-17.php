<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Topic</title>
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
                                $sql_query= "SELECT topic_id FROM ".$GLOBALS["pre_db"]."topic where topic_id ='".$del_record_id."'";
                                if(mysql_num_rows($db->query($sql_query)))
                                    {                                                
                                        $delete_query="delete from ".$GLOBALS["pre_db"]."topic where topic_id='".$del_record_id."'";
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
                        $sql_query= "SELECT topic_id FROM ".$GLOBALS["pre_db"]."topic where topic_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {                           
                        $delete_query="delete from ".$GLOBALS["pre_db"]."topic where topic_id='".$del_record_id."'";
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
    <td colspan="10">
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
                <td width="20%">
                        <select name="subject_id" class="input_select_login" onChange="Javascript:document.search.submit();">
                                <option value="">- Select Subject -</option>
                                <?php
                            	$select_category = "select subject_id,name from subject order by subject_id asc";
                            	$ptr_category = mysql_query($select_category);
                            	while($data_category = mysql_fetch_array($ptr_category))
                            	{
                              	  if($data_category['subject_id'] == $_REQUEST['subject_id'])
                                 	   echo '<option value='.$data_category['subject_id'].' selected="selected">'.$data_category['name'].'</option>';
                             	   else
                                 	   echo '<option value='.$data_category['subject_id'].'>'.$data_category['name'].'</option>';
                            	}
                            ?>       
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
                                $select_name = "select topic_name from topic where (topic_name like '%".$keyword."%' or description like '%".$keyword."%')";                                           
                                if(mysql_num_rows($db->query($select_name)))
                                {
                                    $val_name = $db->fetch_array($db->query($select_name));
                                    $name_to_array = "or topic_name like concat(concat('%','".$val_name['topic_name']."','%')) ";
                                }
                                $subject = '';
                                $select_subject = "select subject_id from subject where name like '%".$keyword."%' ";
                                if(mysql_num_rows($db->query($select_subject)))
                                {
                                    $val_subject_name = $db->fetch_array($db->query($select_subject));
                                    $subject = "or subject_id = '".$val_subject_name['subject_id']."' ";
                                }
                                
                                $pre_keyword=" and (topic_name like '%".$keyword."%' or  description like '%".$keyword."%' $subject $name_to_array)";
                            }                            
                        else
                            $pre_keyword="";
                        
                        if($_REQUEST['free_course'])
                             $pre_keyword_cource="  and (free_course ='".$_REQUEST['free_course']."')";
                            else 
                             $pre_keyword_cource="";

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

                        if($_GET['orderby']=='topic_name' )
                            $img1 = $img;
							
						if($_REQUEST['subject_id']!="subject_id")
                            $subjects_ids=trim($_REQUEST['subject_id']);
								
						if($_REQUEST['subject_id']!='')
							$subject_id="and subject_id='".$_REQUEST['subject_id']."'";
						else
							$subject_id='';
							
                        if($_GET['order'] !='' && ($_GET['orderby']=='topic_name'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                            $select_directory='order by topic_id desc';                      
                            $sql_query= "SELECT topic_id,subject_id,topic_name,duration,description FROM topic where 1 ".$subject_id." ".$pre_keyword." ".$select_directory.""; 
                       //echo $sql_query;
                        $no_of_records=mysql_num_rows($db->query($sql_query));
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword.'&subject_id='.$subjects_ids;
                            $query_string1=$query_string.$date_query;
                           // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
    <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                                 <input type="hidden" name="formAction" id="formAction" value=""/>
  <tr class="grey_td" >
    <td width="7%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
    <td width="7%" align="center"><strong>Sr. No.</strong></td>
    <td width="20%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=course_name".$query_string;?>" class="table_font"><strong>Topic Name</strong></a> <?php echo $img1;?></td>
    <td width="16%"><strong>Subject Name</strong></td>
      
    <td width="7%"><strong>Duration </strong></td>
    <td width="15%"><strong>Description</strong></td>
    <td width="17%" class="centerAlign"><strong>Action</strong></td>
  </tr>
                            <?php

                            while($val_query=mysql_fetch_array($all_records))
                            {
                                $name = '';
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                
                                $listed_record_id=$val_query['topic_id']; 
                                $select_category = "select name from subject where subject_id = '".$val_query['subject_id']."' ";                                           
                                $val_category = $db->fetch_array($db->query($select_category));
                                
                                
                                $arr=explode(",", $val_query['topic_author']);
                                for($i=0;$i<=count($arr);$i++)
                                {
                                    $select_name = "select first_name,last_name from user where user_id = '".$arr[$i]."' ";                                           
                                    $val_name = $db->fetch_array($db->query($select_name));
                                    if($val_name['first_name'])
                                    {
                                        $name .=$val_name['first_name'].' '.$val_name['last_name'].', ';
                                    }                                    
                                }
                                $names = rtrim($name, ", ");
                                include "include/paging_script.php";
                                if ($val_query['free_course']=='Y')
                                    $course_type='Free';
                                else 
                                    $course_type='Paid';
                                echo '<tr '.$bgcolor.' >
                                      <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
                                echo '<td align="center">'.$sr_no.'</td>';                                
                                echo '<td ><a href="add_topic.php?record_id='.$listed_record_id.'" class="table_font">'.$val_query['topic_name'].'</a></td>';
                                echo '<td >'.$val_category['name'].'</td>';
                               
                                echo '<td >'.$val_query['duration'].'</td>';
                                echo '<td >'.$val_query['description'].'</td>';
								/*$open_tab="select * from  discount_coupon where topic_id ='".$listed_record_id."' ";
								$ptr_uery=mysql_query($open_tab);
								$val_qusddery=mysql_fetch_array($ptr_uery);*/
								
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
							     $sr++; } ?>' class="example-fade"/>
                                  <?php
echo '<img src="images/discount_off.png" title="'.$val_qusddery['discount'].' Discount. Valid Date start='.$val_qusddery['start_date'].' end ='.$val_qusddery['end_date'].'  " class="example-fade"/>&nbsp;&nbsp;';*/
echo '<a href="add_topic.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';

                                echo '</td>';
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
							 echo '<td width="25%">Total Topics : '.$no_of_records.'</td>';
                            echo '<td width="70%" align="right">'.$pager->renderFullNav().'</td>';
                         
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
