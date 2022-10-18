<?php include 'ex_inc_classes.php';?>
<?php include "ex_admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Stop Exam</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "ex_include/headHeader.php";?>
<?php include "ex_include/functions.php"; ?>
<?php include "ex_include/ps_pagination.php"; ?>
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
            if(confirm("Are you sure, you want to Stop exam?"))
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
    <td class="top_mid" valign="bottom"><?php include "ex_include/exams_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
  <?php 
	
	/*$sel_exam_no="select stud_login_id,examination_number from stud_login where status='active'";
	$ptr_exam=mysql_query($sel_exam_no);
	while($data_exam_no=mysql_fetch_array($ptr_exam))
	{
		$sel_stud_id="select exams_id from exams where exam_number='".$data_exam_no['examination_number']."' and validity_todate > '".date('Y-m-d')."'";
		$ptr_stud_id=mysql_query($sel_stud_id);
		if(!mysql_num_rows($ptr_stud_id))
		{
			$update_stud_login="update stud_login set status='inactive' where stud_login_id='".$data_exam_no['stud_login_id']."'";
			$ptr_stud_login=mysql_query($update_stud_login);
		}
	}*/
                    
                    if($_REQUEST['stopexam'] && $_REQUEST['stud_login_id'])
                    {
                        $stud_login_id=$_REQUEST['stud_login_id'];
                        $sql_query= "SELECT stud_login_id FROM ex_stud_login where stud_login_id='".$stud_login_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {                           
                            $upd_query="update ex_stud_login set status='intrupted',exam_stoped='yes',stopped_time='".date('Y-m-d H:i:s')."' where stud_login_id='".$stud_login_id."'";
                            //$upd_query="update stud_login set status='stop',exam_stoped='yes',stopped_time='".date('Y-m-d H:i:s')."' where stud_login_id='".$stud_login_id."'";
                        	
                        	$db->query($upd_query);
							
							$update_log="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `admin_id`) VALUES ('stop_exam','Stop','".$stud_login_id."','".$stud_login_id."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."')";
							$query=mysql_query($update_log);
							
                            ?>
                            <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Exam Stop successfully</p></center></div>
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
                <!--<td width="20%">
                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                <option value="">-Operation-</option>
                                <option value="delete">Delete</option>
                        </select>
                </td> -->               
                <td class="rightAlign" > 
                    <table border="0" cellspacing="0" cellpadding="0" align="right">
              <tr>
              <td></td>
              <td class="width5"></td>
                <td><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Exam No." /></td>
                <td class="width2"></td>
                <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="course_example-fade"  /></td>
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
						  $pre_keyword =" and (examination_number like '%".$keyword."%' or name like '%".$keyword."%' or  school_code like '%".$keyword."%')";
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

                        if($_GET['orderby']=='exam_name' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='exam_name'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                            $select_directory='order by stud_login_id desc';                      
                            $sql_query= "SELECT DISTINCT(stud_login_id) FROM ex_stud_login where status='active'  ".$pre_keyword." ".$select_directory.""; 
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
                            <!--<td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>-->
                            <td width="5%" align="center"><strong>Sr. No.</strong></td>
                            <td width="20%"><strong>Student Name </strong><?php echo $img1;?></td>
                            <td width="20%"><strong>Exam Number</strong><?php echo $img1;?></td>
                             <td width="20%"><strong>School Code </strong><?php echo $img1;?></td>
                            <td width="10%" class="centerAlign"><strong>Action</strong></td>
                          </tr>
                            <?php

                            while($val_query=mysql_fetch_array($all_records))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                
                                $listed_record_id=$val_query['stud_login_id']; 
                                                                
                                
                                include "ex_include/paging_script.php";
                                
								$select_stud_details = "select name, examination_number, school_code, added_date from `ex_stud_login` where stud_login_id = '".$val_query['stud_login_id']."' ";
								$ptr_stud_details = mysql_query($select_stud_details);
								$data_stud = mysql_fetch_array($ptr_stud_details);
								
								
                                echo '<tr '.$bgcolor.' >';
								
                                echo '<td align="center">'.$sr_no.'</td>';
								 echo '<td >'.$data_stud['name'].'</td>';
                              echo '<td >'.$data_stud['examination_number'].'</td>';

								 echo '<td >'.$data_stud['school_code'].'</td>';
								                    
                                echo '<td align="center">
                                      <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?stopexam=1&stud_login_id='.$val_query['stud_login_id'].'&page='.$_REQUEST['page'].$query_string1.'"><span style="text-decoration:underline;">Stop Exam</span></a>&nbsp;&nbsp;';

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
                                            echo '<td width="75%" align="right">'.$pager->renderFullNav().'</td>';                         
                                         ?>
                                    </tr>
                                </table>
                            </td>
                            </tr>
                     </form>
      <?php } 
      else
        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No live attempting student found related to your search criteria, please try again</div><br></td></tr>';?>
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
<?php include "ex_include/footer.php"; ?>
</div>
<!--footer end-->
</body>
</html>
