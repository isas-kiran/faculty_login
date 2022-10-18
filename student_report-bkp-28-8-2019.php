<?php  include 'inc_classes.php';?>
<?php include "admin_authentication.php";

$course_batch_id=$_REQUEST['course_batch_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Batch Report</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
   <link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
     <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
     <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>
    
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script>
	 $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
            
//             $('input:radio[name=free_course][value=N]').click();
//             $('input:radio[name=discount_course][value=Y]').click();
//             $('input:radio[name=status][value=Inactive]').click();
        });
	</script>
    <script type="text/javascript">
         function submitAction(action)
        {
            var chks = document.getElementsByName('chkRecords[]');
			//alert("chks");
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
    <td class="top_mid" valign="bottom"><?php include "include/student_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
    <?php       if($_POST['formAction'])
                    {
                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $del_record_id=$_POST['chkRecords'][$r];
                                $sql_query= "SELECT enroll_id FROM ".$GLOBALS["pre_db"]."student_attendence where enroll_id ='".$del_record_id."'";
								$sql=mysql_query($sql_query);
                                if(mysql_num_rows($sql))
                                    {      
									                                       
                                         $delete_query="delete from ".$GLOBALS["pre_db"]."student_attendence where enroll_id='".$del_record_id."'";
                                        $select=mysql_query($delete_query);                                                                                        
                                    }
							}
                             ?>
                             <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record(s) deleted successfully</p></center></div>
                              <?
							}
						
                        
                        
                    }

                    if($_REQUEST['changeStatus'] && $_REQUEST['value'])
                    {
                        $update_query1="update ".$GLOBALS["pre_db"]."employee set status='".$_REQUEST['value']."' where employee_id='".$_REQUEST['changeStatus']."'";
                        //echo $update_query1;
                        $db->query($update_query1);
                        ?>
                        <div id="statusChangesDiv" title="Status Changed"><center><br/><p>Status changed successfully</p></center></div>

                                    <script type="text/javascript">
                                       // $("#statusChangesDiv").dialog();
                                        $(document).ready(function() {
                                            $( "#statusChangesDiv" ).dialog({
                                                modal: true,

                                                buttons: {
                                                            Ok: function() { $( this ).dialog( "close" ); }
                                                         }
                                                });
                                            });
                                    </script>
                            <?php                            
                                }
								
                     
                    if($_REQUEST['enroll_id'] && $_REQUEST['enroll_id'])
                    {
                        $del_record_id=$_REQUEST['enroll_id'];
                        $sql_query= "SELECT enroll_id FROM ".$GLOBALS["pre_db"]."student_attendence where enroll_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {                           
                            $delete_query="delete from ".$GLOBALS["pre_db"]."student_attendence where enroll_id='".$del_record_id."'";
                            $db->query($delete_query);      
                            ?>
                            <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record deleted successfully</p></center></div>
                            <script type="text/javascript">
                               // $("#statusChangesDiv").dialog();
                                $(document).ready(function() {
                                    $( "#statusChangesDiv" ).dialog({
                                        modal: true,
                                        buttons: {
                                                    Ok: function() { $( this ).dialog( "close" ); }
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
        
<table cellspacing="0" cellpadding="0" class="table" width="99%">
  <tr class="head_td">
    <td colspan="13">
        <form method="get" name="jqueryForm" id="jqueryForm">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                <td width="20%">
                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                <option value="">-Operation-</option>
                                <option value="delete">Delete</option>
                                
                        </select></td>
                <td class="rightAlign"> 
                    <table border="0" cellspacing="0" cellpadding="0" align="right">
                    
              	<tr>
               		<td class="width5" style="padding-left:px; width:10px;"></td>
          			<!--      <td><input type="text" value="<?php //if($_REQUEST['batch']!="Batch") echo $_REQUEST['batch'];?>" name="batch" class="defaultText search_box" title="Batch" /></td>
                	<td class="width2"></td>
                	<td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>-->
                	
                    <td width="38%" >
                        <select name="batch_id" id="batch_id" class="validate[required] input_select" style="width:200px" >  
                        <option value=""> Select Batch</option>
                        <?php
                        $select_category = "select * from batch ".$_SESSION['where']." order by batch_id asc";
                        $ptr_category = mysql_query($select_category);
                            
                        while($data_category = mysql_fetch_array($ptr_category))
                        {
                            $sel='';
                            if($_GET['batch_id']==$data_category['batch_id'])
                            {
                                $sel='selected="selected"';
                            }
                                
                            echo '<option '.$sel.' value='.$data_category['batch_id'].'>'.$data_category['batch_name'].'</option>';
                        }
                        ?>  
                        </select>
                    </td>
                                        
          			<!-- <td width="30%" style="padding-left:60px;">
           			<input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php //if($_REQUEST['from_date']!="") echo $_REQUEST['from_date'];?>"></td>
                         
                    <td width="25%"><input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php //if($_REQUEST['to_date']!="") echo $_REQUEST['to_date'];?>"></td>
                         -->
                    <td width="10%" style="padding-left:px;"><input type="submit" name="search" value="Search" class="inputButton"/></td>
					<td class="width5" style="padding-left:100px;"></td>
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
	               /* if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="")
						 {
							$sep=explode("/",$_REQUEST['from_date'],3);
							 $dat=$sep[2]."-".$sep[1]."-".$sep[0];
							        $form=$sep[0];
						  	$pre_from_date="  and repeated >='".$dat."'";
						 }
						else
						{
							$pre_from_date="";                            
						}
						if($_REQUEST['to_date'] && $_REQUEST['to_date']!=="0000-00-00" && $_REQUEST['to_date']!="")
						{
						$sep1=explode("/",$_REQUEST['to_date'],3);
							 $date1=$sep1[2]."-".$sep1[1]."-".$sep1[0];
						  $to=$sep1[0];
							$pre_to_date=" and repeated <='".$date1."'";
						}
						else
						{
							$pre_to_date="";
						}*/
						if($_REQUEST['batch_id'])
						{   
						    $batch=$_REQUEST['batch_id'];
						}
						if($batch)
						{
							 $pre_keyword1=" and(bt.batch_id like '%".$batch."%')";
						}
						else{
							$pre_keyword1="";
						}
	
                        if($_REQUEST['keyword']!="Keyword")
						{
                            $keyword=trim($_REQUEST['keyword']);
						}
                        if($keyword)
						{
                            $pre_keyword=" and (en.name like '%".$keyword."%'||en.contact like '%".$keyword."%' ||en.mail like '%".$keyword."%' )";
						}
                        else
						{
                            $pre_keyword="";
						}
                        
                        if($_REQUEST['page'])
						{
                            $page=$_REQUEST['page'];
						}
                        else
						{
                            $page=0;
						}
                        
                        if($_REQUEST['show_records'])
						{
                            $show=$_REQUEST['show'];
						}
                        else
						{
                            $show=0;
						}

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
						{
                            $order='desc';
						}

                        if($_GET['orderby']=='employee_name' )
						{
                            $img1 = $img;
						}

                        if($_GET['order'] !='' && ($_GET['orderby']=='employee_name'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
					    
						
						echo $sql_query= "SELECT * FROM student_course_batch_map where 1 and c_b_id='".$course_batch_id."' ".$pre_keyword.""; 
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
                            	<td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
                                <td width="5%" align="center"><strong>Sr. No.</strong></td>
                                <td width="10%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=employee_name".$query_string;?>" class="table_font"><strong>Student Name</strong></a> <?php echo $img1;?></td>
                                <td width="10%" align="center"><strong>Course_name</strong></td>
                                <td width="10%" align="center"><strong>Total Days</strong></td>
                                <td width="10%" align="center"><strong>No. of Days Absent</strong></td>
                                
                               	<td width="10%" align="center"><strong>% of Present</strong></td>
                                <!--<td width="10%" align="center"><strong>Action</strong></td>-->
                           	</tr>
                            <?php
                            
                            while($val_query=mysql_fetch_array($all_records))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                
                                $listed_record_id=$val_query['s_c_b_id']; 
								
                                include "include/paging_script.php";
                                
								$sel_cb="select batch_type from course_batch_mapping where c_b_id='".$val_query['c_b_id']."'";
								$ptr_cb=mysql_query($sel_cb);
								$data_cb_id=mysql_fetch_array($ptr_cb);
								
																
                                echo '<tr '.$bgcolor.' >
                                      <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
                                echo '<td align="center">'.$sr_no.'</td>';   
								
								$select_name = "select name from enrollment where enroll_id='".$val_query['enroll_id']."' ";
								$pre_sel=mysql_query($select_name);
								$data_name=mysql_fetch_array($pre_sel);
								 
								$sel_course="select course_name from courses where course_id='".$val_query['course_id']."'";
								$pre_course=mysql_query($sel_course);
								$data_course=mysql_fetch_array($pre_course);
								
								echo '<td align="center">'.$data_name['name'].'</td>';
                                echo '<td align="center">'.$data_course['course_name'].'</a></td>';								
								$select_att="select stud_attendence_id from student_attendence where course_batch_id ='".$val_query['c_b_id']."' and enroll_id= ".$val_query['enroll_id']."";
								$ptr_att= mysql_query($select_att);
								$total_attendence = mysql_num_rows($ptr_att);
								
					    		$select_counter= "SELECT * from student_attendence where enroll_id= ".$val_query['enroll_id']." and course_batch_id='".$val_query['c_b_id']."' and attendence='absent' ";
								$pre_counter= mysql_query($select_counter);
								$count_absent= mysql_num_rows($pre_counter);
								
								echo '<td align="center">'.$total_attendence.'</td>';
								echo '<td align="center"><a href="email_details.php?enroll_id='.$val_query['enroll_id'].'&c_b_id='.$val_query['c_b_id'].'" >'.$count_absent.'</a></td>';
								echo '<td align="center">'.round((($total_attendence-$count_absent)/$total_attendence)*100).'%</td>';
                                echo '</tr>';
                                                                
                                $bgColorCounter++;
                            }    
                            ?>
  
  
  <tr class="head_td">
    <td colspan="13">
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
        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No Page found related to your search criteria, please try again</div><br></td></tr>';?>
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
<?php include "file:///C|/xampp/htdocs/sixpacknutrition_new/admin/include/footer.php"; ?>
</div>
<!--footer end-->
</body>
</html>
