<?php include 'ex_inc_classes.php';?>
<?php include "ex_admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage MCQ Paper</title>
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
    <td class="top_mid" valign="bottom"><?php include "ex_include/exams_menu.php";?></td>
    <td class="top_right"></td>
  	</tr>
    <?php 
	//==============================Permanantly commited multiple delete code ===========================================
	/*if($_POST['formAction'])
	{
		if($_POST['formAction']=="delete")
		{
			for($r=0;$r<count($_POST['chkRecords']);$r++)
			{
				$del_record_id=$_POST['chkRecords'][$r];
				$sql_query= "SELECT papers_id,paper_name FROM ".$GLOBALS["pre_db"]."papers where papers_id ='".$del_record_id."'";
				$db_query=mysql_query($sql_query);
				if(mysql_num_rows($db_query))
				{
					$val_data=mysql_fetch_array($db_query);
							
					$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `admin_id`) VALUES ('manage_mcq_paper','Delete','".$val_data['paper_name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert);
																	
					$delete_query="delete from ".$GLOBALS["pre_db"]."papers where papers_id ='".$del_record_id."'";
					$db->query($delete_query);
					
					$delete_query1="delete from ".$GLOBALS["pre_db"]."papers_section where papers_id='".$del_record_id."'";
					$db->query($delete_query1);                                                                                
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
	}*/
	
	/*if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
	{
		$del_record_id=$_REQUEST['record_id'];
		$sql_query= "SELECT papers_id FROM ".$GLOBALS["pre_db"]."papers where papers_id='".$del_record_id."'";
		$db_query=mysql_query($sql_query);
		if(mysql_num_rows($db_query))
		{
			$val_data=mysql_fetch_array($db_query);
							
			$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `admin_id`) VALUES ('manage_mcq_paper','Delete','".$val_data['paper_name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."')";
			$query=mysql_query($insert);
			
			$delete_query="delete from ".$GLOBALS["pre_db"]."papers where papers_id='".$del_record_id."'";
			$db->query($delete_query);
		
			$delete_query1="delete from ".$GLOBALS["pre_db"]."papers_section where papers_id='".$del_record_id."'";
			$db->query($delete_query1);
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
	}*/
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
                              $pre_keyword =" and (p.paper_name like '%".$keyword."%' and l.language_code like '%".$keyword."%')";
							  
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

                        if($_GET['orderby']=='paper_name' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='paper_name'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        if($keyword)
						{
							$lan1=explode('/',$keyword);
							$lan0=$lan1[0];
							$lan1=$lan1[1];
                            $select_directory='order by papers_id desc'; 
							                     
                           $sql_query= "SELECT  p.*,l.* FROM ex_papers p,ex_language l where 1 and (p.paper_name like '%".$lan0."%' and l.language_code like '%".$lan1."%' )and p.language_id =l.language_id ".$select_directory." "; 
						}else{
							
							$select_directory='order by papers_id desc'; 
							                     
                           $sql_query= "SELECT * FROM ex_papers  where 1  ".$select_directory.""; 
						}
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
                            <!--<td width="6%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>-->
                            <td width="6%" align="center"><strong>Sr. No.</strong></td>
<!--                        <td width="20%"><strong>Exam Name</strong></td>
-->                         <td width="20%" align="center"><strong>Paper Name</strong><?php echo $img1;?></td>
							<td width="10%" align="center"><strong>Language</strong></td>
                            <td width="10%" align="center"><strong>Paper Mark</strong></td>
                            <!-- <td width="20%" align="center"><strong>Convert</strong></td> -->
                            <td width="15%" align="center"><strong>Added Date</strong></td>
                            <td width="10%" class="centerAlign"><strong>Action</strong></td>
                          </tr>
                          <?php
                          while($val_query=mysql_fetch_array($all_records))
                          {
                          		if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                
                                $listed_record_id=$val_query['papers_id']; 
                                $sel_lang="select language_id,language_name,language_code from ex_language where language_id='".$val_query['language_id']."'";       
								$ptr_lang=mysql_query($sel_lang);                      
                                $data_lang=mysql_fetch_array($ptr_lang);
                                include "ex_include/paging_script.php";
                                
                                echo '<tr '.$bgcolor.' >';
								/*$sel_ex_no="select exam_no from student_paper where exam_no='".$val_query['exam_number']."'";
								$ptr_ex_no=mysql_query($sel_ex_no);
								if(!mysql_num_rows($ptr_ex_no))
								{
                                echo'<td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
								}
								else
								{
									echo '<td></td>';
								}*/
                                echo '<td align="center">'.$sr_no.'</td>';
/*								echo '<td >'.$val_query['exam_name'].'</td>';
*/                              echo '<td align="center">'.$val_query['paper_name'].'</td>';
								echo '<td align="center">'.$data_lang['language_name'].'</td>';
                                echo '<td align="center"><a href="ex_question_details.php?papers_id='.$val_query['papers_id'].'">'.$val_query['paper_mark'].'</a></td>';     
								// echo '<td align="center">Convert in to';
								// echo '<select name="language" onchange="redirect1(\'convert_language.php'.'?papers_id='.$val_query['papers_id'].'&language_id=\',this.value)">
                                //     <option value="">Select Language</option>';
								// $sel_lang="select language_id,language_name from language where language_id!='".$data_lang['language_id']."'";
								// $ptr_langugae=mysql_query($sel_lang);
								// while($data_language=mysql_fetch_array($ptr_langugae))
								// {
                                //     echo'<option value="'.$data_language['language_id'].'">'.$data_language['language_name'].'</option>';
								// }
								// echo '</select> </td>';
								$sel_ex_no="select exam_no,paper_id from ex_student_paper where paper_id='".$val_query['papers_id']."'";
								$ptr_ex_no=mysql_query($sel_ex_no);
								$ptr_num_rows=mysql_num_rows($ptr_ex_no);
								
								$select_exam_section="select papers_id from ex_exams_section where papers_id='".$val_query['papers_id']."'";
								$query_exam_section=mysql_query($select_exam_section);
								$num_rows=mysql_num_rows($query_exam_section);
								echo '<td align="center">'.$val_query['added_date'].'</td>';
								if($ptr_num_rows==0 && $num_rows==0 )
								{                    
                                	echo '<td align="center"><a href="ex_add_mcq_paper.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="course_example-fade"/></a>&nbsp;&nbsp;'; //<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="course_example-fade" /></a>&nbsp;&nbsp;
                                	echo '</td>';
								}
								else
								{
									echo '<td></td>';
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
                            </tr>
                     </form>
      <?php } 
      else
        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No exam duration found related to your search criteria, please try again</div><br></td></tr>';?>
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
