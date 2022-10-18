<?php include 'ex_inc_classes.php';?>
<?php include "ex_admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Show exams students</title>
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
	
	<style>
	.btn-success {
   background-color: #65B688;
   border-color: #65B688;
   }
   .btn-danger {
   color: #fff;
   background-color: #d9534f;
   border-color: #d43f3a;
   }
   .btn {
   color: white;
   display: inline-block;
   margin-bottom: 0;
   font-weight: 400;
   text-align: center;
   vertical-align: middle;
   cursor: pointer;
   background-image: none;
   border: 1px solid transparent;
   white-space: nowrap;
   padding: 6px 12px;
   font-size: 14px;
   line-height: 1.42857143;
   border-radius: 4px;
   -webkit-user-select: none;
   -moz-user-select: none;
   -ms-user-select: none;
   user-select: none;
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
    <td class="top_mid" valign="bottom"><?php include "ex_include/exams_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
    				
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
        
<table cellspacing="0" cellpadding="0" class="table" width="95%">  
  <tr class="grey_td">
    <td colspan="10">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
              <td> <a href="ex_student_exam_export.php?exam_no=<?php echo $_GET['exam_no'];?>"><img src="images/excel.png" height="30px" width="30px"/></a></td>  
              
                          
                <td class="rightAlign" > 
                    <table border="0" cellspacing="0" cellpadding="0" align="right">
              <tr>
             <td class="width5"></td><input type="hidden" value="<?php echo $_GET['exam_no'];?>" name="exam_no" />
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
       
            
    </td>
  </tr>
    <?php
			    if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
                    {
                                                
                        	$delete_query="delete from ex_student_exam_registration where id='".$_GET['record_id']."'";
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
								setTimeout('document.location.href="show_exams_student.php";',1000);
                            </script>
                            <?php
                        
                    }

                    
                    if($_REQUEST['keyword']!="Keyword")
                    $keyword=trim($_REQUEST['keyword']);
                if($keyword)
                {                            
                  $pre_keyword ="and exam_no = '".$_REQUEST['exam_no']."' and (pwd like '%".$keyword."%' || enroll_no like '%".$keyword."%')";
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
                            if($_GET['orderby']=='exam_no' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='exam_no'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                            $select_directory='order by id desc'; 

                           
                      
                            $ex = "and exam_no = '".$_GET['exam_no']."' ";             
                         $sql_query= "select * FROM ex_student_exam_registration where 1 ".$ex." ".$pre_keyword." ".$select_directory." "; 
                     
                        $no_of_records=mysql_num_rows($db->query($sql_query));
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                          
                            $query_string='&keyword='.$keyword;
                            $query_string1=$query_string.$date_query;
                         
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
                     <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                         <input type="hidden" name="formAction" id="formAction" value=""/>
                          <tr class="grey_td" >
                           
                            <td width="5%" align="center"><strong>Sr. No.</strong></td>
						
							<td width="10%" align="center"><strong>Student Name</strong><?php echo $img1;?></td>
                            <td width="10%" align="center"><strong>Course Name</strong></td>
							 <td width="10%" align="center"><strong>School code</strong></td>
                            <td width="10%" align="center"><strong>Exam no</strong></td>
							
                            <td width="10%" align="center"><strong>enroll no</strong></td>
							  <td width="10%" align="center"><strong>Password</strong></td>
							  <td width="10%" align="center"><strong>present or abscent</strong></td>
                            <td width="10%" align="center"><strong>Added Date</strong></td>
							
                            <td width="10%" align="center" class="centerAlign"><strong>Action</strong></td>
                          </tr>
                            <?php

                            while($val_query=mysql_fetch_array($all_records))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                $listed_record_id=$val_query['id'];                                                                
                                include "include/paging_script.php";
                                
                                echo '<tr '.$bgcolor.' >';
								
                                echo '<td align="center">'.$sr_no.'</td>';
								
								 $select_name="select name from enrollment where enroll_id='".$val_query['enroll_no']."'";
								$ptr_name=mysql_query($select_name );
								$nm = mysql_fetch_array($ptr_name);
								
                              	echo '<td align="center">'.$nm['name'].'</td>';

                                $select_course="select course_name from courses where course_id='".$val_query['course_id']."'";
								$ptr_course=mysql_query($select_course);
								$cs = mysql_fetch_array($ptr_course);
								

                                echo '<td align="center">'.$cs['course_name'].'</td>'; 
									$select_school_code = "select school_code FROM `ex_exams` WHERE exam_number='".$_GET['exam_no']."'";
									$ptr_schoolcode = mysql_query($select_school_code);
								$sc = mysql_fetch_array($ptr_schoolcode);
								echo '<td align="center">'.$sc['school_code'].'</td>';
								echo '<td align="center">'.$val_query['exam_no'].'</td>';          
								echo '<td align="center">'.$val_query['enroll_no'].'</td>';
								echo '<td align="center">'.$val_query['pwd'].'</td>';
								echo '<td align="center">';
									echo '<select name="status" id="status" class="input_select" style="width:100px;" onChange="set_status(this.value,'.$val_query['id'].')">
									<option value="">Select</option>';
									$act_selecteds = '';
									$inact_selecteds='';
									if($val_query['status']=='0')
										$act_selecteds = 'selected="selected"';
									else if	($val_query['status']=='1')
										$inact_selecteds = 'selected="selected"';
										
									echo "<option value='0' ".$act_selecteds." >Present</option>";
									echo "<option value='1' ".$inact_selecteds." >Abscent</option>";
									echo'</select>';
									echo '</td>';
								echo '<td align="center">'.$val_query['date_added'].'</td>';
								
								
								$sel_ex_no="select id from ex_student_exam_registration where id='".$val_query['id']."'";
								$ptr_ex_no=mysql_query($sel_ex_no);
								
								//if(!mysql_num_rows($ptr_ex_no))
								//{                     
									echo '<td align="center"><a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteStatus=1&deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="course_example-fade" /></a>&nbsp;&nbsp;';
									echo '</td>';
								//}
								
                                echo '</tr>';
                                $bgColorCounter++;
                            }
                            ?>
                          	
                     </form>
      <?php } 
     // else
       // echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No exam duration found related to your search criteria, please try again</div><br></td></tr>';?>
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
<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<script>
function set_status(values,ids)
{
	var data1="status="+values+"&id="+ids;	
	//alert(data1);
	$.ajax({
		url: "status.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
		}
	});
}
</script>
</body>
</html>
