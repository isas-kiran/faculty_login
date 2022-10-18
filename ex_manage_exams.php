<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Exams</title>
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
<?php
if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'] && $_REQUEST['deleteStatus'])
{
	$del_record_id=$_REQUEST['record_id'];
	$sql_query= "SELECT exams_id,exam_number FROM ".$GLOBALS["pre_db"]."ex_exams where exams_id='".$del_record_id."'";
	$ptr_query=mysql_query($sql_query);
	if(mysql_num_rows($ptr_query))
	{
		$val_data=mysql_fetch_array($ptr_query);

		$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `admin_id`) VALUES ('manage_exams','Delete','".$val_data['exam_number']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."')";
		$query=mysql_query($insert);

		$delete_query="delete from ".$GLOBALS["pre_db"]."ex_exams where exams_id='".$del_record_id."'";
		$db->query($delete_query);

		$delete_query1="delete from ".$GLOBALS["pre_db"]."ex_exams_section where exams_id ='".$del_record_id."'";
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
}
?>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
    	<td class="top_left"></td>
    	<td class="top_mid" valign="bottom"><?php include "include/exams_menu.php";?></td>
    	<td class="top_right"></td>
  	</tr>
  	<tr>
    	<td class="mid_left"></td>
    	<td class="mid_mid" align="center">
			<table cellspacing="0" cellpadding="0" class="table" width="95%">  
  				<tr class="grey_td">
    				<td colspan="9">
        				<form method="get" name="search">
							<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              					<tr>
              						<td> <a href="ex_student_export.php<?php echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a></td>
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
				  $pre_keyword =" and (exam_number like '%".$keyword."%' || school_code like '".$keyword."')";
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
					$select_directory='order by exams_id desc';                      
				
				$sql_query= "SELECT * FROM ex_exams where 1  ".$pre_keyword." ".$select_directory.""; 
			   	//echo $sql_query;
				$no_of_records=mysql_num_rows($db->query($sql_query));
				if($no_of_records)
				{
					$bgColorCounter=1;
					//$_SESSION['show_records'] = 10;
					$query_string='&keyword='.$keyword;
					$query_string1=$query_string.$date_query;
					// $pager = new 	PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
					$pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
					$all_records= $pager->paginate();
					?>
					<form method="post" name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>">
                    <input type="hidden" name="formAction" id="formAction" value=""/>
					<tr class="grey_td">
						<!--<td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>-->
						<td width="5%" align="center"><strong>Sr. No.</strong></td>
						<!--<td width="20%"><strong>Exam Name</strong></td>-->
						<td width="10%" align="center"><strong>Exam Number</strong><?php echo $img1;?></td>
						<td width="10%" align="center"><strong>Exam Mark</strong></td>
						<td width="10%" align="center"><strong>Exam Duration</strong></td>
						<td width="15%" align="center"><strong>Paper Name</strong></td>
						<td width="10%" align="center"><strong>Added Date</strong></td>
						<td width="10%" align="center"><strong>Add student</strong></td>
						<td width="10%" align="center"><strong>show student</strong></td>
						<td width="10%" align="center" class="centerAlign"><strong>Action</strong></td>
					</tr>
					<?php
					while($val_query=mysql_fetch_array($all_records))
					{
						if($bgColorCounter%2==0)
							$bgcolor='class="grey_td"';
						else
							$bgcolor="";                
						$listed_record_id=$val_query['exams_id'];                                                                
						include "include/paging_script.php";

						echo '<tr '.$bgcolor.' >';
						echo '<td align="center">'.$sr_no.'</td>';
						echo '<td align="center">'.$val_query['exam_number'].'</td>';

						$select_paper="select DISTINCT(papers_id) from ex_exams_section where exams_id='".$val_query['exams_id']."'";
						$ptr_paper_ids=mysql_query($select_paper);
						$result ='';
						$fetch_exam=mysql_fetch_array($ptr_paper_ids);
						
						echo '<td align="center">'.$val_query['exam_mark'].'</td>';     
						echo '<td align="center">'.$val_query['exam_duration'].'</td>';
						
						$sel_paper="select paper_name from `ex_papers` where papers_id='".$fetch_exam['papers_id']."'";
						$ptr_paper=mysql_query($sel_paper);
						$data_paper=mysql_fetch_array($ptr_paper);
						
						echo '<td align="center">'.$data_paper['paper_name'].'</td>';
						
						echo '<td align="center">'.$val_query['added_date'].'</td>';
						echo '<td align="center"><a href="ex_add_exams_student.php?record_id='.$listed_record_id.'&exam_no='.$val_query['exam_number'].'&view=0" >add student</a></td>';
						$student = "select exam_no from `ex_student_exam_registration` where exam_no = '".$val_query['exam_number']."' ";
						$st = mysql_query($student);
						if(mysql_num_rows($st)){
						echo '<td align="center"><a href="ex_show_exams_student.php?record_id='.$listed_record_id.'&exam_no='.$val_query['exam_number'].'&view=0" >show student</a></td>';
						}else{
							echo '<td align="center">No student to show</td>';
						}
						$sel_ex_no="select exam_no from ex_student_paper where exam_no='".$val_query['exam_number']."'";
						$ptr_ex_no=mysql_query($sel_ex_no);

						if(!mysql_num_rows($ptr_ex_no))
						{                     
							echo '<td align="center"><a href="ex_add_exams.php?record_id='.$listed_record_id.'&view=0" ><img  src="images/edit_icon.png" title="Edit Record" class="course_example-fade"/></a>&nbsp;&nbsp;';
							echo '<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteStatus=1&deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="course_example-fade" /></a>&nbsp;&nbsp;';
							echo '</td>';
						}
						else
						{
							echo '<td align="center"><a href="ex_add_exams.php?record_id='.$listed_record_id.'&view=1" ><img title="View" src="images/view1.png" title="Edit Record" class="course_example-fade"/></a>&nbsp;&nbsp;';
							echo '</td>';
						}
						echo '</tr>';
						$bgColorCounter++;
					}
					?>
					<tr class="grey_td">
						<td colspan="9">
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
								echo '<td width="75%" align="right">'.$pager->renderFullNav().'</td>';               ?>
								</tr>
							</table>
						</td>
					</tr>
				</form>
      			<?php 
			} 
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
<?php include "include/footer.php"; ?>
</div>
<!--footer end-->
</body>
</html>
